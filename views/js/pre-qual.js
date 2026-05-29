// ─── Restore agent info: URL param -> localStorage (legacy) ──────────────────

(function () {
  try {
    var params = new URLSearchParams(window.location.search);
    var agentIdFromUrl = params.get('agent_id');
    if (agentIdFromUrl) {
      window._htPrequalAgentId = agentIdFromUrl;
      window._htPrequalAgentName = agentIdFromUrl;
      window._htPrequalAgentEmail = '';
    }

    var stored = localStorage.getItem('htPrequalAgent');
    if (stored) {
      var obj = JSON.parse(stored);
      window._htPrequalAgentEmail  = obj.email      || window._htPrequalAgentEmail  || '';
      window._htPrequalAgentName   = obj.name       || window._htPrequalAgentName   || '';
      window._htPrequalAgentId     = obj.agentId    || obj.agentID || window._htPrequalAgentId || '';
      window._htSelectedPropertyID = obj.propertyId || window._htSelectedPropertyID || null;

      setTimeout(function () {
        localStorage.removeItem('htPrequalAgent');
      }, 100);
    }
  } catch (e) {
    console.warn('Failed to restore prequal agent info', e);
  }
})();


// ─── Show/hide notification and form on page load ─────────────────────────────

document.addEventListener('DOMContentLoaded', function () {
  try {
    var notif = document.getElementById('prequal-notification');
    var form  = document.getElementById('prequal-form-container');

    if (window._htPrequalAgentName && notif) {
      var nameEl = notif.querySelector('.prequal-agent-name');
      if (nameEl) nameEl.textContent = window._htPrequalAgentName;
      notif.style.display = 'block';
      if (form) form.style.display = 'none';
    } else {
      if (notif) notif.style.display = 'none';
      if (form)  form.style.display  = 'block';
    }

    loadPrequalData();
  } catch (e) {
    console.warn('pre-qual UI init failed', e);
  }
});


// ─── Called by the Continue button in the notification ───────────────────────

function htShowPrequalForm() {
  var notif = document.getElementById('prequal-notification');
  var form  = document.getElementById('prequal-form-container');
  if (notif) notif.style.display = 'none';
  if (form)  form.style.display  = 'block';
}


// ─── Toggle: Co-Owner Section (shown when civil status = married) ─────────────

function toggleCoOwner() {
  const civilStatus    = document.getElementById('civil-status').value;
  const coOwnerSection = document.getElementById('coOwner-section');

  if (civilStatus === 'married') {
    if (coOwnerSection) coOwnerSection.classList.remove('hidden');
  } else {
    if (coOwnerSection) coOwnerSection.classList.add('hidden');
    clearCoOwnerFields();
  }
}

function toggleCoOwnerDetails() {
  const coOwner        = document.querySelector('input[name="co_owner"]:checked');
  const coOwnerSection = document.getElementById('coOwner-section');
  if (!coOwnerSection) return;

  if (coOwner && coOwner.value === 'yes') {
    coOwnerSection.classList.remove('hidden');
  } else {
    coOwnerSection.classList.add('hidden');
    clearCoOwnerFields();
  }
}

function clearCoOwnerFields() {
  const ids = [
    'relationship', 'co-owner-firstname', 'co-owner-lastname', 'co-owner-mi',
    'co-owner-suffix', 'co-owner-email', 'co-owner-phone',
    'co-owner-employment', 'co-owner-income'
  ];
  ids.forEach(function (id) {
    const el = document.getElementById(id);
    if (el) el.value = '';
  });
}


// ─── Toggle: Financing Sections ───────────────────────────────────────────────

function toggleFinancing() {
  const financingType  = document.getElementById('financing-type').value;
  const bankSection    = document.getElementById('bank-section');
  const pagibigSection = document.getElementById('pagibig-section');

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
  document.querySelectorAll('input[name="existing_house_loan"]').forEach(r => r.checked = false);
  document.querySelectorAll('input[name="cancelled_house_loan"]').forEach(r => r.checked = false);
}

function clearPagibigFields() {
  const date = document.getElementById('contribution-date');
  if (date) date.value = '';
  document.querySelectorAll('input[name="current_loan"]').forEach(r => r.checked = false);
}


// ─── Validation ───────────────────────────────────────────────────────────────

function validateForm() {
  const civilStatus    = document.getElementById('civil-status').value;
  const employmentStatus = document.getElementById('employment-status').value;
  const monthlyIncome  = document.getElementById('monthly-income').value;
  const financingType  = document.getElementById('financing-type').value;
   const coOwner  = document.getElementById('coOwner-section').value;

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

  // Validate co-owner fields when married
  if (coOwner === 'yes') {
    const coOwnerFirst      = document.getElementById('co-owner-firstname').value.trim();
    const coOwnerLast       = document.getElementById('co-owner-lastname').value.trim();
    const coOwnerEmail      = document.getElementById('co-owner-email').value.trim();
    const coOwnerPhone      = document.getElementById('co-owner-phone').value.trim();
    const coOwnerEmployment = document.getElementById('co-owner-employment').value;

    if (!coOwnerFirst || !coOwnerLast) {
      alert('Please enter co-owner first and last name.');
      return false;
    }
    if (!coOwnerEmail) {
      alert('Please enter co-owner email.');
      return false;
    }
    if (!coOwnerPhone) {
      alert('Please enter co-owner phone number.');
      return false;
    }
    if (!coOwnerEmployment) {
      alert('Please select co-owner employment status.');
      return false;
    } 
  }

  // Validate bank fields
  if (financingType === 'bank') {
    const bankName      = document.getElementById('bank-name').value.trim();
    const existingLoan  = document.querySelector('input[name="existing_house_loan"]:checked');
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


// ─── Collect Form Data ────────────────────────────────────────────────────────

function collectFormData() {
  const civilStatus   = document.getElementById('civil-status').value;
  const financingType = document.getElementById('financing-type').value;

  const data = {
    civil_status:      civilStatus,
    employment_status: document.getElementById('employment-status').value,
    monthly_income:    document.getElementById('monthly-income').value,
    financing_type:    financingType,
    agent_id:          window._htPrequalAgentId || null,
    coOwner:           null,
    bank:              null,
    pagibig:           null
  };

  const coOwnerRadio = document.querySelector('input[name="co_owner"]:checked');
  data.co_owner = coOwnerRadio ? coOwnerRadio.value : 'no';

  if (coOwnerRadio && coOwnerRadio.value === 'yes') {
    data.coOwner = {
      relationship:      document.getElementById('relationship').value,
      firstname:         document.getElementById('co-owner-firstname').value.trim(),
      lastname:          document.getElementById('co-owner-lastname').value.trim(),
      mi:                document.getElementById('co-owner-mi').value.trim(),
      suffix:            document.getElementById('co-owner-suffix').value.trim(),
      email:             document.getElementById('co-owner-email').value.trim(),
      phone:             document.getElementById('co-owner-phone').value.trim(),
      employment_status: document.getElementById('co-owner-employment').value,
      monthly_income:    document.getElementById('co-owner-income').value
    };
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


// ─── Load Prequal Data (Edit Mode or Copy from Another Property) ──────────

async function loadPrequalData() {
  if (!window._htPrequalAgentId || !window._htSelectedPropertyID) {
    return;
  }

  try {
    var response = await fetch('/habitrack/ajax/prequal.ajax.php?action=getPrequal', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        agent_id: window._htPrequalAgentId,
        property_id: window._htSelectedPropertyID
      })
    });

    var json = await response.json();

    if (json.success && json.data) {
      populateFormWithData(json.data);
      window._htPrequalData = json.data;
      
      // Determine mode based on property and agent match
      if (json.data.isSameProperty && json.data.isSameAgent) {
        window._htIsEditMode = true;      // Edit mode: update existing record
        window._htIsCopyMode = false;
      } else {
        window._htIsEditMode = false;     // Copy mode: create new record
        window._htIsCopyMode = true;      // (different property and/or agent)
      }
    }
  } catch (err) {
    console.error('Failed to load pre-qual data', err);
  }
}


// ─── Populate Form with Data ─────────────────────────────────────────────

function populateFormWithData(data) {
  if (data.civil_status) {
    var civilStatusEl = document.getElementById('civil-status');
    if (civilStatusEl) {
      civilStatusEl.value = data.civil_status;
      toggleCoOwner();
    }
  }

  if (data.employment_status) {
    var empStatusEl = document.getElementById('employment-status');
    if (empStatusEl) empStatusEl.value = data.employment_status;
  }

  if (data.monthly_income) {
    var incomeEl = document.getElementById('monthly-income');
    if (incomeEl) incomeEl.value = data.monthly_income;
  }

  if (data.financing_type) {
    var financingEl = document.getElementById('financing-type');
    if (financingEl) {
      financingEl.value = data.financing_type;
      toggleFinancing();
    }

    if (data.financing_type === 'bank' && data.bank) {
      var bankNameEl = document.getElementById('bank-name');
      if (bankNameEl && data.bank.bank_name) bankNameEl.value = data.bank.bank_name;
      
      if (data.bank.existing_house_loan) {
        var existingEl = document.querySelector('input[name="existing_house_loan"][value="' + data.bank.existing_house_loan + '"]');
        if (existingEl) existingEl.checked = true;
      }
      
      if (data.bank.cancelled_house_loan) {
        var cancelledEl = document.querySelector('input[name="cancelled_house_loan"][value="' + data.bank.cancelled_house_loan + '"]');
        if (cancelledEl) cancelledEl.checked = true;
      }
    }

    if (data.financing_type === 'pagibig' && data.pagibig) {
      var dateEl = document.getElementById('contribution-date');
      if (dateEl && data.pagibig.contribution_start_date) dateEl.value = data.pagibig.contribution_start_date;
      
      if (data.pagibig.current_loan) {
        var loanEl = document.querySelector('input[name="current_loan"][value="' + data.pagibig.current_loan + '"]');
        if (loanEl) loanEl.checked = true;
      }
    }
  }

  if (data.co_owner === 'yes' && data.coOwner) {
    var coOwnerRadio = document.querySelector('input[name="co_owner"][value="yes"]');
    if (coOwnerRadio) {
      coOwnerRadio.checked = true;
      toggleCoOwnerDetails();
    }

    var relationshipEl = document.getElementById('relationship');
    if (relationshipEl && data.coOwner.relationship) relationshipEl.value = data.coOwner.relationship;

    var firstNameEl = document.getElementById('co-owner-firstname');
    if (firstNameEl && data.coOwner.firstname) firstNameEl.value = data.coOwner.firstname;

    var lastNameEl = document.getElementById('co-owner-lastname');
    if (lastNameEl && data.coOwner.lastname) lastNameEl.value = data.coOwner.lastname;

    var miEl = document.getElementById('co-owner-mi');
    if (miEl && data.coOwner.mi) miEl.value = data.coOwner.mi;

    var suffixEl = document.getElementById('co-owner-suffix');
    if (suffixEl && data.coOwner.suffix) suffixEl.value = data.coOwner.suffix;

    var emailEl = document.getElementById('co-owner-email');
    if (emailEl && data.coOwner.email) emailEl.value = data.coOwner.email;

    var phoneEl = document.getElementById('co-owner-phone');
    if (phoneEl && data.coOwner.phone) phoneEl.value = data.coOwner.phone;

    var coOwnerEmpEl = document.getElementById('co-owner-employment');
    if (coOwnerEmpEl && data.coOwner.employment_status) coOwnerEmpEl.value = data.coOwner.employment_status;

    var coOwnerIncomeEl = document.getElementById('co-owner-income');
    if (coOwnerIncomeEl && data.coOwner.monthly_income) coOwnerIncomeEl.value = data.coOwner.monthly_income;
  } else if (data.co_owner === 'no') {
    var noPrincipalRadio = document.querySelector('input[name="co_owner"][value="no"]');
    if (noPrincipalRadio) {
      noPrincipalRadio.checked = true;
      toggleCoOwnerDetails();
    }
  }
}


// ─── Update Form Submit (Edit vs New) ────────────────────────────────────

async function submitForm() {
  if (!validateForm()) return;

  var formData = collectFormData();
  formData.property_id = window._htSelectedPropertyID || null;
  formData.agent_id    = window._htPrequalAgentId     || null;

  if (!formData.property_id) {
    alert('Unable to submit pre-qualification: property not selected.');
    return;
  }

  if (!formData.agent_id) {
    alert('Unable to submit pre-qualification: agent not selected.');
    return;
  }

  var endpoint = '/habitrack/ajax/prequal.ajax.php?action=savePrequal';
  var successMsg = 'Pre-qualification submitted successfully. Your request is now pending agent approval.';

  if (window._htIsEditMode && window._htPrequalData) {
    formData.prequal_id = window._htPrequalData.prequalID;
    endpoint = '/habitrack/ajax/prequal.ajax.php?action=updatePrequal';
    successMsg = 'Pre-qualification updated successfully.';
  } else if (window._htIsCopyMode && window._htPrequalData) {
    // In copy mode, reuse financing and co-owner IDs from source
    formData.financing_id = window._htPrequalData.financingID || '';
    formData.co_owner_id = window._htPrequalData.coOwnerID || '';
  }

  try {
    var response = await fetch(endpoint, {
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

    alert(successMsg);
    window.location = 'dashboard';
  } catch (err) {
    console.error('Prequal save failed', err);
    alert('Failed to submit pre-qualification. ' + (err.message || 'Please try again.'));
  }
}