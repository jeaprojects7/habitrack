/**
 * bookVisit.js
 *
 * Handles the "Book Visit" button click event and saves the site visit booking
 * to the database via AJAX.
 */

(function () {
    'use strict';

    // ── Config ──────────────────────────────────────────────────────────────
    const BOOKING_ENDPOINT = '/habitrack/ajax/calendar_getrecord.ajax.php?action=saveSiteVisit';

    // ── Get selected data from dropdowns and time picker ─────────────────────
    function getFormData() {
        const propertyDropdown = document.querySelector('[data-type="property"]');
        const agentDropdown = document.querySelector('[data-type="agent"]');
        const hourEl = document.getElementById('time-hr');
        const minuteEl = document.getElementById('time-mn');

        // Get selected date from calendar (find the selected day card)
        let selectedDate = null;
        const selectedDay = document.querySelector('.calendar-day-selected');
        if (selectedDay && selectedDay.dataset.date) {
            selectedDate = selectedDay.dataset.date;
        }

        // Get time in 12-hour format with AM/PM
        const hour = hourEl ? hourEl.textContent.trim().padStart(2, '0') : '09';
        const minute = minuteEl ? minuteEl.textContent.trim().padStart(2, '0') : '00';
        const pmBtn = document.getElementById('ampm-pm');
        const isPM = pmBtn ? pmBtn.classList.contains('bg-white') : false;
        const period = isPM ? 'PM' : 'AM';
        const siteVisitTime = `${hour}:${minute} ${period}`;

        // Validate required fields and return all missing selections.
        const missing = [];
        if (!propertyDropdown || !propertyDropdown.dataset.selectedId) {
            missing.push('property');
        }

        if (!agentDropdown || !agentDropdown.dataset.selectedId) {
            missing.push('agent');
        }

        if (!selectedDate) {
            missing.push('date');
        }

        if (missing.length) {
            return { missingFields: missing };
        }

        // If booking today, warn about selecting a time that already passed.
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const todayString = `${year}-${month}-${day}`;
        
        console.log('[TIME DEBUG] Current time:', now.toLocaleString());
        console.log('[TIME DEBUG] Selected date:', selectedDate);
        console.log('[TIME DEBUG] Today string:', todayString);
        console.log('[TIME DEBUG] Date match:', selectedDate === todayString);
        
        if (selectedDate === todayString) {
            // Convert 12-hour time to 24-hour format
            let hour24 = parseInt(hour, 10);
            console.log('[TIME DEBUG] Original hour:', hour, 'isPM:', isPM);
            
            if (isPM && hour !== '12') {
                hour24 += 12;
            } else if (!isPM && hour === '12') {
                hour24 = 0;
            }
            
            console.log('[TIME DEBUG] Converted hour24:', hour24);
            
            // Create booking datetime in local timezone
            const bookingDateTime = new Date(
                parseInt(selectedDate.substring(0, 4), 10),
                parseInt(selectedDate.substring(5, 7), 10) - 1,
                parseInt(selectedDate.substring(8, 10), 10),
                hour24,
                parseInt(minute, 10),
                0
            );
            
            console.log('[TIME DEBUG] Booking datetime:', bookingDateTime.toLocaleString());
            console.log('[TIME DEBUG] Comparison result:', bookingDateTime <= now);
            
            // Compare with current time
            if (bookingDateTime <= now) {
                console.log('[TIME DEBUG] BLOCKING BOOKING - time is in the past');
                return { error: 'Please select a future time for today.' };
            }
        }

        return {
            propertyID: propertyDropdown.dataset.selectedCode || propertyDropdown.dataset.selectedId,
            agentID: agentDropdown.dataset.selectedCode || agentDropdown.dataset.selectedId,
            siteVisitDate: selectedDate,
            siteVisitTime: siteVisitTime
        };
    }

    // ── Show feedback message ────────────────────────────────────────────────
    function showFeedback(message, isSuccess = true) {
        // Remove existing feedback
        const existing = document.getElementById('booking-feedback');
        if (existing) existing.remove();

        const feedback = document.createElement('div');
        feedback.id = 'booking-feedback';
        feedback.className = isSuccess 
            ? 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-lg z-50'
            : 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-2xl shadow-lg z-50';
        feedback.textContent = message;

        document.body.appendChild(feedback);

        // Auto-remove after 4 seconds
        setTimeout(() => feedback.remove(), 4000);
    }

    function showWarningPanel(message) {
        const existing = document.getElementById('booking-panel');
        if (existing) existing.remove();

        const panel = document.createElement('div');
        panel.id = 'booking-panel';
        panel.style.position = 'fixed';
        panel.style.top = '0';
        panel.style.left = '0';
        panel.style.width = '100vw';
        panel.style.height = '100vh';
        panel.style.background = 'rgba(0,0,0,0.55)';
        panel.style.display = 'flex';
        panel.style.alignItems = 'center';
        panel.style.justifyContent = 'center';
        panel.style.zIndex = '9999';

        const card = document.createElement('div');
        card.style.maxWidth = '420px';
        card.style.width = '100%';
        card.style.padding = '24px';
        card.style.borderRadius = '24px';
        card.style.background = '#1f2937';
        card.style.color = '#f8fafc';
        card.style.boxShadow = '0 30px 60px rgba(15,23,42,0.4)';
        card.style.textAlign = 'center';

        const title = document.createElement('h2');
        title.style.margin = '0 0 16px';
        title.style.fontSize = '1.25rem';
        title.style.fontWeight = '700';
        title.textContent = 'Warning';

        const messageBlock = document.createElement('p');
        messageBlock.style.margin = '0 0 24px';
        messageBlock.style.lineHeight = '1.6';
        messageBlock.textContent = message;

        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = 'Close';
        button.style.padding = '12px 20px';
        button.style.border = 'none';
        button.style.borderRadius = '9999px';
        button.style.background = '#f59e0b';
        button.style.color = '#111827';
        button.style.cursor = 'pointer';
        button.addEventListener('click', function () {
            panel.remove();
        });

        card.appendChild(title);
        card.appendChild(messageBlock);
        card.appendChild(button);
        panel.appendChild(card);
        document.body.appendChild(panel);
    }

    function resetDropdownSelection(type, defaultLabel) {
        const dropdown = document.querySelector(`[data-type="${type}"]`);
        if (!dropdown) return;

        const valueSpan = dropdown.querySelector('.dropdown-value');
        if (valueSpan) {
            valueSpan.textContent = defaultLabel;
        }

        delete dropdown.dataset.selectedId;
        delete dropdown.dataset.selectedCode;
        delete dropdown.dataset.selectedName;

        const searchInput = dropdown.querySelector('.dropdown-search');
        if (searchInput) {
            searchInput.value = '';
        }

        const menu = dropdown.querySelector('.dropdown-menu');
        const closeBtn = dropdown.querySelector('.dropdown-close');
        if (menu) {
            menu.classList.remove('block');
            menu.classList.add('hidden');
        }
        if (closeBtn) {
            closeBtn.classList.add('hidden');
        }
    }

    function clearSelectedCalendarDay() {
        document.querySelectorAll('.calendar-day-selected').forEach(function (card) {
            const check = card.querySelector('.calendar-day-check');
            if (check) {
                check.classList.add('hidden');
            }
            card.classList.remove('calendar-day-selected', 'border-emerald-400', '!bg-emerald-50', 'dark:!bg-emerald-500/10', 'dark:!border-emerald-400');
        });
    }

    function resetBookingForm() {
        resetDropdownSelection('property', 'Select property');
        resetDropdownSelection('agent', 'Agent name');
        clearSelectedCalendarDay();

        if (window.CalendarBooking && typeof window.CalendarBooking.refreshCalendar === 'function') {
            window.CalendarBooking.refreshCalendar();
        }
    }

    function showPanel(message, isSuccess = true) {
        const existing = document.getElementById('booking-panel');
        if (existing) existing.remove();

        const panel = document.createElement('div');
        panel.id = 'booking-panel';
        panel.style.position = 'fixed';
        panel.style.top = '0';
        panel.style.left = '0';
        panel.style.width = '100vw';
        panel.style.height = '100vh';
        panel.style.background = 'rgba(0,0,0,0.55)';
        panel.style.display = 'flex';
        panel.style.alignItems = 'center';
        panel.style.justifyContent = 'center';
        panel.style.zIndex = '9999';

        const card = document.createElement('div');
        card.style.maxWidth = '420px';
        card.style.width = '100%';
        card.style.padding = '24px';
        card.style.borderRadius = '24px';
        card.style.background = '#0f172a';
        card.style.color = '#f8fafc';
        card.style.boxShadow = '0 30px 60px rgba(15,23,42,0.4)';
        card.style.textAlign = 'center';

        const title = document.createElement('h2');
        title.style.margin = '0 0 16px';
        title.style.fontSize = '1.25rem';
        title.style.fontWeight = '700';
        title.textContent = isSuccess ? 'Booking Status' : 'Booking Failed';

        const messageBlock = document.createElement('p');
        messageBlock.style.margin = '0 0 24px';
        messageBlock.style.lineHeight = '1.6';
        messageBlock.textContent = message;

        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = 'Close';
        button.style.padding = '12px 20px';
        button.style.border = 'none';
        button.style.borderRadius = '9999px';
        button.style.background = isSuccess ? '#22c55e' : '#ef4444';
        button.style.color = '#ffffff';
        button.style.cursor = 'pointer';
        button.addEventListener('click', function () {
            panel.remove();
        });

        card.appendChild(title);
        card.appendChild(messageBlock);
        card.appendChild(button);
        panel.appendChild(card);
        document.body.appendChild(panel);
    }

    function showConfirmationPanel() {
        return new Promise((resolve) => {
            const existing = document.getElementById('booking-panel');
            if (existing) existing.remove();

            const panel = document.createElement('div');
            panel.id = 'booking-panel';
            panel.style.position = 'fixed';
            panel.style.top = '0';
            panel.style.left = '0';
            panel.style.width = '100vw';
            panel.style.height = '100vh';
            panel.style.background = 'rgba(0,0,0,0.55)';
            panel.style.display = 'flex';
            panel.style.alignItems = 'center';
            panel.style.justifyContent = 'center';
            panel.style.zIndex = '9999';

            const card = document.createElement('div');
            card.style.maxWidth = '420px';
            card.style.width = '100%';
            card.style.padding = '24px';
            card.style.borderRadius = '24px';
            card.style.background = '#0f172a';
            card.style.color = '#f8fafc';
            card.style.boxShadow = '0 30px 60px rgba(15,23,42,0.4)';
            card.style.textAlign = 'center';

            const title = document.createElement('h2');
            title.style.margin = '0 0 16px';
            title.style.fontSize = '1.25rem';
            title.style.fontWeight = '700';
            title.textContent = 'Confirm Booking';

            const messageBlock = document.createElement('p');
            messageBlock.style.margin = '0 0 24px';
            messageBlock.style.lineHeight = '1.6';
            messageBlock.textContent = 'Do you want to book this site visit?';

            const buttons = document.createElement('div');
            buttons.style.display = 'flex';
            buttons.style.gap = '12px';
            buttons.style.justifyContent = 'center';

            const cancelButton = document.createElement('button');
            cancelButton.type = 'button';
            cancelButton.textContent = 'Cancel';
            cancelButton.style.padding = '12px 20px';
            cancelButton.style.border = '1px solid #334155';
            cancelButton.style.borderRadius = '9999px';
            cancelButton.style.background = '#0f172a';
            cancelButton.style.color = '#f8fafc';
            cancelButton.style.cursor = 'pointer';
            cancelButton.addEventListener('click', function () {
                panel.remove();
                resetBookingForm();
                resolve(false);
            });

            const confirmButton = document.createElement('button');
            confirmButton.type = 'button';
            confirmButton.textContent = 'Yes, book it';
            confirmButton.style.padding = '12px 20px';
            confirmButton.style.border = 'none';
            confirmButton.style.borderRadius = '9999px';
            confirmButton.style.background = '#22c55e';
            confirmButton.style.color = '#ffffff';
            confirmButton.style.cursor = 'pointer';
            confirmButton.addEventListener('click', function () {
                panel.remove();
                resolve(true);
            });

            buttons.appendChild(cancelButton);
            buttons.appendChild(confirmButton);
            card.appendChild(title);
            card.appendChild(messageBlock);
            card.appendChild(buttons);
            panel.appendChild(card);
            document.body.appendChild(panel);
        });
    }

    // ── Disable button during submission ─────────────────────────────────────
    function setButtonLoading(isLoading) {
        const btn = document.getElementById('book-visit-btn');
        if (!btn) return;

        if (isLoading) {
            btn.disabled = true;
            btn.textContent = 'Booking...';
            btn.classList.add('opacity-60');
        } else {
            btn.disabled = false;
            btn.textContent = 'Book Visit';
            btn.classList.remove('opacity-60');
        }
    }

    // ── Submit booking ──────────────────────────────────────────────────────
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
                    action: 'saveSiteVisit',
                    agentID: formData.agentID,
                    propertyID: formData.propertyID,
                    siteVisitDate: formData.siteVisitDate,
                    siteVisitTime: formData.siteVisitTime,
                }),
            });

            const data = await response.json();

            if (data.success) {
                showPanel(data.message || 'Site visit booked successfully!', true);
                resetBookingForm();
                console.log('Booking saved with ID:', data.siteVisitID);
            } else {
                showPanel(data.message || 'Failed to book site visit.', false);
            }
        } catch (error) {
            console.error('Booking error:', error);
            showFeedback('An error occurred while booking. Please try again.', false);
        } finally {
            setButtonLoading(false);
        }
    }

    // ── Init - attach click handler ──────────────────────────────────────────
    function init() {
        const btn = document.getElementById('book-visit-btn');
        if (!btn) {
            console.warn('[bookVisit] Book visit button not found.');
            return;
        }

        btn.addEventListener('click', async function (e) {
            e.preventDefault();

            const formData = getFormData();

            if (formData.missingFields) {
                const labels = {
                    property: 'property',
                    agent: 'agent',
                    date: 'date',
                };
                const missing = formData.missingFields.map(function (field) {
                    return labels[field] || field;
                });
                const last = missing.pop();
                const message = missing.length
                    ? 'Please select ' + missing.join(', ') + ' and ' + last + '.'
                    : 'Please select ' + last + '.';
                showWarningPanel(message);
                return;
            }

            // Check for validation errors (e.g., past time)
            if (formData.error) {
                showWarningPanel(formData.error);
                return;
            }

            const confirmed = await showConfirmationPanel();
            if (!confirmed) {
                return;
            }

            submitBooking(formData);
        });
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
