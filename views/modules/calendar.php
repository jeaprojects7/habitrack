<link rel="stylesheet" href="/habitrack/views/Adminassets/css/calendar.css" />

<div class="mx-auto max-w-5xl px-4 py-6 lg:px-6">
    <div class="grid gap-6 xl:grid-cols-[1.6fr_1fr]">
        <div class="space-y-6">
            <div class="calendar-wrapper rounded-3xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-900">

                <!-- Header -->
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <button id="cal-prev" type="button" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            ‹
                        </button>
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400">Month view</p>
                            <h2 id="cal-title" class="mt-1 text-2xl font-semibold text-slate-900 dark:text-white"></h2>
                        </div>
                        <button id="cal-next" type="button" class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            ›
                        </button>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-full bg-slate-50 px-4 py-2 text-sm font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        <span class="inline-flex h-3.5 w-3.5 rounded-full bg-emerald-500"></span>
                        Click a day
                    </div>
                </div>

                <!-- Day headers -->
                <div class="mt-6 grid grid-cols-7 gap-2 text-center text-xs uppercase tracking-[0.24em] text-slate-500 dark:text-slate-400">
                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                </div>

                <!-- Calendar grid -->
                <div id="cal-grid" class="mt-3 grid grid-cols-7 gap-2 text-sm text-slate-700 dark:text-slate-200"></div>

            </div>
        </div>

        <aside class="space-y-6">
            <div class="calendar-sidebar rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-900">
                <div class="mt-6 rounded-3xl bg-gradient-to-br from-sky-500 via-cyan-400 to-indigo-500 p-5 text-white shadow-lg shadow-sky-500/20">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-200/80">Site Visit Details</p>

                    <div class="mt-6 grid gap-4 text-sm text-white/90">

                        <!-- TIME STEPPER -->
                        <div class="rounded-3xl bg-white/10 px-4 py-3">
                            <span class="block text-xs uppercase tracking-[0.2em] text-white/70">Time</span>
                            <div class="mt-3 flex items-center justify-center gap-2">

                                <!-- Hour -->
                                <div class="flex flex-col items-center gap-1">
                                    <button type="button" id="hr-up" class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30 focus:outline-none">▲</button>
                                    <span id="time-hr" class="w-10 text-center text-2xl font-semibold text-white">09</span>
                                    <button type="button" id="hr-down" class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30 focus:outline-none">▼</button>
                                </div>

                                <span class="text-2xl font-light text-white/60">:</span>

                                <!-- Minute -->
                                <div class="flex flex-col items-center gap-1">
                                    <button type="button" id="mn-up" class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30 focus:outline-none">▲</button>
                                    <span id="time-mn" class="w-10 text-center text-2xl font-semibold text-white">00</span>
                                    <button type="button" id="mn-down" class="flex h-7 w-7 items-center justify-center rounded-full bg-white/15 text-white transition hover:bg-white/30 focus:outline-none">▼</button>
                                </div>

                                <!-- AM / PM -->
                                <div class="ml-2 flex flex-col gap-1">
                                    <button type="button" id="ampm-am" class="rounded-2xl bg-white px-3 py-1 text-xs font-semibold text-sky-600 shadow transition">AM</button>
                                    <button type="button" id="ampm-pm" class="rounded-2xl bg-white/20 px-3 py-1 text-xs font-semibold text-white transition hover:bg-white/30">PM</button>
                                </div>

                            </div>
                        </div>
                        <!-- END TIME STEPPER -->

                        <!-- CHANGED: added data-type="property" -->
                        <label class="dropdown block rounded-3xl bg-white/10 px-4 py-3" data-type="property">
                            <span class="block text-xs uppercase tracking-[0.2em] text-white/70">Property to Visit</span>
                            <div class="mt-2 flex items-center gap-2 rounded-2xl border border-white/20 bg-slate-950/20 px-2 py-2">
                                <button type="button" class="dropdown-toggle flex-1 flex items-center text-left text-sm font-medium text-white transition focus:outline-none" aria-haspopup="true" aria-expanded="false">
                                    <span class="dropdown-value">Select property</span>
                                </button>
                                <button type="button" class="dropdown-close hidden rounded-full bg-white/10 px-2 py-1 text-white transition hover:bg-white/20" aria-label="Close dropdown">×</button>
                                <span class="dropdown-caret text-white/70">v</span>
                            </div>
                            <div class="dropdown-menu hidden mt-2 rounded-3xl border border-white/10 bg-slate-950/95 p-3 shadow-xl">
                                <input type="text" class="dropdown-search w-full rounded-2xl border border-white/10 bg-slate-900/80 px-3 py-2 text-sm text-white outline-none transition focus:border-white/40 focus:ring-2 focus:ring-white/20" placeholder="Search property" />
                                <div class="mt-2 space-y-1">
                                    <!-- Items will be populated dynamically by properties.js -->
                                </div>
                            </div>
                        </label>

                        <!-- CHANGED: added data-type="agent" -->
                        <label class="dropdown block rounded-3xl bg-white/10 px-4 py-3" data-type="agent">
                            <span class="block text-xs uppercase tracking-[0.2em] text-white/70">Agent</span>
                            <div class="mt-2 flex items-center gap-2 rounded-2xl border border-white/20 bg-slate-950/20 px-2 py-2">
                                <button type="button" class="dropdown-toggle flex-1 flex items-center text-left text-sm font-medium text-white transition focus:outline-none" aria-haspopup="true" aria-expanded="false">
                                    <span class="dropdown-value">Agent name</span>
                                </button>
                                <button type="button" class="dropdown-close hidden rounded-full bg-white/10 px-2 py-1 text-white transition hover:bg-white/20" aria-label="Close dropdown">×</button>
                                <span class="dropdown-caret text-white/70">v</span>
                            </div>
                            <div class="dropdown-menu hidden mt-2 rounded-3xl border border-white/10 bg-slate-950/95 p-3 shadow-xl">
                                <input type="text" class="dropdown-search w-full rounded-2xl border border-white/10 bg-slate-900/80 px-3 py-2 text-sm text-white outline-none transition focus:border-white/40 focus:ring-2 focus:ring-white/20" placeholder="Search agent" />
                                <div class="mt-2 space-y-1">
                                    <!-- Items will be populated dynamically by calendar.js -->
                                </div>
                            </div>
                        </label>

                        <button type="button" id="book-visit-btn" class="mt-2 w-full rounded-3xl bg-white/15 px-4 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-white transition hover:bg-white/25 focus:outline-none focus:ring-2 focus:ring-white/30">Book Visit</button>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
(async function () {
    const MONTHS = ['January','February','March','April','May','June',
                    'July','August','September','October','November','December'];

    const today = new Date();
    const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    let currentYear  = today.getFullYear();
    let currentMonth = today.getMonth();
    let bookedVisits = new Map();

    const HOLIDAYS = new Map([
        ['2026-01-01', "New Year's Day"],
        ['2026-02-25', 'EDSA People Power Revolution Anniversary'],
        ['2026-04-09', 'Araw ng Kagitingan'],
        ['2026-04-17', 'Maundy Thursday'],
        ['2026-04-18', 'Good Friday'],
        ['2026-05-01', 'Labor Day'],
        ['2026-06-12', 'Independence Day'],
        ['2026-08-30', 'National Heroes Day'],
        ['2026-11-01', 'All Saints Day'],
        ['2026-11-30', 'Bonifacio Day'],
        ['2026-12-25', 'Christmas Day'],
        ['2026-12-30', 'Rizal Day'],
    ]);

    function getHolidayLabel(dateString) {
        return HOLIDAYS.get(dateString) || null;
    }

    async function loadBookedDates() {
        try {
            const response = await fetch('/habitrack/ajax/calendar_getrecord.ajax.php?action=getBookedVisitDetails', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Server error ' + response.status);
            }

            const data = await response.json();
            if (data.success && Array.isArray(data.details)) {
                bookedVisits = new Map();
                data.details.forEach(function (item) {
                    if (!item.siteVisitDate) return;
                    const date = item.siteVisitDate;
                    const time = item.siteVisitTime || '';
                    if (!bookedVisits.has(date)) {
                        bookedVisits.set(date, []);
                    }
                    bookedVisits.get(date).push(time);
                });
            }
        } catch (error) {
            console.warn('Unable to load booked visit details:', error);
        }
    }

    function isBookedDate(dateString) {
        return bookedVisits.has(dateString);
    }

    function getBookedLabel(dateString) {
        const times = bookedVisits.get(dateString) || [];
        if (times.length === 0) {
            return 'Booked';
        }
        if (times.length === 1) {
            return times[0];
        }
        return times.slice(0, 2).join(', ') + (times.length > 2 ? ` +${times.length - 2} more` : '');
    }

    function renderCalendar(year, month) {
        const grid  = document.getElementById('cal-grid');
        const title = document.getElementById('cal-title');
        if (!grid || !title) return;

        title.textContent = MONTHS[month] + ' ' + year;

        const firstDay  = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        let html = '';

        for (let b = 0; b < firstDay; b++) {
            html += '<div class="calendar-blank-cell h-24 rounded-3xl"></div>';
        }

        for (let d = 1; d <= totalDays; d++) {
            const dateObj = new Date(year, month, d);
            const isToday = (d === today.getDate() && month === today.getMonth() && year === today.getFullYear());
            const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
            const booked  = isBookedDate(dateStr);
            const isPast  = dateObj < todayStart;
            const bookedLabel = booked ? getBookedLabel(dateStr) : null;
            const holidayName = getHolidayLabel(dateStr);
            const holidayLabel = holidayName ? `Holiday${holidayName ? ': ' + holidayName : ''}` : null;
            const label = booked
                ? `Booked ${bookedLabel}`
                : holidayLabel
                    ? holidayLabel
                    : (isToday ? 'Today' : '&nbsp;');
            const cardClasses = booked
                ? 'calendar-day-card relative flex h-24 flex-col items-start justify-between rounded-3xl border border-emerald-400 bg-emerald-900/10 text-emerald-200 p-3 text-left transition cursor-not-allowed dark:border-emerald-200 dark:bg-emerald-900 dark:text-emerald-100'
                : holidayLabel
                    ? 'calendar-day-card relative flex h-24 flex-col items-start justify-between rounded-3xl border border-red-300 bg-red-100 text-red-700 p-3 text-left transition cursor-pointer dark:border-red-500 dark:bg-red-900/15 dark:text-red-100'
                    : isPast
                        ? 'calendar-day-card relative flex h-24 flex-col items-start justify-between rounded-3xl border border-slate-300 bg-slate-200 text-slate-600 p-3 text-left transition cursor-not-allowed dark:border-slate-800 dark:bg-slate-950 dark:text-slate-500'
                        : 'calendar-day-card relative flex h-24 flex-col items-start justify-between rounded-3xl border border-slate-200 bg-slate-50 p-3 text-left transition hover:border-slate-300 hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800/60 dark:hover:border-slate-500 dark:hover:bg-slate-700/80';

            html += `
                <button type="button" class="${cardClasses}" data-date="${dateStr}" data-booked="${booked}" data-past="${isPast}">
                    <div class="flex w-full items-start justify-between">
                        <span class="text-sm font-semibold text-slate-900 dark:text-white">${d}</span>
                        <span class="calendar-day-check hidden rounded-full bg-emerald-500 p-2 text-white">✓</span>
                    </div>
                    <div class="mt-1 text-xs ${booked ? 'text-emerald-700' : holidayLabel ? 'text-red-700 dark:text-red-100' : 'text-slate-500 dark:text-slate-300'}">${label}</div>
                </button>`;
        }

        grid.innerHTML = html;

        grid.querySelectorAll('.calendar-day-card').forEach(function (card) {
            card.addEventListener('click', function () {
                if (this.dataset.booked === 'true') {
                    alert('This date is already booked. Please choose another day.');
                    return;
                }
                if (this.dataset.past === 'true') {
                    alert('Past dates are not available for booking. Please choose a future date.');
                    return;
                }
                if (this.classList.contains('calendar-day-selected')) {
                    const check = this.querySelector('.calendar-day-check');
                    if (check) check.classList.add('hidden');
                    this.classList.remove('calendar-day-selected', 'border-emerald-400', '!bg-emerald-50', 'dark:!bg-emerald-500/10', 'dark:!border-emerald-400');
                    return;
                }

                // Remove selection from other days
                grid.querySelectorAll('.calendar-day-card').forEach(function (c) {
                    const check = c.querySelector('.calendar-day-check');
                    if (check) check.classList.add('hidden');
                    c.classList.remove('border-emerald-400', '!bg-emerald-50', 'dark:!bg-emerald-500/10', 'dark:!border-emerald-400');
                    c.classList.remove('calendar-day-selected');
                });
                
                // Select current day
                var dayCheck = this.querySelector('.calendar-day-check');
                if (dayCheck) {
                    dayCheck.classList.remove('hidden');
                    this.classList.add('border-emerald-400');
                    this.classList.add('!bg-emerald-50');
                    this.classList.add('dark:!bg-emerald-500/10');
                    this.classList.add('dark:!border-emerald-400');
                    this.classList.add('calendar-day-selected');
                }
            });
        });
    }

    document.getElementById('cal-prev').addEventListener('click', function () {
        currentMonth--;
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        renderCalendar(currentYear, currentMonth);
    });

    document.getElementById('cal-next').addEventListener('click', function () {
        currentMonth++;
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        renderCalendar(currentYear, currentMonth);
    });

    await loadBookedDates();
    renderCalendar(currentYear, currentMonth);

    function clearSelectedDay() {
        document.querySelectorAll('.calendar-day-selected').forEach(function (card) {
            const check = card.querySelector('.calendar-day-check');
            if (check) check.classList.add('hidden');
            card.classList.remove('calendar-day-selected', 'border-emerald-400', '!bg-emerald-50', 'dark:!bg-emerald-500/10', 'dark:!border-emerald-400');
        });
    }

    window.CalendarBooking = {
        refreshCalendar: async function () {
            await loadBookedDates();
            renderCalendar(currentYear, currentMonth);
        },
        clearSelectedDay: clearSelectedDay,
    };

    // ── Time Stepper ─────────────────────────────────────────────────
    let hr = 9, mn = 0, isPM = false;

    const hrEl   = document.getElementById('time-hr');
    const mnEl   = document.getElementById('time-mn');
    const amBtn  = document.getElementById('ampm-am');
    const pmBtn  = document.getElementById('ampm-pm');

    function updateTime() {
        hrEl.textContent = String(hr).padStart(2, '0');
        mnEl.textContent = String(mn).padStart(2, '0');
    }

    function setAmPm(pm) {
        isPM = pm;
        if (isPM) {
            pmBtn.className = 'rounded-2xl bg-white px-3 py-1 text-xs font-semibold text-sky-600 shadow transition';
            amBtn.className = 'rounded-2xl bg-white/20 px-3 py-1 text-xs font-semibold text-white transition hover:bg-white/30';
        } else {
            amBtn.className = 'rounded-2xl bg-white px-3 py-1 text-xs font-semibold text-sky-600 shadow transition';
            pmBtn.className = 'rounded-2xl bg-white/20 px-3 py-1 text-xs font-semibold text-white transition hover:bg-white/30';
        }
    }

    document.getElementById('hr-up').addEventListener('click', function () {
        hr = hr >= 12 ? 1 : hr + 1;
        updateTime();
    });
    document.getElementById('hr-down').addEventListener('click', function () {
        hr = hr <= 1 ? 12 : hr - 1;
        updateTime();
    });
    document.getElementById('mn-up').addEventListener('click', function () {
        mn = mn >= 45 ? 0 : mn + 15;
        updateTime();
    });
    document.getElementById('mn-down').addEventListener('click', function () {
        mn = mn <= 0 ? 45 : mn - 15;
        updateTime();
    });

    amBtn.addEventListener('click', function () { setAmPm(false); });
    pmBtn.addEventListener('click', function () { setAmPm(true); });

    // ── Dropdown logic ────────────────────────────────────────────────
    function closeDropdown(dropdown) {
        var toggle   = dropdown.querySelector('.dropdown-toggle');
        var menu     = dropdown.querySelector('.dropdown-menu');
        var closeBtn = dropdown.querySelector('.dropdown-close');
        if (toggle)   { toggle.setAttribute('aria-expanded', 'false'); }
        if (menu)     { menu.classList.remove('block'); menu.classList.add('hidden'); }
        if (closeBtn) { closeBtn.classList.add('hidden'); }
    }

    document.querySelectorAll('.dropdown').forEach(function (dropdown) {
        var toggle      = dropdown.querySelector('.dropdown-toggle');
        var closeBtn    = dropdown.querySelector('.dropdown-close');
        var menu        = dropdown.querySelector('.dropdown-menu');
        var searchInput = dropdown.querySelector('.dropdown-search');
        var items       = dropdown.querySelectorAll('.dropdown-item');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            var isOpen = menu.classList.contains('block');
            if (isOpen) {
                closeBtn && closeBtn.classList.add('hidden');
            } else {
                menu.classList.remove('hidden');
                menu.classList.add('block');
                closeBtn && closeBtn.classList.remove('hidden');
            }
        });

        closeBtn && closeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            closeDropdown(dropdown);
        });

        menu.addEventListener('click', function (e) { e.stopPropagation(); });

        if (searchInput) {
            searchInput.addEventListener('click', function (e) { e.stopPropagation(); });
            searchInput.addEventListener('input', function () {
                var q = this.value.toLowerCase();
                items.forEach(function (item) {
                    item.style.display = item.textContent.toLowerCase().includes(q) ? 'block' : 'none';
                });
            });
        }

        items.forEach(function (item) {
            item.addEventListener('click', function () {
                var valueSpan = toggle.querySelector('.dropdown-value');
                if (valueSpan) valueSpan.textContent = this.textContent;
                closeDropdown(dropdown);
            });
        });
    });

    window.addEventListener('click', function () {
        document.querySelectorAll('.dropdown').forEach(closeDropdown);
    });

})();
</script>

<!-- CHANGED: load agent and properties dropdown AJAX scripts -->
<script src="/habitrack/views/js/calendar.js"></script>
<script src="/habitrack/views/js/properties.js"></script>
<script src="/habitrack/views/js/bookVisit.js"></script>