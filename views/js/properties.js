/**
 * properties.js
 *
 * Fetches properties from the server via AJAX and populates
 * the Property dropdown in the Site Visit Details sidebar.
 *
 * Depends on: the existing dropdown JS already in the page.
 */

(function () {
    'use strict';

    // ── Config ──────────────────────────────────────────────────────────────
    // Adjust this path to match your project's directory structure.
    const PROPERTIES_ENDPOINT = '/habitrack/ajax/calendar_getrecord.ajax.php?action=getProperties';

    // ── State ────────────────────────────────────────────────────────────────
    let allProperties = [];   // full list cached after first fetch

    // ── DOM refs ─────────────────────────────────────────────────────────────
    // The property dropdown is the first .dropdown inside the sidebar card.
    function getPropertyDropdown() {
        // Be explicit: find the dropdown whose toggle currently shows "Select property" or has data-type="property"
        return [...document.querySelectorAll('.dropdown')].find(function (el) {
            const val = el.querySelector('.dropdown-value');
            return val && (val.textContent.trim() === 'Select property' || el.dataset.type === 'property');
        });
    }

    // ── Fetch ─────────────────────────────────────────────────────────────────
    async function fetchProperties() {
        const res = await fetch(PROPERTIES_ENDPOINT, {
            method:  'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
        });

        if (!res.ok) {
            throw new Error('Server returned ' + res.status);
        }

        const data = await res.json();

        if (!data.success) {
            throw new Error(data.message || 'Failed to load properties.');
        }

        return data.properties;   // [{ id, propertyID, propertyName }, ...]
    }

    // ── Render items into dropdown ────────────────────────────────────────────
    function renderPropertyItems(dropdown, properties) {
        const itemsContainer = dropdown.querySelector('.dropdown-menu .space-y-1');
        if (!itemsContainer) return;

        itemsContainer.innerHTML = '';   // clear existing static items

        if (properties.length === 0) {
            itemsContainer.innerHTML =
                '<p class="px-3 py-2 text-xs text-white/50">No properties found.</p>';
            return;
        }

        properties.forEach(function (property) {
            const btn = document.createElement('button');
            btn.type         = 'button';
            btn.className    = 'dropdown-item w-full rounded-2xl px-3 py-2 text-left text-sm text-white/90 transition hover:bg-white/10';
            btn.textContent  = property.propertyName;
            btn.dataset.id   = property.id;
            btn.dataset.code = property.propertyID;

            // Re-attach item-click logic (mirrors the existing dropdown JS)
            btn.addEventListener('click', function () {
                const toggle    = dropdown.querySelector('.dropdown-toggle');
                const valueSpan = toggle && toggle.querySelector('.dropdown-value');
                if (valueSpan) valueSpan.textContent = property.propertyName;

                // Store selected property data on the dropdown element for later use
                dropdown.dataset.selectedId   = property.id;
                dropdown.dataset.selectedCode = property.propertyID;
                dropdown.dataset.selectedName = property.propertyName;

                closeDropdown(dropdown);
            });

            itemsContainer.appendChild(btn);
        });
    }

    // ── Search / filter ───────────────────────────────────────────────────────
    function attachSearch(dropdown) {
        const searchInput = dropdown.querySelector('.dropdown-search');
        if (!searchInput) return;

        // Replace the input listener (remove old static one by cloning)
        const fresh = searchInput.cloneNode(true);
        searchInput.parentNode.replaceChild(fresh, searchInput);

        fresh.addEventListener('input', function () {
            const q       = this.value.toLowerCase();
            const filtered = allProperties.filter(function (p) {
                return p.propertyName.toLowerCase().includes(q);
            });
            renderPropertyItems(dropdown, filtered);
        });

        // Prevent clicks inside the input from closing the dropdown
        fresh.addEventListener('click', function (e) { e.stopPropagation(); });
    }

    // ── Shared close helper (mirrors the one in the main inline script) ───────
    function closeDropdown(dropdown) {
        const toggle   = dropdown.querySelector('.dropdown-toggle');
        const menu     = dropdown.querySelector('.dropdown-menu');
        const closeBtn = dropdown.querySelector('.dropdown-close');
        if (toggle)   toggle.setAttribute('aria-expanded', 'false');
        if (menu)   { menu.classList.remove('block'); menu.classList.add('hidden'); }
        if (closeBtn) closeBtn.classList.add('hidden');
    }

    // ── Loading / error states ────────────────────────────────────────────────
    function setDropdownState(dropdown, state, message) {
        const itemsContainer = dropdown.querySelector('.dropdown-menu .space-y-1');
        if (!itemsContainer) return;

        const classes = {
            loading: 'text-white/50',
            error:   'text-red-400',
        };

        itemsContainer.innerHTML =
            `<p class="px-3 py-2 text-xs ${classes[state] || 'text-white/50'}">${message}</p>`;
    }

    // ── Init ──────────────────────────────────────────────────────────────────
    async function init() {
        const dropdown = getPropertyDropdown();
        if (!dropdown) {
            console.warn('[propertyDropdown] Property dropdown not found in DOM.');
            return;
        }

        // Mark so re-runs can find it reliably
        dropdown.dataset.type = 'property';

        setDropdownState(dropdown, 'loading', 'Loading properties…');

        try {
            allProperties = await fetchProperties();
            renderPropertyItems(dropdown, allProperties);
            attachSearch(dropdown);
        } catch (err) {
            console.error('[propertyDropdown] Error:', err);
            setDropdownState(dropdown, 'error', 'Could not load properties. Please refresh.');
        }
    }

    // Run after the DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ── Public API (optional — useful if you need to refresh the list later) ──
    window.PropertyDropdown = { refresh: init };

})();
