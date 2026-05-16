
    function saveAdmin(){
        let adminID = $("#adminID").val(); ///
        let firstname = $("#firstname").val();
        let lastname = $("#lastname").val();
        let middlename = $("#middlename").val();
        let suffix = $("#suffix").val();
        let email = $("#email").val();
        let phonenumber = $("#phonenumber").val();
        let password = $("#password").val();
       

        

        let admin = new FormData();
        admin.append("adminID", adminID); ///
        admin.append("firstname", firstname);
        admin.append("lastname", lastname);
        admin.append("middlename", middlename);
        admin.append("suffix", suffix);
        admin.append("email", email);
        admin.append("phonenumber", phonenumber);
        admin.append("password", password);


        $.ajax({
            url: "/habitrack/ajax/adminsignup.save.ajax.php",
            method: "POST",
            data: admin,
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


    $("#btn-signup-admin").click(function () {
        
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
                alert("SALA KA")
                return;
            }
            saveAdmin();
            
            window.location = "login"; /* added 51226 */
            
    });
