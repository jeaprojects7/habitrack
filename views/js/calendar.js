/**
 * agentDropdown.js
 *
 * Fetches agents from the server via AJAX and populates
 * the Agent dropdown in the Site Visit Details sidebar.
 *
 * Depends on: the existing dropdown JS already in the page.
 */

(function () {
    'use strict';

    // ── Config ──────────────────────────────────────────────────────────────
    // Adjust this path to match your project's directory structure.
    const AGENTS_ENDPOINT = '/habitrack/ajax/calendar_getrecord.ajax.php?action=getAgents';

    // ── State ────────────────────────────────────────────────────────────────
    let allAgents = [];   // full list cached after first fetch

    // ── DOM refs ─────────────────────────────────────────────────────────────
    // The agent dropdown is the second .dropdown inside the sidebar card.
    function getAgentDropdown() {
        // Be explicit: find the dropdown whose toggle currently shows "Agent name"
        return [...document.querySelectorAll('.dropdown')].find(function (el) {
            const val = el.querySelector('.dropdown-value');
            return val && (val.textContent.trim() === 'Agent name' || el.dataset.type === 'agent');
        });
    }

    // ── Fetch ─────────────────────────────────────────────────────────────────
    async function fetchAgents() {
        const res = await fetch(AGENTS_ENDPOINT, {
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
            throw new Error(data.message || 'Failed to load agents.');
        }

        return data.agents;   // [{ id, agentID, fullName }, ...]
    }

    // ── Render items into dropdown ────────────────────────────────────────────
    function renderAgentItems(dropdown, agents) {
        const itemsContainer = dropdown.querySelector('.dropdown-menu .space-y-1');
        if (!itemsContainer) return;

        itemsContainer.innerHTML = '';   // clear existing static items

        if (agents.length === 0) {
            itemsContainer.innerHTML =
                '<p class="px-3 py-2 text-xs text-white/50">No agents found.</p>';
            return;
        }

        agents.forEach(function (agent) {
            const btn = document.createElement('button');
            btn.type         = 'button';
            btn.className    = 'dropdown-item w-full rounded-2xl px-3 py-2 text-left text-sm text-white/90 transition hover:bg-white/10';
            btn.textContent  = agent.fullName;
            btn.dataset.id   = agent.id;
            btn.dataset.code = agent.agentID;

            // Re-attach item-click logic (mirrors the existing dropdown JS)
            btn.addEventListener('click', function () {
                const toggle    = dropdown.querySelector('.dropdown-toggle');
                const valueSpan = toggle && toggle.querySelector('.dropdown-value');
                if (valueSpan) valueSpan.textContent = agent.fullName;

                // Store selected agent data on the dropdown element for later use
                dropdown.dataset.selectedId   = agent.id;
                dropdown.dataset.selectedCode = agent.agentID;
                dropdown.dataset.selectedName = agent.fullName;

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
            const filtered = allAgents.filter(function (a) {
                return a.fullName.toLowerCase().includes(q);
            });
            renderAgentItems(dropdown, filtered);
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
        const dropdown = getAgentDropdown();
        if (!dropdown) {
            console.warn('[agentDropdown] Agent dropdown not found in DOM.');
            return;
        }

        // Mark so re-runs can find it reliably
        dropdown.dataset.type = 'agent';

        setDropdownState(dropdown, 'loading', 'Loading agents…');

        try {
            allAgents = await fetchAgents();
            renderAgentItems(dropdown, allAgents);
            attachSearch(dropdown);
        } catch (err) {
            console.error('[agentDropdown] Error:', err);
            setDropdownState(dropdown, 'error', 'Could not load agents. Please refresh.');
        }
    }

    // Run after the DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ── Public API (optional — useful if you need to refresh the list later) ──
    window.AgentDropdown = { refresh: init };

})();
