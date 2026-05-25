document.addEventListener('DOMContentLoaded', function () {

 
    $("#btn-register").click(function(e) {
    e.preventDefault();  // Stop form submission
    Swal.fire({
        title: 'Register this agent?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, add it!',
        cancelButtonText: 'Cancel'
        // ... rest of your Swal config
    }).then(function (result) {
        if (result.value) {
            editAgent();
              //document.querySelector('form').submit();
            // Handle confirmation, e.g., submit form or redirect
        }
    });
});  


    function editAgent(){
        //let trans_type = $("#trans_type").val();
        let trans_type = "Update";
       // let propertyType = $("#property_type").val();
        let agentID = $("#agentID").val();
        //let agentPass = $("#agentPass").val();
        let agentFName = $("#agentFName").val();
        let agentMName = $("#agentMName").val();
        let agentLName = $("#agentLName").val();
        let agentSuffix = $("#agentSuffix").val();
        let agentGender = $("#agentGender").val();
        let agentBirthdate = $("#agentBirthdate").val();
        let agentSoldUnits = $("#agentSoldUnits").val();
        let agentAddress = $("#agentAddress").val();
        let agentPhoneNum = $("#agentPhoneNum").val();
        let agentEmail = $("#agentEmail").val();
        let agentFB = $("#agentFB").val();
        let agentPhoto = document.getElementById("pro-img");
      

      

        // alert(firstname + ' ' + lastname + ' ' + mi + ' ' + extension + ' ' + birthdate + ' ' + gender + ' ' + nationality + ' ' + email + ' ' + mobile + ' ' + alternate + ' ' + address);

        let addagent = new FormData();
        addagent.append("trans_type", trans_type);
        addagent.append("agentID", agentID);
        //addagent.append("agentPass", agentPass);
        addagent.append("agentFName", agentFName);
        addagent.append("agentMName", agentMName);
        addagent.append("agentLName", agentLName);
        addagent.append("agentSuffix", agentSuffix);
        addagent.append("agentGender", agentGender);
        addagent.append("agentBirthdate", agentBirthdate);
        addagent.append("agentSoldUnits", agentSoldUnits);
        addagent.append("agentAddress", agentAddress);
        addagent.append("agentPhoneNum", agentPhoneNum);
        addagent.append("agentEmail", agentEmail);
        addagent.append("agentFB", agentFB);

        if (agentPhoto && agentPhoto.files.length > 0) {
            addagent.append("agentPic", agentPhoto.files[0]);
        }
       



        $.ajax({
            url:"/habitrack/ajax/agent-register.ajax.php",
            method: "POST",
            data: addagent,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"text",
            success:function(answer){
                let agentID = answer;
                // alert(patientid);
               
            console.log(answer);
        /*      let imgagentData = new FormData();

            filesArray.forEach((file, index) => {
                imgagentData.append("images[]", file);
                imgagentData.append("orders[]", index);
            });

            imgData.append("propertyID", propertyID);
            console.log(filesArray.length);
            console.log(filesArray); */
                  Swal.fire({
                    title: 'Success!',
                    text: 'Agent updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'Got it',
                        customClass: {
                        confirmButton: 'btn btn-success'
                        },
                        //buttonsStyling: false
                }).then(function (result) {
                        if (result.value) {
                            window.location = 'agentdisplay';
                        }
                    });
/* 
            $.ajax({
                url: "/habitrack/ajax/upload-images.ajax.php",
                method: "POST",
                data: imgData,
                contentType: false,
                processData: false,
                success: function(res){
                    console.log("Images saved");
                    
                Swal.fire({
                    title: 'Success!',
                    text: 'Property saved successfully.',
                    icon: 'success',
                    confirmButtonText: 'Got it',
                        customClass: {
                        confirmButton: 'btn btn-success'
                        },
                        //buttonsStyling: false
                }).then(function (result) {
                        if (result.value) {
                            window.location = 'add-property';
                        }
                    });
                },
                  error: function () {
                Swal.fire({
                    title: 'Oops. Something went wrong!',
                    icon: 'error',
                    confirmButtonText: 'Got it',
                    customClass: {
                      confirmButton: 'btn btn-danger waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            }
                
            }); */
/* 
            Swal.fire({
                title: 'Success!',
                text: 'Property saved successfully.',
                icon: 'success',
                confirmButtonText: 'Got it',
                    customClass: {
                      confirmButton: 'btn btn-success waves-effect waves-light'
                    },
                    buttonsStyling: false
            }).then(function (result) {
                    if (result.value) {
                        window.location = 'add-property.php';
                    }
                }); */
            },
            error: function () {
                Swal.fire({
                    title: 'Oops. Something went wrong!',
                    icon: 'error',
                    confirmButtonText: 'Got it',
                    customClass: {
                      confirmButton: 'btn btn-danger waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            } 
        });
    }

/*     document.getElementById("propertyPhotos").addEventListener("change", function () {
    const preview = document.getElementById("preview");
    preview.innerHTML = ""; // clear old previews

    Array.from(this.files).forEach(file => {
        const img = document.createElement("img");

        img.src = URL.createObjectURL(file);
        img.classList.add("w-24", "h-24", "object-cover", "rounded-md", "shadow");

        preview.appendChild(img);
    });
}); */

/* document.getElementById("closeModal").addEventListener("click", function (e) {
    e.preventDefault();

    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImg");

    modal.classList.add("hidden");
    modal.classList.remove("flex");
    modalImg.src = "";
});
 */
const input = document.getElementById("agentPhoto");
const preview = document.getElementById("preview");

window.previewAgentPhoto = function (fileInput) {
    if (!fileInput || !preview) return;

    const file = fileInput.files[0];
        preview.innerHTML = "";

        if (!file) return;

        const item = document.createElement("div");
        item.className = "relative w-24 h-24 border rounded overflow-hidden shadow";

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "w-full h-full object-cover cursor-pointer";

        img.addEventListener("click", function () {
            const modal = document.getElementById("imageModal");
            const modalImg = document.getElementById("modalImg");

            if (!modal || !modalImg) return;

            modalImg.src = img.src;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        // ================= REMOVE =================
        const btn = document.createElement("button");
        btn.type = "button";
        btn.innerHTML = "×";

        btn.className =
            "absolute top-1 right-1 hover:bg-red-500 rounded-full text-white w-5 h-5 text-xs flex items-center justify-center";

        btn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            fileInput.value = "";
            preview.innerHTML = "";
        });

        item.appendChild(img);
        item.appendChild(btn);
        preview.appendChild(item);
};

// ================= FILE CHANGE =================
if (input && preview) {
    input.addEventListener("change", function () {
        window.previewAgentPhoto(this);
    });
}

const closeModal = document.getElementById("closeModal");
if (closeModal) {
    closeModal.addEventListener("click", function (e) {
        e.preventDefault();

        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImg");

        if (!modal || !modalImg) return;

        modal.classList.add("hidden");
        modal.classList.remove("flex");
        modalImg.src = "";
    });
}

});
