// Initialize dropdown filters from database
async function initializeDashboardFilters(propertyType = '') {
    try {
        const url = propertyType 
            ? `/habitrack/ajax/dashboard-filters.ajax.php?action=getFilters&type=${encodeURIComponent(propertyType)}`
            : '/habitrack/ajax/dashboard-filters.ajax.php?action=getFilters';
        
        const response = await fetch(url);
        const result = await response.json();
        
        if (result.success) {
            const data = result.data;
            
            // Clear and populate Location for House
            const locationHouse = document.getElementById('f-location-house');
            while (locationHouse.options.length > 1) {
                locationHouse.remove(1);
            }
            data.locations.forEach(loc => {
                const option = document.createElement('option');
                option.value = loc.city + ' - ' + loc.brgy; // raw value; model splits on " - "
                option.textContent = loc.display;
                locationHouse.appendChild(option);
            });
            
            // Clear and populate Location for Lot
            const locationLot = document.getElementById('f-location-lot');
            while (locationLot.options.length > 1) {
                locationLot.remove(1);
            }
            data.locations.forEach(loc => {
                const option = document.createElement('option');
                option.value = loc.city + ' - ' + loc.brgy; // raw value; model splits on " - "
                option.textContent = loc.display;
                locationLot.appendChild(option);
            });
            
            // Clear and populate Storey
            const storey = document.getElementById('f-storey');
            while (storey.options.length > 1) {
                storey.remove(1);
            }
            data.houseStorey.forEach(s => {
                const option = document.createElement('option');
                option.value = s;
                option.textContent = s + ' Storey';
                storey.appendChild(option);
            });
            
            // Clear and populate Bedroom
            const bedroom = document.getElementById('f-bedroom');
            while (bedroom.options.length > 1) {
                bedroom.remove(1);
            }
            data.houseBedroom.forEach(b => {
                const option = document.createElement('option');
                option.value = b;
                option.textContent = b + ' BR';
                bedroom.appendChild(option);
            });
            
            // Clear and populate Toilet & Bathroom
            const tb = document.getElementById('f-tb');
            while (tb.options.length > 1) {
                tb.remove(1);
            }
            data.houseTandB.forEach(t => {
                const option = document.createElement('option');
                option.value = t;
                option.textContent = t + ' T&B';
                tb.appendChild(option);
            });
            
            // Clear and populate Floor Area
            const floorArea = document.getElementById('f-floor-area');
            while (floorArea.options.length > 1) {
                floorArea.remove(1);
            }
            data.houseFloorArea.forEach(f => {
                const option = document.createElement('option');
                option.value = f;
                option.textContent = f + ' sqm';
                floorArea.appendChild(option);
            });
            
            // Clear and populate Lot Area (House)
            const lotAreaHouse = document.getElementById('f-lot-area-house');
            while (lotAreaHouse.options.length > 1) {
                lotAreaHouse.remove(1);
            }
            data.propertyLotArea.forEach(l => {
                const option = document.createElement('option');
                option.value = l;
                option.textContent = l + ' sqm';
                lotAreaHouse.appendChild(option);
            });
            
            // Clear and populate Lot Area (Lot)
            const lotAreaLot = document.getElementById('f-lot-area');
            while (lotAreaLot.options.length > 1) {
                lotAreaLot.remove(1);
            }
            data.propertyLotArea.forEach(l => {
                const option = document.createElement('option');
                option.value = l;
                option.textContent = l + ' sqm';
                lotAreaLot.appendChild(option);
            });
            
            // Clear and populate Size Range
            const sizeRange = document.getElementById('f-size-range');
            while (sizeRange.options.length > 1) {
                sizeRange.remove(1);
            }
            data.propertyLotArea.forEach(l => {
                const option = document.createElement('option');
                option.value = l;
                option.textContent = l + ' sqm';
                sizeRange.appendChild(option);
            });
            
            // Update SlimSelect to show new options
            reinitializeOtherSelects();
        }
    } catch (error) {
        console.error('Error fetching filters:', error);
    }
}

window.slimInstances = {};

function initializeSlimSelect() {
    // Initialize ALL dropdowns on page load
    document.querySelectorAll('.ht-sel').forEach(function(el) {
        if (window.slimInstances[el.id]) {
            window.slimInstances[el.id].destroy();
        }
        
        window.slimInstances[el.id] = new SlimSelect({
            select: el,
            settings: {
                allowDeselect: true,
                placeholderText: el.options[0]?.text || 'Select…',
                searchPlaceholder: 'Search…',
                searchText: 'No results',
                showArrow: true,
            },
            events: {
                afterChange: function(newVal) {
                    if (el.id === 'f-type') {
                        htSwitchType(newVal[0]?.value || '');
                    }
                }
            }
        });
    });
}

function reinitializeOtherSelects() {
    // Destroy and recreate each SlimSelect so it picks up the new <option> elements
    document.querySelectorAll('.ht-sel:not(#f-type)').forEach(function(el) {
        if (window.slimInstances[el.id]) {
            window.slimInstances[el.id].destroy();
        }
        window.slimInstances[el.id] = new SlimSelect({
            select: el,
            settings: {
                allowDeselect: true,
                placeholderText: el.options[0]?.text || 'Select...',
                searchPlaceholder: 'Search...',
                searchText: 'No results',
                showArrow: true,
            }
        });
    });
}

async function loadAmenities() {
    try {
        const response = await fetch('/habitrack/ajax/dashboard-filters.ajax.php?action=getAmenities');
        const result = await response.json();
        
        if (result.success) {
            const amenitiesSelect = document.getElementById('f-amenities');
            
            // Clear existing options except the first one
            while (amenitiesSelect.options.length > 1) {
                amenitiesSelect.remove(1);
            }
            
            // Add amenities where value = 1
            result.data.forEach(amenity => {
                const option = document.createElement('option');
                option.value = amenity.value;
                option.textContent = amenity.label;
                amenitiesSelect.appendChild(option);
            });
            
            // Update SlimSelect for amenities
            if (window.slimInstances['f-amenities']) {
                window.slimInstances['f-amenities'].setData();
            }
        }
    } catch (error) {
        console.error('Error loading amenities:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all SlimSelect dropdowns
    initializeSlimSelect();
    // Load initial data without property type filter
    initializeDashboardFilters('');
    // Load amenities from database
    loadAmenities();
});

// Watch for any ss-content becoming visible and fix its width
document.addEventListener('click', function(e) {
    const wrap = e.target.closest('.ht-sel-wrap');
    if (!wrap) return;

    setTimeout(function() {
        const ssMain = wrap.querySelector('.ss-main');
        if (!ssMain) return;
        const mainRect = ssMain.getBoundingClientRect();

        document.querySelectorAll('.ss-content').forEach(function(content) {
            const cRect = content.getBoundingClientRect();
            if (Math.abs(cRect.left - mainRect.left) < 5) {
                content.style.setProperty('width', mainRect.width + 'px', 'important');
            }
        });
    }, 10);
});

function htSwitchType(type) {
    document.getElementById('filters-house').style.display = 'none';
    document.getElementById('filters-lot').style.display   = 'none';

    if (type === 'house') {
        document.getElementById('filters-house').style.display = 'block';
        loadPropertiesByType('House', 'f-name-house');
        initializeDashboardFilters('House');
    } else if (type === 'lot') {
        document.getElementById('filters-lot').style.display = 'block';
        loadPropertiesByType('Lot', 'f-name-lot');
        initializeDashboardFilters('Lot');
    } else {
        // If no type selected, load all data
        initializeDashboardFilters('');
    }
}

async function loadPropertiesByType(propertyType, selectId) {
    try {
        const response = await fetch(`/habitrack/ajax/dashboard-filters.ajax.php?action=getProperties&type=${encodeURIComponent(propertyType)}`);
        const result = await response.json();
        
        if (result.success) {
            const select = document.getElementById(selectId);
            
            // Clear existing options except the first one
            while (select.options.length > 1) {
                select.remove(1);
            }
            
            // Add property names — value must be the raw name; model queries WHERE propertyName = :propertyName
            result.data.forEach(propertyName => {
                const option = document.createElement('option');
                option.value = propertyName;
                option.textContent = propertyName;
                select.appendChild(option);
            });
            
            // Reinitialize SlimSelect if it exists
            if (window.slimInstances[selectId]) {
                window.slimInstances[selectId].destroy();
                window.slimInstances[selectId] = new SlimSelect({
                    select: select,
                    settings: {
                        allowDeselect: true,
                        placeholderText: select.options[0]?.text || 'Select…',
                        searchPlaceholder: 'Search…',
                        searchText: 'No results',
                        showArrow: true,
                    }
                });
            }
        }
    } catch (error) {
        console.error('Error loading properties by type:', error);
    }
}

    let properties = [];

    // Fetch properties from database via controller
    async function loadProperties() {
        try {
            const response = await fetch('/habitrack/controllers/dashboard.controller.php?action=getAll');
            const result = await response.json();
            
            if (result.success) {
                properties = result.data;
                globalProperties = result.data;
                initializeMap();
            } else {
                console.error('Error loading properties:', result.error);
                properties = [];
                globalProperties = [];
                initializeMap();
            }
        } catch (error) {
            console.error('Error fetching properties:', error);
            properties = [];
            globalProperties = [];
            initializeMap();
        }
    }

    // Global map and markers variable
    let globalMap = null;
    let globalMarkers = [];
    let globalProperties = [];

    function initializeMap() {
        const map = L.map('ht-map', {
            center:[10.6713, 122.9511],
            zoom:11
        });

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution:'© OpenStreetMap',
                maxZoom:19
            }
        ).addTo(map);

        // ── Icon factory ──────────────────────────────────────────────
        function makeIcon(color) {
            return L.divIcon({
                className: '',
                html: `
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="28" height="38" viewBox="0 0 28 38">
                    <path fill="${color}"
                          stroke="#fff"
                          stroke-width="1.5"
                          d="M14 0C6.27 0 0 6.27 0 14c0 9.63 14 24 14 24S28 23.63 28 14C28 6.27 21.73 0 14 0z"/>
                    <circle cx="14" cy="14" r="5" fill="#fff"/>
                </svg>`,
                iconSize:    [28, 38],
                iconAnchor:  [14, 38],
                popupAnchor: [0, -40]
            });
        }

        const blueIcon  = makeIcon('#2151cc');
        const greenIcon = makeIcon('#16a34a');

        // ── Property detail modal ─────────────────────────────────────
        // Inject modal HTML once into the page
        if (!document.getElementById('ht-prop-modal')) {
            const modal = document.createElement('div');
            modal.id = 'ht-prop-modal';
            modal.style.cssText = `
                display:none;
                position:fixed;
                top:67px;
                right:20px;
                width:320px;
                height:calc(100vh - 67px);
                overflow-y:auto;
                background:#fff;
                border-radius:14px;
                box-shadow:0 8px 32px rgba(0,0,0,.22);
                z-index:9999;
                font-family:inherit;
            `;
            modal.innerHTML = `
                <div id="ht-prop-modal-inner" style="padding:0;">
                    <!-- content injected dynamically -->
                </div>
            `;
            document.body.appendChild(modal);
        }

        function closePropModal() {
            document.getElementById('ht-prop-modal').style.display = 'none';
            // Reset any green marker back to blue
            if (window._htActiveMarker) {
                window._htActiveMarker.setIcon(blueIcon);
                window._htActiveMarker = null;
            }
        }

        async function openPropModal(propertyId, clickedMarker) {
            // Reset previous active marker
            if (window._htActiveMarker && window._htActiveMarker !== clickedMarker) {
                window._htActiveMarker.setIcon(blueIcon);
            }
            // Turn clicked marker green
            clickedMarker.setIcon(greenIcon);
            window._htActiveMarker = clickedMarker;

            // Save the current property ID for agent connect/referral flow
            window._htSelectedPropertyID = propertyId;

            // Show loading state
            const modal = document.getElementById('ht-prop-modal');
            const inner = document.getElementById('ht-prop-modal-inner');
            inner.innerHTML = `
                <div style="padding:28px;text-align:center;color:#6b7280;">
                    <div style="font-size:1.5rem;margin-bottom:8px;">⏳</div>
                    Loading property…
                </div>`;
            modal.style.display = 'block';

            try {
                const res  = await fetch(`/habitrack/controllers/dashboard.controller.php?action=getDetail&id=${propertyId}`);
                const json = await res.json();

                if (!json.success) {
                    inner.innerHTML = `<div style="padding:24px;color:#ef4444;">Failed to load property details.</div>`;
                    return;
                }

                const p = json.data;

                // Build amenity badges
                const amenityMap = {
                    housePowderRoom:'Powder Room', houseGarage:'Garage',
                    houseBalcony:'Balcony', houseTerrace:'Terrace',
                    housePool:'Pool', houseLaundryArea:'Laundry Area',
                    houseMaidRoom:'Maid Room', houseCabinets:'Cabinets',
                    houseBilliardRoom:'Billiard Room', houseClubhouse:'Clubhouse',
                    houseGarden:'Garden'
                };
                const amenityList = Object.entries(amenityMap)
                    .filter(([col]) => p[col] == 1 || p[col] === '1');
                const amenities = amenityList
                    .map(([, label]) => `<span style="display:inline-block;background:#eff6ff;color:#2151cc;border-radius:6px;padding:2px 9px;font-size:.75rem;margin:2px 2px 2px 0;">${label}</span>`)
                    .join('');

                const price = Number(p.propertyPrice || 0).toLocaleString('en-PH');
                const type  = (p.propertyType || '').charAt(0).toUpperCase() + (p.propertyType || '').slice(1);

                inner.innerHTML = `
                    <!-- Header with Image -->
                    <div style="position:relative;border-radius:14px 14px 0 0;overflow:hidden;background:#2151cc;height:${p.imagePath ? '220px' : 'auto'};">
                        <!-- Image Background -->
                        ${p.imagePath ? `
                        <img src="/habitrack${p.imagePath}" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;opacity:0.7;" alt="${p.propertyName || 'Property'}">` : ''}
                        
                        <!-- Overlay Text -->
                        <div style="position:relative;padding:14px 16px 12px;display:flex;justify-content:space-between;align-items:flex-start;height:100%;z-index:2;flex-direction:column;">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;width:100%;">
                                <div>
                                    <div style="color:${p.imagePath ? '#fff' : '#bfdbfe'};font-size:.7rem;letter-spacing:.06em;text-transform:uppercase;font-weight:600;text-shadow:${p.imagePath ? '0 1px 3px rgba(0,0,0,0.3)' : 'none'};">
                                        ${type}
                                        ${p.propertyID ? '· #' + p.propertyID : ''}
                                    </div>
                                    <div style="color:#fff;font-weight:700;font-size:1rem;margin-top:2px;line-height:1.25;text-shadow:0 1px 3px rgba(0,0,0,0.3);">
                                        ${p.propertyName || 'Unnamed Property'}
                                    </div>
                                </div>
                                <button onclick="window._htClosePropModal()"
                                    style="background:rgba(255,255,255,.25);border:none;border-radius:50%;width:30px;height:30px;cursor:pointer;font-size:1.1rem;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-left:8px;backdrop-filter:blur(2px);">
                                    ✕
                                </button>
                            </div>
                            <button onclick="htOpenPicturesModal('${p.propertyID}')"
                                style="align-self:center;margin-top:10px;margin-bottom:10px;background:rgba(255,255,255,0.92);color:#2151cc;border:none;border-radius:20px;padding:5px 16px;font-size:.78rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;">
                                🖼️ View pictures
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div style="padding:16px;">

                        <!-- Price chip -->
                        <div style="background:#f0fdf4;border:1.5px solid #16a34a;border-radius:8px;padding:8px 14px;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                            <span style="font-size:1.15rem;">🏷️</span>
                            <div>
                                <div style="font-size:.68rem;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;">Price</div>
                                <div style="font-weight:700;font-size:1.05rem;color:#16a34a;">₱${price}</div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div style="display:flex;gap:8px;align-items:flex-start;margin-bottom:12px;">
                            <span style="font-size:1rem;margin-top:1px;">📍</span>
                            <div style="font-size:.85rem;color:#374151;line-height:1.4;">
                                ${[p.propertyBrgy, p.propertyCity].filter(Boolean).join(', ') || '—'}
                            </div>
                        </div>

                        <!-- Stats row -->
                        ${p.propertyType === 'house' || p.houseFloorArea ? `
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px;">
                            ${p.houseBedroom ? `<div style="background:#f9fafb;border-radius:8px;padding:8px 6px;text-align:center;">
                                <div style="font-size:1.1rem;">🛏️</div>
                                <div style="font-size:.75rem;color:#6b7280;">Bedroom</div>
                                <div style="font-weight:600;color:#111827;font-size:.9rem;">${p.houseBedroom}</div>
                            </div>` : ''}
                            ${p.houseTandB ? `<div style="background:#f9fafb;border-radius:8px;padding:8px 6px;text-align:center;">
                                <div style="font-size:1.1rem;">🚿</div>
                                <div style="font-size:.75rem;color:#6b7280;">T&amp;B</div>
                                <div style="font-weight:600;color:#111827;font-size:.9rem;">${p.houseTandB}</div>
                            </div>` : ''}
                            ${p.houseStorey ? `<div style="background:#f9fafb;border-radius:8px;padding:8px 6px;text-align:center;">
                                <div style="font-size:1.1rem;">🏠</div>
                                <div style="font-size:.75rem;color:#6b7280;">Storey</div>
                                <div style="font-weight:600;color:#111827;font-size:.9rem;">${p.houseStorey}</div>
                            </div>` : ''}
                        </div>` : ''}

                        <!-- Area info -->
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:14px;">
                            ${p.houseFloorArea ? `<div style="background:#f9fafb;border-radius:8px;padding:8px 10px;">
                                <div style="font-size:.68rem;color:#6b7280;text-transform:uppercase;letter-spacing:.04em;">Floor Area</div>
                                <div style="font-weight:600;color:#111827;font-size:.9rem;">${p.houseFloorArea} sqm</div>
                            </div>` : ''}
                            ${p.propertyLotArea ? `<div style="background:#f9fafb;border-radius:8px;padding:8px 10px;">
                                <div style="font-size:.68rem;color:#6b7280;text-transform:uppercase;letter-spacing:.04em;">Lot Area</div>
                                <div style="font-weight:600;color:#111827;font-size:.9rem;">${p.propertyLotArea} sqm</div>
                            </div>` : ''}
                        </div>

                        <!-- Amenities -->
                        ${amenityList.length > 0 ? `
                        <div style="margin-bottom:14px;">
                            <div style="font-size:.68rem;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Amenities</div>
                            <div>${amenities}</div>
                        </div>` : ''}

                        <!-- Reserve + Agent buttons (only for logged-in clients) -->
                        ${window.HT_CLIENT_LOGGED_IN ? `
                        <button
                            style="width:100%;padding:11px;background:#2151cc;color:#fff;border:none;border-radius:9px;font-size:.9rem;font-weight:600;cursor:pointer;letter-spacing:.02em;margin-top:4px;"
                            onmouseover="this.style.background='#1a42a8'"
                            onmouseout="this.style.background='#2151cc'"
                            onclick="htOpenAgentModal()">
                            Reserve
                        </button>
                        ` : `
                        <div style="margin-top:8px;padding:10px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:9px;text-align:center;font-size:.82rem;color:#6b7280;">
                            <a href="clientlogin" style="color:#2151cc;font-weight:600;text-decoration:none;">Log in</a> to reserve or contact an agent.
                        </div>
                        `}

                    </div><!-- /body -->
                `;

            } catch(err) {
                inner.innerHTML = `<div style="padding:24px;color:#ef4444;">Error: ${err.message}</div>`;
            }
        }

        // Expose close globally for the inline onclick
        window._htClosePropModal = closePropModal;

        // Store map globally
        globalMap = map;

        // Make addMarkers function globally accessible
        window.addMarkers = function(list, autoZoom = true) {
            globalMarkers.forEach(m => globalMap.removeLayer(m));
            globalMarkers = [];

            // Close modal & reset active marker when markers are refreshed
            closePropModal();

            list.forEach(p => {

                const marker = L.marker(
                    [p.lat, p.lng],
                    { icon: blueIcon }
                )
                .addTo(globalMap);

                // Click → open floating modal, turn marker green
                marker.on('click', function() {
                    openPropModal(p.id, marker);
                });

                globalMarkers.push(marker);
            });

            // Automatically zoom to show markers ONLY if autoZoom is true
            if (autoZoom) {
                if (globalMarkers.length === 0) {
                    // No markers - show full map
                    globalMap.setView([10.6713, 122.9511], 11);
                } else if (globalMarkers.length === 1) {
                    // Single marker - zoom to it
                    globalMap.setView([list[0].lat, list[0].lng], 14);
                } else {
                    // Multiple markers - fit all in view
                    const group = L.featureGroup(globalMarkers);
                    globalMap.fitBounds(group.getBounds().pad(0.1));
                }
            }

            document.getElementById('result-count').textContent =
                list.length === globalProperties.length
                ? 'Showing all properties'
                : `${list.length} properties found`;
        };

        // Initial load - show NO markers (pass empty array)
        window.addMarkers([], false);

        window.filterProperties = async function () {
            try {
                const params = new URLSearchParams();
                params.append('action', 'search');

                // Property type
                const typeVal = document.getElementById('f-type')?.value;
                if (typeVal) params.append('type', typeVal);

                // Determine active panel to avoid reading hidden inputs
                const isHouse = typeVal === 'house';
                const isLot   = typeVal === 'lot';

                // Location — only read from the visible panel
                if (isHouse) {
                    const loc = document.getElementById('f-location-house')?.value;
                    if (loc) params.append('location', loc);
                } else if (isLot) {
                    const loc = document.getElementById('f-location-lot')?.value;
                    if (loc) params.append('location', loc);
                }

                // House-only specs
                if (isHouse) {
                    const storeyVal = document.getElementById('f-storey')?.value;
                    if (storeyVal) params.append('storey', storeyVal);

                    const bedroomVal = document.getElementById('f-bedroom')?.value;
                    if (bedroomVal) params.append('bedroom', bedroomVal);

                    const tbVal = document.getElementById('f-tb')?.value;
                    if (tbVal) params.append('tb', tbVal);

                    const floorAreaVal = document.getElementById('f-floor-area')?.value;
                    if (floorAreaVal) params.append('floorArea', floorAreaVal);

                    const lotAreaHouseVal = document.getElementById('f-lot-area-house')?.value;
                    if (lotAreaHouseVal) params.append('lotAreaHouse', lotAreaHouseVal);

                    // Amenities — values are already the real column names (housePowderRoom etc.)
                    const amenitiesSelect = document.getElementById('f-amenities');
                    if (amenitiesSelect) {
                        Array.from(amenitiesSelect.selectedOptions).forEach(opt => {
                            if (opt.value) params.append('amenities[]', opt.value);
                        });
                    }

                    const propNameHouse = document.getElementById('f-name-house')?.value;
                    if (propNameHouse) params.append('propertyName', propNameHouse);

                    // Price — read from house panel inputs
                    const housePanel = document.getElementById('filters-house');
                    const priceStart = housePanel?.querySelector('.ht-price-input[placeholder="Price Start"]')?.value;
                    const priceEnd   = housePanel?.querySelector('.ht-price-input[placeholder="Price End"]')?.value;
                    if (priceStart) params.append('priceStart', priceStart);
                    if (priceEnd)   params.append('priceEnd',   priceEnd);
                }

                // Lot-only specs
                if (isLot) {
                    const sizeRangeVal = document.getElementById('f-size-range')?.value;
                    if (sizeRangeVal) params.append('sizeRange', sizeRangeVal);

                    const lotAreaVal = document.getElementById('f-lot-area')?.value;
                    if (lotAreaVal) params.append('lotArea', lotAreaVal);

                    const propNameLot = document.getElementById('f-name-lot')?.value;
                    if (propNameLot) params.append('propertyName', propNameLot);

                    // Price — read from lot panel inputs
                    const lotPanel = document.getElementById('filters-lot');
                    const priceStart = lotPanel?.querySelector('.ht-price-input[placeholder="Price Start"]')?.value;
                    const priceEnd   = lotPanel?.querySelector('.ht-price-input[placeholder="Price End"]')?.value;
                    if (priceStart) params.append('priceStart', priceStart);
                    if (priceEnd)   params.append('priceEnd',   priceEnd);
                }

                console.log('Sending filter search:', params.toString());

                const response = await fetch(
                    `/habitrack/controllers/dashboard.controller.php?${params.toString()}`
                );
                const result = await response.json();

                console.log('Filter response:', result);

                if (result.success) {
                    addMarkers(result.data);

                    // Update result count
                    const countElem = document.getElementById('result-count');
                    if (countElem) {
                        countElem.textContent = result.count === globalProperties.length
                            ? 'Showing all properties'
                            : `${result.count} properties found`;
                    }

                    // Adjust map view based on results
                    if (result.data.length === 1) {
                        globalMap.setView([result.data[0].lat, result.data[0].lng], 14);
                    } else if (result.data.length > 1) {
                        const group = L.featureGroup(globalMarkers);
                        globalMap.fitBounds(group.getBounds().pad(0.2));
                    }
                } else {
                    console.error('Search error:', result.error);
                    addMarkers([]);
                }
            } catch (error) {
                console.error('Filter error:', error);
            }
        };

        window.clearFilters = function () {
            [
                'f-type',
                'f-location-house',
                'f-location-lot',
                'f-storey',
                'f-bedroom',
                'f-tb',
                'f-name-house',
                'f-name-lot',
                'f-floor-area',
                'f-lot-area-house',
                'f-lot-area',
                'f-size-range',
                'f-amenities',
            ].forEach(id => {
                const elem = document.getElementById(id);
                if (!elem) return;
                elem.value = '';
                if (window.slimInstances && window.slimInstances[id]) {
                    window.slimInstances[id].setSelected('');
                }
            });

            // Clear price inputs in both panels
            document.querySelectorAll('.ht-price-input').forEach(el => el.value = '');

            // Hide both filter panels
            document.getElementById('filters-house').style.display = 'none';
            document.getElementById('filters-lot').style.display   = 'none';

            addMarkers(globalProperties);
            globalMap.setView([10.6713, 122.9511], 11);
        };

        window.viewDetails = function () {
            if (globalMarkers.length === 1) {
                globalMarkers[0].openPopup();
            } else {
                alert('Narrow your search to one property first.');
            }
        };
    }

    // ────────────────────────────────────────────────────────────────
    //  FILTER SEARCH - Called from dashboard search button
    // ────────────────────────────────────────────────────────────────
    window.filterProperties = async function () {
        console.log('Filter Properties called!');
        try {
            // Collect all filter values
            const filters = new FormData();
            
            // Property type
            const typeVal = document.getElementById('f-type')?.value;
            if (typeVal) filters.append('type', typeVal);
            
            // Location (house or lot)
            const locHouse = document.getElementById('f-location-house')?.value;
            const locLot = document.getElementById('f-location-lot')?.value;
            if (locHouse) filters.append('location', locHouse);
            if (locLot) filters.append('location', locLot);
            
            // House specs
            const storeyVal = document.getElementById('f-storey')?.value;
            if (storeyVal) filters.append('storey', storeyVal);
            
            const bedroomVal = document.getElementById('f-bedroom')?.value;
            if (bedroomVal) filters.append('bedroom', bedroomVal);
            
            const tbVal = document.getElementById('f-tb')?.value;
            if (tbVal) filters.append('tb', tbVal);
            
            const floorAreaVal = document.getElementById('f-floor-area')?.value;
            if (floorAreaVal) filters.append('floorArea', floorAreaVal);
            
            const lotAreaVal = document.getElementById('f-lot-area-house')?.value;
            if (lotAreaVal) filters.append('lotAreaHouse', lotAreaVal);
            
            // Send AJAX request to controller
            const queryString = new URLSearchParams(filters).toString();
            console.log('Sending filter search:', queryString);
            
            const response = await fetch(
                `/habitrack/controllers/dashboard.controller.php?action=search&${queryString}`
            );
            const result = await response.json();
            
            console.log('Filter response:', result);
            
            if (result.success && result.data) {
                console.log('Got ' + result.count + ' properties');
                
                // Update markers with filtered results - WITH auto-zoom enabled
                if (typeof window.addMarkers === 'function') {
                    window.addMarkers(result.data, true);
                    console.log('Markers updated and map zoomed!');
                } else {
                    console.log('addMarkers function not found');
                }
            } else {
                console.error('Search error:', result.error);
                // Show all markers again if search fails
                if (typeof window.addMarkers === 'function' && typeof window.globalProperties !== 'undefined') {
                    window.addMarkers(window.globalProperties, false);
                }
            }
        } catch (error) {
            console.error('Filter error:', error);
        }
    };

    // Load properties and initialize map
    loadProperties();