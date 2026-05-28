/**
 * HabiTrack – Property Detail Modal
 * Depends on: #ht-property-modal and its child elements in dashboard.php
 * Called by: map.js → htOpenPropertyModal(propertyId)
 */

// ─────────────────────────────────────────────
//  PUBLIC API
// ─────────────────────────────────────────────

/**
 * Open the modal and fetch property details by ID.
 * Called from map.js marker click handler.
 */

function htOpenPropertyModal(propertyId) {
    const modal = document.getElementById('ht-property-modal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    _htModalShow('loading');

    fetch('/habitrack/controllers/dashboard.controller.php?action=getDetail&id=' + encodeURIComponent(propertyId))
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(json) {
            if (!json.success) throw new Error(json.error || 'Unknown error');
            _htRenderModal(json.data);
        })
        .catch(function(err) {
            document.getElementById('modal-error-msg').textContent =
                'Failed to load property details. ' + (err.message || '');
            _htModalShow('error');
        });
}

/**
 * Close the modal.
 */
function htCloseModal() {
    const modal = document.getElementById('ht-property-modal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// ─────────────────────────────────────────────
//  PRIVATE HELPERS
// ─────────────────────────────────────────────

/** Switch which panel is visible inside the modal. */
function _htModalShow(state) {
    ['loading', 'error', 'content'].forEach(function(s) {
        document.getElementById('modal-' + s).style.display = (s === state) ? 'block' : 'none';
    });
}

/** Populate modal fields from the property object returned by the API. */
function _htRenderModal(p) {
    // Type badge
    document.getElementById('modal-type-badge').textContent = p.propertyType || 'Property';

    // Name
    document.getElementById('modal-name').textContent = p.propertyName || '—';

    // Location
    const city = p.propertyCity || '';
    const brgy = p.propertyBrgy || '';
    document.querySelector('#modal-location span').textContent =
        [city, brgy].filter(Boolean).join(', ') || 'Location not specified';

    // Price
    const price = parseFloat(p.propertyPrice || 0);
    document.getElementById('modal-price').textContent =
        price > 0
            ? '₱ ' + price.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
            : 'Price on request';

    // Specs grid
    const specs = [];
    if (p.houseStorey    > 0) specs.push({ icon: '🏠', label: 'Storey',     value: p.houseStorey });
    if (p.houseBedroom   > 0) specs.push({ icon: '🛏️', label: 'Bedrooms',   value: p.houseBedroom });
    if (p.houseTandB     > 0) specs.push({ icon: '🚿', label: 'Bathrooms',  value: p.houseTandB });
    if (p.houseFloorArea > 0) specs.push({ icon: '📐', label: 'Floor Area', value: p.houseFloorArea + ' m²' });
    if (p.propertyLotArea > 0) specs.push({ icon: '🗺️', label: 'Lot Area',  value: p.propertyLotArea + ' m²' });

    document.getElementById('modal-specs-grid').innerHTML = specs.map(function(s) {
        return '<div style="background:#f9fafb;border-radius:10px;padding:10px 12px;text-align:center;">' +
            '<div style="font-size:1.3rem;line-height:1;">'                                  + s.icon  + '</div>' +
            '<div style="font-size:1rem;font-weight:700;color:#111827;margin:4px 0 2px;">'   + s.value + '</div>' +
            '<div style="font-size:.72rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.04em;">' + s.label + '</div>' +
        '</div>';
    }).join('');

    // Amenities
    const amenityMap = {
        housePowderRoom:   '🚽 Powder Room',
        houseGarage:       '🚗 Garage',
        houseBalcony:      '🌿 Balcony',
        houseTerrace:      '☀️ Terrace',
        housePool:         '🏊 Pool',
        houseLaundryArea:  '🧺 Laundry Area',
        houseMaidRoom:     '🛏 Maid Room',
        houseCabinets:     '🗄️ Cabinets',
        houseBilliardRoom: '🎱 Billiard Room',
        houseClubhouse:    '🏛️ Clubhouse',
        houseGarden:       '🌻 Garden',
    };

    const amenitySection = document.getElementById('modal-amenities-section');
    const amenityList    = document.getElementById('modal-amenities-list');
    const found = Object.entries(amenityMap).filter(function(e) { return parseInt(p[e[0]]) === 1; });

    if (found.length > 0) {
        amenityList.innerHTML = found.map(function(e) {
            return '<span style="background:#dcfce7;color:#166534;border-radius:20px;padding:3px 10px;font-size:.78rem;font-weight:500;">'
                + e[1] + '</span>';
        }).join('');
        amenitySection.style.display = 'block';
    } else {
        amenitySection.style.display = 'none';
    }

    // Status
    const status   = p.propertyStatus || 'Available';
    const statusEl = document.getElementById('modal-status');
    statusEl.textContent  = status;
    statusEl.style.color  = status.toLowerCase().includes('sold')     ? '#dc2626'
                          : status.toLowerCase().includes('reserved') ? '#d97706'
                          : '#16a34a';

    _htModalShow('content');
}

// ─────────────────────────────────────────────
//  EVENT LISTENERS (run after DOM is ready)
// ─────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    // Close on backdrop click
    document.getElementById('ht-property-modal').addEventListener('click', function(e) {
        if (e.target === this) htCloseModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            htCloseAgentModal();
            htCloseModal();
        }
    });
});


// ═════════════════════════════════════════════
//  AGENT MODALS
// ═════════════════════════════════════════════

// ─────────────────────────────────────────────
//  PUBLIC API
// ─────────────────────────────────────────────

/** Open the agent list modal. Called from the "Agent" button in the property panel. */
function htOpenAgentModal() {
    const modal = document.getElementById('ht-agent-modal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    _htAgentModalShow('loading');

    fetch('/habitrack/controllers/dashboard.controller.php?action=getAgents')
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
        })
        .then(function(json) {
            if (!json.success) throw new Error(json.error || 'Unknown error');
            _htRenderAgentList(json.data);
        })
        .catch(function(err) {
            document.getElementById('agent-modal-error-msg').textContent =
                'Failed to load agents. ' + (err.message || '');
            _htAgentModalShow('error');
        });
}

/** Close the entire agent modal (both list and detail views). */
function htCloseAgentModal() {
    const modal = document.getElementById('ht-agent-modal');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
    _htAgentClickState = {};
}

// ─────────────────────────────────────────────
//  PRIVATE HELPERS
// ─────────────────────────────────────────────

/** Track click state for double-click detection per agent card. */
var _htAgentClickState = {};

/** Switch which panel is visible inside the agent modal. */
function _htAgentModalShow(state) {
    ['loading', 'error', 'list', 'detail'].forEach(function(s) {
        var el = document.getElementById('agent-modal-' + s);
        if (el) el.style.display = (s === state) ? 'block' : 'none';
    });
}

/** Build initials from first + last name. */
function _htAgentInitials(agent) {
    var f = (agent.agentFName || '').charAt(0).toUpperCase();
    var l = (agent.agentLName || '').charAt(0).toUpperCase();
    return f + l || '??';
}

/** Render the agent list panel. */
function _htRenderAgentList(agents) {
    var list = document.getElementById('agent-list-items');
    if (!list) return;

    if (!agents || agents.length === 0) {
        list.innerHTML = '<p style="text-align:center;color:#6b7280;padding:24px;font-size:.9rem;">No agents found.</p>';
        _htAgentModalShow('list');
        return;
    }

    list.innerHTML = agents.map(function(a) {
        var fullName = [a.agentFName, a.agentMName ? a.agentMName.charAt(0) + '.' : '', a.agentLName, a.agentSuffix].filter(Boolean).join(' ');
        var initials = _htAgentInitials(a);
        var picHtml = a.agentPic
            ? '<img src="' + a.agentPic + '" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid #bbf7d0;" alt="' + fullName + '">'
            : '<div style="width:44px;height:44px;border-radius:50%;background:#dcfce7;color:#166534;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid #bbf7d0;flex-shrink:0;">' + initials + '</div>';

        return '<div class="ht-agent-row" data-agent-id="' + a.agentID + '" style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid #f3f4f6;cursor:pointer;transition:background .15s;" '
            + 'onmouseover="this.style.background=\'#f0fdf4\'" onmouseout="this.style.background=\'#fff\'">'
            + '<div style="flex-shrink:0;">' + picHtml + '</div>'
            + '<div style="flex:1;min-width:0;">'
            + '<p style="margin:0 0 2px;font-size:14px;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + fullName + '</p>'
            + '<p style="margin:0;font-size:12px;color:#6b7280;">' + a.agentID + (a.agentAddress ? ' · ' + a.agentAddress : '') + '</p>'
            + '</div>'
            + '<span style="color:#d1d5db;font-size:16px;flex-shrink:0;">›</span>'
            + '</div>';
    }).join('');

    // Attach single/double click handlers to each row
    list.querySelectorAll('.ht-agent-row').forEach(function(row) {
        row.addEventListener('click', function() {
            var agentId = row.getAttribute('data-agent-id');
            var now = Date.now();
            var last = _htAgentClickState[agentId] || 0;

            if (now - last < 350) {
                // Double-click → open detail
                _htAgentClickState[agentId] = 0;
                _htOpenAgentDetail(agentId, agents);
            } else {
                // Single click → highlight briefly
                _htAgentClickState[agentId] = now;
                list.querySelectorAll('.ht-agent-row').forEach(function(r) {
                    r.style.background = '#fff';
                });
                row.style.background = '#f0fdf4';
            }
        });
    });

    _htAgentModalShow('list');
}

/** Open the agent detail panel for the given agentID. */
function _htOpenAgentDetail(agentId, agents) {
    var agent = agents.find(function(a) { return a.agentID === agentId; });
    if (!agent) return;

    var fullName = [agent.agentFName, agent.agentMName ? agent.agentMName.charAt(0) + '.' : '', agent.agentLName, agent.agentSuffix].filter(Boolean).join(' ');
    var initials = _htAgentInitials(agent);

    var picHtml = agent.agentPic
        ? '<img src="' + agent.agentPic + '" style="width:68px;height:68px;border-radius:50%;object-fit:cover;border:2.5px solid rgba(255,255,255,0.6);margin:0 auto 10px;display:block;" alt="' + fullName + '">'
        : '<div style="width:68px;height:68px;border-radius:50%;background:rgba(255,255,255,0.25);border:2.5px solid rgba(255,255,255,0.6);color:#fff;font-size:20px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">' + initials + '</div>';

    var infoRows = [
        agent.agentEmail    ? { icon: '✉️', text: agent.agentEmail }    : null,
        agent.agentPhoneNum ? { icon: '📞', text: agent.agentPhoneNum } : null,
        agent.agentAddress  ? { icon: '📍', text: agent.agentAddress }  : null,
        agent.agentGender   ? { icon: '👤', text: agent.agentGender }   : null,
        agent.agentBirthdate ? { icon: '🎂', text: _htFormatDate(agent.agentBirthdate) } : null,
        agent.agentFB       ? { icon: '📘', text: agent.agentFB }       : null,
    ].filter(Boolean);

    var rowsHtml = infoRows.map(function(r) {
        return '<div style="display:flex;align-items:center;gap:10px;padding:9px 18px;font-size:13px;color:#374151;border-bottom:1px solid #f3f4f6;">'
            + '<span style="font-size:15px;width:20px;text-align:center;flex-shrink:0;">' + r.icon + '</span>'
            + '<span style="word-break:break-all;">' + _htEsc(r.text) + '</span>'
            + '</div>';
    }).join('');

    var soldUnits = parseInt(agent.agentSoldUnits) || 0;

    var detail = document.getElementById('agent-modal-detail');
    detail.innerHTML =
        '<div style="background:linear-gradient(135deg,#166534 0%,#16a34a 100%);padding:18px 18px 16px;position:relative;text-align:center;">'
        + '<button onclick="_htAgentGoBack()" style="position:absolute;top:12px;left:12px;background:rgba(255,255,255,0.2);border:none;border-radius:50%;width:28px;height:28px;color:#fff;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;line-height:1;">‹</button>'
        + picHtml
        + '<p style="margin:0 0 3px;font-size:1rem;font-weight:700;color:#fff;">' + _htEsc(fullName) + '</p>'
        + '<p style="margin:0;font-size:12px;color:rgba(255,255,255,0.75);">' + _htEsc(agent.agentID) + '</p>'
        + '</div>'
        // Sold units bar
        + '<div style="background:#f0fdf4;border-bottom:1px solid #dcfce7;padding:9px 18px;font-size:12px;color:#15803d;font-weight:600;display:flex;align-items:center;gap:6px;">'
        + '🏆 ' + soldUnits + ' sold unit' + (soldUnits !== 1 ? 's' : '')
        + '</div>'
        // Info rows
        + rowsHtml
        // Connect button
        + '<button onclick="_htConnectAgent(\'' + _htEsc(agent.agentEmail) + '\',\'' + _htEsc(fullName) + '\',\'' + _htEsc(agent.agentID) + '\')" '
        + 'style="display:block;width:calc(100% - 36px);margin:14px 18px;padding:11px;background:linear-gradient(135deg,#166534 0%,#16a34a 100%);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;text-align:center;">'
        + 'Connect to agent'
        + '</button>'

        + '</div>';

    _htAgentModalShow('detail');
}

/** Go back from detail to list view. */
function _htAgentGoBack() {
    _htAgentModalShow('list');
}

/** Handle "Connect to agent" — open pre-qual modal. */
function _htConnectAgent(email, name, agentId) {
    if (!email) {
        alert('No email address available for this agent.');
        return;
    }

    if (!window._htSelectedPropertyID) {
        alert('Please select a property before connecting to an agent.');
        return;
    }

    // Persist agent info and selected property so the pre-qual page can pick it up after navigation
    try {
        var dataToSave = {
            email: email,
            name: name,
            agentId: agentId,
            propertyId: window._htSelectedPropertyID
        };
        localStorage.setItem('htPrequalAgent', JSON.stringify(dataToSave));
        
        // Verify the data was actually saved
        var verify = JSON.parse(localStorage.getItem('htPrequalAgent'));
        if (!verify.propertyId) {
            console.error('Warning: propertyId was not saved to localStorage', dataToSave);
            alert('Error saving property selection. Please try again.');
            return;
        }
    } catch (e) {
        console.error('Unable to persist agent info to localStorage', e);
        alert('Error saving data. Please try again.');
        return;
    }

    // Redirect to the Pre-Qual form (route-based navigation)
    // Uses the same route parameter format as the app: ?route=pre-qual
    window.location.href = '/habitrack/?route=pre-qual';
}

/** Format a date string (YYYY-MM-DD) to readable form. */
function _htFormatDate(dateStr) {
    if (!dateStr) return '';
    var d = new Date(dateStr);
    if (isNaN(d)) return dateStr;
    return d.toLocaleDateString('en-PH', { year: 'numeric', month: 'long', day: 'numeric' });
}

/** Escape HTML special characters. */
function _htEsc(str) {
    return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

// ═════════════════════════════════════════════
//  PRE-QUALIFICATION MODAL
// ═════════════════════════════════════════════

/** Open pre-qual modal and show notification card. */
function htOpenPrequalModal(agentName) {
    var modal = document.getElementById('ht-prequal-modal');
    if (!modal) return;
    
    modal.style.display = 'flex';
    modal.style.flexDirection = 'column';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    document.body.style.overflow = 'hidden';
    
    // Show notification with agent name
    document.getElementById('prequal-agent-name').textContent = 'You\'re connected to ' + (agentName || 'Agent') + '.';
    document.getElementById('prequal-notification').style.display = 'block';
    document.getElementById('prequal-form-container').style.display = 'none';
}

/** Show the form after user clicks Continue on notification. */
function htShowPrequalForm() {
    var notif = document.getElementById('prequal-notification');
    var form = document.getElementById('prequal-form-container');
    
    if (notif && form) {
        notif.style.display = 'none';
        form.style.display = 'block';
        
        // Load pre-qual form content if not already loaded
        if (!form.innerHTML.trim()) {
            _htLoadPrequalForm();
        }
    }
}

/** Load pre-qual form HTML into modal. */
function _htLoadPrequalForm() {
    var container = document.getElementById('prequal-form-container');
    if (!container) return;
    
    container.innerHTML = '<p style="padding: 20px; text-align: center; color: #9ca3af;">Loading form...</p>';
    
    // Load the pre-qual form HTML from modal-specific endpoint
    fetch('/habitrack/views/modules/pre-qual-modal.php')
        .then(function(res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.text();
        })
        .then(function(html) {
            // Insert form HTML directly
            container.innerHTML = html;
            
            // Load the pre-qual.js script if not already loaded
            if (!window._prequalJsLoaded) {
                var script = document.createElement('script');
                script.src = '/habitrack/views/js/pre-qual.js';
                script.onload = function() {
                    window._prequalJsLoaded = true;
                };
                document.head.appendChild(script);
            }
        })
        .catch(function(err) {
            console.error('Form load error:', err);
            container.innerHTML = '<div style="padding: 40px; text-align: center; color: #dc2626;"><p><strong>Error:</strong> ' + err.message + '</p></div>';
        });
}

/** Close the pre-qual modal. */
function htClosePrequalModal() {
    var modal = document.getElementById('ht-prequal-modal');
    if (modal) {
        modal.style.display = 'none';
    }
    document.body.style.overflow = '';
    // Close agent modal as well
    htCloseAgentModal();
}