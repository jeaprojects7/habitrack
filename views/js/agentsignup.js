
    function saveAgent(){
        let agentID = $("#agentID").val(); ///
        let firstname = $("#firstname").val();
        let lastname = $("#lastname").val();
        let middlename = $("#middlename").val();
        let suffix = $("#suffix").val();
        let email = $("#email").val();
        let phonenumber = $("#phonenumber").val();
        let password = $("#password").val();

        let gender = $("#gender").val();
        let birthdate = $("#birthdate").val();
        let fb = $("#fb").val();
        let address = $("#address").val();
        let picture = $("#picture").val();
        let firstID = $("#firstID").val();
        let secondID = $("#secondID").val();
        let curEmp = $("#curEmp").val();
        let curPos = $("#curPos").val();
        let prevRealty = $("#prevRealty").val();
        let level = $("#level").val();
        let tin = $("#tin").val();
        let institution = $("#institution").val();
        let degree = $("#degree").val();
        let civilStatPic = $("#civilStatPic").val();
        let diploma = $("#diploma").val();
        let nbiPic = $("#nbiPic").val();
        let resumePic = $("#resumePic").val();
        let torPic = $("#torPic").val();
       

        

        let agent = new FormData();
        agent.append("agentID", agentID); ///
        agent.append("firstname", firstname);
        agent.append("lastname", lastname);
        agent.append("middlename", middlename);
        agent.append("suffix", suffix);
        agent.append("email", email);
        agent.append("phonenumber", phonenumber);
        agent.append("password", password);
        agent.append("gender", gender);
        agent.append("birthdate", birthdate);
        agent.append("fb", fb);
        agent.append("address", address);
        agent.append("picture", picture);
        agent.append("firstID", firstID);
        agent.append("secondID", secondID);
        agent.append("curEmp", curEmp);
        agent.append("curPos", curPos);
        agent.append("prevRealty", prevRealty);
        agent.append("level", level);
        agent.append("tin", tin);
        agent.append("institution", institution);
        agent.append("degree", degree);
        agent.append("civilStatPic", civilStatPic);
        agent.append("diploma", diploma);
        agent.append("nbiPic", nbiPic);
        agent.append("resumePic", resumePic);
        agent.append("torPic", torPic);


        $.ajax({
            url: "/habitrack/ajax/agentsignup.save.ajax.php",
            method: "POST",
            data: agent,
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


    $("#btn-signup-agent").click(function () {
        
            let requiredFields = [
                { id: "#firstname", label: "First Name" },
                { id: "#lastname", label: "Last Name" },
                { id: "#middlename", label: "Middle Name" },
                { id: "#email", label: "Email" },
                { id: "#phonenumber", label: "Phone Number" },
                { id: "#password", label: "Password" },
                /* { id: "#gender", label: "Gender" },
                { id: "#birthdate", label: "Birthdate" }, */
                { id: "#fb", label: "Facebook" },
                { id: "#address", label: "address" },
                { id: "#picture", label: "picture" },
                { id: "#firstID", label: "firstID" },
                { id: "#secondID", label: "secondID" },
                { id: "#curEmp", label: "curEmp" },
                { id: "#curPos", label: "curPos" },
                { id: "#prevRealty", label: "prevRealty" },
                // { id: "#level", label: "level" },
                { id: "#tin", label: "tin" },
                { id: "#institution", label: "institution" },
                { id: "#degree", label: "degree" },
                { id: "#civilStatPic", label: "civilStatPic" },
                { id: "#diploma", label: "diploma" },
                { id: "#nbiPic", label: "nbiPic" },
                { id: "#resumePic", label: "resumePic" },
                { id: "#torPic", label: "torPic" }
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
            saveAgent();
            
            window.location = "login"; /* added 51226 */
            
    });
