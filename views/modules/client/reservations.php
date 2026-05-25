<?php

require_once __DIR__ . '/../../../controllers/reservations.controller.php';
// require_once __DIR__ . '/../../../models/reservations.model.php';

$reservations = ReservationController::ctrGetReservations();

?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px; bottom:0; z-index:20;"
>
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">List of Reservations</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-blue-600 dark:hover:text-white">
                        <a href="index.php">Habitrack</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-blue-600 dark:text-white" aria-current="page">
                        Reservations
                    </li>
                </ul>
            </div>

            <!-- SEARCH BAR -->
            <div class="mb-4">
                <input 
                    id="reservation-search"
                    type="text"
                    placeholder="Search reservations..."
                    class="border p-2 rounded w-96"
                />
            </div>


            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 mt-6">

                <?php if (empty($reservations)): ?>
                    <div id="empty-reservations" class="lg:col-span-2 rounded-md bg-white dark:bg-slate-900 shadow p-6 text-center">
                        <p class="text-slate-500">No reservations yet.</p>
                    </div>
                <?php endif; ?>
               
                <?php foreach ($reservations as $res): ?>
                    <?php
                        $type        = trim($res['propertyType'] ?? '');
                        $buyerName   = htmlspecialchars(trim(($res['clientFName'] ?? '') . ' ' . ($res['clientLName'] ?? '')));
                        $propName    = htmlspecialchars($res['propertyName'] ?? '');
                        $price       = number_format($res['propertyPrice'] ?? 0);
                        $address     = htmlspecialchars(($res['propertyBrgy'] ?? '') . ', ' . ($res['propertyCity'] ?? ''));
                        $lotArea     = htmlspecialchars($res['propertyLotArea'] ?? '');
                        $prequal     = htmlspecialchars($res['prequalStatus'] ?? 'Pending');
                        $resDate     = htmlspecialchars($res['reserveDate'] ?? '');
                        $resStatus   = htmlspecialchars($res['reserveStatus'] ?? 'Pending');

                        $prequalColor = match(strtolower($prequal)) {
                            'approved' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                            'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            default    => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'
                        };

                        $statusColor = match(strtolower($resStatus)) {
                            'confirmed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                            'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            default     => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'
                        };
                    ?>

                    <!-- <div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 w-full mx-auto"> -->
                        <!-- <div class="reservation-card group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 w-full mx-auto"> -->
                            <div class="reservation-card group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl overflow-hidden ease-in-out duration-500 w-full mx-auto"
     data-id="<?= $res['reservationID'] ?>">
                        <div class="md:flex">

                            <!-- Left: Type Badge placeholder -->
                            <div class="relative md:shrink-0 bg-slate-100 dark:bg-slate-800 h-56 w-full md:w-48 flex items-center justify-center">
                                <?php if ($type === 'House'): ?>
                                    <i class="mdi mdi-home text-6xl text-blue-600"></i>
                                <?php else: ?>
                                    <i class="mdi mdi-map text-6xl text-blue-600"></i>
                                <?php endif; ?>
                                <!-- ang may htmlspecialchars($type) na di span class = "absolute top-2 -->
                            </div>

                            
                            <!-- Right: Details -->
                            <div class="p-6 w-full">

                                <!-- removed Buyer -->
                                 
                                <!-- removed Property Name -->
                                <!-- Property Name + Type -->
<div class="md:pb-4 pb-6 flex justify-between items-start gap-4">

    <div>
        <h6 class="text-lg font-medium"><?= $propName ?></h6>
        <p class="text-slate-400 text-sm"><?= $resDate ?></p>
    </div>

    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-600 text-white shadow whitespace-nowrap">
        <?= htmlspecialchars($type) ?>
    </span>

</div>

                                <ul class="md:py-4 py-6 border-y border-slate-100 dark:border-gray-800 list-none space-y-2">

                                    <?php if ($type === 'House'): ?>

                                        <li class="flex items-center">
                                            <i class="mdi mdi-home-outline text-2xl me-2 text-blue-600"></i>
                                            <span class="font-medium"><?= $propName ?></span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="mdi mdi-map-marker text-2xl me-2 text-blue-600"></i>
                                            <span><?= $address ?></span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="mdi mdi-cash text-2xl me-2 text-blue-600"></i>
                                            <span>₱<?= $price ?></span>
                                        </li>

                                    <?php elseif ($type === 'Lot'): ?>

                                        <li class="flex items-center">
                                            <i class="mdi mdi-map-marker text-2xl me-2 text-blue-600"></i>
                                            <span><?= $address ?></span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="mdi mdi-cash text-2xl me-2 text-blue-600"></i>
                                            <span>₱<?= $price ?></span>
                                        </li>
                                        <li class="flex items-center">
                                            <i class="mdi mdi-ruler-square text-2xl me-2 text-blue-600"></i>
                                            <span><?= $lotArea ?> sqm</span>
                                        </li>

                                    <?php endif; ?>

                                </ul>

                                <!-- Status Row -->
                                <ul class="md:pt-4 pt-6 flex justify-between items-center list-none">
                                    <li>
                                        <span class="text-slate-400 text-sm">Reservation</span>
                                        <p>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusColor ?>">
                                                <?= $resStatus ?>
                                            </span>
                                        </p>
                                    </li>

                                    <!-- prequal na di -->
                                    
                                </ul>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>