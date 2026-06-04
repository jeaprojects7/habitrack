<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pre-qualification Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --color-background-primary:   #ffffff;
      --color-background-secondary: #f8f9fb;
      --color-text-primary:         #030712;
      --color-text-secondary:       #374151;
      --color-border-tertiary:      #e5e7eb;
      --color-border-secondary:     #d1d5db;
      --color-accent:               #3b82f6;
      --color-accent-hover:         #2563eb;
      --color-accent-active:        #1d4ed8;
      --font-sans:                  'Segoe UI', system-ui, -apple-system, sans-serif;
      --border-radius-md:           8px;
    }

    .dark {
      --color-background-primary:   #111827;
      --color-background-secondary: #1f2937;
      --color-text-primary:         #f9fafb;
      --color-text-secondary:       #9ca3af;
      --color-border-tertiary:      #374151;
      --color-border-secondary:     #4b5563;
      --color-accent:               #3b82f6;
      --color-accent-hover:         #60a5fa;
      --color-accent-active:        #93c5fd;
    }
    .dark body { background: #111827; }
    .dark .field select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    }

    body { font-family: var(--font-sans); background: var(--color-background-secondary); }

    .page {
      background: var(--color-background-primary);
      min-height: 100vh;
      max-width: 860px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      box-shadow: 0 0 0 0.5px var(--color-border-tertiary);
    }

    .top-bar {
      padding: 14px 24px;
      font-size: 16px;
      font-weight: 500;
      color: var(--color-text-primary);
      border-bottom: 0.5px solid var(--color-border-tertiary);
      flex-shrink: 0;
    }

    .form-body { padding: 20px 24px 24px; flex: 1; }

    .row { display: grid; gap: 12px; margin-bottom: 14px; }
    .row-2 { grid-template-columns: 1fr 1fr; }
    .row-3 { grid-template-columns: 1fr 1fr 1fr; }
    .row-4 { grid-template-columns: 2fr 2fr 1fr 1fr; }

    .field label { font-size: 13px; }
    .field input,
    .field select {
      width: 100%;
      height: 36px;
      border: 0.5px solid var(--color-border-tertiary);
      border-radius: 6px;
      padding: 0 10px;
      font-size: 14px;
      color: var(--color-text-primary);
      background: var(--color-background-primary);
      outline: none;
      transition: border-color .15s;
      appearance: none;
      -webkit-appearance: none;
    }
    .field select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      padding-right: 28px;
    }
    .field input:focus,
    .field select:focus {
      border-color: var(--color-accent);
      box-shadow: 0 0 0 2px rgba(59,130,246,.12);
    }
    .field input[type="date"] { padding: 0 8px; }

    .section-box {
      background: var(--color-background-secondary);
      border-radius: var(--border-radius-md);
      padding: 14px 16px;
      margin-bottom: 14px;
    }
    .section-title { font-size: 14px; }

    .three-col {
      display: grid;
      grid-template-columns: 160px 1fr 1fr;
      gap: 12px;
      align-items: start;
    }
    .yn-group { display: flex; flex-direction: column; }
    .yn-group .yn-label { font-size: 13px; }
    .radio-row {
      display: flex;
      gap: 8px;
      align-items: center;
      margin-top: 6px;
    }
    .radio-row label { font-size: 14px; cursor: pointer; }
    .radio-row input[type="radio"] {
      accent-color: var(--color-accent);
      width: 14px;
      height: 14px;
      cursor: pointer;
    }

    .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-top: 0.5px solid var(--color-border-tertiary);
      flex-shrink: 0;
    }
    .btn-back {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 16px;
      border: 0.5px solid var(--color-border-tertiary);
      border-radius: 6px;
      background: var(--color-background-primary);
      font-size: 14px;
      color: var(--color-text-secondary);
      cursor: pointer;
      transition: background .15s, border-color .15s;
    }
    .btn-back:hover {
      background: var(--color-background-secondary);
      border-color: var(--color-border-secondary);
    }
    .btn-next {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 20px;
      border: none;
      border-radius: 6px;
      background: var(--color-accent);
      color: #fff;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      transition: background .15s, transform .1s;
    }
    .btn-next:hover  { background: var(--color-accent-hover); }
    .btn-next:active { background: var(--color-accent-active); transform: scale(0.98); }

    .hidden { display: none !important; }
    .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0,0,0,0); white-space: nowrap; }
  </style>
</head>
<body>

<div class="page">
  <div class="top-bar">Pre-qualification Form</div>

  <div id="prequal-notification" style="display:none;padding:28px;text-align:center;">
    <div style="max-width:640px;margin:0 auto;background:linear-gradient(135deg,#2563eb 0%,#3b82f6 100%);color:#fff;padding:22px;border-radius:10px;box-shadow:0 8px 20px rgba(59,130,246,.12);">
      <div style="font-size:18px;font-weight:700;margin-bottom:8px;">You're connected to <span class="prequal-agent-name">Agent</span>.</div>
      <div style="font-size:13px;opacity:.95;margin-bottom:12px;">Please continue to fill out the pre-qualification form so the agent can contact you.</div>
      <button onclick="htShowPrequalForm()" style="padding:10px 18px;background:#fff;color:#1e40af;border-radius:8px;border:none;font-weight:600;cursor:pointer;">Continue</button>
    </div>
  </div>

  <div id="prequal-form-container" class="form-body">

    <!-- Row 1: Civil status / Employment / Income -->
    <div class="row row-3">
      <div class="field">
        <label for="civil-status">Civil status</label>
        <select id="civil-status" name="civil_status">
          <option value="">— select —</option>
          <option value="married">Married</option>
          <option value="widow">Widow</option>
          <option value="divorced">Divorced</option>
          <option value="single">Single</option>
        </select>
      </div>
      <div class="field">
        <label for="employment-status">Employment status</label>
        <select id="employment-status" name="employment_status">
          <option value="">— select —</option>
          <option value="local">Local</option>
          <option value="ofw">OFW</option>
        </select>
      </div>
      <div class="field">
        <label for="monthly-income">Monthly income</label>
        <input type="number" id="monthly-income" name="monthly_income" placeholder="0.00" min="0" step="0.01" />
      </div>
    </div>

    <!-- Principal buyer Co-Owner? — always visible -->
    <div id="ownership-section" class="section-box">
      <span class="yn-label">Principal buyer Co-Owner?</span>
      <div class="radio-row">
        <label><input type="radio" name="co_owner" value="yes" onchange="toggleCoOwnerDetails()" /> co-owner</label>
        <label><input type="radio" name="co_owner" value="no"  onchange="toggleCoOwnerDetails()" /> Principal buyer</label>
      </div>
    </div>

    <!-- Co-Owner details — shown only when YES is selected -->
    <div id="coOwner-section" class="section-box hidden">
      <div class="section-title">Co-Owner details</div>
      <div class="row" style="grid-template-columns: 2fr 2fr 2fr 1fr 1fr;">
        <div class="field">
          <label for="relationship">Relationship with Co-owner</label>
          <select id="relationship" name="co-owner_relationship">
            <option value="">— select —</option>
            <option value="Mother">Mother</option>
            <option value="Father">Father</option>
            <option value="Sister">Sister</option>
            <option value="Brother">Brother</option>
            <option value="Spouse">Spouse</option>
          </select>
        </div>
        <div class="field">
          <label for="co-owner-firstname">First name</label>
          <input type="text" id="co-owner-firstname" name="co-owner_firstname" />
        </div>
        <div class="field">
          <label for="co-owner-lastname">Last name</label>
          <input type="text" id="co-owner-lastname" name="co-owner_lastname" />
        </div>
        <div class="field">
          <label for="co-owner-mi">M.I.</label>
          <input type="text" id="co-owner-mi" name="co-owner_mi" maxlength="3" />
        </div>
        <div class="field">
          <label for="co-owner-suffix">Suffix</label>
          <input type="text" id="co-owner-suffix" name="co-owner_suffix" />
        </div>
      </div>
      <div class="row row-2">
        <div class="field">
          <label for="co-owner-email">Email</label>
          <input type="email" id="co-owner-email" name="co-owner_email" />
        </div>
        <div class="field">
          <label for="co-owner-phone">Phone number</label>
          <input type="tel" id="co-owner-phone" name="co-owner_phone" />
        </div>
      </div>
      <div class="row row-2">
        <div class="field">
          <label for="co-owner-employment">Employment status</label>
          <select id="co-owner-employment" name="co-owner_employment_status">
            <option value="">— select —</option>
            <option value="local">Local</option>
            <option value="ofw">OFW</option>
          </select>
        </div>
        <div class="field">
          <label for="co-owner-income">Monthly income</label>
          <input type="number" id="co-owner-income" name="co-owner_monthly_income" placeholder="0.00" min="0" step="0.01" />
        </div>
      </div>
    </div>

    <!-- Financing type -->
    <div class="row" style="grid-template-columns:240px">
      <div class="field">
        <label for="financing-type">Financing type</label>
        <select id="financing-type" name="financing_type" onchange="toggleFinancing()">
          <option value="">— select —</option>
          <option value="bank">Bank</option>
          <option value="pagibig">Pag-Ibig</option>
        </select>
      </div>
    </div>

    <!-- Bank Section -->
    <div id="bank-section" class="section-box hidden">
      <div class="three-col">
        <div class="field">
          <label for="bank-name">Bank name</label>
          <input type="text" id="bank-name" name="bank_name" />
        </div>
        <div class="yn-group">
          <span class="yn-label">Do you have existing house loan?</span>
          <div class="radio-row">
            <label><input type="radio" name="existing_house_loan" value="yes" /> YES</label>
            <label><input type="radio" name="existing_house_loan" value="no"  /> No</label>
          </div>
        </div>
        <div class="yn-group">
          <span class="yn-label">Do you have cancelled house loan?</span>
          <div class="radio-row">
            <label><input type="radio" name="cancelled_house_loan" value="yes" /> YES</label>
            <label><input type="radio" name="cancelled_house_loan" value="no"  /> No</label>
          </div>
        </div>
      </div>
    </div>

    <!-- Pag-Ibig Section -->
    <div id="pagibig-section" class="section-box hidden">
      <div class="row row-2" style="max-width:480px">
        <div class="field">
          <label for="contribution-date">Contribution start date</label>
          <input type="date" id="contribution-date" name="contribution_start_date" />
        </div>
        <div class="yn-group" style="padding-top:4px">
          <span class="yn-label">Do you have current loan?</span>
          <div class="radio-row">
            <label><input type="radio" name="current_loan" value="yes" /> YES</label>
            <label><input type="radio" name="current_loan" value="no"  /> No</label>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.form-body -->

  <div class="footer">
    <button class="btn-back" onclick="history.back()">
      <i class="ti ti-arrow-left" aria-hidden="true"></i> Back
    </button>
    <button class="btn-next" onclick="submitForm()">
      Submit <i class="ti ti-arrow-right" aria-hidden="true"></i>
    </button>
  </div>
</div>

<script src="pre-qual.js"></script>
<script>
(function () {
  const html = document.documentElement;

  function applyDark(on) {
    html.classList.toggle('dark', on);
  }

  function init() {
    const chk = document.getElementById('chk');
    if (chk) {
      applyDark(chk.checked);
      chk.addEventListener('change', function () {
        applyDark(this.checked);
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  new MutationObserver(function (mutations) {
    mutations.forEach(function (m) {
      if (m.attributeName === 'class') {
        const isDark = html.classList.contains('dark');
        const chk = document.getElementById('chk');
        if (chk && chk.checked !== isDark) chk.checked = isDark;
      }
    });
  }).observe(html, { attributes: true });
})();
</script>
</body>
</html>