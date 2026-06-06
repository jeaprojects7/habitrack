$(document).ready(function () {
    loadSpouseInfo();
});

function saveSpouseInfo() {

    let spouse = new FormData();

    // ================= PAGE 1 =================
    spouse.append("clientCISID", $("#clientCISID").val());

    spouse.append("spouseFName", $("input[name=firstname]").val());
    spouse.append("spouseMName", $("input[name=middlename]").val());
    spouse.append("spouseLName", $("input[name=lastname]").val());
    spouse.append("spouseSuffix", $("input[name=suffix]").val());

    spouse.append("spouseEmail", $("input[name=email]").val());
    spouse.append("spousePhoneNum", $("input[name=phonenumber]").val());

    // spouse.append("civilstatus", $("#civilstatus").val());
    spouse.append("spouseGender", $("#gender").val());
    spouse.append("spouseBirthdate", $("#birthdate").val());

    spouse.append("spouseCitizenship", $("input[name=citizenship]").val());
    spouse.append("spouseReligion", $("input[name=religion]").val());
    spouse.append("spousePlaceOfBirth", $("input[name=placeofbirth]").val());

    // ================= PAGE 2 =================
    let parts = [
        $("input[name=unitno]").val(),
        $("input[name=street]").val(),
        $("input[name=subdivision]").val(),
        $("input[name=barangay]").val(),
        $("input[name=city]").val(),
        $("input[name=province]").val()
    ];

    spouse.append(
        "spouseAddress",
        parts.filter(v => v && v.trim() !== "").join(", ")
    );

    let provParts = [
        $("input[name=prov_unitno]").val(),
        $("input[name=prov_street]").val(),
        $("input[name=prov_subdivision]").val(),
        $("input[name=prov_barangay]").val(),
        $("input[name=prov_city]").val(),
        $("input[name=prov_province]").val()
    ];

    spouse.append(
        "spouseProvinceAddress",
        provParts.filter(v => v && v.trim() !== "").join(", ")
    );

    // ================= PAGE 3 =================
    spouse.append("spouseTaxIdenNum", $("input[name=tin]").val());
    spouse.append("spouseSSS_GSISnumber", $("input[name=sss_gsis]").val());

    spouse.append("spouseDependentsElem", $("input[name=elem]").val());
    spouse.append("spouseDependentsHS", $("input[name=highschool]").val());
    spouse.append("spouseDependentsC", $("input[name=college]").val());
    spouse.append("spouseDependentsNotStud", $("input[name=notstudying]").val());

    // ================= PAGE 4 =================
    spouse.append("spouseMonthlyIncome", $("input[name=gmi]").val());

    spouse.append("spouseSourceOfIncome", $("#sourceofincome").val());
    spouse.append("spouseEmployerBusinessName", $("input[name=empbusinessname]").val());
    spouse.append("spouseNatureOfBusiness", $("input[name=natureofbusiness]").val());
    spouse.append("spouseBusinessAddress", $("input[name=businessaddress]").val());

    spouse.append("spouseAppointment", $("#appointment").val());
    spouse.append("spousePlaceOfWork", $("#placeofwork").val());
    spouse.append("spouseDateHired", $("#datehired").val());

    spouse.append("spousePosition", $("input[name=position]").val());
    spouse.append("spouseDepartment", $("input[name=department]").val());
    spouse.append("spouseEmpPhoneNum", $("input[name=employerphonenumber]").val());
    spouse.append("spouseEmployerEmail", $("input[name=employeremail]").val());

    // ================= PAGE 5 =================
    spouse.append("spouseParentsAddress", $("input[name=parentsaddress]").val());
    spouse.append("spouseParentsPhoneNum", $("input[name=parentsphonenumber]").val());

    let fatherParts = [
        $("input[name=fathersfirstname]").val(),
        $("input[name=fathersmiddlename]").val(),
        $("input[name=fatherslastname]").val(),
        $("input[name=fatherssuffix]").val()
    ];

    spouse.append(
        "spouseFathersName",
        fatherParts.filter(v => v && v.trim() !== "").join(" ")
    );

    let motherParts = [
        $("input[name=mothersfirstname]").val(),
        $("input[name=mothersmiddlename]").val(),
        $("input[name=motherslastname]").val()
    ];

    spouse.append(
        "spouseMothersMaidenName",
        motherParts.filter(v => v && v.trim() !== "").join(" ")
    );

    // ================= AJAX =================
    $.ajax({
        url: "/habitrack/ajax/spouseInfoSheet.save.ajax.php",
        method: "POST",
        data: spouse,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "text",
        success: function (answer) {

            console.log("saved");

            Swal.fire({
                icon: "success",
                title: "<span style='font-size:35px;'>Success</span>",
                html: "<span style='font-size:25px;'>Information Sheet saved successfully!</span>",
                showConfirmButton: true
            }).then(() => {
                window.location = "reservations";
            });

        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Something went wrong"
            });
        }
    });
}

// ================= SUBMIT BUTTON =================

$("#btn-submit").click(function (e) {
    e.preventDefault();

    // FINAL CHECK (page 6 validation if needed)
    if (!validatePage(6)) return;

    Swal.fire({
        title: "Confirm Submission?",
        text: "Do you want to submit your information sheet?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Submit",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            saveSpouseInfo();
        }
    });
});



function validatePage(page) {

    let errors = [];

    // ================= PAGE 1 =================
    if (page === 1) {

        let required = [
            { el: "input[name=firstname]", label: "First Name" },
            { el: "input[name=lastname]", label: "Last Name" },
            { el: "input[name=email]", label: "Email" },
            { el: "input[name=phonenumber]", label: "Phone Number" },
            { el: "#civilstatus", label: "Civil Status" },
            { el: "#gender", label: "Gender" },
            { el: "#birthdate", label: "Birthdate" },
            { el: "input[name=citizenship]", label: "Citizenship" },
            { el: "input[name=religion]", label: "Religion" },
            { el: "input[name=placeofbirth]", label: "Place of Birth" }

        ];

        required.forEach(f => {
            let val = $(f.el).val();
            if (!val || val.trim() === "") errors.push(f.label);
        });

        // EMAIL VALIDATION
        let email = $("input[name=email]").val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && !emailRegex.test(email)) {
            errors.push("Email format is invalid");
        }

        // PHONE VALIDATION
        let phone = $("input[name=phonenumber]").val().trim();

        if (phone && !/^[0-9]{11}$/.test(phone)) {
            errors.push("Phone Number must be exactly 11 digits");
        }
    }

    // ================= PAGE 2 =================
    if (page === 2) {
        
        let required = [
            { el: "input[name=barangay]", label: "Barangay" },
            { el: "input[name=city]", label: "City" },
            { el: "input[name=province]", label: "Province" }
        ];

        required.forEach(f => {
            let val = $(f.el).val();

            if (!val || val.trim() === "") {
                errors.push(f.label);
            }
        });
    }

    // ================= PAGE 3 =================
    if (page === 3) {

        let required = [
            "input[name=tin]",
            "input[name=sss_gsis]",
        ];

        required.forEach(el => {
            let val = $(el).val();
            if (!val || val.trim() === "") {
                errors.push($(el).closest(".mb-4").find("label").text());
            }
        });
    }

    // ================= PAGE 4 =================
    if (page === 4) {

        let required = [
            "input[name=gmi]",
            "#sourceofincome",
            "input[name=empbusinessname]",
            "input[name=natureofbusiness]",
            "input[name=businessaddress]",
            "#appointment",
            "#placeofwork",
            "#datehired",
            "input[name=position]",
            "input[name=department]",
            "input[name=employerphonenumber]",
            "input[name=employeremail]"
        ];

        required.forEach(el => {
            let val = $(el).val();
            if (!val || val.trim() === "") {
                errors.push($(el).closest(".mb-4").find("label").text() || el);
            }
        });

        let employerEmail = $("input[name=employeremail]").val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (employerEmail && !emailRegex.test(employerEmail)) {
            errors.push("Invalid Employer Email Format");
        }

        let employerPhone = $("input[name=employerphonenumber]").val().trim();
        if (employerPhone && !/^[0-9]{11}$/.test(employerPhone)) {
            errors.push("Invalid Employer Phone Number");
        }
   
    }

    // ================= PAGE 5 =================
    if (page === 5) {

        let required = [
            "input[name=fathersfirstname]",
            "input[name=fatherslastname]",
            "input[name=mothersfirstname]",
            "input[name=motherslastname]",
            "input[name=parentsaddress]",
            "input[name=parentsphonenumber]"
        ];

        required.forEach(el => {
            let val = $(el).val();
            if (!val || val.trim() === "") {
                errors.push($(el).closest(".mb-4").find("label").text());
            }
        });

        // PHONE VALIDATION (PARENTS PHONE)
        let parentPhone = $("input[name=parentsphonenumber]").val().trim();

        if (parentPhone && !/^[0-9]{11}$/.test(parentPhone)) {
            errors.push("Invalid Parent Phone Number");
        }
    }


    // ================= ERROR ALERT =================
    if (errors.length > 0) {
        Swal.fire({
            icon: "error",
            title: "<span style='font-size:30px;'>Missing Fields</span>",
            html: `
                <div style="font-size:20px;">
                    Please fill in:<br><br>
                    <div style="text-align:left; display:inline-block;">
                        ${errors.map(e => `• ${e}`).join("<br>")}
                    </div>
                </div>
            `
        });

        return false;
    }

    return true;
}


function loadSpouseInfo() {

    let prequal = new FormData();
    prequal.append("prequalID", $("#prequalID").val());
    $.ajax({
        url: "/habitrack/ajax/spouseinfosheet.get.ajax.php",
        method: "POST",
        dataType: "json",
        data: prequal,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log("DATA TYPE:", typeof data);
            console.log("DATA:", data);
            if (!data) return;

            $("input[name=firstname]").val(data.coOwnerFName);
            $("input[name=middlename]").val(data.coOwnerMName);
            $("input[name=lastname]").val(data.coOwnerLName);
            $("input[name=suffix]").val(data.coOwnerSuffix ? data.coOwnerSuffix : " ") ;
            $("input[name=email]").val(data.coOwnerEmail);
            $("input[name=phonenumber]").val(data.coOwnerPhoneNum);
            $("input[name=gmi]").val(data.coOwnerMonthlyIncome);
            $("#civilstatus").val("Married");
            console.log($("#civilstatus").val());
            
        },

        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to load spouse information"
            });
        }
    });
}














const totalPages = 6;


function goToPage(pageNumber) {

    let currentPage = $("[id^=page-]:visible").attr("id");
    let current = currentPage ? parseInt(currentPage.replace("page-", "")) : 1;

    // validate current page BEFORE going next
    if (pageNumber > current) {
        if (!validatePage(current)) {
            return; // STOP navigation
        }
    }

    // hide all pages
    $("[id^=page-]").addClass("hidden");

    // show target page
    $("#page-" + pageNumber).removeClass("hidden");

    updateStepIndicator(pageNumber);
}

function updateStepIndicator(step) {

    for (let i = 1; i <= 6; i++) {

        let el = $("#step-" + i + "-indicator");

        if (i < step) {
            el.removeClass("bg-gray-200 text-gray-400")
              .addClass("bg-green-500 text-white");
        }

        if (i === step) {
            el.removeClass("bg-gray-200 text-gray-400 bg-green-500")
              .addClass("bg-blue-600 text-white");
        }

        if (i > step) {
            el.removeClass("bg-blue-600 bg-green-500 text-white")
              .addClass("bg-gray-200 text-gray-400");
        }
    }
}

function toggleGenderDropdown() {
    document.getElementById('gender-options').classList.toggle('hidden');
    document.getElementById('gender-arrow').classList.toggle('rotate-180');
}

function selectGender(value, label) {
    document.getElementById('gender').value = value;
    document.getElementById('gender-label').textContent = label;
    document.getElementById('gender-label').classList.remove('text-gray-400', 'dark:text-white/30');
    document.getElementById('gender-label').classList.add('text-gray-900', 'dark:text-white');
    document.getElementById('gender-options').classList.add('hidden');
    document.getElementById('gender-arrow').classList.remove('rotate-180');
}

function toggleCivilStatusDropdown() {
    document.getElementById('civstat-options').classList.toggle('hidden');
    document.getElementById('civstat-arrow').classList.toggle('rotate-180');
}

function selectCivilStatus(value, label) {
    document.getElementById('civilstatus').value = value;
    document.getElementById('civstat-label').textContent = label;
    document.getElementById('civstat-label').classList.remove('text-gray-400', 'dark:text-white/30');
    document.getElementById('civstat-label').classList.add('text-gray-900', 'dark:text-white');
    document.getElementById('civstat-options').classList.add('hidden');
    document.getElementById('civstat-arrow').classList.remove('rotate-180');
}

function toggleAppointmentDropdown() {
    document.getElementById('appointment-options').classList.toggle('hidden');
    document.getElementById('appointment-arrow').classList.toggle('rotate-180');
}

function selectAppointment(value, label) {
    document.getElementById('appointment').value = value;

    document.getElementById('appointment-label').textContent = label;

    document.getElementById('appointment-label').classList.remove(
        'text-gray-400',
        'dark:text-white/30'
    );

    document.getElementById('appointment-label').classList.add(
        'text-gray-900',
        'dark:text-white'
    );

    document.getElementById('appointment-options').classList.add('hidden');

    document.getElementById('appointment-arrow').classList.remove('rotate-180');
}

function toggleWorkplaceDropdown() {
    document.getElementById('workplace-options').classList.toggle('hidden');
    document.getElementById('workplace-arrow').classList.toggle('rotate-180');
}

function selectWorkplace(value, label) {
    document.getElementById('placeofwork').value = value;

    document.getElementById('workplace-label').textContent = label;

    document.getElementById('workplace-label').classList.remove(
        'text-gray-400',
        'dark:text-white/30'
    );

    document.getElementById('workplace-label').classList.add(
        'text-gray-900',
        'dark:text-white'
    );

    document.getElementById('workplace-options').classList.add('hidden');

    document.getElementById('workplace-arrow').classList.remove('rotate-180');
}

function toggleSourceOfIncomeDropdown() {
    document.getElementById('sourceofincome-options').classList.toggle('hidden');
    document.getElementById('sourceofincome-arrow').classList.toggle('rotate-180');
}

function selectSourceOfIncome(value, label) {
    document.getElementById('sourceofincome').value = value;
    document.getElementById('sourceofincome-label').textContent = label;
    document.getElementById('sourceofincome-label').classList.remove('text-gray-400', 'dark:text-white/30');
    document.getElementById('sourceofincome-label').classList.add('text-gray-900', 'dark:text-white');
    document.getElementById('sourceofincome-options').classList.add('hidden');
    document.getElementById('sourceofincome-arrow').classList.remove('rotate-180');
}

function copyHomeAddress(checkbox) {

    if (checkbox.checked) {

        // Get home address values
        let unitno = $("input[name=unitno]").val();
        let street = $("input[name=street]").val();
        let subdivision = $("input[name=subdivision]").val();
        let barangay = $("input[name=barangay]").val();
        let city = $("input[name=city]").val();
        let province = $("input[name=province]").val();

        // Copy to provincial address fields
        $("input[name=prov_unitno]").val(unitno);
        $("input[name=prov_street]").val(street);
        $("input[name=prov_subdivision]").val(subdivision);
        $("input[name=prov_barangay]").val(barangay);
        $("input[name=prov_city]").val(city);
        $("input[name=prov_province]").val(province);

    } else {

        // Clear fields when unchecked
        $("input[name=prov_unitno]").val("");
        $("input[name=prov_street]").val("");
        $("input[name=prov_subdivision]").val("");
        $("input[name=prov_barangay]").val("");
        $("input[name=prov_city]").val("");
        $("input[name=prov_province]").val("");

    }
}


document.addEventListener('click', function(e) {
    // Gender dropdown
    if (!document.getElementById('gender-wrapper').contains(e.target)) {
        document.getElementById('gender-options').classList.add('hidden');
        document.getElementById('gender-arrow').classList.remove('rotate-180');
    }

    // Appointment dropdown
    if (!document.getElementById('appointment-wrapper').contains(e.target)) {
        document.getElementById('appointment-options').classList.add('hidden');
        document.getElementById('appointment-arrow').classList.remove('rotate-180');
    }

    // Workplace dropdown
    if (!document.getElementById('workplace-wrapper').contains(e.target)) {
        document.getElementById('workplace-options').classList.add('hidden');
        document.getElementById('workplace-arrow').classList.remove('rotate-180');
    }

    // Civil Status dropdown
    if (!document.getElementById('civstat-wrapper').contains(e.target)) {
        document.getElementById('civstat-options').classList.add('hidden');
        document.getElementById('civstat-arrow').classList.remove('rotate-180');
    }

    // Soure of Income dropdown
    if (!document.getElementById('sourceofincome-wrapper').contains(e.target)) {
        document.getElementById('sourceofincome-options').classList.add('hidden');
        document.getElementById('sourceofincome-arrow').classList.remove('rotate-180');
    }
});



document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#birthdate", {
        dateFormat: "m-d-Y",
        maxDate: "today",
        disableMobile: true,
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.style.fontSize = "14px";
        },
        onOpen: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.style.fontSize = "14px";
        }
    });

    flatpickr("#datehired", {
        dateFormat: "m-d-Y",
        disableMobile: true,
        onReady: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.style.fontSize = "14px";
        },
        onOpen: function(selectedDates, dateStr, instance) {
            instance.calendarContainer.style.fontSize = "14px";
        }
    });
});


