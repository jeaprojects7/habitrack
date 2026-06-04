<?php
require_once __DIR__ . "/../../../controllers/clientPreQual.controller.php";

$statusUpdate = PrequalController::ctrUpdateSelectedPrequalStatus();
$prequal = PrequalController::ctrGetSelectedPrequal();

function htPrequalDetailsE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function htPrequalDetailsValue($value, $fallback = 'Not provided') {
    $value = trim((string) ($value ?? ''));
    return $value !== '' ? htPrequalDetailsE($value) : $fallback;
}

function htPrequalDetailsMoney($value) {
    if ($value === null || $value === '') {
        return 'Not provided';
    }

    return 'PHP ' . number_format((float) $value, 2);
}

$status = strtolower($prequal['prequalStatus'] ?? 'pending');
$statusClass = match ($status) {
    'approved' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
    'archived' => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
    default => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
};

$financingType = strtolower($prequal['financingType'] ?? '');
$hasCoOwner = !empty($prequal['coOwnerID']);
?>

<div id="main-area"
     class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
     style="left:300px;bottom:0;z-index:20;">

    <?php if (!$prequal): ?>
        <div class="max-w-3xl mx-auto bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Prequalification not found</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Select a prequalification from the list to view its details.
            </p>
            <a href="index.php?route=clientPreQual"
               class="inline-flex mt-5 px-4 py-2 rounded-md bg-green-600 text-white text-sm font-medium hover:bg-green-700">
                Back to Prequalifications
            </a>
        </div>
    <?php else: ?>
        <div class="max-w-5xl mx-auto space-y-5 pb-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <a href="index.php?route=clientPreQual"
                       class="inline-flex items-center text-sm text-slate-500 hover:text-green-600 dark:text-slate-400 dark:hover:text-green-400">
                        <i class="mdi mdi-arrow-left mr-1"></i> Back
                    </a>
                    <h1 class="mt-3 text-2xl font-semibold text-slate-900 dark:text-white">
                    <?= htPrequalDetailsValue(trim(($prequal['clientFName'] ?? '') . ' ' . ($prequal['clientMName'] ?? '') . ' ' . ($prequal['clientLName'] ?? '') . ' ' . ($prequal['clientSuffix'] ?? '')), 'Client') ?>
                    </h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        <?= htPrequalDetailsValue($prequal['propertyName'] ?? '') ?>
                    </p>
                </div>
                <span class="w-fit px-3 py-1 rounded-full text-sm font-semibold <?= $statusClass ?>">
                    <?= htPrequalDetailsE(ucfirst($prequal['prequalStatus'] ?? 'Pending')) ?>
                </span>
            </div>

            <?php if ($statusUpdate): ?>
                <?php $messageClass = $statusUpdate['success'] ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-900' : 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-900'; ?>
                <div class="border rounded-lg px-4 py-3 text-sm <?= $messageClass ?>">
                    <?= htPrequalDetailsE($statusUpdate['message'] ?? '') ?>
                </div>
            <?php endif; ?>

            <!-- <?php if ($status === 'pending'): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Prequalification Decision</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update this pending prequalification status.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <form method="post" action="index.php?route=clientPreDetails">
                            <input type="hidden" name="prequal_id" value="<?= htPrequalDetailsE($prequal['prequalID'] ?? '') ?>">
                            <input type="hidden" name="prequal_status_action" value="approve">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Approved
                            </button>
                        </form>
                        <form method="post" action="index.php?route=clientPreDetails">
                            <input type="hidden" name="prequal_id" value="<?= htPrequalDetailsE($prequal['prequalID'] ?? '') ?>">
                            <input type="hidden" name="prequal_status_action" value="reject">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Rejected
                            </button>
                        </form>
                    </div>
                </section>
            <?php endif; ?> -->

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Client Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Email</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['clientEmail'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Phone</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['clientPhoneNum'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Submitted</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['submissionDate'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Civil Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue(ucfirst($prequal['clientCivilStatus'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Employment Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue(strtoupper($prequal['clientEmpStatus'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Monthly Income</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsMoney($prequal['clientMonthlyIncome'] ?? null) ?></p>
                    </div>
                </div>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Property Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Property</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['propertyName'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Type</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['propertyType'] ?? '') ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Location</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200">
                            <?= htPrequalDetailsValue(trim(($prequal['propertyCity'] ?? '') . ', ' . ($prequal['propertyBrgy'] ?? ''), ', ')) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Price</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsMoney($prequal['propertyPrice'] ?? null) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Lot Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['propertyLotArea'] ?? '') ?> sqm</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Floor Area</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['houseFloorArea'] ?? '') ?> sqm</p>
                    </div>
                </div>
            </section>

            <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Financing Details</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Financing Type</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue(ucfirst($prequal['financingType'] ?? '')) ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Financing Status</p>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['financingStatus'] ?? '') ?></p>
                    </div>

                    <?php if ($financingType === 'bank'): ?>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Bank Name</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['bankName'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Existing House Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['existingHouseLoan'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Cancelled House Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['cancelledHouseLoan'] ?? '') ?></p>
                        </div>
                    <?php elseif ($financingType === 'pagibig'): ?>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Contribution Start Date</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['contributionStartDate'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Current Loan</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['currentLoan'] ?? '') ?></p>
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
                                <?= htPrequalDetailsValue(trim(($prequal['coOwnerFName'] ?? '') . ' ' . ($prequal['coOwnerMName'] ?? '') . ' ' . ($prequal['coOwnerLName'] ?? '') . ' ' . ($prequal['coOwnerSuffix'] ?? ''))) ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Relationship</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['coOwnerRelationship'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Email</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['coOwnerEmail'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Phone</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue($prequal['coOwnerPhoneNum'] ?? '') ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Employment Status</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsValue(strtoupper($prequal['coOwnerEmpStatus'] ?? '')) ?></p>
                        </div>
                        <div>
                            <p class="text-xs uppercase text-slate-400">Monthly Income</p>
                            <p class="mt-1 text-sm text-slate-700 dark:text-slate-200"><?= htPrequalDetailsMoney($prequal['coOwnerMonthlyIncome'] ?? null) ?></p>
                        </div>
                    </div>

                </section>

            <?php endif; ?>
            <?php if ($status === 'pending'): ?>
                <section class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-5">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Prequalification Decision</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update this pending prequalification status.</p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <form method="post" action="index.php?route=clientPreDetails">
                            <input type="hidden" name="prequal_id" value="<?= htPrequalDetailsE($prequal['prequalID'] ?? '') ?>">
                            <input type="hidden" name="prequal_status_action" value="approve">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-green-600 text-white text-sm font-semibold hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Approve
                            </button>
                        </form>
                        <form method="post" action="index.php?route=clientPreDetails">
                            <input type="hidden" name="prequal_id" value="<?= htPrequalDetailsE($prequal['prequalID'] ?? '') ?>">
                            <input type="hidden" name="prequal_status_action" value="reject">
                            <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Reject
                            </button>
                        </form>
                    </div>
                </section>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</div>
