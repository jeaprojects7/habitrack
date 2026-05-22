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
            addAgent();
              //document.querySelector('form').submit();
            // Handle confirmation, e.g., submit form or redirect
        }
    });
});  


    function addAgent(){
        //let trans_type = $("#trans_type").val();
        let trans_type = "New";
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
let filesArray = [];

const input = document.getElementById("propertyPhotos");
const preview = document.getElementById("preview");

// ================= MODAL CLOSE =================
document.getElementById("closeModal").addEventListener("click", function (e) {
    e.preventDefault();

    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImg");

    modal.classList.add("hidden");
    modal.classList.remove("flex");
    modalImg.src = "";
});

// ================= FILE CHANGE =================
input.addEventListener("change", function () {
    //filesArray = Array.from(this.files);
    filesArray = [...filesArray, ...Array.from(this.files)];
    updateInput();
    render();
});

// ================= RENDER =================
function render() {
    preview.innerHTML = "";

    filesArray.forEach((file, index) => {
        const item = document.createElement("div");

        item.className =
            "relative w-24 h-24 border rounded overflow-hidden shadow cursor-grab";

        item.draggable = true;

        // IMPORTANT: always sync real index
        item.dataset.index = index;

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "w-full h-full object-cover";

        // ================= MODAL OPEN =================
        img.addEventListener("click", () => {
            const modal = document.getElementById("imageModal");
            const modalImg = document.getElementById("modalImg");

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

            filesArray.splice(index, 1);
            updateInput();
            render();
        });

        // ================= DRAG START =================
        item.addEventListener("dragstart", (e) => {
            e.dataTransfer.setData("fromIndex", index);
            item.classList.add("opacity-50");
        });

        item.addEventListener("dragend", () => {
            item.classList.remove("opacity-50");
        });

        // ================= DRAG OVER =================
        item.addEventListener("dragover", (e) => {
            e.preventDefault();
        });

        // ================= DROP (FIXED LOGIC) =================
        item.addEventListener("drop", (e) => {
            e.preventDefault();

            const fromIndex = parseInt(e.dataTransfer.getData("fromIndex"));
            const toIndex = parseInt(item.dataset.index);

            if (fromIndex === toIndex) return;

            const moved = filesArray.splice(fromIndex, 1)[0];
            filesArray.splice(toIndex, 0, moved);

            updateInput();
            render();
        });

        item.appendChild(img);
        item.appendChild(btn);
        preview.appendChild(item);
    });
}

// ================= SYNC INPUT =================
function updateInput() {
    const dt = new DataTransfer();
    filesArray.forEach(file => dt.items.add(file));
    input.files = dt.files;
}

});