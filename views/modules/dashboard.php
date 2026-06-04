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
                    </select>
                </div>

                <div class="ht-sel-wrap">
                    <select id="f-amenities" class="ht-sel" multiple>
                        <option value="" data-placeholder="true">Amenities</option>
                        <option value="housePowderRoom">Powder Room</option>
                        <option value="houseGarage">Garage</option>
                        <option value="houseBalcony">Balcony</option>
                        <option value="houseTerrace">Terrace</option>
                        <option value="housePool">Pool</option>
                        <option value="houseLaundryArea">Laundry Area</option>
                        <option value="houseMaidRoom">Maid Room</option>
                        <option value="houseCabinets">Cabinets</option>
                        <option value="houseBilliardRoom">Billiard Room</option>
                        <option value="houseClubhouse">Clubhouse</option>
                        <option value="houseGarden">Garden</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Property Name</p>
                <div class="ht-sel-wrap">
                    <select id="f-name-house" class="ht-sel">
                        <option value="" data-placeholder="true">All Properties</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Area &amp; Price</p>
                <div class="ht-grid2">
                    <div class="ht-sel-wrap">
                        <select id="f-floor-area" class="ht-sel">
                            <option value="" data-placeholder="true">Floor Area</option>
                        </select>
                    </div>
                    <div class="ht-sel-wrap">
                        <select id="f-lot-area-house" class="ht-sel">
                            <option value="" data-placeholder="true">Lot Area</option>
                        </select>
                    </div>
                </div>

                <div class="ht-sel-wrap" style="position:relative;">
                    <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.82rem; color:#9ca3af; pointer-events:none;">₱</span>
                    <input type="number" id="f-house-price-start" class="ht-price-input"
                        placeholder="Price Start" min="0" step="1000"
                        style="padding-left: 22px;">
                </div>
                <div class="ht-sel-wrap" style="position:relative;">
                    <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.82rem; color:#9ca3af; pointer-events:none;">₱</span>
                    <input type="number" id="f-house-price-end" class="ht-price-input"
                        placeholder="Price End" min="0" step="1000"
                        style="padding-left: 22px;">
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
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Size Range</p>
                <div class="ht-sel-wrap">
                    <select id="f-size-range" class="ht-sel">
                        <option value="" data-placeholder="true">All Sizes</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Property Name</p>
                <div class="ht-sel-wrap">
                    <select id="f-name-lot" class="ht-sel">
                        <option value="" data-placeholder="true">All Properties</option>
                    </select>
                </div>

                <hr class="ht-hr">
                <p class="ht-label">Lot Area &amp; Price</p>
                <div class="ht-sel-wrap">
                    <select id="f-lot-area" class="ht-sel">
                        <option value="" data-placeholder="true">Lot Area</option>
                    </select>
                </div>

                <div class="ht-sel-wrap" style="position:relative;">
                    <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.82rem; color:#9ca3af; pointer-events:none;">₱</span>
                    <input type="number" id="f-lot-price-start" class="ht-price-input"
                        placeholder="Price Start" min="0" step="1000"
                        style="padding-left: 22px;">
                </div>
                <div class="ht-sel-wrap" style="position:relative;">
                    <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); font-size:.82rem; color:#9ca3af; pointer-events:none;">₱</span>
                    <input type="number" id="f-lot-price-end" class="ht-price-input"
                        placeholder="Price End" min="0" step="1000"
                        style="padding-left: 22px;">
                </div>

                <hr class="ht-hr">
                <button class="ht-btn ht-btn-primary" onclick="filterProperties()">🔍 Search</button>
            </div>
            <!-- /filters-lot -->

        </aside>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     PROPERTY DETAIL MODAL
══════════════════════════════════════════════════════════ -->
<div id="ht-property-modal" style="
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(2px);
    align-items: center;
    justify-content: center;
">
    <!-- Modal Card -->
    <div style="
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 520px;
        margin: 16px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.25);
        overflow: hidden;
        position: relative;
        animation: htModalIn .2s ease;
    ">

        <!-- Loading State -->
        <div id="modal-loading" style="padding: 48px; text-align: center; display: none;">
            <div style="
                width: 40px; height: 40px;
                border: 3px solid #e5e7eb;
                border-top-color: #3b82f6;
                border-radius: 50%;
                animation: htSpin .7s linear infinite;
                margin: 0 auto 12px;
            "></div>
            <p style="color: #6b7280; font-size: .9rem; margin: 0;">Loading property details…</p>
        </div>

        <!-- Error State -->
        <div id="modal-error" style="padding: 48px; text-align: center; display: none;">
            <div style="font-size: 2rem; margin-bottom: 8px;">⚠️</div>
            <p id="modal-error-msg" style="color: #dc2626; font-size: .9rem; margin: 0 0 16px;">Failed to load property details.</p>
            <button onclick="htCloseModal()" style="
                background: #f3f4f6; border: none; border-radius: 8px;
                padding: 8px 20px; cursor: pointer; font-size: .85rem; color: #374151;
            ">Close</button>
        </div>

        <!-- Content State -->
        <div id="modal-content" style="display: none;">

            <!-- Header / Hero -->
            <div id="modal-header" style="
                background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
                padding: 24px 24px 20px;
                color: #fff;
                position: relative;
            ">
                <!-- Close button -->
                <button onclick="htCloseModal()" style="
                    position: absolute; top: 14px; right: 14px;
                    background: rgba(255,255,255,0.2); border: none;
                    border-radius: 50%; width: 30px; height: 30px;
                    cursor: pointer; color: #fff; font-size: 1rem;
                    line-height: 30px; text-align: center;
                    transition: background .15s;
                " onmouseover="this.style.background='rgba(255,255,255,0.35)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)'">&times;</button>

                <!-- Type badge -->
                <span id="modal-type-badge" style="
                    display: inline-block;
                    background: rgba(255,255,255,0.25);
                    border-radius: 20px;
                    padding: 2px 12px;
                    font-size: .75rem;
                    font-weight: 600;
                    letter-spacing: .04em;
                    text-transform: uppercase;
                    margin-bottom: 8px;
                "></span>

                <h2 id="modal-name" style="margin: 0 0 4px; font-size: 1.25rem; font-weight: 700; line-height: 1.3;"></h2>
                <p id="modal-location" style="margin: 0; font-size: .85rem; opacity: .85;">
                    📍 <span></span>
                </p>
            </div>

            <!-- Price Bar -->
            <div id="modal-price-bar" style="
                background: #f0fdf4;
                border-bottom: 1px solid #dcfce7;
                padding: 12px 24px;
                display: flex;
                align-items: center;
                gap: 8px;
            ">
                <span style="color: #15803d; font-size: 1.4rem; font-weight: 800;" id="modal-price"></span>
            </div>

            <!-- Body -->
            <div style="padding: 20px 24px;">

                <!-- Quick Stats Grid -->
                <div id="modal-specs-grid" style="
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
                    gap: 10px;
                    margin-bottom: 18px;
                "></div>

                <!-- Amenities -->
                <div id="modal-amenities-section" style="display:none; margin-bottom: 18px;">
                    <p style="margin: 0 0 8px; font-size: .78rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .06em;">Amenities</p>
                    <div id="modal-amenities-list" style="display: flex; flex-wrap: wrap; gap: 6px;"></div>
                </div>

                <!-- Status -->
                <div id="modal-status-row" style="
                    display: flex; align-items: center; gap: 8px;
                    padding: 10px 14px;
                    background: #f9fafb;
                    border-radius: 8px;
                    font-size: .85rem;
                    color: #374151;
                ">
                    <span style="font-size: 1rem;">🏷️</span>
                    Status: <strong id="modal-status" style="color: #3b82f6;"></strong>
                </div>

            </div>

            <!-- Footer -->
            <div style="
                padding: 14px 24px;
                border-top: 1px solid #f3f4f6;
                display: flex;
                justify-content: space-between;
                gap: 8px;
            ">
                <button onclick="htOpenPicturesModal(window._htSelectedPropertyID)" style="
                    background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
                    border: none;
                    border-radius: 8px;
                    padding: 9px 20px;
                    cursor: pointer;
                    font-size: .85rem;
                    color: #fff;
                    font-weight: 500;
                    transition: opacity .15s;
                " onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    📷 View Pictures
                </button>
                <button onclick="htCloseModal()" style="
                    background: #f3f4f6; border: none; border-radius: 8px;
                    padding: 9px 20px; cursor: pointer; font-size: .85rem; color: #374151;
                    font-weight: 500;
                ">Close</button>
            </div>

        </div>
        <!-- /modal-content -->
    </div>
</div>

<!-- Modal animations -->
<style>
@keyframes htModalIn {
    from { opacity: 0; transform: translateY(16px) scale(.97); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
}
@keyframes htSpin {
    to { transform: rotate(360deg); }
}
</style>

<!-- ══════════════════════════════════════════════════════════
     AGENT MODAL
     Opened by: htOpenAgentModal() in property-modal.js
     Triggered by: "Agent" button inside the property side panel (map.js)
══════════════════════════════════════════════════════════ -->
<div id="ht-agent-modal" style="
    display: none;
    position: fixed;
    inset: 0;
    z-index: 10000;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(2px);
    align-items: center;
    justify-content: center;
">
    <!-- Modal Card -->
    <div style="
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 460px;
        margin: 16px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.25);
        overflow: hidden;
        position: relative;
        animation: htModalIn .2s ease;
        max-height: calc(100vh - 80px);
        display: flex;
        flex-direction: column;
    ">

        <!-- ── LOADING STATE ── -->
        <div id="agent-modal-loading" style="padding: 48px; text-align: center; display: none;">
            <div style="
                width: 40px; height: 40px;
                border: 3px solid #e5e7eb;
                border-top-color: #3b82f6;
                border-radius: 50%;
                animation: htSpin .7s linear infinite;
                margin: 0 auto 12px;
            "></div>
            <p style="color: #6b7280; font-size: .9rem; margin: 0;">Loading agents…</p>
        </div>

        <!-- ── ERROR STATE ── -->
        <div id="agent-modal-error" style="padding: 48px; text-align: center; display: none;">
            <div style="font-size: 2rem; margin-bottom: 8px;">⚠️</div>
            <p id="agent-modal-error-msg" style="color: #dc2626; font-size: .9rem; margin: 0 0 16px;">Failed to load agents.</p>
            <button onclick="htCloseAgentModal()" style="
                background: #f3f4f6; border: none; border-radius: 8px;
                padding: 8px 20px; cursor: pointer; font-size: .85rem; color: #374151;
            ">Close</button>
        </div>

        <!-- ── LIST STATE ── -->
        <div id="agent-modal-list" style="display: none; flex-direction: column; overflow: hidden; flex: 1;">
            <!-- Header -->
            <div style="
                background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
                padding: 18px 20px 16px;
                display: flex;
                align-items: center;
                gap: 10px;
                flex-shrink: 0;
            ">
                <div style="width:28px;flex-shrink:0;"></div>
                <h2 style="flex:1;text-align:center;margin:0;font-size:1rem;font-weight:700;color:#fff;">List of agents</h2>
                <button onclick="htCloseAgentModal()" style="
                    background: rgba(255,255,255,0.2); border: none; border-radius: 50%;
                    width: 28px; height: 28px; color: #fff; font-size: 1rem;
                    cursor: pointer; display: flex; align-items: center; justify-content: center;
                    line-height: 1; flex-shrink: 0;
                ">&times;</button>
            </div>
            <!-- Hint -->
            <p style="margin:0;font-size:11px;color:#9ca3af;text-align:center;padding:7px 12px;background:#f9fafb;border-bottom:1px solid #f3f4f6;flex-shrink:0;">
                Double-click any agent to view full details
            </p>
            <!-- Scrollable list -->
            <div id="agent-list-items" style="overflow-y:auto;flex:1;"></div>
        </div>

        <!-- ── DETAIL STATE ── -->
        <div id="agent-modal-detail" style="display: none; overflow-y: auto; flex: 1;">
            <!-- Populated dynamically by property-modal.js → _htOpenAgentDetail() -->
        </div>

    </div>
</div>

<!-- ══════════════════════════════════════════════════════════
     PRE-QUALIFICATION MODAL
     Opened by: htOpenPrequalModal() in property-modal.js
     Triggered by: "Connect to agent" button
══════════════════════════════════════════════════════════ -->
<div id="ht-prequal-modal" style="
    display: none;
    position: fixed;
    inset: 0;
    z-index: 10001;
    background: transparent;
    align-items: center;
    justify-content: center;
    flex-direction: column;
">
    <!-- Modal Card -->
    <div style="
        background: #fff;
        border-radius: 16px;
        width: 100%;
        max-width: 860px;
        margin: 16px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        overflow: hidden;
        position: relative;
        animation: htModalIn .2s ease;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    ">
        <!-- Notification Card (shown before form) -->
        <div id="prequal-notification" style="display: none; padding: 16px; background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%); text-align: center; border-radius: 12px; max-width: 400px; margin: auto;">
            <div style="color: #fff;">
                <div style="font-size: 1.5rem; margin-bottom: 8px;">✓</div>
                <h3 style="margin: 0 0 6px; font-size: 1rem; font-weight: 600;">Connected to Agent</h3>
                <p id="prequal-agent-name" style="margin: 0 0 12px; font-size: 0.9rem; opacity: 0.9;"></p>
                <p style="margin: 0 0 12px; font-size: 0.85rem; opacity: 0.85;">Please fill up this pre-qualification form.</p>
            </div>
            <button onclick="htShowPrequalForm()" style="
                background: rgba(255,255,255,0.3);
                border: 1px solid rgba(255,255,255,0.5);
                color: #fff;
                padding: 8px 18px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 13px;
                font-weight: 600;
                transition: background .15s;
            " onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.3)'">
                Continue
            </button>
        </div>

        <!-- Pre-qual Form Container -->
        <div id="prequal-form-container" style="display: none; flex: 1; overflow-y: auto; background: #fff;">
            <!-- Form will be loaded here -->
        </div>

        <!-- Close Button (always visible) -->
        <button onclick="htClosePrequalModal()" style="
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(0,0,0,0.1);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            color: #374151;
            font-size: 1.2rem;
            line-height: 30px;
            text-align: center;
            z-index: 10;
            transition: background .15s;
        " onmouseover="this.style.background='rgba(0,0,0,0.15)'" onmouseout="this.style.background='rgba(0,0,0,0.1)'">&times;</button>
    </div>
</div>

<div id="ht-pictures-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.88);align-items:center;justify-content:center;flex-direction:column;">

    <!-- Top bar -->
    <div style="width:100%;max-width:860px;display:flex;justify-content:space-between;align-items:center;padding:14px 20px 10px;box-sizing:border-box;">
        <div>
            <div id="pics-modal-subtitle" style="color:rgba(255,255,255,0.55);font-size:.7rem;text-transform:uppercase;letter-spacing:.06em;"></div>
            <div id="pics-modal-counter" style="color:#fff;font-size:.85rem;font-weight:600;margin-top:2px;">Image 1 of 1</div>
        </div>
        <button onclick="htClosePicturesModal()" style="background:rgba(255,255,255,0.15);border:none;border-radius:50%;width:34px;height:34px;color:#fff;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">&times;</button>
    </div>

    <!-- Main image area -->
    <div style="position:relative;width:100%;max-width:860px;flex:1;display:flex;align-items:center;justify-content:center;padding:0 20px;box-sizing:border-box;min-height:0;">

        <!-- Prev -->
        <button id="pics-prev-btn" onclick="htPicsNav(-1)"
            style="position:absolute;left:24px;z-index:2;background:rgba(255,255,255,0.18);border:none;border-radius:50%;width:42px;height:42px;color:#fff;font-size:1.4rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">&#8249;</button>

        <!-- Image -->
        <img id="pics-main-img"
            src=""
            alt="Property image"
            style="max-width:100%;max-height:calc(100vh - 220px);border-radius:10px;object-fit:contain;display:none;">

        <!-- Loading / no images state -->
        <div id="pics-loading" style="display:none;color:rgba(255,255,255,0.5);font-size:.95rem;text-align:center;">Loading images…</div>
        <div id="pics-empty" style="display:none;color:rgba(255,255,255,0.5);font-size:.95rem;text-align:center;">No images available for this property.</div>

        <!-- Next -->
        <button id="pics-next-btn" onclick="htPicsNav(1)"
            style="position:absolute;right:24px;z-index:2;background:rgba(255,255,255,0.18);border:none;border-radius:50%;width:42px;height:42px;color:#fff;font-size:1.4rem;cursor:pointer;display:flex;align-items:center;justify-content:center;">&#8250;</button>

    </div>

    <!-- Thumbnail strip -->
    <div id="pics-thumbs" style="display:flex;gap:8px;justify-content:center;padding:14px 20px 18px;flex-wrap:wrap;max-width:860px;box-sizing:border-box;"></div>

</div>

<script>
    var HT_CLIENT_LOGGED_IN = <?= isset($_SESSION['clientID']) ? 'true' : 'false'; ?>;
</script>
<!-- Property modal logic (includes agent modal logic) -->
<script src="/habitrack/views/js/property-modal.js"></script>