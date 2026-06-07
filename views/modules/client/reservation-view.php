<?php
$static_url = '/habitrack/views/Adminassets';
$reservationID = $_GET['id'] ?? null;

require_once __DIR__ . '/../../../controllers/reservations.controller.php';
require_once __DIR__ . '/../../../controllers/coowner.controller.php';
require_once __DIR__ . '/../../../models/spouse.model.php';

if (!$reservationID) {
    die("Invalid reservation ID");
}

$res = ReservationController::ctrGetReservationById($reservationID);

if (!$res) {
    http_response_code(404);
    die("Reservation not found.");
}

$prequalID = $res['prequalID'] ?? null;
$coOwnerID = $res['coOwnerID'] ?? null;
$coOwnerRelationship = trim($res['coOwnerRelationship'] ?? '');
$hasCoOwnerRelationship = ($coOwnerRelationship !== '');
$isSpouseRelationship = strcasecmp($coOwnerRelationship, 'Spouse') === 0;
$spouse = ModelSpouse::mdlGetSpouseInfo($prequalID);
$spouseInfo = ModelSpouse::mdlGetSpouseIS($prequalID);
$hasSpouse = is_array($spouseInfo) && !empty($spouseInfo);
$coOwnerInfo = ControllerCoOwner::ctrGetCoOwnerIS($prequalID);
$hasCoOwner = !empty($coOwnerInfo);
// echo "<pre>";
// print_r(ModelSpouse::mdlGetSpouseInfo($prequalID));
// echo "</pre>";
// die();


require_once __DIR__ . '/../../../controllers/clientsignup.controller.php';

$existingInfo = ControllerClient::ctrCheckClientInfo($prequalID);
$hasFilled = !empty($existingInfo);
$validIDPath = $res['clientValidID'] ?? '';
$hasValidIDSaved = !empty($validIDPath);

if (session_status() === PHP_SESSION_NONE) session_start();

$loggedInClientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

if (!$loggedInClientID || $res['clientID'] !== $loggedInClientID) {
    http_response_code(403);
    die("Access denied.");
}




$resStatus = strtolower($res['reserveStatus'] ?? 'pending');


$statusColor = match($resStatus) {
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-blue-300',
    'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
    'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
    default     => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'
};

$prequalStatus = strtolower($res['prequalStatus'] ?? 'pending');
$requirementsDisabled = ($prequalStatus !== 'approved');  //gn add komn ni pra sa whole n m disable ang buttons if indi p sya approved
$showSpouseRequirement = $hasCoOwnerRelationship && $isSpouseRelationship;
$showCoOwnerRequirement = $hasCoOwnerRelationship && !$isSpouseRelationship;
$relationshipRequirementFilled = (!$showSpouseRequirement || $hasSpouse) && (!$showCoOwnerRequirement || $hasCoOwner);
$allRequirementsComplete = $hasFilled && $relationshipRequirementFilled && $hasValidIDSaved;

$prequalColor = match($prequalStatus) {
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
    'in review' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'
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

                    <!-- PROPERTY DETAILS AND SITE VISIT -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 flex flex-col h-auto">

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

                        <!-- SITE VISIT -->
                        <a href="index.php?route=calendar&id=<?= $reservationID ?>">

                            <button
                                id="btn-sitevisit"
                                class="w-full mt-5 px-24 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200"
                            >
                                Site Visit
                            </button>

                        </a>
                    </div>

                    <!-- TOP SECTION -->
                    <!-- <div class="mt-6 flex flex-col">before -->
                    <div class="mt-6 flex flex-col gap-6">

                    <!-- PREQUAL FORM -->
                        <!-- <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6"> before -->
                        <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 min-h-[180px] flex flex-col justify-between">
                            <h5 class="text-xl font-semibold text-gray-800 dark:text-white text-center mt-5 ">
                                Prequalification Form
                            </h5>

                            <!-- View Prequal -->
                            <a href="index.php?route=pre-qual&id=<?= $reservationID ?>">

                                <button
                                    id="btn-prequal"
                                    class="w-full px-24 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200 mb-4"
                                >
                                    View
                                </button>

                            </a>
                        </div>

                        <!-- GAP -->
                        <!-- <div class="mt-6"></div> -->
                        <!-- RESERVATION NA DI -->
                        
                        <!-- BACK BUTTON -->
                        <div class="flex justify-start mt-20 mx-5">

                            <a href="reservations"
                                class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>

                                Back to Reservations
                            </a>

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
                                    Floor Area
                                </label>

                                <input
                                    value="<?= $res['houseFloorArea'] ?> sqm"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Reservation Date
                                </label>

                                <input
                                    value="<?= $resStatus === 'approved' ? $res['reserveDate'] : '' ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>

                            <div>
                                <label class="form-label font-medium">
                                    Reservation Time
                                </label>

                                <input
                                    value="<?= $resStatus === 'approved' ? $res['reserveTime'] : '' ?>"
                                    class="form-input w-full"
                                    disabled
                                >
                            </div>
                        </div>

                    </div>

                    <!-- STATUS SECTION -->
                    <!-- <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6"> before -->
                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6 min-h-[180px]">

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

                                <div class="mt-2">
                                    <span
                                        class="inline-block px-5 py-2 text-md font-semibold rounded-full <?= $prequalColor ?>"
                                    >
                                        <?= ucfirst($prequalStatus) ?>
                                    </span>
                                </div>

                                <!-- <input
                                    value="Pending"
                                    class="form-input w-full"
                                    disabled
                                > -->

                            </div>

                        </div>

                        
                        <!-- BACK BUTTON
                        <div class="flex justify-end mt-8">

                            <a href="reservations">

                                <button
                                    id="btn-back"
                                    class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200"
                                >
                                    Back to Reservations
                                </button>

                            </a>

                        </div> -->

                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6 min-h-[180px]">

                        <h5 class="text-xl font-semibold text-gray-800 dark:text-white text-left mb-4">
                            Reservation Requirements
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 items-start">
                            <div class="flex flex-col">
                                <label class="form-label font-medium">Information Sheet</label>
                                <?php if ($hasFilled): ?>
                                    <a href="index.php?route=clientInfoSheet-view&prequalID=<?= urlencode($prequalID) ?>"
                                    class="w-full text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg cursor-pointer">
                                        View
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?route=clientInfoSheet&id=<?= urlencode($reservationID) ?>"
                                    class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer <?= $requirementsDisabled ? 'opacity-50 pointer-events-none' : 'hover:bg-blue-700' ?>" id=fillUpBtn >
                                        Fill Up
                                    </a>
                                <?php endif; ?>
                            </div>
                             <div class="flex flex-col">
                                <label class="form-label font-medium">Valid ID</label>

                                <?php if ($hasValidIDSaved): ?>
                                    <button type="button"
                                        onclick="openSavedValidIDModal()"
                                        class="w-full text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg">
                                        View
                                    </button>
                                <?php else: ?>
                                    <label for="valid-id-upload"
                                        class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer <?= $requirementsDisabled ? 'opacity-50 cursor-not-allowed' : '' ?>">
                                        Upload
                                    </label>
                                <?php endif; ?>

                                <div class="flex items-center justify-center gap-2 mt-2">
                                    <span id="file-name" class="text-xs text-gray-500 dark:text-white/70 break-all">
                                        <?= $hasValidIDSaved ? 'Uploaded' : 'No file chosen' ?>
                                    </span>
                                    <button type="button" id="preview-label"
                                            class="text-xs text-blue-600 hover:underline hidden"
                                            onclick="openValidIDModal()">
                                        Preview
                                    </button>
                                </div>

                                <input id="valid-id-upload" type="file" accept="image/*" class="hidden" <?= $requirementsDisabled ? 'disabled' : '' ?>
                                    onchange="handleValidIDChange(event)">
                            </div>

                            <?php if ($showSpouseRequirement): ?>
                                <div class="flex flex-col">
                                    <label class="form-label font-medium">Spouse</label>
                                    <?php if ($hasSpouse): ?>
                                        <a href="index.php?route=spouseInfoSheet-view&prequalID=<?= urlencode($prequalID) ?>"
                                        class="w-full text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg cursor-pointer">
                                            View
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?route=spouseInfoSheet&id=<?= urlencode($prequalID) ?>"
                                            class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer <?= $requirementsDisabled ? 'opacity-50 pointer-events-none' : '' ?>"
                                            id=fillUpBtnSpouse>
                                            Fill Up
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($showCoOwnerRequirement): ?>
                                <div class="flex flex-col">
                                    <label class="form-label font-medium">Co-owner</label>
                                    <?php if ($hasCoOwner): ?>
                                        <a href="index.php?route=co-ownerInfoSheet-view&id=<?= urlencode($prequalID) ?>"
                                        class="w-full text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg cursor-pointer">
                                            View
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?route=co-ownerInfoSheet&id=<?= urlencode($reservationID) ?>"
                                            class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer <?= $requirementsDisabled ? 'opacity-50 pointer-events-none' : '' ?>"
                                            id=fillUpBtnCo>
                                            Fill Up
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                              <div class="flex flex-col">
                                <label class="form-label font-medium invisible">Submit</label>
                                <button type="button" id="submit-valid-id-btn"
                                 <?= $requirementsDisabled ? 'disabled' : '' ?>
                                    class="w-full px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 <?= $allRequirementsComplete ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                    <?= $allRequirementsComplete ? 'disabled' : '' ?>>
                                    Submit
                                </button>
                            </div>
                        </div>
                     

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start mt-6 pt-6 border-t border-slate-100 dark:border-gray-800">
                           <!--  <div class="flex flex-col">
                                <label class="form-label font-medium">Valid ID</label>

                                <?php if ($hasValidIDSaved): ?>
                                    <button type="button"
                                        onclick="openSavedValidIDModal()"
                                        class="w-full text-center px-5 py-2.5 bg-emerald-600 text-white rounded-lg">
                                        View
                                    </button>
                                <?php else: ?>
                                    <label for="valid-id-upload"
                                        class="w-full text-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer <?= $requirementsDisabled ? 'opacity-50 cursor-not-allowed' : '' ?>">
                                        Upload
                                    </label>
                                <?php endif; ?>

                                <div class="flex items-center justify-center gap-2 mt-2">
                                    <span id="file-name" class="text-xs text-gray-500 dark:text-white/70 break-all">
                                        <?= $hasValidIDSaved ? 'Uploaded' : 'No file chosen' ?>
                                    </span>
                                    <button type="button" id="preview-label"
                                            class="text-xs text-blue-600 hover:underline hidden"
                                            onclick="openValidIDModal()">
                                        Preview
                                    </button>
                                </div>

                                <input id="valid-id-upload" type="file" accept="image/*" class="hidden" <?= $requirementsDisabled ? 'disabled' : '' ?>
                                    onchange="handleValidIDChange(event)">
                            </div> -->

                            <!-- <div class="flex flex-col">
                                <label class="form-label font-medium invisible">Submit</label>
                                <button type="button" id="submit-valid-id-btn"
                                 <?= $requirementsDisabled ? 'disabled' : '' ?>
                                    class="w-full px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 <?= $allRequirementsComplete ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                    <?= $allRequirementsComplete ? 'disabled' : '' ?>>
                                    Submit
                                </button>
                            </div> -->
                        </div>
                    </div>

                    <!-- IMAGE PREVIEW MODAL — single instance, single img id -->
                    <div id="valid-id-modal" class="fixed inset-0 bg-black/80 hidden z-[9999]">
                        <div class="absolute left-[300px] right-0 top-[90px] bottom-0 flex items-center justify-center">
                            <div class="relative">
                                <button type="button" onclick="closeValidIDModal()"
                                        class="absolute -top-4 -right-4 bg-black/80 hover:bg-black text-white w-9 h-9 rounded-full flex items-center justify-center text-xl z-[10000]">
                                    &times;
                                </button>
                                <img id="valid-id-modal-img" src=""
                                    class="max-w-[90vw] max-h-[85vh] rounded-lg shadow-lg">
                            </div>
                        </div>
                    </div>

                    <!-- BACK BUTTON beforeee-->
                    <!-- <div class="flex justify-end mt-8">

                        <a href="reservations"

                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to Reservations
                        </a>

                        

                    </div> -->

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    let validIDImageSrc = "";
    let hasValidID      = false;
    var hasFilled       = <?= $hasFilled ? 'true' : 'false' ?>;
    var hasSavedValidID = <?= $hasValidIDSaved ? 'true' : 'false' ?>;
    var requiresSpouse  = <?= $showSpouseRequirement ? 'true' : 'false' ?>;
    var hasSpouseInfo   = <?= $hasSpouse ? 'true' : 'false' ?>;
    var requiresCoOwner = <?= $showCoOwnerRequirement ? 'true' : 'false' ?>;
    var hasCoOwnerInfo  = <?= $hasCoOwner ? 'true' : 'false' ?>;
    var reservationID   = <?= json_encode($reservationID) ?>;
    var savedValidIDPath = <?= json_encode($validIDPath) ?>;
    console.log(savedValidIDPath);
    

    function openSavedValidIDModal() {
        document.getElementById('valid-id-modal-img').src =
            '/habitrack' + savedValidIDPath;
        
        const modal = document.getElementById('valid-id-modal');
        console.log(modal);
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function handleValidIDChange(event) {
        const file         = event.target.files[0];
        const fileName     = document.getElementById('file-name');
        const previewLabel = document.getElementById('preview-label');

        if (!file) {
            fileName.textContent = "No file chosen";
            previewLabel.classList.add('hidden');
            hasValidID     = false;
            validIDImageSrc = "";
            return;
        }

        fileName.textContent = file.name;
        previewLabel.classList.remove('hidden');
        hasValidID = true;

        const reader  = new FileReader();
        reader.onload = function (e) { validIDImageSrc = e.target.result; };
        reader.readAsDataURL(file);
    }

    function openValidIDModal() {
        if (!validIDImageSrc) return;
        document.getElementById('valid-id-modal-img').src = validIDImageSrc;
        const modal = document.getElementById('valid-id-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeValidIDModal() {
        const modal = document.getElementById('valid-id-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('valid-id-modal').addEventListener('click', function (e) {
        if (e.target === this) closeValidIDModal();
    });

    document.getElementById('submit-valid-id-btn').addEventListener('click', function (e) {
        e.preventDefault();
        submitValidID();
    });

function submitValidID() {

    const missingRequirements = [];

    if (!hasFilled) {
        missingRequirements.push('Client Information Sheet');
    }

    if (requiresSpouse && !hasSpouseInfo) {
        missingRequirements.push('Spouse Information Sheet');
    }

    if (requiresCoOwner && !hasCoOwnerInfo) {
        missingRequirements.push('Co-owner Information Sheet');
    }

    if (!hasSavedValidID && !hasValidID) {
        missingRequirements.push('Valid ID');
    }

    if (missingRequirements.length > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Requirements',
            html: `
            <div style="text-align:center;">
                <p style="margin-bottom:8px;">Please complete the following before submitting:</p>
                <ul style="display:inline-block; text-align:left; list-style:disc; padding-left:20px;">
                    ${missingRequirements.map(item => `<li style="margin-bottom:4px;">${item}</li>`).join('')}
                </ul>
            </div>
        `
        });
        return;
    }

    if (hasSavedValidID) {
        Swal.fire({
            icon: 'info',
            title: 'Already Submitted',
            text: 'All reservation requirements are already complete.'
        });
        return;
    }

    let file = document.getElementById('valid-id-upload').files[0];

    let formData = new FormData();

    formData.append("reservationID", reservationID);
    formData.append("validID", file);

    Swal.fire({
        title: "Uploading...",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: "ajax/saveValidID.ajax.php",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function(response){

            let res = JSON.parse(response);

            if(res.status === "success"){

                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Reservation requirements uploaded successfully."
                }).then(() => {
                    location.reload();
                });

            }else{

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: res.message
                });

            }
        },

        error: function(){

            Swal.fire({
                icon: "error",
                title: "Error",
                text: "AJAX request failed."
            });

        }
    });

}

</script>
