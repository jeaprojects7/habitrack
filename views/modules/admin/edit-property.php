
<?php
/* $base_dir = views/ ;  */ 
$static_url = '/habitrack/views/Adminassets';
/* $route = 'edit-property'; */
require_once __DIR__ . '/../../../controllers/add-property.controller.php'; 

//  Get ID from URL
/* $propertyID = $_GET['propertyID'] ?? null; */

$propertyID = $_SESSION['propertyID'] ?? null;

if (!$propertyID) {
    die("No property ID provided.");
}

//  Fetch property data
$property = ControllerAddProperty::ctrGetProperty($propertyID);
$images = ControllerAddProperty::ctrGetPropertyImages($propertyID);

if (!$property) {
    die("Property not found.");
}


?>
<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="
        left:300px;
        bottom:0;
        z-index:20;
    "
    >


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<div class="container-fluid relative px-3 main-content">
    <div class="layout-specing">

        <!-- Header -->
        
         <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Edit Properties</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white"><a href="exploreproperty">Explore Properties</a></li>
                    <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Edit Properties</li>
                </ul>
            </div>


        <!-- GRID (UPDATED: 12 columns system) -->
        <div class="grid md:grid-cols-12 grid-cols-1 gap-6 mt-6">

            <!-- FORM (SMALLER - 1/3) -->
            <div class="md:col-span-4 col-span-12 rounded-md shadow p-6 bg-white dark:bg-slate-900 h-fit">
                <form id="property-form">
                     <!-- hidden ID -->
                    <input type="hidden" id="propertyID" name="propertyID" value="<?= htmlspecialchars($property['propertyID']) ?>">

                    <!-- hidden coordinates -->
                    <div class="grid grid-cols-12 gap-5">
                        <input type="hidden" name="propertyLat" id="propertyLat" value="<?= htmlspecialchars($property['propertyLat']) ?>">
                        <input type="hidden" name="propertyLng" id="propertyLng" value="<?= htmlspecialchars($property['propertyLng']) ?>">
                        
                         <div class="md:col-span-6 col-span-12 bg-white dark:bg-slate-900 h-fit">
                                    <label for="property_type" class="form-label text-gray-900 dark:text-gray-200">Property Type</label>
                                    <select id="property_type" name="propertyType" class="select2 form-select 
                       bg-white dark:bg-slate-800 
                       text-gray-800 dark:text-gray-200 
                       border-gray-300 dark:border-slate-700" data-allow-clear="true" placeholder="Select Property Type"  value="<?= htmlspecialchars($property['propertyType']) ?>">
                                         <option value="">Select Property Type</option>

                                        <option value="Lot" <?= $property['propertyType'] == 'Lot' ? 'selected' : '' ?>>
                                            Lot
                                        </option>

                                        <option value="House" <?= $property['propertyType'] == 'House' ? 'selected' : '' ?>>
                                            House
                                        </option>
                                    </select>
                            </div>

                             <div class="md:col-span-6 col-span-12 bg-white dark:bg-slate-900 h-fit">
                                    <label for="propertyStatus" class="form-label text-gray-900 dark:text-gray-200">Property Status</label>
                                    <select id="propertyStatus" name="propertyStatus" class="select2 form-select 
                       bg-white dark:bg-slate-800 
                       text-gray-800 dark:text-gray-200 
                       border-gray-300 dark:border-slate-700" data-allow-clear="true" placeholder="Select Property Type"  value="<?= htmlspecialchars($property['propertyStatus']) ?>">
                                         <option value="">Select Property Status</option>

                                        <option value="Available" <?= $property['propertyStatus'] == 'Available' ? 'selected' : '' ?>>
                                            Available
                                        </option>

                                        <option value="Reserved" <?= $property['propertyStatus'] == 'Reserved' ? 'selected' : '' ?>>
                                            Reserved
                                        </option>

                                        <option value="Archived" <?= $property['propertyStatus'] == 'Archived' ? 'selected' : '' ?>>
                                            Archived
                                        </option>
                                    </select>
                            </div>


                        <div class="col-span-12">
                            <label class="font-medium">Property Name:</label>
                            <input type="text" id="propertyName" name="propertyName" class="form-input mt-2" placeholder="Property Name :" 
                             value="<?= htmlspecialchars($property['propertyName']) ?>">
                        </div>
                         <div class="col-span-12">
                            <label class="font-medium">Property City:</label>
                            <input type="text" id="propertyCity" name="propertyCity" class="form-input mt-2" placeholder="City"
                            value="<?= htmlspecialchars($property['propertyCity']) ?>">
                        </div>
                        <div class="col-span-12">
                            <label class="font-medium">Property Barangay:</label>
                            <input type="text" id="propertyBrgy" name="propertyBrgy" class="form-input mt-2" placeholder="Brgy"
                            value="<?= htmlspecialchars($property['propertyBrgy']) ?>">
                        </div>

                        <div class="md:col-span-12 col-span-12">
                            <label class="font-medium">Lot Area:</label>
                            <input type="number" id="propertyLotArea" name="propertyLotArea" class="form-input mt-2" placeholder="Size (sqm)"
                            value="<?= htmlspecialchars($property['propertyLotArea']) ?>">
                        </div>
                        <div class="col-span-12 mb-8">
                            <label class="font-medium">Price:</label>
                            <input type="number" id="propertyPrice" name="propertyPrice" class="form-input mt-2" placeholder="Price"
                            value="<?= htmlspecialchars($property['propertyPrice']) ?>">
                        </div>


                        
                        
                        <!-- <br> -->
<!-- 
                        <div id="lotFields" style="display:none;">
                            <div class="grid grid-cols-12 gap-5 bg-gray-50 p-3 rounded  bg-white dark:bg-slate-900 h-fit">
                               
                                 <div class="col-span-12">
                                    <h4 class="font-semibold mb-1">Lot Details</h4>
                                </div>

                                 <div class="md:col-span-12 col-span-12">
                                    <label class="font-medium">Lot Area:</label>
                                    <input type="number" class="form-input mt-2" placeholder="Lot Area (sqm)">
                                </div>

                            </div>
                        </div> -->

                            <div id="houseFields" style="display:none;">
    <div class="grid grid-cols-12 gap-5 bg-gray-50 p-3 rounded  bg-white dark:bg-slate-900 h-fit">

        <div class="col-span-12">
            <h4 class="font-semibold mb-1">House Details</h4>
        </div>

        <div class="md:col-span-12 col-span-12">
            <label class="font-medium">Floor Area:</label>
            <input type="number" id="houseFloorArea" name="houseFloorArea" class="form-input mt-2" placeholder="Floor Area (sqm)"
            value="<?= htmlspecialchars($property['houseFloorArea']) ?>">
        </div>

        <div class="md:col-span-12 col-span-12">
            <label class="font-medium">Storey:</label>
            <input type="number" id="houseStorey" name="houseStorey" class="form-input mt-2" placeholder="Storey"
            value="<?= htmlspecialchars($property['houseStorey']) ?>">
        </div>

        <div class="md:col-span-6 col-span-12">
            <label class="font-medium">Bedroom:</label>
            <input type="number" id="houseBedroom" name="houseBedroom" class="form-input mt-2" placeholder="Bedrooms"
            value="<?= htmlspecialchars($property['houseBedroom']) ?>">
        </div>

        <div class="md:col-span-6 col-span-12">
            <label class="font-medium">Toilet and Bath:</label>
            <input type="number" id="houseTandB" name="houseTandB" class="form-input mt-2" placeholder="Toilet and Bath"
            value="<?= htmlspecialchars($property['houseTandB']) ?>">
        </div>

    </div>
</div>


                       

                        

                    </div>
                    <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit">
                        <div>
                            <p class="font-medium mb-4">Upload your property image here, Please click "Upload Image" Button.</p>
                             <!-- PREVIEW AREA (ABOVE BUTTON) -->
                           <!-- EXISTING DATABASE IMAGES -->
<div id="existingPreview" class="flex flex-wrap gap-2 mb-4">

 <?php if (!empty($images)): ?>
    <?php foreach ($images as $img): ?>

        <div class="relative w-24 h-24 group existing-image"
             data-imageid="<?= htmlspecialchars($img['id'] ?? '') ?>">

            <img 
                src="/habitrack/<?= htmlspecialchars($img['imagePath'] ?? '') ?>"
                class="preview-image w-full h-full object-cover rounded-md border cursor-pointer"
            >

            <button type="button"
                class="delete-existing absolute top-0 right-0 bg-red-500 text-white text-xs px-1 rounded">
                ×
            </button>

        </div>

    <?php endforeach; ?>
<?php endif; ?>

</div>

<!-- NEW UPLOAD PREVIEW -->
<div id="preview" class="flex flex-wrap gap-2 mb-4"></div>
                            <div class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">Supports JPG and PNG. Max file size : 10MB.</div>
                            <!-- <input type="file" id="input-file" name="input-file" accept="image/*" onchange={handleChange()} hidden> -->
                             <input type="file" id="propertyPhotos" name="propertyPhotos[]" multiple accept="image/*" hidden>
                            <label class="btn-upload btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-6 cursor-pointer" for="propertyPhotos">Upload Image</label>
                        </div>
                        
</div>

                    <button type="submit" id="btn-add"
                        class="btn bg-green-600 hover:bg-green-700 text-white rounded-md mt-5 w-full">
                        Update Property
                    </button>
                </form>
            </div>

            <!-- MAP (BIGGER - 2/3) -->
            <div class="md:col-span-8 col-span-12 rounded-md shadow p-6 bg-white dark:bg-slate-900 h-fit">
                <div id="map" style="height: 500px; width: 100%;"></div>

                <div id="houseAmenities" style="display:none;">
    <!-- <div class="grid grid-cols-12 gap-5 bg-gray-50 p-3 rounded  bg-white dark:bg-slate-900 h-fit">
 -->
         <!-- CHECKBOXES -->
    <div class="mt-6">
        <h4 class="font-semibold mb-3">House Amenities</h4>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Garage"
                <?= $property['houseGarage'] == 1 ? 'checked' : '' ?>>
                <span>Garage</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Swimming Pool"
                <?= $property['housePool'] == 1 ? 'checked' : '' ?>>
                <span>Swimming Pool</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Garden"
                <?= $property['houseGarden'] == 1 ? 'checked' : '' ?>>
                <span>Garden</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Balcony"
                <?= $property['houseBalcony'] == 1 ? 'checked' : '' ?>>
                <span>Balcony</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Terrace"
                <?= $property['houseTerrace'] == 1 ? 'checked' : '' ?>>
                <span>Terrace</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Laundry Area"
                <?= $property['houseLaundryArea'] == 1 ? 'checked' : '' ?>>
                <span>Laundry Area</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Maid's Room"
                <?= $property['houseMaidRoom'] == 1 ? 'checked' : '' ?>>
                <span>Maid's Room</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Powder Room"
                <?= $property['housePowderRoom'] == 1 ? 'checked' : '' ?>>
                <span>Powder Room</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Built-in Cabinets"
                <?= $property['houseCabinets'] == 1 ? 'checked' : '' ?>>
                <span>Built-in Cabinets</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Clubouse"
                <?= $property['houseClubhouse'] == 1 ? 'checked' : '' ?>>
                <span>Clubhouse</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Billiard"
                <?= $property['houseBilliardRoom'] == 1 ? 'checked' : '' ?>>
                <span>Billiard Room</span>
            </label>

        <!-- </div> -->
    </div>

    </div>
</div>
<div id="imageModal"
     class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-70 z-[9999] p-6">

    <div class="relative bg-white p-2 rounded-lg shadow-lg max-w-2xl w-full">
        
        <button id="closeModal"
                class="absolute -top-3 -right-3 bg-red-500 hover:bg-green-500 text-white w-8 h-8 rounded-full flex items-center justify-center">
            ×
        </button>

        <img id="modalImg"
             class="w-full max-h-[70vh] object-contain rounded-md">
    </div>

</div>

                <!-- CHECKBOXES -->
    <!-- <div class="mt-6">
        <h4 class="font-semibold mb-3">Amenities</h4>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Garage">
                <span>Garage</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Swimming Pool">
                <span>Swimming Pool</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Garden">
                <span>Garden</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Balcony">
                <span>Balcony</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="WiFi">
                <span>Terrace</span>
            </label>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Laundry Area</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Maid's Room</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Powder Room</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Built-in Cabinets</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Clubhouse</span>
            </label>

             <label class="flex items-center gap-2">
                <input type="checkbox" name="amenities[]" value="Air Conditioning">
                <span>Billiard</span>
            </label>

        </div>
    </div> -->
 
            </div>

        </div>

    </div>
</div>

 <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>  
<!-- 
<script>
var map = L.map('map').setView([9.7392, 118.7353], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
</script>
<script>
document.getElementById('property_type').addEventListener('change', function () {
    let type = this.value;

    let lotFields = document.getElementById('lotFields');
    let houseFields = document.getElementById('houseFields');

    // hide both first
    lotFields.style.display = 'none';
    houseFields.style.display = 'none';

    // show based on selection
    if (type === 'Lot') {
        lotFields.style.display = 'block';
    }

    if (type === 'House and Lot') {
        houseFields.style.display = 'block';
    }
});
</script>   -->

<script>
    window.propertyData = {
        lat: <?= json_encode($property['propertyLat'] ?? null) ?>,
        lng: <?= json_encode($property['propertyLng'] ?? null) ?>
    };
</script>

