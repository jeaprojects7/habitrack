// ─── Toggle: Spouse Details ───────────────────────────────────────────────────

// Restore agent info: URL param -> localStorage (legacy)
(function () {
  try {
    var params = new URLSearchParams(window.location.search);
    var agentIdFromUrl = params.get('agent_id');
    if (agentIdFromUrl) {
      window._htPrequalAgentId = agentIdFromUrl;
      window._htPrequalAgentName = agentIdFromUrl; // fallback display
      window._htPrequalAgentEmail = '';
    }

    var stored = localStorage.getItem('htPrequalAgent');
    if (stored) {
      var obj = JSON.parse(stored);
      window._htPrequalAgentEmail = obj.email   || window._htPrequalAgentEmail || '';
      window._htPrequalAgentName  = obj.name    || window._htPrequalAgentName  || '';
      window._htPrequalAgentId    = obj.agentId || obj.agentID || window._htPrequalAgentId || '';
      window._htSelectedPropertyID = obj.propertyId || window._htSelectedPropertyID || null;
      
      // Only remove from localStorage after all values are safely stored in window
      setTimeout(function() {
        localStorage.removeItem('htPrequalAgent');
      }, 100);
    }
  } catch (e) {
    console.warn('Failed to restore prequal agent info', e);
  }
})();

// Show/hide the notification and form on page load
document.addEventListener('DOMContentLoaded', function() {
  try {
    var notif = document.getElementById('prequal-notification');
    var form = document.getElementById('prequal-form-container');

    if (window._htPrequalAgentName && notif) {
      var nameEl = notif.querySelector('.prequal-agent-name');
      if (nameEl) nameEl.textContent = window._htPrequalAgentName;
      notif.style.display = 'block';
      if (form) form.style.display = 'none';
    } else {
      if (notif) notif.style.display = 'none';
      if (form) form.style.display = 'block';
    }
  } catch (e) {
    console.warn('pre-qual UI init failed', e);
  }
});

// Called by the Continue button in the notification — reveal the form
function htShowPrequalForm() {
  var notif = document.getElementById('prequal-notification');
  var form = document.getElementById('prequal-form-container');
  if (notif) notif.style.display = 'none';
  if (form) form.style.display = 'block';
}

function toggleSpouse() {
  const civilStatus = document.getElementById('civil-status').value;
  const ownershipSection = document.getElementById('ownership-section');
  const spouseSection = document.getElementById('spouse-section');

  if (civilStatus === 'married') {
    if (ownershipSection) ownershipSection.classList.remove('hidden');
  } else {
    if (ownershipSection) ownershipSection.classList.add('hidden');
    if (spouseSection) spouseSection.classList.add('hidden');
    clearSpouseFields();
  }
}

// Show/hide spouse details when the co-owner radio is toggled
function toggleSpouseDetails() {
  const coOwner = document.querySelector('input[name="co_owner"]:checked');
  const spouseSection = document.getElementById('spouse-section');
  if (!spouseSection) return;

  if (coOwner && coOwner.value === 'yes') {
    spouseSection.classList.remove('hidden');
  } else {
    spouseSection.classList.add('hidden');
    clearSpouseFields();
  }
}

function clearSpouseFields() {
  const fields = [
    'spouse-firstname', 'spouse-lastname', 'spouse-mi',
    'spouse-suffix', 'spouse-email', 'spouse-phone',
    'spouse-employment', 'spouse-income'
  ];
  fields.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
}


// ─── Toggle: Financing Sections ──────────────────────────────────────────────

function toggleFinancing() {
  const financingType = document.getElementById('financing-type').value;
  const bankSection = document.getElementById('bank-section');
  const pagibigSection = document.getElementById('pagibig-section');

  // Hide both first and clear their fields
  bankSection.classList.add('hidden');
  pagibigSection.classList.add('hidden');
  clearBankFields();
  clearPagibigFields();

  if (financingType === 'bank') {
    bankSection.classList.remove('hidden');
  } else if (financingType === 'pagibig') {
    pagibigSection.classList.remove('hidden');
  }
}

function clearBankFields() {
  const bankName = document.getElementById('bank-name');
  if (bankName) bankName.value = '';

  document.querySelectorAll('input[name="existing_house_loan"]')
    .forEach(r => r.checked = false);
  document.querySelectorAll('input[name="cancelled_house_loan"]')
    .forEach(r => r.checked = false);
}

function clearPagibigFields() {
  const date = document.getElementById('contribution-date');
  if (date) date.value = '';

  document.querySelectorAll('input[name="current_loan"]')
    .forEach(r => r.checked = false);
}


// ─── Validation ───────────────────────────────────────────────────────────────

function validateForm() {
  const civilStatus = document.getElementById('civil-status').value;
  const employmentStatus = document.getElementById('employment-status').value;
  const monthlyIncome = document.getElementById('monthly-income').value;
  const financingType = document.getElementById('financing-type').value;

  if (!civilStatus) {
    alert('Please select a civil status.');
    return false;
  }

  if (!employmentStatus) {
    alert('Please select an employment status.');
    return false;
  }

  if (!monthlyIncome || parseFloat(monthlyIncome) <= 0) {
    alert('Please enter a valid monthly income.');
    return false;
  }

  if (!financingType) {
    alert('Please select a financing type.');
    return false;
  }

  // Validate spouse fields only when married AND spouse is a co-owner
  if (civilStatus === 'married') {
    const coOwner = document.querySelector('input[name="co_owner"]:checked')?.value || 'no';
    if (coOwner === 'yes') {
      const spouseFirst = document.getElementById('spouse-firstname').value.trim();
      const spouseLast = document.getElementById('spouse-lastname').value.trim();
      const spouseEmail = document.getElementById('spouse-email').value.trim();
      const spousePhone = document.getElementById('spouse-phone').value.trim();
      const spouseEmployment = document.getElementById('spouse-employment').value;

      if (!spouseFirst || !spouseLast) {
        alert('Please enter spouse first and last name.');
        return false;
      }
      if (!spouseEmail) {
        alert('Please enter spouse email.');
        return false;
      }
      if (!spousePhone) {
        alert('Please enter spouse phone number.');
        return false;
      }
      if (!spouseEmployment) {
        alert('Please select spouse employment status.');
        return false;
      }
    }
  }

  // Validate bank fields
  if (financingType === 'bank') {
    const bankName = document.getElementById('bank-name').value.trim();
    const existingLoan = document.querySelector('input[name="existing_house_loan"]:checked');
    const cancelledLoan = document.querySelector('input[name="cancelled_house_loan"]:checked');

    if (!bankName) {
      alert('Please enter the bank name.');
      return false;
    }
    if (!existingLoan) {
      alert('Please answer: Do you have an existing house loan?');
      return false;
    }
    if (!cancelledLoan) {
      alert('Please answer: Do you have a cancelled house loan?');
      return false;
    }
  }

  // Validate Pag-Ibig fields
  if (financingType === 'pagibig') {
    const contribDate = document.getElementById('contribution-date').value;
    const currentLoan = document.querySelector('input[name="current_loan"]:checked');

    if (!contribDate) {
      alert('Please enter the contribution start date.');
      return false;
    }
    if (!currentLoan) {
      alert('Please answer: Do you have a current loan?');
      return false;
    }
  }

  return true;
}


// ─── Submit ───────────────────────────────────────────────────────────────────

async function submitForm() {
  if (!validateForm()) return;

  var formData = collectFormData();
  formData.property_id = window._htSelectedPropertyID || null;
  formData.agent_id = window._htPrequalAgentId || null;

  if (!formData.property_id) {
    alert('Unable to submit pre-qualification: property not selected.');
    return;
  }

  if (!formData.agent_id) {
    alert('Unable to submit pre-qualification: agent not selected.');
    return;
  }

  try {
    var response = await fetch('/habitrack/ajax/prequal.ajax.php?action=savePrequal', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(formData)
    });

    var json = await response.json();

    if (!json.success) {
      throw new Error(json.error || 'Save failed');
    }

    alert('Pre-qualification submitted successfully. Your request is now pending agent approval.');
    window.location.href = '/habitrack/?route=dashboard';
  } catch (err) {
    console.error('Prequal save failed', err);
    alert('Failed to submit pre-qualification. ' + (err.message || 'Please try again.'));
  }
}


// ─── Collect Form Data ────────────────────────────────────────────────────────

function collectFormData() {
  const civilStatus = document.getElementById('civil-status').value;
  const financingType = document.getElementById('financing-type').value;

  const data = {
    civil_status:       civilStatus,
    employment_status:  document.getElementById('employment-status').value,
    monthly_income:     document.getElementById('monthly-income').value,
    financing_type:     financingType,
    agent_id:           window._htPrequalAgentId || null,
    ownership:          null,
    spouse:             null,
    bank:               null,
    pagibig:            null
  };

  if (civilStatus === 'married') {
    const coOwnerEl = document.querySelector('input[name="co_owner"]:checked');
    const coOwner = coOwnerEl ? coOwnerEl.value : null;

    data.ownership = { co_owner: coOwner };

    if (coOwner === 'yes') {
      data.spouse = {
        firstname:         document.getElementById('spouse-firstname').value.trim(),
        lastname:          document.getElementById('spouse-lastname').value.trim(),
        mi:                document.getElementById('spouse-mi').value.trim(),
        suffix:            document.getElementById('spouse-suffix').value.trim(),
        email:             document.getElementById('spouse-email').value.trim(),
        phone:             document.getElementById('spouse-phone').value.trim(),
        employment_status: document.getElementById('spouse-employment').value,
        monthly_income:    document.getElementById('spouse-income').value
      };
    }
  }

  if (financingType === 'bank') {
    data.bank = {
      bank_name:            document.getElementById('bank-name').value.trim(),
      existing_house_loan:  document.querySelector('input[name="existing_house_loan"]:checked')?.value ?? null,
      cancelled_house_loan: document.querySelector('input[name="cancelled_house_loan"]:checked')?.value ?? null
    };
  }

  if (financingType === 'pagibig') {
    data.pagibig = {
      contribution_start_date: document.getElementById('contribution-date').value,
      current_loan:            document.querySelector('input[name="current_loan"]:checked')?.value ?? null
    };
  }

  return data;
}