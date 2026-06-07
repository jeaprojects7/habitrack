/**
 * bookVisit.js
 *
 * Handles the "Book Visit" and "Cancel Visit" button click events.
 * Saves/cancels site visit bookings via AJAX.
 */

(function () {
    'use strict';

    // ── Config ───────────────────────────────────────────────────────────────
    const BOOKING_ENDPOINT       = '/habitrack/ajax/calendar_getrecord.ajax.php?action=saveSiteVisit';
    const CLIENT_BOOKINGS_ENDPOINT = '/habitrack/ajax/calendar_getrecord.ajax.php?action=getClientBookings';
    const CANCEL_ENDPOINT        = '/habitrack/ajax/calendar_getrecord.ajax.php?action=cancelSiteVisit';

    // ── Shared modal helpers ─────────────────────────────────────────────────

    /**
     * Create and return a full-screen overlay with a centered modal card.
     * Does NOT append to DOM — caller does that after building content.
     */
    function createOverlay() {
        const overlay = document.createElement('div');
        overlay.style.cssText = [
            'position:fixed', 'inset:0', 'z-index:9999',
            'background:rgba(0,0,0,0.55)',
            'display:flex', 'align-items:center', 'justify-content:center',
            'padding:16px',
        ].join(';');
        return overlay;
    }

    function createCard() {
        const card = document.createElement('div');
        card.style.cssText = [
            'max-width:440px', 'width:100%',
            'background:#1f2937', 'color:#f8fafc',
            'border-radius:24px', 'padding:28px 24px',
            'box-shadow:0 24px 48px rgba(0,0,0,0.4)',
        ].join(';');
        return card;
    }

    function createBtn(label, styles) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = label;
        btn.style.cssText = [
            'padding:11px 22px', 'border-radius:9999px',
            'font-size:0.85rem', 'font-weight:600',
            'cursor:pointer', 'transition:opacity .15s',
            ...styles,
        ].join(';');
        btn.addEventListener('mouseover',  function () { this.style.opacity = '0.85'; });
        btn.addEventListener('mouseout',   function () { this.style.opacity = '1'; });
        return btn;
    }

    function makeRow(styles) {
        const row = document.createElement('div');
        row.style.cssText = ['display:flex', 'gap:10px', ...styles].join(';');
        return row;
    }

    // ── Generic warning panel ────────────────────────────────────────────────
    function showWarningPanel(message) {
        const existing = document.getElementById('booking-panel');
        if (existing) existing.remove();

        const overlay = createOverlay();
        overlay.id = 'booking-panel';
        const card  = createCard();

        const icon = document.createElement('div');
        icon.innerHTML = '&#9888;';
        icon.style.cssText = 'font-size:2rem;text-align:center;margin-bottom:12px;color:#f59e0b;';

        const title = document.createElement('h2');
        title.style.cssText = 'margin:0 0 10px;font-size:1.1rem;font-weight:700;text-align:center;';
        title.textContent = 'Warning';

        const msg = document.createElement('p');
        msg.style.cssText = 'margin:0 0 22px;line-height:1.6;text-align:center;';
        msg.textContent = message;

        const closeBtn = createBtn('Close', [
            'border:none', 'background:#f59e0b', 'color:#111827', 'display:block', 'margin:0 auto',
        ]);
        closeBtn.addEventListener('click', function () { overlay.remove(); });

        card.append(icon, title, msg, closeBtn);
        overlay.appendChild(card);
        document.body.appendChild(overlay);
    }

    // ── Generic result panel (success / error) ───────────────────────────────
    function showPanel(message, isSuccess) {
        const existing = document.getElementById('booking-panel');
        if (existing) existing.remove();

        const overlay = createOverlay();
        overlay.id = 'booking-panel';
        const card = createCard();

        const icon = document.createElement('div');
        icon.innerHTML = isSuccess ? '&#10003;' : '&#10007;';
        icon.style.cssText = [
            'font-size:2.5rem', 'text-align:center', 'margin-bottom:12px',
            'color:' + (isSuccess ? '#22c55e' : '#ef4444'),
        ].join(';');

        const msg = document.createElement('p');
        msg.style.cssText = 'margin:0 0 22px;line-height:1.6;text-align:center;font-size:1rem;';
        msg.textContent = message;

        const closeBtn = createBtn('Close', [
            'border:none',
            'background:' + (isSuccess ? '#22c55e' : '#ef4444'),
            'color:#fff', 'display:block', 'margin:0 auto',
        ]);
        closeBtn.addEventListener('click', function () { overlay.remove(); });

        card.append(icon, msg, closeBtn);
        overlay.appendChild(card);
        document.body.appendChild(overlay);
    }

    // ── Booking confirmation panel ────────────────────────────────────────────
    function showConfirmationPanel() {
        return new Promise(function (resolve) {
            const existing = document.getElementById('booking-panel');
            if (existing) existing.remove();

            const overlay = createOverlay();
            overlay.id = 'booking-panel';
            const card = createCard();

            const title = document.createElement('h2');
            title.style.cssText = 'margin:0 0 10px;font-size:1.1rem;font-weight:700;text-align:center;';
            title.textContent = 'Confirm Booking';

            const msg = document.createElement('p');
            msg.style.cssText = 'margin:0 0 22px;line-height:1.6;text-align:center;';
            msg.textContent = 'Do you want to book this site visit?';

            const row = makeRow(['justify-content:center']);

            const noBtn = createBtn('Cancel', [
                'border:1px solid #334155', 'background:#0f172a', 'color:#f8fafc',
            ]);
            noBtn.addEventListener('click', function () {
                overlay.remove();
                resetBookingForm();
                resolve(false);
            });

            const yesBtn = createBtn('Yes, book it', [
                'border:none', 'background:#22c55e', 'color:#fff',
            ]);
            yesBtn.addEventListener('click', function () {
                overlay.remove();
                resolve(true);
            });

            row.append(noBtn, yesBtn);
            card.append(title, msg, row);
            overlay.appendChild(card);
            document.body.appendChild(overlay);
        });
    }

    // ── Step 1 — "Are you sure?" cancel intent modal ──────────────────────────
    function showCancelIntentModal() {
        return new Promise(function (resolve) {
            const existing = document.getElementById('cancel-intent-panel');
            if (existing) existing.remove();

            const overlay = createOverlay();
            overlay.id = 'cancel-intent-panel';
            const card = createCard();

            const icon = document.createElement('div');
            icon.innerHTML = '&#9888;';
            icon.style.cssText = 'font-size:2rem;text-align:center;margin-bottom:10px;color:#ef4444;';

            const title = document.createElement('h2');
            title.style.cssText = 'margin:0 0 10px;font-size:1.1rem;font-weight:700;text-align:center;';
            title.textContent = 'Cancel booking?';

            const msg = document.createElement('p');
            msg.style.cssText = 'margin:0 0 22px;line-height:1.6;text-align:center;color:#cbd5e1;';
            msg.textContent = 'Are you sure you want to cancel your site visit booking?';

            const row = makeRow(['justify-content:center']);

            const keepBtn = createBtn('No, keep it', [
                'border:1px solid #334155', 'background:#0f172a', 'color:#f8fafc',
            ]);
            keepBtn.addEventListener('click', function () {
                overlay.remove();
                resolve(false);
            });

            const yesBtn = createBtn('Yes, cancel', [
                'border:none', 'background:#ef4444', 'color:#fff',
            ]);
            yesBtn.addEventListener('click', function () {
                overlay.remove();
                resolve(true);
            });

            row.append(keepBtn, yesBtn);
            card.append(icon, title, msg, row);
            overlay.appendChild(card);
            document.body.appendChild(overlay);
        });
    }

    // ── Step 2 — booking list selection modal ─────────────────────────────────
    function showBookingListModal(bookings) {
        return new Promise(function (resolve) {
            const existing = document.getElementById('cancel-list-panel');
            if (existing) existing.remove();

            const overlay = createOverlay();
            overlay.id = 'cancel-list-panel';
            const card = createCard();

            const title = document.createElement('h2');
            title.style.cssText = 'margin:0 0 6px;font-size:1.1rem;font-weight:700;';
            title.textContent = 'Your booked visits';

            const sub = document.createElement('p');
            sub.style.cssText = 'margin:0 0 16px;font-size:0.8rem;color:#94a3b8;';
            sub.textContent = 'Select a booking, then click Cancel selected.';

            // Scrollable list container
            const list = document.createElement('div');
            list.style.cssText = [
                'display:flex', 'flex-direction:column', 'gap:8px',
                'max-height:260px', 'overflow-y:auto',
                'margin-bottom:20px', 'padding-right:4px',
            ].join(';');

            let selectedID = null;

            bookings.forEach(function (visit) {
                const row = document.createElement('div');
                row.dataset.id = visit.siteVisitID;
                row.style.cssText = [
                    'display:flex', 'align-items:center', 'gap:12px',
                    'padding:10px 12px', 'border-radius:14px',
                    'border:1.5px solid #334155', 'cursor:pointer',
                    'transition:border-color .15s, background .15s',
                    'background:#111827',
                ].join(';');

                // Calendar icon bubble
                const bubble = document.createElement('div');
                bubble.style.cssText = [
                    'width:36px', 'height:36px', 'border-radius:50%',
                    'background:#0e9ca630', 'display:flex',
                    'align-items:center', 'justify-content:center',
                    'flex-shrink:0', 'font-size:1rem',
                ].join(';');
                bubble.textContent = '📅';

                const info = document.createElement('div');
                info.style.cssText = 'flex:1;min-width:0;';

                const idLine = document.createElement('div');
                idLine.style.cssText = 'font-size:0.85rem;font-weight:600;color:#f8fafc;';
                idLine.textContent = visit.siteVisitID;

                // Format date nicely
                const dateObj = new Date(visit.siteVisitDate + 'T00:00:00');
                const dateStr = dateObj.toLocaleDateString('en-PH', { year: 'numeric', month: 'long', day: 'numeric' });

                const dateLine = document.createElement('div');
                dateLine.style.cssText = 'font-size:0.78rem;color:#94a3b8;margin-top:2px;';
                dateLine.textContent = dateStr + ' · ' + visit.siteVisitTime;

                const propLine = document.createElement('div');
                propLine.style.cssText = 'font-size:0.78rem;color:#94a3b8;';
                propLine.textContent = (visit.propertyName || '—') + ' — ' + (visit.agentName || '—');

                const badge = document.createElement('span');
                badge.style.cssText = [
                    'font-size:0.7rem', 'padding:3px 10px', 'border-radius:999px',
                    'background:#0e9ca620', 'color:#0e9ca6',
                    'font-weight:600', 'white-space:nowrap', 'flex-shrink:0',
                ].join(';');
                badge.textContent = 'Booked';

                info.append(idLine, dateLine, propLine);
                row.append(bubble, info, badge);

                row.addEventListener('click', function () {
                    // Deselect all
                    list.querySelectorAll('[data-id]').forEach(function (r) {
                        r.style.borderColor = '#334155';
                        r.style.background  = '#111827';
                    });
                    // Select this
                    row.style.borderColor = '#ef4444';
                    row.style.background  = '#ef44440f';
                    selectedID = visit.siteVisitID;
                });

                list.appendChild(row);
            });

            const btnRow = makeRow(['justify-content:flex-end']);

            const closeBtn = createBtn('Close', [
                'border:1px solid #334155', 'background:#0f172a', 'color:#f8fafc',
            ]);
            closeBtn.addEventListener('click', function () {
                overlay.remove();
                resolve(null);
            });

            const cancelBtn = createBtn('Cancel selected', [
                'border:none', 'background:#ef4444', 'color:#fff',
            ]);
            cancelBtn.addEventListener('click', function () {
                if (!selectedID) {
                    // Shake the list to hint selection needed
                    list.style.animation = 'none';
                    list.style.outline = '2px solid #ef4444';
                    setTimeout(function () { list.style.outline = 'none'; }, 800);
                    return;
                }
                overlay.remove();
                resolve(selectedID);
            });

            btnRow.append(closeBtn, cancelBtn);
            card.append(title, sub, list, btnRow);
            overlay.appendChild(card);
            document.body.appendChild(overlay);
        });
    }

    // ── Cancel visit flow (Steps 1 → 2 → result) ─────────────────────────────
    async function handleCancelVisit() {
        // Step 1: confirm intent
        const confirmed = await showCancelIntentModal();
        if (!confirmed) return;

        // Fetch client's booked visits
        let bookings = [];
        try {
            const res = await fetch(CLIENT_BOOKINGS_ENDPOINT, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();

            if (!data.success) {
                showWarningPanel(data.message || 'Could not load your bookings.');
                return;
            }
            bookings = data.bookings || [];
        } catch (err) {
            console.error('[cancelVisit] Fetch error:', err);
            showWarningPanel('A network error occurred. Please try again.');
            return;
        }

        if (bookings.length === 0) {
            showPanel('You have no active bookings to cancel.', false);
            return;
        }

        // Step 2: let client pick which booking to cancel
        const chosenID = await showBookingListModal(bookings);
        if (!chosenID) return;

        // Submit cancellation
        try {
            const res = await fetch(CANCEL_ENDPOINT, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'cancelSiteVisit',
                    siteVisitID: chosenID,
                }),
            });

            const data = await res.json();

            if (data.success) {
                // Step 3: success
                showPanel('Your booking has been successfully cancelled.', true);

                // Refresh calendar so the cancelled date is no longer marked booked
                if (window.CalendarBooking && typeof window.CalendarBooking.refreshCalendar === 'function') {
                    window.CalendarBooking.refreshCalendar();
                }
            } else {
                showPanel(data.message || 'Could not cancel the booking.', false);
            }
        } catch (err) {
            console.error('[cancelVisit] Cancel error:', err);
            showWarningPanel('A network error occurred while cancelling. Please try again.');
        }
    }

    // ── Book Visit helpers ────────────────────────────────────────────────────

    function getFormData() {
        const propertyInput = document.getElementById('property-input');
        const agentInput    = document.getElementById('agent-input');
        const hourEl        = document.getElementById('time-hr');
        const minuteEl      = document.getElementById('time-mn');

        let selectedDate = null;
        const selectedDay = document.querySelector('.calendar-day-selected');
        if (selectedDay && selectedDay.dataset.date) {
            selectedDate = selectedDay.dataset.date;
        }

        const hour   = hourEl   ? hourEl.textContent.trim().padStart(2, '0')   : '09';
        const minute = minuteEl ? minuteEl.textContent.trim().padStart(2, '0') : '00';
        const pmBtn  = document.getElementById('ampm-pm');
        const isPM   = pmBtn ? pmBtn.classList.contains('bg-white') : false;
        const period = isPM ? 'PM' : 'AM';
        const siteVisitTime = `${hour}:${minute} ${period}`;

        const missing = [];
        if (!propertyInput || !propertyInput.dataset.selectedCode) missing.push('property');
        if (!agentInput    || !agentInput.dataset.selectedCode)    missing.push('agent');
        if (!selectedDate)                                          missing.push('date');

        if (missing.length) return { missingFields: missing };

        // Block past times when booking today
        const now  = new Date();
        const todayString = [
            now.getFullYear(),
            String(now.getMonth() + 1).padStart(2, '0'),
            String(now.getDate()).padStart(2, '0'),
        ].join('-');

        if (selectedDate === todayString) {
            let hour24 = parseInt(hour, 10);
            if (isPM && hour !== '12')  hour24 += 12;
            else if (!isPM && hour === '12') hour24 = 0;

            const bookingDateTime = new Date(
                parseInt(selectedDate.substring(0, 4), 10),
                parseInt(selectedDate.substring(5, 7), 10) - 1,
                parseInt(selectedDate.substring(8, 10), 10),
                hour24, parseInt(minute, 10), 0
            );

            if (bookingDateTime <= now) {
                return { error: 'Please select a future time for today.' };
            }
        }

        return {
            propertyID:    propertyInput.dataset.selectedCode || propertyInput.dataset.selectedId,
            agentID:       agentInput.dataset.selectedCode    || agentInput.dataset.selectedId,
            siteVisitDate: selectedDate,
            siteVisitTime: siteVisitTime,
        };
    }

    function resetInputSelection(id) {
        const input = document.getElementById(id);
        if (!input) return;
        input.value = '';
        input.dataset.selectedId   = '';
        input.dataset.selectedCode = '';
    }

    function clearSelectedCalendarDay() {
        document.querySelectorAll('.calendar-day-selected').forEach(function (card) {
            const check = card.querySelector('.calendar-day-check');
            if (check) check.classList.add('hidden');
            card.classList.remove(
                'calendar-day-selected', 'border-emerald-400',
                '!bg-emerald-50', 'dark:!bg-emerald-500/10', 'dark:!border-emerald-400'
            );
        });
    }

    function resetBookingForm() {
        resetInputSelection('property-input');
        resetInputSelection('agent-input');
        clearSelectedCalendarDay();

        if (window.CalendarBooking && typeof window.CalendarBooking.refreshCalendar === 'function') {
            window.CalendarBooking.refreshCalendar();
        }
    }

    function setButtonLoading(isLoading) {
        const btn = document.getElementById('book-visit-btn');
        if (!btn) return;
        btn.disabled     = isLoading;
        btn.textContent  = isLoading ? 'Booking…' : 'Book Visit';
        btn.style.opacity = isLoading ? '0.6' : '1';
    }

    async function submitBooking(formData) {
        setButtonLoading(true);
        try {
            const response = await fetch(BOOKING_ENDPOINT, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action:        'saveSiteVisit',
                    agentID:       formData.agentID,
                    propertyID:    formData.propertyID,
                    siteVisitDate: formData.siteVisitDate,
                    siteVisitTime: formData.siteVisitTime,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showPanel(data.message || 'Site visit booked successfully!', true);
                resetBookingForm();
            } else {
                showPanel(data.message || 'Failed to book site visit.', false);
            }
        } catch (error) {
            console.error('Booking error:', error);
            showWarningPanel('An error occurred while booking. Please try again.');
        } finally {
            setButtonLoading(false);
        }
    }

    // ── Populate inputs from reservation ─────────────────────────────────────
    async function populateInputsFromReservation() {
        const RESERVATION_ENDPOINT = '/habitrack/ajax/calendar_getrecord.ajax.php?action=getReservationDetails';
        const reservationID = window.RESERVATION_ID;

        try {
            const res = await fetch(RESERVATION_ENDPOINT + '&reservationID=' + encodeURIComponent(reservationID), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!res.ok) throw new Error('Server returned ' + res.status);

            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Failed to load reservation details.');

            const propertyInput = document.getElementById('property-input');
            if (propertyInput && data.propertyID) {
                propertyInput.value                 = data.propertyName;
                propertyInput.dataset.selectedCode  = data.propertyID;
                propertyInput.dataset.selectedId    = data.propertyID;
            }

            const agentInput = document.getElementById('agent-input');
            if (agentInput && data.agentID) {
                agentInput.value                = data.agentName;
                agentInput.dataset.selectedCode = data.agentCode || data.agentID;
                agentInput.dataset.selectedId   = data.agentID;
            }
        } catch (err) {
            console.error('[bookVisit] Error populating reservation details:', err);
        }
    }

    // ── Init ─────────────────────────────────────────────────────────────────
    function init() {
        if (window.RESERVATION_ID) {
            populateInputsFromReservation();
        }

        // Book Visit button
        const bookBtn = document.getElementById('book-visit-btn');
        if (bookBtn) {
            bookBtn.addEventListener('click', async function (e) {
                e.preventDefault();

                const formData = getFormData();

                if (formData.missingFields) {
                    const labels = { property: 'property', agent: 'agent', date: 'date' };
                    const missing = formData.missingFields.map(function (f) { return labels[f] || f; });
                    const last    = missing.pop();
                    const message = missing.length
                        ? 'Please select ' + missing.join(', ') + ' and ' + last + '.'
                        : 'Please select ' + last + '.';
                    showWarningPanel(message);
                    return;
                }

                if (formData.error) {
                    showWarningPanel(formData.error);
                    return;
                }

                const confirmed = await showConfirmationPanel();
                if (!confirmed) return;

                submitBooking(formData);
            });
        } else {
            console.warn('[bookVisit] Book visit button not found.');
        }

        // Cancel Visit button
        const cancelBtn = document.getElementById('cancel-visit-btn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function (e) {
                e.preventDefault();
                handleCancelVisit();
            });
        } else {
            console.warn('[bookVisit] Cancel visit button not found.');
        }
    }

    // Run after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ── Public API ────────────────────────────────────────────────────────────
    window.BookVisit = { getFormData, submitBooking };

})();
