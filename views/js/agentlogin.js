function loginAgent() {

    let email = $("#agentLoginEmail").val();
    let password = $("#agentLoginPass").val();

    let emptyFields = [];

    if (!email || email.trim() === '') emptyFields.push("Email");
    if (!password || password.trim() === '') emptyFields.push("Password");

    // ❌ VALIDATION
    if (emptyFields.length > 0) {
        Swal.fire({
            icon: "error",
            title: "<span style='font-size:35px;'>Missing Fields</span>",
            html: `
                <div style="font-size:25px; text-align:center;">
                    ${emptyFields.map(f => `• ${f}`).join("<br>")}
                </div>
            `
        });
        return;
    }

    // LOADING
    Swal.fire({
        title: "<span style='font-size:30px;'>Logging in...</span>",
        html: "<span style='font-size:22px;'>Please wait</span>",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    // AJAX REQUEST
    $.ajax({
        url: "/habitrack/ajax/agentlogin.ajax.php",
        method: "POST",
        data: {
            agentLoginEmail: email,
            agentLoginPass: password
        },
        success: function (response) {

            if (response.trim() === "success") {

                Swal.fire({
                    icon: "success",
                    title: "<span style='font-size:35px;'>Login Successful</span>",
                    showConfirmButton: true
                }).then(() => {
                    window.location = "agentDashboard";
                });

            } else {

                Swal.fire({
                    icon: "error",
                    title: "<span style='font-size:35px;'>Login Failed</span>",
                    html: "<span style='font-size:25px;'>Incorrect email or password</span>"
                });
            }
        }
    });
}

// BUTTON CLICK
$("#btn-agent-login").click(function () {
    loginAgent();
});