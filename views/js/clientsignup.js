
    function saveClient(){
        let clientID = $("#clientID").val(); ///
        let firstname = $("#firstname").val();
        let lastname = $("#lastname").val();
        let middlename = $("#middlename").val();
        let suffix = $("#suffix").val();
        let email = $("#email").val();
        let phonenumber = $("#phonenumber").val();
        let password = $("#password").val();
       

        

        let client = new FormData();
        client.append("clientID", clientID); ///
        client.append("firstname", firstname);
        client.append("lastname", lastname);
        client.append("middlename", middlename);
        client.append("suffix", suffix);
        client.append("email", email);
        client.append("phonenumber", phonenumber);
        client.append("password", password);


        $.ajax({
            url: "/habitrack/ajax/clientsignup.save.ajax.php",
            method: "POST",
            data: client,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"text",
            success:function(answer){
                console.log("saved")
               // added 51626
                Swal.fire({
                    icon: "success",
                    title: "<span style='font-size:35px;'>Success</span>",
                    html: "<span style='font-size:25px;'>Account created successfully!</span>",
                    showConfirmButton: true
                }).then(() => {
                    window.location = "clientlogin";
                });
  
                
            },
            error: function (xhr) {
                /* console.log(xhr.responseText);
                alert("AJAX ERROR - check console"); */
                //added v 51626
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong"
                });
            }
        });
    }


    $("#btn-signup").click(function () {
        
            let requiredFields = [
                { id: "#firstname", label: "First Name" },
                { id: "#lastname", label: "Last Name" },
                { id: "#middlename", label: "Middle Name" },
                { id: "#email", label: "Email" },
                { id: "#phonenumber", label: "Phone Number" },
                { id: "#password", label: "Password" }
            ];

            let emptyFields = [];
            requiredFields.forEach(function (field) {
                let value = $(field.id).val();

                if (!value || value.trim() === '') {
                    emptyFields.push(field.label);
                }
            });

            if (emptyFields.length > 0) {
                // added 51626
                Swal.fire({
                icon: "error",
                title: "<span style='font-size:35px;'>Missing Fields</span>",
                html: `
                    <div style="font-size:25px; text-align:center;">
                        Please fill in the following fields:<br><br>

                        <div style="display:inline-block; text-align:left;">
                            ${emptyFields.map(field => `• ${field}`).join("<br>")}
                        </div>
                    </div>
                `,
                confirmButtonText: "OK"
            });
                return;
            }
            

            // email validation added 51626
            let email = $("#email").val().trim();
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Email",
                    text: "Please enter a valid email address"
                });
                return;
            }

            // phone validation added 51626
            let phonenumber = $("#phonenumber").val().trim();

            if (!/^[0-9]{11}$/.test(phonenumber)) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Phone Number",
                    text: "Please enter a valid phone number"
                });
                return;
            }

            // password validation added 51626
            let password = $("#password").val().trim();

            let errors = [];

            // 1. length check (max 10 only)
            if (password.length > 10) {
                errors.push("Must not exceed 10 characters");
            }

            // 2. uppercase check
            if (!/[A-Z]/.test(password)) {
                errors.push("Must contain at least 1 uppercase letter");
            }

            // 3. lowercase check
            if (!/[a-z]/.test(password)) {
                errors.push("Must contain at least 1 lowercase letter");
            }

            // 4. number check
            if (!/[0-9]/.test(password)) {
                errors.push("Must contain at least 1 number");
            }

            // 5. special character check
            if (!/[^A-Za-z0-9]/.test(password)) {
                errors.push("Must contain at least 1 special character");
            }

            // show all errors like missing fields
            if (errors.length > 0) {
                Swal.fire({
                    icon: "error",
                    title: "Invalid Password",
                    html: `
                        Password must contain the following:<br><br>
                        <div style="text-align:left; display:inline-block;">
                            ${errors.map(e => `• ${e}`).join("<br>")}
                        </div>
                    `
                });
                return;
            }


            else{
                saveClient(); //changed 51326
            }
    });
