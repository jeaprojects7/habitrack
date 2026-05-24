$(document).ready(function () {
    loadClientInfo();
});

function saveClientInfo() {

    let client = new FormData();

    // ================= PAGE 1 =================
    // client.append("firstname", $("input[name=firstname]").val());
    // client.append("middlename", $("input[name=middlename]").val());
    // client.append("lastname", $("input[name=lastname]").val());
    // client.append("suffix", $("input[name=suffix]").val());
    // client.append("email", $("input[name=email]").val());
    // client.append("phonenumber", $("input[name=phonenumber]").val());

    client.append("civilstatus", $("#civilstatus").val());
    client.append("gender", $("#gender").val());
    client.append("birthdate", $("#birthdate").val());

    client.append("citizenship", $("input[name=citizenship]").val());
    client.append("religion", $("input[name=religion]").val());
    client.append("placeofbirth", $("input[name=placeofbirth]").val());

    // ================= PAGE 2 =================
    // client.append("unitno", $("input[name=unitno]").val());
    // client.append("street", $("input[name=street]").val());
    // client.append("subdivision", $("input[name=subdivision]").val());
    // client.append("barangay", $("input[name=barangay]").val());
    // client.append("city", $("input[name=city]").val());
    // client.append("province", $("input[name=province]").val());

    let parts = [
        $("input[name=unitno]").val(),
        $("input[name=street]").val(),
        $("input[name=subdivision]").val(),
        $("input[name=barangay]").val(),
        $("input[name=city]").val(),
        $("input[name=province]").val()
    ];

    let fullAddress = parts
        .filter(v => v && v.trim() !== "")
        .join(", ");

    client.append("address", fullAddress);


    // client.append("prov_unitno", $("input[name=prov_unitno]").val());
    // client.append("prov_street", $("input[name=prov_street]").val());
    // client.append("prov_subdivision", $("input[name=prov_subdivision]").val());
    // client.append("prov_barangay", $("input[name=prov_barangay]").val());
    // client.append("prov_city", $("input[name=prov_city]").val());
    // client.append("prov_province", $("input[name=prov_province]").val());
    let provParts = [
        $("input[name=prov_unitno]").val(),
        $("input[name=prov_street]").val(),
        $("input[name=prov_subdivision]").val(),
        $("input[name=prov_barangay]").val(),
        $("input[name=prov_city]").val(),
        $("input[name=prov_province]").val()
    ];

    let provAddress = provParts
        .filter(v => v && v.trim() !== "")
        .join(", ");

    client.append("prov_address", provAddress);

    // ================= PAGE 3 =================
    client.append("tin", $("input[name=tin]").val());
    client.append("sss_gsis", $("input[name=sss_gsis]").val());

    client.append("elem", $("input[name=elem]").val());
    client.append("highschool", $("input[name=highschool]").val());
    client.append("college", $("input[name=college]").val());
    client.append("notstudying", $("input[name=notstudying]").val());

    // ================= PAGE 4 =================
    // client.append("sourceofincome", $("input[name=sourceofincome]").val());
    client.append("sourceofincome", $("#sourceofincome").val());
    client.append("empbusinessname", $("input[name=empbusinessname]").val());
    client.append("natureofbusiness", $("input[name=natureofbusiness]").val());
    client.append("businessaddress", $("input[name=businessaddress]").val());

    client.append("appointment", $("#appointment").val());
    client.append("placeofwork", $("#placeofwork").val());
    client.append("datehired", $("#datehired").val());

    client.append("position", $("input[name=position]").val());
    client.append("department", $("input[name=department]").val());
    client.append("employerphonenumber", $("input[name=employerphonenumber]").val());
    client.append("employeremail", $("input[name=employeremail]").val());

    // ================= PAGE 5 =================
    client.append("parentsaddress", $("input[name=parentsaddress]").val());
    client.append("parentsphonenumber", $("input[name=parentsphonenumber]").val());

    // client.append("fathersfirstname", $("input[name=fathersfirstname]").val());
    // client.append("fathersmiddlename", $("input[name=fathersmiddlename]").val());
    // client.append("fatherslastname", $("input[name=fatherslastname]").val());
    // client.append("fatherssuffix", $("input[name=fatherssuffix]").val());

    let fatherParts = [
        $("input[name=fathersfirstname]").val(),
        $("input[name=fathersmiddlename]").val(),
        $("input[name=fatherslastname]").val(),
        $("input[name=fatherssuffix]").val()
    ];

    let fathersFullName = fatherParts
        .filter(v => v && v.trim() !== "")
        .join(" ");

    client.append("fathersfullname", fathersFullName);

    // client.append("mothersfirstname", $("input[name=mothersfirstname]").val());
    // client.append("mothersmiddlename", $("input[name=mothersmiddlename]").val());
    // client.append("motherslastname", $("input[name=motherslastname]").val());

    let motherParts = [
        $("input[name=mothersfirstname]").val(),
        $("input[name=mothersmiddlename]").val(),
        $("input[name=motherslastname]").val()
    ];

    let mothersFullName = motherParts
        .filter(v => v && v.trim() !== "")
        .join(" ");

    client.append("mothersfullname", mothersFullName);

    // ================= PAGE 6 =================
    // client.append("spafirstname", $("input[name=spafirstname]").val());
    // client.append("spamiddlename", $("input[name=spamiddlename]").val());
    // client.append("spalastname", $("input[name=spalastname]").val());
    // client.append("spasuffix", $("input[name=spasuffix]").val());

    let spaParts = [
        $("input[name=spafirstname]").val(),
        $("input[name=spamiddlename]").val(),
        $("input[name=spalastname]").val(),
        $("input[name=spasuffix]").val()
    ];

    let spaFullName = spaParts
        .filter(v => v && v.trim() !== "")
        .join(" ");

    client.append("spafullname", spaFullName);

    client.append("spaaddress", $("input[name=spaaddress]").val());
    client.append("spaphonenumber", $("input[name=spaphonenumber]").val());

    // ================= AJAX =================
    $.ajax({
        url: "/habitrack/ajax/clientInfoSheet.save.ajax.php",
        method: "POST",
        data: client,
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
                window.location = "home";
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

    

   

    // $.ajax({
    //     url: "/habitrack/ajax/clientInfoSheet.save.ajax.php",
    //     method: "POST",
    //     data: client,
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     dataType: "text",
    //     success: function (answer) {

    //         console.log("saved");

    //         Swal.fire({
    //             icon: "success",
    //             title: "<span style='font-size:35px;'>Success</span>",
    //             html: "<span style='font-size:25px;'>Information Sheet saved successfully!</span>",
    //             showConfirmButton: true
    //         }).then(() => {
    //             window.location = "home";
    //         });

    //     },
    //     error: function () {

    //         Swal.fire({
    //             icon: "error",
    //             title: "Error",
    //             text: "Something went wrong"
    //         });

    //     }
    // });

    /* 
       Swal.fire({
        icon: "question",
        title: "Confirm Save",
        html: "<span style='font-size:20px;'>Do you want to save this information sheet?</span>",
        showCancelButton: true,
        confirmButtonText: "Yes, Save",
        cancelButtonText: "Cancel"
    }).then((result) => */
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
            saveClientInfo();
        }
    });
});
// $("#btn-submit").click(function (e) {
//     e.preventDefault();

//     let requiredFields = [
//         { id: "firstname", label: "First Name" },
//         { id: "lastname", label: "Last Name" },
//         { id: "email", label: "Email" },
//         { id: "phonenumber", label: "Phone Number" },
//         { id: "civilstatus", label: "Civil Status" },
//         { id: "gender", label: "Gender" }
//     ];

//     let emptyFields = [];

//     requiredFields.forEach(field => {
//         let val = $(`[name=${field.id}]`).val() || $("#" + field.id).val();

//         if (!val || val.trim() === "") {
//             emptyFields.push(field.label);
//         }
//     });

//     if (emptyFields.length > 0) {
//         Swal.fire({
//             icon: "error",
//             title: "<span style='font-size:35px;'>Missing Fields</span>",
//             html: `
//                 <div style="font-size:25px;">
//                     Please fill in the following fields:<br><br>
//                     <div style="text-align:left; display:inline-block;">
//                         ${emptyFields.map(f => `• ${f}`).join("<br>")}
//                     </div>
//                 </div>
//             `
//         });
//         return;
//     }

//     // email validation
//     let email = $("input[name=email]").val().trim();
//     let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//     if (!emailRegex.test(email)) {
//         Swal.fire({
//             icon: "error",
//             title: "Invalid Email",
//             text: "Enter a valid email address"
//         });
//         return;
//     }

//     // phone validation
//     let phone = $("input[name=phonenumber]").val().trim();

//     if (!/^[0-9]{11}$/.test(phone)) {
//         Swal.fire({
//             icon: "error",
//             title: "Invalid Phone Number",
//             text: "Must be 11 digits"
//         });
//         return;
//     }

//     saveClientInfo();
// });



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
            // { el: "input[name=unitno]", label: "Unit No." },
            // { el: "input[name=street]", label: "Street" },
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
            "input[name=elem]",
            "input[name=highschool]",
            "input[name=college]",
            "input[name=notstudying]"
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

        // let required = [
        //     "input[name=gmi]",
        //     // "input[name=sourceofincome]",
        //     "#sourceofincome",
        //     "input[name=empbusinessname]",
        //     "input[name=businessaddress]",
        //     "input[name=appointment]",
        //     "input[name=placeofwork]",
        //     "input[name=datehired]",
        // ];

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

        let employerEmail = $("input[name=employeremail]").val().trim();
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (employerEmail && !emailRegex.test(employerEmail)) {
            errors.push("Employer Email format is invalid");
        }

        let employerPhone = $("input[name=employerphonenumber]").val().trim();
        if (employerPhone && !/^[0-9]{11}$/.test(employerPhone)) {
            errors.push("Invalid Employer Phone Number");
        }

        // required.forEach(el => {
        //     let val = $(el).val();
        //     if (!val || val.trim() === "") {
        //         errors.push($(el).closest(".mb-4").find("label").text() || el);
        //     }
        // });
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
            errors.push("Parent Phone Number must be 11 digits");
        }
    }

    // PAGE 6 optional (SPA often optional)
    if (page === 6) {
        return true;
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


function loadClientInfo() {

    $.ajax({
        url: "/habitrack/ajax/clientinfosheet.get.ajax.php",
        method: "POST",
        dataType: "json",
        success: function (data) {
            console.log("DATA TYPE:", typeof data);
            console.log("DATA:", data);
            if (!data) return;

            $("input[name=firstname]").val(data.clientFName);
            $("input[name=middlename]").val(data.clientMName);
            $("input[name=lastname]").val(data.clientLName);
            $("input[name=suffix]").val(data.clientSuffix ? data.clientSuffix : " ") ;
            $("input[name=email]").val(data.clientEmail);
            $("input[name=phonenumber]").val(data.clientPhoneNum);
        },

        error: function () {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Failed to load client information"
            });
        }
    });
}














const totalPages = 6;

// function goToPage(pageNum) {
//     for (let i = 1; i <= totalPages; i++) {
//         document.getElementById('page-' + i).classList.add('hidden');
//         const indicator = document.getElementById('step-' + i + '-indicator');
//         indicator.classList.remove('bg-blue-600', 'text-white');
//         indicator.classList.add('bg-gray-200', 'text-gray-400');
//     }
//     document.getElementById('page-' + pageNum).classList.remove('hidden');
//     const active = document.getElementById('step-' + pageNum + '-indicator');
//     active.classList.remove('bg-gray-200', 'text-gray-400');
//     active.classList.add('bg-blue-600', 'text-white');
//     document.getElementById('main-area').scrollTo({ top: 0, behavior: 'smooth' });
// }

// function goToPage(pageNumber) {

//     let currentPage = $(".page:visible").attr("id"); 
//     let current = currentPage ? parseInt(currentPage.replace("page-", "")) : 1;

//     // validate current page BEFORE going next
//     if (pageNumber > current) {
//         if (!validatePage(current)) {
//             return; // STOP navigation
//         }
//     }

//     // hide all pages
//     $("[id^=page-]").addClass("hidden");

//     // show target page
//     $("#page-" + pageNumber).removeClass("hidden");

//     // update step indicator (optional but nice)
//     updateStepIndicator(pageNumber);
// }

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

// let birthdatePicker;

// document.addEventListener("DOMContentLoaded", function () {

//     birthdatePicker = flatpickr("#birthdate", {
//         dateFormat: "Y-m-d",
//         altInput: true,
//         altFormat: "F j, Y",
//         maxDate: "today",

//         onChange: function(selectedDates, dateStr) {
//             const clearBtn = document.getElementById("clearBirthdate");

//             if (dateStr) {
//                 clearBtn.classList.remove("hidden");
//             } else {
//                 clearBtn.classList.add("hidden");
//             }
//         }
//     });

// });

// function clearBirthdateField() {
//     birthdatePicker.clear();
//     document.getElementById("clearBirthdate").classList.add("hidden");
// }

// document.addEventListener("DOMContentLoaded", function () {
//     flatpickr("#birthdate", {
//         dateFormat: "Y-m-d",
//         maxDate: "today",
//         disableMobile: true,
//         onReady: function(selectedDates, dateStr, instance) {
//             instance.calendarContainer.style.width = instance.input.offsetWidth + "px";
//         },
//         onOpen: function(selectedDates, dateStr, instance) {
//             instance.calendarContainer.style.width = instance.input.offsetWidth + "px";
//         }
//     });
// });



