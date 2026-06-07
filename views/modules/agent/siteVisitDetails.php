<?php

require_once __DIR__ . "/../../../controllers/siteVisit_controller.php";

if (session_status() === PHP_SESSION_NONE) session_start();

$actionResult = SiteVisitController::ctrMarkSiteVisitDone();
$siteVisit    = SiteVisitController::ctrGetSelectedSiteVisit();

function htSVDetailsE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function htSVDetailsValue($value, $fallback = 'Not provided') {
    $value = trim((string) ($value ?? ''));
    return $value !== '' ? htSVDetailsE($value) : $fallback;
}

function htSVDetailsMoney($value) {
    if ($value === null || $value === '') return 'Not provided';
    return 'PHP ' . number_format((float) $value, 2);
}

$svStatus = strtolower($siteVisit['siteVisitStatus'] ?? 'booked');

// Check if the site visit date is today or in the past
$svDateStr   = $siteVisit['siteVisitDate'] ?? null;
$svDateObj   = $svDateStr ? date_create($svDateStr) : null;
$today       = date_create(date('Y-m-d'));
$isFutureDate = $svDateObj && $svDateObj > $today;

$svStatusClass = match ($svStatus) {
    'completed'      => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    default     => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
};
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px;bottom:0;z-index:20;"
>
    <?php if (!$siteVisit): ?>
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Site visit not found</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Select a site visit from the list to view its details.
            </p>
            <a href="index.php?route=siteVisit"
               class="inline-flex mt-5 px-4 py-2 rounded-md bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                Back to Site Visits
            </a>
        </div>

    <?php else: ?>
        <div class="max-w-5xl mx-auto space-y-5 pb-8">

            <!-- HEADER -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <a href="index.php?route=siteVisit"
                       class="inline-flex items-center text-sm text-slate-500 hover:text-green-600 dark:text-slate-400 dark:hover:text-green-400">
                        <i class="mdi mdi-arrow-left mr-1"></i> Back
                    </a>
                    <h1 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">
                        <?= htSVDetailsValue(trim(($siteVisit['clientFName'] ?? '') . ' ' . ($siteVisit['clientLName'] ?? '')), 'Client') ?>
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        <?= htSVDetailsValue($siteVisit['propertyName'] ?? '') ?>
                    </p>
                </div>

                <span class="w-fit px-3 py-1 rounded-full text-sm font-semibold <?= $svStatusClass ?>">
                    <?= htSVDetailsE(ucfirst($siteVisit['siteVisitStatus'] ?? 'Booked')) ?>
                </span>
            </div>

            <!-- ACTION RESULT MESSAGE -->
            <?php if ($actionResult): ?>
                <?php $msgClass = $actionResult['success']
                    ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-900'
                    : 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-900';
                ?>
                <div class="border rounded-lg px-4 py-3 text-sm <?= $msgClass ?>">
                    <?= htSVDetailsE($actionResult['message'] ?? '') ?>
                </div>
            <?php endif; ?>

            <!-- SITE VISIT DETAILS -->
            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Site Visit Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Site Visit ID</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['siteVisitID'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Date</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['siteVisitDate'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Time</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['siteVisitTime'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Status</p>
                        <p class="mt-1">
                            <span class="px-2 py-1 rounded-full text-xs font-medium <?= $svStatusClass ?>">
                                <?= htSVDetailsE(ucfirst($siteVisit['siteVisitStatus'] ?? 'Booked')) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- CLIENT DETAILS -->
            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Client Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Full Name</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">
                            <?= htSVDetailsValue(trim(($siteVisit['clientFName'] ?? '') . ' ' . ($siteVisit['clientLName'] ?? ''))) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Email</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['clientEmail'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Phone</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['clientPhoneNum'] ?? '') ?></p>
                    </div>
                </div>
            </section>

            <!-- PROPERTY DETAILS -->
            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Property Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Property Name</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['propertyName'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Type</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['propertyType'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Location</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">
                            <?= htSVDetailsValue(trim(($siteVisit['propertyCity'] ?? '') . ', ' . ($siteVisit['propertyBrgy'] ?? ''), ', ')) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Price</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsMoney($siteVisit['propertyPrice'] ?? null) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Lot Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['propertyLotArea'] ?? '') ?> sqm</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Floor Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htSVDetailsValue($siteVisit['houseFloorArea'] ?? '') ?> sqm</p>
                    </div>
                </div>
            </section>

            <!-- COMPLETED BUTTON — only show when still Booked -->
            <?php if ($svStatus === 'booked'): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Update Status</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Mark this site visit as completed once the visit has taken place.</p>
                    <div class="mt-4">
                        <?php if ($isFutureDate): ?>
                            <!-- Future date: button opens warning modal -->
                            <button type="button" onclick="document.getElementById('futureVisitModal').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <i class="mdi mdi-check-circle-outline text-base"></i>
                                Completed
                            </button>

                            <!-- Warning Modal -->
                            <div id="futureVisitModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-xl p-6 max-w-sm w-full mx-4">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                                            <i class="mdi mdi-calendar-clock text-xl text-yellow-600 dark:text-yellow-400"></i>
                                        </span>
                                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Visit Not Yet Due</h3>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        This site visit is scheduled for a future date (<strong class="text-slate-700 dark:text-slate-200"><?= htSVDetailsE($svDateStr) ?></strong>). You can only mark it as completed on or after the visit date.
                                    </p>
                                    <div class="mt-5 flex justify-end">
                                        <button type="button" onclick="document.getElementById('futureVisitModal').classList.add('hidden')"
                                            class="px-4 py-2 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-200 dark:hover:bg-slate-600">
                                            Got it
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <form method="post" action="index.php?route=siteVisitDetails">
                                <input type="hidden" name="sitevisit_id" value="<?= htSVDetailsE($siteVisit['siteVisitID'] ?? '') ?>">
                                <input type="hidden" name="sitevisit_action" value="completed">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <i class="mdi mdi-check-circle-outline text-base"></i>
                                    Completed
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    <?php endif; ?>
</div>