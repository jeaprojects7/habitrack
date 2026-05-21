<?php
/**
 * HabiTrack – Map Module
 * Routed via: ?route=guest
 */
?>



<div
    id="main-area"
    class="map-page fixed overflow-hidden transition-all duration-300"
    style="
        top:67px;
        left:300px;
        right:0;
        bottom:0;
        z-index:20;
    "
>
    <div class="ht-map-wrapper">

        <!-- Map -->
        <div id="ht-map"></div>

        <!-- Right Filter Panel -->
        <aside class="ht-panel">

            <!-- ── Property Type (always visible) ── -->
            <div class="ht-sel-wrap">
                <select id="f-type" class="ht-sel">
                    <option value="" data-placeholder="true">Property Type</option>
                    <option value="house">House and Lot</option>
                    <option value="lot">Lot</option>
                </select>
            </div>

            <!-- ════════════════════════════════════
                 HOUSE & LOT FILTERS
            ════════════════════════════════════ -->
            <div id="filters-house" class="ht-filter-group" style="display:none;">

                <hr class="ht-hr">
                <p class="ht-label">Location</p>
                <div class="ht-sel-wrap">
                    <select id="f-location-house" class="ht-sel">
                        <option value="" data-placeholder="true">All Locations</option>
                        <option value="bacolod">Bacolod City</option>
                        <option value="talisay">Talisay City</option>
                        <option value="silay">Silay City</option>
                        <option value="bago">Bago City</option>
                        <option value="victorias">Victorias City</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Specifications</p>

                <div class="ht-grid2">
                    <div class="ht-sel-wrap">
                        <select id="f-storey" class="ht-sel">
                            <option value="" data-placeholder="true">Storey</option>
                            <option value="1">1 Storey</option>
                            <option value="2">2 Storey</option>
                            <option value="3">3+ Storey</option>
                        </select>
                    </div>
                    <div class="ht-sel-wrap">
                        <select id="f-bedroom" class="ht-sel">
                            <option value="" data-placeholder="true">Bedroom</option>
                            <option value="1">1 BR</option>
                            <option value="2">2 BR</option>
                            <option value="3">3 BR</option>
                            <option value="4">4+ BR</option>
                        </select>
                    </div>
                    </div>

                <div class="ht-sel-wrap">
                    <select id="f-tb" class="ht-sel">
                        <option value="" data-placeholder="true">Toilet and Bathroom</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3+</option>
                    </select>
                </div>

                <div class="ht-sel-wrap">
                    <select id="f-amenities" class="ht-sel">
                        <option value="" data-placeholder="true">Amenities</option>
                        <option value="pool">Swimming Pool</option>
                        <option value="garage">Garage</option>
                        <option value="garden">Garden</option>
                        <option value="gym">Gym</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Property Name</p>
                <div class="ht-sel-wrap">
                    <select id="f-name-house" class="ht-sel">
                        <option value="" data-placeholder="true">All Properties</option>
                        <option value="villa-rosa">Villa Rosa</option>
                        <option value="palm-residences">Palm Residences</option>
                        <option value="sugarland">Sugarland Homes</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Area &amp; Price</p>
                <div class="ht-grid2">
                    <div class="ht-sel-wrap">
                        <select id="f-floor-area" class="ht-sel">
                            <option value="" data-placeholder="true">Floor Area</option>
                            <option value="50">≤ 50 sqm</option>
                            <option value="100">51–100 sqm</option>
                            <option value="150">101–150 sqm</option>
                            <option value="150+">150+ sqm</option>
                        </select>
                    </div>
                    <div class="ht-sel-wrap">
                        <select id="f-lot-area-house" class="ht-sel">
                            <option value="" data-placeholder="true">Lot Area</option>
                            <option value="100">≤ 100 sqm</option>
                            <option value="200">101–200 sqm</option>
                            <option value="300">201–300 sqm</option>
                            <option value="300+">300+ sqm</option>
                        </select>
                    </div>
                </div>

                <div class="ht-grid2">
                    <div class="ht-sel-wrap">
                        <select id="f-price-start" class="ht-sel">
                            <option value="" data-placeholder="true">Price Start</option>
                            <option value="500k">₱500K</option>
                            <option value="1m">₱1M</option>
                            <option value="3m">₱3M</option>
                            <option value="5m">₱5M</option>
                        </select>
                    </div>
                    <div class="ht-sel-wrap">
                        <select id="f-price-end" class="ht-sel">
                            <option value="" data-placeholder="true">Price End</option>
                            <option value="1m">₱1M</option>
                            <option value="3m">₱3M</option>
                            <option value="5m">₱5M</option>
                            <option value="5m+">₱5M+</option>
                        </select>
                    </div>
                </div>

                <hr class="ht-hr">
                <button class="ht-btn ht-btn-primary" onclick="filterProperties()">🔍 Search</button>
            </div>
            <!-- /filters-house -->

            <!-- ════════════════════════════════════
                 LOT FILTERS
            ════════════════════════════════════ -->
            <div id="filters-lot" class="ht-filter-group" style="display:none;">

                <hr class="ht-hr">
                <p class="ht-label">Location</p>
                <div class="ht-sel-wrap">
                    <select id="f-location-lot" class="ht-sel">
                        <option value="" data-placeholder="true">All Locations</option>
                        <option value="bacolod">Bacolod City</option>
                        <option value="talisay">Talisay City</option>
                        <option value="silay">Silay City</option>
                        <option value="bago">Bago City</option>
                        <option value="victorias">Victorias City</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Size Range</p>
                <div class="ht-sel-wrap">
                    <select id="f-size-range" class="ht-sel">
                        <option value="" data-placeholder="true">All Sizes</option>
                        <option value="100">≤ 100 sqm</option>
                        <option value="300">101–300 sqm</option>
                        <option value="500">301–500 sqm</option>
                        <option value="500+">500+ sqm</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Property Name</p>
                <div class="ht-sel-wrap">
                    <select id="f-name-lot" class="ht-sel">
                        <option value="" data-placeholder="true">All Properties</option>
                        <option value="lot-a">Lot A – Talisay</option>
                        <option value="lot-b">Lot B – Silay</option>
                        <option value="lot-c">Lot C – Bacolod</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Lot Area &amp; Price</p>
                <div class="ht-sel-wrap">
                    <select id="f-lot-area" class="ht-sel">
                        <option value="" data-placeholder="true">Lot Area</option>
                        <option value="100">≤ 100 sqm</option>
                        <option value="300">101–300 sqm</option>
                        <option value="500">301–500 sqm</option>
                        <option value="500+">500+ sqm</option>
                    </select>
                </div>

                <div class="ht-grid2">
                    <div class="ht-sel-wrap">
                        <select id="f-lot-price-start" class="ht-sel">
                            <option value="" data-placeholder="true">Price Start</option>
                            <option value="200k">₱200K</option>
                            <option value="500k">₱500K</option>
                            <option value="1m">₱1M</option>
                        </select>
                    </div>
                    <div class="ht-sel-wrap">
                        <select id="f-lot-price-end" class="ht-sel">
                            <option value="" data-placeholder="true">Price End</option>
                            <option value="500k">₱500K</option>
                            <option value="1m">₱1M</option>
                            <option value="3m">₱3M+</option>
                        </select>
                    </div>
                </div>

                <hr class="ht-hr">
                <button class="ht-btn ht-btn-primary" onclick="filterProperties()">🔍 Search</button>
            </div>
            <!-- /filters-lot -->

        </aside>
    </div>
</div>

<script>
window.slimInstances = {};

document.querySelectorAll('.ht-sel').forEach(function(el) {
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
    } else if (type === 'lot') {
        document.getElementById('filters-lot').style.display = 'block';
    }
}
</script>

<!-- /* ── Init all panel selects with SlimSelect ── */
document.querySelectorAll('.ht-sel').forEach(function(el) {
    new SlimSelect({
        select: el,
        settings: {
            allowDeselect: true,
            placeholderText: el.options[0]?.text || 'Select…',
            searchPlaceholder: 'Search…',
            searchText: 'No results',
            showArrow: true,
        }
    });
});

/* ── Switch visible filter group ── */
function htSwitchType(type) {
    document.getElementById('filters-house').style.display = 'none';
    document.getElementById('filters-lot').style.display   = 'none';

    if (type === 'house') {
        document.getElementById('filters-house').style.display = 'block';
    } else if (type === 'lot') {
        document.getElementById('filters-lot').style.display = 'block';
    }
}

/* Wire Property Type dropdown to htSwitchType */
document.querySelector('#f-type').addEventListener('change', function() {
    htSwitchType(this.value);
}); -->
