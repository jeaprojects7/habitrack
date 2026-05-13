
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
            url: "/habitrack_tryWsignin/ajax/clientsignup.save.ajax.php",
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
                alert("SALA KA")
                return;
            }
            saveClient();
            
            window.location = "login"; /* added 51226 */
            
    });
