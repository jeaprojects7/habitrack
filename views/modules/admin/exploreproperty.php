<?php

require_once 'controllers/edit-property.controller.php';

$selectedType = trim($_GET['type'] ?? '');
$selectedStatus = trim($_GET['status'] ?? ''); //gn add kolng
$selectedCity = trim($_GET['city'] ?? '');
$selectedMinPrice = trim($_GET['minPrice'] ?? '');
$selectedMaxPrice = trim($_GET['maxPrice'] ?? '');
$allowedTypes = ['House', 'Lot'];
$allowedStatus = ['Available', 'Reserved','Archived']; //gn add kolng

if (!in_array($selectedType, $allowedTypes, true)) {
    $selectedType = '';
}

if (!in_array($selectedStatus, $allowedStatus, true)) { //gn add kolng 
    $selectedStatus = '';
}

// Build one clean filter array for the model. Empty values are ignored there,
// so users can combine any filters they want without needing separate queries.
$properties = PropertyController::ctrGetPropertiesFiltered([
    'type' => $selectedType,
    'status' => $selectedStatus, //gn add kolng
    'city' => $selectedCity,
    'minPrice' => $selectedMinPrice,
    'maxPrice' => $selectedMaxPrice
]);

$printQuery = http_build_query([
    'route' => 'print-properties',
    'type' => $selectedType,
    'status' => $selectedStatus, //gn add kolng
    'city' => $selectedCity,
    'minPrice' => $selectedMinPrice,
    'maxPrice' => $selectedMaxPrice
]);

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
 <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Explore Properties</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                        <a href="adminDashboard">Habitrack</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">
                        Explore Properties
                    </li>
                </ul>
            </div>


    <!-- FILTER FORM -->
<!-- <form method="GET" action="/habitrack/index.php">
      <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <div class="row g-6">
    <input type="hidden" name="route" value="exploreproperty">

    <select name="type" rounded>
        <option value="">All Types</option>
        <option value="House" <?= ($selectedType == 'House') ? 'selected' : '' ?>>House</option>
        <option value="Lot" <?= ($selectedType == 'Lot') ? 'selected' : '' ?>>Lot</option>
    </select>

    <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($selectedCity) ?>">
    <input type="number" name="minPrice" placeholder="Min Price" value="<?= htmlspecialchars($selectedMinPrice) ?>">
    <input type="number" name="maxPrice" placeholder="Max Price" value="<?= htmlspecialchars($selectedMaxPrice) ?>">

    <button type="submit">Filter</button>
    <a href="/habitrack/index.php?<?= htmlspecialchars($printQuery) ?>" target="_blank">Print PDF</a>
</div>
</div>
</form> -->
<form method="GET" action="/habitrack/index.php" class="flex flex-wrap gap-3 items-end">

    <input type="hidden" name="route" value="exploreproperty">

    <!-- TYPE -->
    <select name="type"
        class="px-4 py-3 text-lg rounded-full border border-gray-300 bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[180px]">
        <option value="">All Types</option>
        <option value="House" <?= ($selectedType == 'House') ? 'selected' : '' ?>>House</option>
        <option value="Lot" <?= ($selectedType == 'Lot') ? 'selected' : '' ?>>Lot</option>
    </select>

      <!-- STATUS (ADD LNG NI) -->
    <select name="status"
        class="px-4 py-3 text-lg rounded-full border border-gray-300 bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[180px]">
        <option value="">Status</option>
        <option value="Available" <?= ($selectedStatus == 'Available') ? 'selected' : '' ?>>Available</option>
        <option value="Reserved" <?= ($selectedStatus == 'Reserved') ? 'selected' : '' ?>>Reserved</option>
        <option value="Archived" <?= ($selectedStatus == 'Archived') ? 'selected' : '' ?>>Archived</option>
    </select>

    <!-- CITY -->
    <input type="text"
        name="city"
        placeholder="City"
        value="<?= htmlspecialchars($selectedCity) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">

    <!-- MIN PRICE -->
    <input type="number"
        name="minPrice"
        placeholder="Min Price"
        value="<?= htmlspecialchars($selectedMinPrice) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">

    <!-- MAX PRICE -->
    <input type="number"
        name="maxPrice"
        placeholder="Max Price"
        value="<?= htmlspecialchars($selectedMaxPrice) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">

    <!-- FILTER BUTTON (GREEN like your upload button) -->
    <button type="submit"
        class="px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-semibold transition">
        Filter
    </button>

    <!-- PRINT -->
    <a href="/habitrack/index.php?<?= htmlspecialchars($printQuery) ?>" target="_blank"
        class="px-4 py-3 rounded-full border border-gray-300 text-black hover:bg-gray-100 transition">
        Print PDF
    </a>

</form>
    <!-- PROPERTY GRID -->
    <div class="property-grid grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-6">

        <?php foreach ($properties as $item): ?>
            <a href="set-edit-session.php?type=property&id=<?= $item['propertyID'] ?>"
    class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
>

            <div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500">

                <!-- IMAGE -->
                <div class="relative">

                    <img
                        src="/habitrack<?= $item['imagePath']; ?>"
                        alt=""
                        class="w-full h-64 object-cover"
                    >

                    

                </div>
                 

                <!-- CONTENT -->
                <div class="p-6">

                    <div class="pb-6">

                       <!--  <a
                            href="index.php?route=edit-property&propertyID=<?= $item['propertyID'] ?>"
                            class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
                        > -->

                            <?= $item['propertyName']; ?>

                        

                    </div>

                    <!-- PROPERTY DETAILS -->
                    <ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">

                        <li class="flex items-center me-4">

                            <i class="mdi mdi-arrow-expand-all text-2xl me-2 text-green-600"></i>

                            <span>
                                <?= $item['propertyCity']; ?> City
                            </span>

                        </li>

                        <li class="flex items-center me-4">

                            <i class="mdi mdi-map-marker text-2xl me-2 text-green-600"></i>

                            <span>
                                <?= $item['propertyBrgy']; ?> Brgy
                            </span>

                        </li>

                        <li class="flex items-center">

                            <i class="mdi mdi-ruler-square text-2xl me-2 text-green-600"></i>

                            <span>
                                <?= $item['propertyLotArea']; ?> sqm
                            </span>

                        </li>

                    </ul>

                    <!-- PRICE -->
                    <ul class="pt-6 flex justify-between items-center list-none">

                        <li>

                            <span class="text-slate-400">
                                Price
                            </span>

                            <p class="text-lg font-medium">

                                ₱<?= number_format($item['propertyPrice']); ?>

                            </p>

                        </li>

        </ul>
                    

                </div>

            </div>
            </a>

        <?php endforeach; ?>

    </div>

</div>
