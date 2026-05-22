document.addEventListener('DOMContentLoaded', function () {

    /* var map = L.map('map').setView([9.7392, 118.7353], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

     let marker;

    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // remove old marker
        if (marker) {
            map.removeLayer(marker);
        }

        // add new marker
        marker = L.marker([lat, lng]).addTo(map);

        // store values in form
        document.getElementById('propertyLat').value = lat;
        document.getElementById('propertyLng').value = lng;

        console.log("Selected location:", lat, lng);
    }); 
    const lat = parseFloat("<?= $property['propertyLat'] ?>");
    const lng = parseFloat("<?= $property['propertyLng'] ?>");

    if (lat && lng) {
        map.setView([lat, lng], 15);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("Property Location")
            .openPopup();
    } */
   var map = L.map('map').setView([9.7392, 118.7353], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
const lat = parseFloat(window.propertyData.lat);
const lng = parseFloat(window.propertyData.lng);

console.log("Coords:", lat, lng);

if (!isNaN(lat) && !isNaN(lng)) {
    map.setView([lat, lng], 15);

    L.marker([lat, lng])
        .addTo(map)
        //.bindPopup('propertyID')
        .openPopup();
}

    // Property type toggle (your existing logic is fine)
    const propertyType = document.getElementById('property_type');
    //const lotFields = document.getElementById('lotFields');
    const houseFields = document.getElementById('houseFields');
    const houseAmenities = document.getElementById('houseAmenities');
/* 
    if (propertyType) {
        propertyType.addEventListener('change', function () {

            //lotFields.style.display = 'none';
            houseFields.style.display = 'none';
            houseAmenities.style.display = 'none';

            //if (this.value === 'Lot') lotFields.style.display = 'block';
            if (this.value === 'House') houseFields.style.display = 'block';
            if (this.value === 'House') houseAmenities.style.display = 'block';
        });
    } */
        function togglePropertyFields() {

            houseFields.style.display = 'none';
            houseAmenities.style.display = 'none';

            if (propertyType.value === 'House') {

                houseFields.style.display = 'block';
                houseAmenities.style.display = 'block';
            }
        }

        // run when dropdown changes
        propertyType.addEventListener('change', togglePropertyFields);

        // run immediately on page load
        togglePropertyFields();
    $("#btn-add").click(function(e) {
    e.preventDefault();  // Stop form submission
    Swal.fire({
        title: 'Edit this property?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Edit it!',
        cancelButtonText: 'Cancel'
        // ... rest of your Swal config
    }).then(function (result) {
        if (result.value) {
            editProperty();
              //document.querySelector('form').submit();
            // Handle confirmation, e.g., submit form or redirect
        }
    });
});  


    function editProperty(){
        //let trans_type = $("#trans_type").val();
        let trans_type = "Update";
        let propertyType = $("#property_type").val();

        let propertyName = $("#propertyName").val();
        let propertyLat = $("#propertyLat").val();
        let propertyLng = $("#propertyLng").val();

        //let propertyID = $("#propertyID").val();
        let propertyID = document.getElementById("propertyID").value;
        
        let propertyCity = $("#propertyCity").val();
        let propertyBrgy = $("#propertyBrgy").val();
        let propertyPrice = $("#propertyPrice").val();
        let houseFloorArea = $("#houseFloorArea").val();
        let houseStorey = $("#houseStorey").val();
        let houseBedroom = $("#houseBedroom").val();
        let houseTandB = $("#houseTandB").val();
        let propertyLotArea = $("#propertyLotArea").val();

            // Collect checked amenities
        let amenities = [];
        $("#houseAmenities input[type='checkbox']:checked").each(function() {
            amenities.push($(this).val());
        });

        // alert(firstname + ' ' + lastname + ' ' + mi + ' ' + extension + ' ' + birthdate + ' ' + gender + ' ' + nationality + ' ' + email + ' ' + mobile + ' ' + alternate + ' ' + address);

        let addproperty = new FormData();
        addproperty.append("trans_type", trans_type);
        addproperty.append("propertyID", propertyID);
        addproperty.append("propertyType", propertyType);
        addproperty.append("propertyName", propertyName);
        addproperty.append("propertyLat", propertyLat);
        addproperty.append("propertyLng", propertyLng);
        addproperty.append("propertyCity", propertyCity);
        addproperty.append("propertyBrgy", propertyBrgy);
        addproperty.append("propertyPrice", propertyPrice);
        addproperty.append("houseFloorArea", houseFloorArea);
        addproperty.append("houseStorey", houseStorey);
        addproperty.append("houseBedroom", houseBedroom);
        addproperty.append("houseTandB", houseTandB);
        addproperty.append("propertyLotArea", propertyLotArea);

        // Add amenities array to FormData
    amenities.forEach(function(item){
        addproperty.append("amenities[]", item);
    });

        
    // append property data first
    addproperty.append("propertyID", propertyID);

  


        $.ajax({
            url:"/habitrack/ajax/add-property.ajax.php",
            method: "POST",
            data: addproperty,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"text",
            success:function(answer){
                //let propertyID = answer;
                // alert(patientid);
               
            console.log(answer);
             let imgData = new FormData();

            filesArray.forEach((file, index) => {
                imgData.append("images[]", file);
                imgData.append("orders[]", index);
            });

            imgData.append("propertyID", propertyID);
            console.log(filesArray.length);
            console.log(filesArray);

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
                            window.location = 'exploreproperty.php';//'edit-property.php?propertyID=' + propertyID;
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
                
            });
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
          /*   error: function () {
                Swal.fire({
                    title: 'Oops. Something went wrong!',
                    icon: 'error',
                    confirmButtonText: 'Got it',
                    customClass: {
                      confirmButton: 'btn btn-danger waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            } */
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