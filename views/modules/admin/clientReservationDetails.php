<?php

require_once __DIR__ . "/../../../controllers/clientReservation.controller.php";

$statusUpdate = ClientReservationController::ctrUpdateSelectedReservationStatus();
$reservation = ClientReservationController::ctrGetSelectedReservation();

function htAdminReservationDetailsE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function htAdminReservationDetailsValue($value, $fallback = 'Not provided') {
    $value = trim((string) ($value ?? ''));
    return $value !== '' ? htAdminReservationDetailsE($value) : $fallback;
}

function htAdminReservationDetailsMoney($value) {
    if ($value === null || $value === '') {
        return 'Not provided';
    }

    return 'PHP ' . number_format((float) $value, 2);
}

$reserveStatus = strtolower($reservation['reserveStatus'] ?? 'pending');
$prequalStatus = strtolower($reservation['prequalStatus'] ?? 'pending');
$financingType = strtolower($reservation['financingType'] ?? '');
$hasCoOwner = !empty($reservation['coOwnerID']);
$hasClientInfo = !empty($reservation['clientCISID']);

$reserveStatusClass = match ($reserveStatus) {
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    'archived' => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
};

$prequalStatusClass = match ($prequalStatus) {
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
};
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px;bottom:0;z-index:20;"
>
    <?php if (!$reservation): ?>
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Reservation not found</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Select a reservation from the list to view its details.
            </p>
            <a href="index.php?route=clientReservation"
               class="inline-flex mt-5 px-4 py-2 rounded-md bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                Back to Reservations
            </a>
        </div>
    <?php else: ?>
        <div class="max-w-5xl mx-auto space-y-5 pb-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <!-- <a href="index.php?route=clientReservation"
                       class="inline-flex items-center text-sm text-slate-500 hover:text-green-600 dark:text-slate-400 dark:hover:text-green-400">
                        <i class="mdi mdi-arrow-left mr-1"></i> Back
                    </a> -->
                    <h1 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">
                        <?= htAdminReservationDetailsValue(trim(($reservation['clientFName'] ?? '') . ' ' . ($reservation['clientMName'] ?? '') . ' ' . ($reservation['clientLName'] ?? '') . ' ' . ($reservation['clientSuffix'] ?? '')), 'Client') ?>
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        <?= htAdminReservationDetailsValue($reservation['propertyName'] ?? '') ?>
                    </p>
                </div>
                <span class="w-fit px-3 py-1 rounded-full text-sm font-semibold <?= $reserveStatusClass ?>">
                    <?= htAdminReservationDetailsE(ucfirst($reservation['reserveStatus'] ?? 'Pending')) ?>
                </span>
            </div>

            <?php if ($statusUpdate): ?>
                <?php $messageClass = $statusUpdate['success'] ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-900' : 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-900'; ?>
                <div class="border rounded-lg px-4 py-3 text-sm <?= $messageClass ?>">
                    <?= htAdminReservationDetailsE($statusUpdate['message'] ?? '') ?>
                </div>
            <?php endif; ?>

           <!--  <?php if ($reserveStatus === 'pending'): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Reservation Decision</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update this pending reservation status.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <form method="post" action="index.php?route=clientReservationDetails">
                            <input type="hidden" name="reservation_id" value="<?= htAdminReservationDetailsE($reservation['reservationID'] ?? '') ?>">
                            <input type="hidden" name="reservation_status_action" value="approve">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Approved
                            </button>
                        </form>
                        <form method="post" action="index.php?route=clientReservationDetails">
                            <input type="hidden" name="reservation_id" value="<?= htAdminReservationDetailsE($reservation['reservationID'] ?? '') ?>">
                            <input type="hidden" name="reservation_status_action" value="reject">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Rejected
                            </button>
                        </form>
                    </div>
                </section>
            <?php endif; ?> -->

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Reservation Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Reservation Date</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['reserveDate'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Reservation Time</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['reserveTime'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Prequal Status</p>
                        <p class="mt-1">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $prequalStatusClass ?>">
                                <?= htAdminReservationDetailsE(ucfirst($reservation['prequalStatus'] ?? 'Pending')) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Client Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Email</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientEmail'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Phone</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientPhoneNum'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Prequal Submitted</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['submissionDate'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Civil Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue(ucfirst($reservation['clientCivilStatus'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Employment Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue(strtoupper($reservation['clientEmpStatus'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Monthly Income</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsMoney($reservation['clientMonthlyIncome'] ?? null) ?></p>
                    </div>
                </div>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Client Information Sheet</h2>

                <?php if (!$hasClientInfo): ?>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                        No linked client information sheet was found for this reservation.
                    </p>
                <?php else: ?>
                    <div class="mt-4 space-y-5">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Personal Information</h3>
                            <div class="mt-3 grid gap-4 md:grid-cols-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Citizenship</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientCitizenship'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Gender</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientGender'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Religion</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientReligion'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Birthdate</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientBirthdate'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Place of Birth</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientPlaceOfBirth'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">TIN</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientTaxIdenNum'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">SSS/GSIS Number</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientSSS_GSISnumber'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Address</h3>
                            <div class="mt-3 grid gap-4 md:grid-cols-2">
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Current Address</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientAddress'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Provincial Address</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientProvinceAddress'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Dependents</h3>
                            <div class="mt-3 grid gap-4 md:grid-cols-4">
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Elementary</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDependentsElem'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">High School</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDependentsHS'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">College</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDependentsC'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Not Studying</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDependentsNotStud'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Employment and Income</h3>
                            <div class="mt-3 grid gap-4 md:grid-cols-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Source of Income</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientSourceOfIncome'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Employer/Business Name</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientEmployerBusinessName'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Nature of Business</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientNatureOfBusiness'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Business Address</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientBusinessAddress'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Position</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientPosition'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Department</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDepartment'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Date Hired</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientDateHired'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Appointment</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientAppointment'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Place of Work</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientPlaceOfWork'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Employer Phone</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientEmpPhoneNum'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Employer Email</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientEmployerEmail'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Family and SPA</h3>
                            <div class="mt-3 grid gap-4 md:grid-cols-3">
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Father's Name</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientFathersName'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Mother's Maiden Name</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientMothersMaidenName'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Parents Phone</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientParentsPhoneNum'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">Parents Address</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientParentsAddress'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">SPA Name</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientSpaName'] ?? '') ?></p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-slate-400">SPA Phone</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientSpaPhoneNum'] ?? '') ?></p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs uppercase text-slate-400">SPA Address</p>
                                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['clientSpaAddress'] ?? '') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Property Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Property</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['propertyName'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Type</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['propertyType'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Location</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">
                            <?= htAdminReservationDetailsValue(trim(($reservation['propertyCity'] ?? '') . ', ' . ($reservation['propertyBrgy'] ?? ''), ', ')) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Price</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsMoney($reservation['propertyPrice'] ?? null) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Lot Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['propertyLotArea'] ?? '') ?> sqm</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Floor Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['houseFloorArea'] ?? '') ?> sqm</p>
                    </div>
                </div>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Financing Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Financing Type</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue(ucfirst($reservation['financingType'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Financing Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['financingStatus'] ?? '') ?></p>
                    </div>

                    <?php if ($financingType === 'bank'): ?>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Bank Name</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['bankName'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Existing House Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['existingHouseLoan'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Cancelled House Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['cancelledHouseLoan'] ?? '') ?></p>
                        </div>
                    <?php elseif ($financingType === 'pagibig'): ?>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Contribution Start Date</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['contributionStartDate'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Current Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['currentLoan'] ?? '') ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <?php if ($hasCoOwner): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Co-owner Details</h2>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <div>
                            <p class="text-xs uppercase text-slate-400">Name</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">
                                <?= htAdminReservationDetailsValue(trim(($reservation['coOwnerFName'] ?? '') . ' ' . ($reservation['coOwnerMName'] ?? '') . ' ' . ($reservation['coOwnerLName'] ?? '') . ' ' . ($reservation['coOwnerSuffix'] ?? ''))) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Relationship</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['coOwnerRelationship'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Email</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['coOwnerEmail'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Phone</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue($reservation['coOwnerPhoneNum'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Employment Status</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsValue(strtoupper($reservation['coOwnerEmpStatus'] ?? '')) ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Monthly Income</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htAdminReservationDetailsMoney($reservation['coOwnerMonthlyIncome'] ?? null) ?></p>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
             <?php if ($reserveStatus === 'pending'): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Reservation Decision</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update this pending reservation status.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <form method="post" action="index.php?route=clientReservationDetails">
                            <input type="hidden" name="reservation_id" value="<?= htAdminReservationDetailsE($reservation['reservationID'] ?? '') ?>">
                            <input type="hidden" name="reservation_status_action" value="approve">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Approve
                            </button>
                        </form>
                        <form method="post" action="index.php?route=clientReservationDetails">
                            <input type="hidden" name="reservation_id" value="<?= htAdminReservationDetailsE($reservation['reservationID'] ?? '') ?>">
                            <input type="hidden" name="reservation_status_action" value="reject">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Reject
                            </button>
                        </form>
                    </div>
                </section>
            <?php endif; ?>
            <a href="index.php?route=clientReservation"
                       class="inline-flex items-center text-sm text-slate-500 hover:text-green-600 dark:text-slate-400 dark:hover:text-green-400">
                        <i class="mdi mdi-arrow-left mr-1"></i> Back
                    </a>
        </div>
    <?php endif; ?>
</div>
