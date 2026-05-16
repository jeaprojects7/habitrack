
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
               /*  console.log(answer) */
  
                
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("AJAX ERROR - check console");
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
            }else{
                saveClient(); //changed 51326
                // added 51626
                Swal.fire({
                    icon: "success",
                    title: "<span style='font-size:35px;'>Success</span>",
                    html: "<span style='font-size:25px;'>Account created successfully!</span>",
                    showConfirmButton: true
                }).then(() => {
                    window.location = "clientlogin";
                });
                //window.location = "login"; /* added 51226 */
            }
    });
