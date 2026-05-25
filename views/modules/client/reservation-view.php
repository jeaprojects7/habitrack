<?php
$static_url = '/habitrack/views/Adminassets';
$reservationID = $_POST['reservationID'] ?? null;


require_once __DIR__ . '/../../../controllers/reservations.controller.php';

// $reservationID = $_GET['id'] ?? null;
// $reservationID = $_POST['reservationID'] ?? null;

if (!$reservationID) {
    die("No reservation selected");
}

$res = ReservationController::ctrGetReservationById($reservationID);


?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px; bottom:0; z-index:20;"
>

    <div class="container-fluid relative px-3">

        <div class="layout-specing">

            <!-- HEADER / BANNER -->
            <div class="grid grid-cols-1">

                <div class="relative rounded-md overflow-hidden shadow">

                    <img
                        src="<?= $static_url ?>/images/bg.jpg"
                        class="h-80 w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-black/70"></div>

                </div>

            </div>

            <div class="grid md:grid-cols-12 gap-6 mt-6">

                <!-- LEFT SIDE (PROPERTY IMAGE) -->
                <div class="xl:col-span-3 lg:col-span-4 md:col-span-4">

                    <div class="p-6 bg-white dark:bg-slate-900 rounded-md shadow text-center">

                       

                        <img
                            src="/habitrack<?= $res['imagePath'] ?>"
                            class="rounded-md w-full h-48 object-cover mx-auto"
                        />

                        <div class="mt-4">
                            <!-- <h5 id="propertyName" class="text-lg font-semibold"></h5> -->
                             <h5><?= htmlspecialchars($res['propertyName']) ?></h5>
                            <p id="propertyType" class="text-slate-400"></p>
                        </div>

                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="xl:col-span-9 lg:col-span-8 md:col-span-8">

                    <!-- PROPERTY DETAILS -->
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-md shadow">

                        <h5 class="text-lg font-semibold mb-4">
                            Property Details
                        </h5>

                        <div class="grid lg:grid-cols-2 gap-5">

                            <div>
                                <label class="form-label">Property Name</label>
                                <input id="propertyNameInput" class="form-input" disabled>
                            </div>

                            <div>
                                <label class="form-label">Type</label>
                                <!-- <input id="propertyTypeInput" class="form-input" disabled> -->
                                 <p><?= htmlspecialchars($res['propertyType']) ?></p>
                            </div>

                            <div>
                                <label class="form-label">Price</label>
                                <!-- <input id="propertyPrice" class="form-input" disabled> -->
                                 <input value="₱<?= number_format($res['propertyPrice']) ?>" disabled>
                            </div>

                            <div>
                                <label class="form-label">Lot Area</label>
                                <!-- <input id="propertyLotArea" class="form-input" disabled> -->
                                 <input value="<?= $res['propertyLotArea'] ?> sqm" disabled>
                            </div>

                            <div>
                                <label class="form-label">Location</label>
                                <!-- <input id="propertyAddress" class="form-input" disabled> -->
                                <input value="<?= $res['propertyBrgy'] . ', ' . $res['propertyCity'] ?>" disabled>
                            </div>

                            <div>
                                <label class="form-label">Reservation Date</label>
                                <!-- <input id="reserveDate" class="form-input" disabled> -->
                                 <input value="<?= $res['reserveDate'] ?>" disabled>
                            </div>

                        </div>

                    </div>

                    <!-- RESERVATION STATUS -->
                    <div class="p-6 mt-6 bg-white dark:bg-slate-900 rounded-md shadow">

                        <h5 class="text-lg font-semibold mb-4">
                            Reservation Status
                        </h5>

                        <div class="grid gap-5">

                            <div>
                                <label class="form-label">Status</label>
                                <!-- <input id="reserveStatus" class="form-input" disabled> -->
                                 <input value="<?= $res['reserveStatus'] ?>" disabled>
                            </div>

                        </div>

                        <div class="flex gap-4 mt-5">

                            <a href="reservations">
                                <button
                                    id="btn-back"
                                    class="btn bg-blue-600 text-white"
                                >
                                    Back to Reservations
                                </button>
                            </a>

                            <a href="clientInfoSheet">
                                <button
                                    id="btn-is"
                                    class="btn bg-blue-600 text-white"
                                >
                                    Information Sheet
                                </button>
                            </a>

                        </div>
                        
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>