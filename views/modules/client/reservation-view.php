<?php
$static_url = '/habitrack/views/Adminassets';
$reservationID = $_GET['id'] ?? null;

require_once __DIR__ . '/../../../controllers/reservations.controller.php';

if (!$reservationID) {
    die("Invalid reservation ID");
}

$res = ReservationController::ctrGetReservationById($reservationID);


$resStatus = strtolower($res['reserveStatus'] ?? 'pending');

$statusColor = match($resStatus) {
    'confirmed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
    'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
    'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
    default     => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'
};
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 bottom-0 left-[300px] overflow-y-auto px-6 pb-10 transition-all duration-300"
    style="z-index:20;"
>

    <div class="container-fluid relative px-3">

        <div class="layout-specing">

            <!-- HEADER -->
            <div class="grid grid-cols-1">

                <div class="relative rounded-xl overflow-hidden shadow-lg">

                    <img
                        src="<?= $static_url ?>/images/bg.jpg"
                        class="h-72 md:h-80 w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-black/60"></div>

                    <div class="absolute bottom-6 left-6 text-white">
                        <h2 class="text-2xl font-bold">
                            Reservation Details
                        </h2>

                        <p class="text-white/80 text-sm mt-1">
                            View reservation and property information
                        </p>
                    </div>

                </div>

            </div>

            <!-- MAIN CONTENT -->
            <div class="grid md:grid-cols-12 gap-6 mt-6">

                <!-- LEFT SIDE -->
<div class="xl:col-span-4 lg:col-span-4 md:col-span-4">

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-5 flex flex-col h-full">

        <!-- PROPERTY IMAGE -->
        <img
            src="/habitrack<?= $res['imagePath'] ?>"
            class="rounded-lg w-full h-56 object-cover"
        />

        <!-- PROPERTY INFO -->
        <div class="mt-5 text-center">

            <h5 class="text-xl font-semibold text-gray-800 dark:text-white">
                <?= htmlspecialchars($res['propertyName']) ?>
            </h5>

            <p class="text-slate-400 mt-1">
                <?= htmlspecialchars($res['propertyType']) ?>
            </p>

        </div>

        <!-- TOP SECTION -->
<div class="mt-6 flex flex-col">

    <!-- View Prequal -->
    <a href="index.php?route=spouseInfoSheet&id=<?= $reservationID ?>">

        <button
    id="btn-prequal"
    class="mx-6 px-24 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200"
>
    View Prequal
</button>

    </a>

    <!-- GAP -->
    <div class="mt-6"></div>

    <!-- Reservation Requirements (same style as sections) -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6">

        <h5 class="text-xl font-semibold text-gray-800 dark:text-white text-center mb-4 ">
            Reservation Requirements
        </h5>

        <!-- BOTTOM BUTTONS -->
        <div class="flex flex-col gap-3">

            <!-- Information Sheet -->
            <a href="index.php?route=clientInfoSheet&id=<?= $reservationID ?>">

                <button
                    id="btn-is"
                    class="w-full px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200"
                >
                    Information Sheet
                </button>

            </a>
<!-- Upload Valid ID -->
<div class="flex flex-col gap-2">

    <label
        for="valid-id-upload"
        class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer transition-colors duration-200"
    >
        Upload Valid ID
    </label>

    <span
        id="file-name"
        class="text-xs text-center text-gray-500 dark:text-white/70 break-all"
    >
        No file chosen
    </span>

    <!-- ✅ NEW BUTTON -->
    <button
        type="button"
        class="w-full mt-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200"
    >
        Submit Reservation Requirements
    </button>

    <input
        id="valid-id-upload"
        name="valid_id"
        type="file"
        accept="image/*"
        class="hidden"
        onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen'"
    >

</div>

        </div>

      

    </div>

</div>

        

        

    </div>

</div>

                <!-- RIGHT SIDE -->
                <div class="xl:col-span-8 lg:col-span-8 md:col-span-8">

                    <!-- PROPERTY DETAILS -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6">

                        <h5 class="text-xl font-semibold text-gray-800 dark:text-white mb-5">
                            Property Details
                        </h5>

                        <div class="grid lg:grid-cols-2 gap-5">

                            <div>
                                <label class="form-label font-medium">
                                    Property Name
                                </label>

                                <input
                                    value="<?= htmlspecialchars($res['propertyName']) ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Property Type
                                </label>

                                <input
                                    value="<?= htmlspecialchars($res['propertyType']) ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Property Price
                                </label>

                                <input
                                    value="₱<?= number_format($res['propertyPrice']) ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Lot Area
                                </label>

                                <input
                                    value="<?= $res['propertyLotArea'] ?> sqm"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Location
                                </label>

                                <input
                                    value="<?= $res['propertyBrgy'] . ', ' . $res['propertyCity'] ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Reservation Date
                                </label>

                                <input
                                    value="<?= $res['reserveDate'] ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                        </div>

                    </div>

                    <!-- STATUS SECTION -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

                        <h5 class="text-xl font-semibold text-gray-800 dark:text-white mb-5">
                            Status
                        </h5>

                        <div class="grid lg:grid-cols-2 gap-5">

                            <!-- Reservation Status -->
                            <div>

                                <label class="form-label font-medium">
                                    Reservation Status
                                </label>

                                <!-- <input
                                    value="<?= $res['reserveStatus'] ?>"
                                    class="form-input w-full"
                                    disabled
                                > -->
                                <div class="mt-2">
                                    <span
                                        class="inline-block px-5 py-2 text-md font-semibold rounded-full <?= $statusColor ?>"
                                    >
                                        <?= ucfirst($resStatus) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Prequal Status -->
                            <div>

                                <label class="form-label font-medium">
                                    Prequal Status
                                </label>

                                <input
                                    value="Pending"
                                    class="form-input w-full"
                                    disabled
                                >

                            </div>

                        </div>

                        <!-- BACK BUTTON -->
                        <div class="flex justify-end mt-8">

                            <a href="reservations">

                                <button
                                    id="btn-back"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200"
                                >
                                    Back to Reservations
                                </button>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>