<?php

require_once __DIR__ . "/../../../controllers/siteVisit_controller.php";

if (session_status() === PHP_SESSION_NONE) session_start();

$agentID = $_SESSION['agentID'] ?? $_SESSION['userid'] ?? null;

if (!$agentID) {
    $siteVisits = [];
} else {
    $siteVisits = SiteVisitController::ctrGetSiteVisits($agentID);
}

$status = $_GET['status'] ?? 'All';

if ($status !== 'All') {
    $siteVisits = array_filter($siteVisits, fn($sv) => $sv['siteVisitStatus'] === $status);
}

function htSiteVisitListE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function htSiteVisitListMoney($value) {
    if ($value === null || $value === '') return 'Not provided';
    return 'PHP ' . number_format((float) $value, 2);
}
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px;bottom:0;z-index:20;"
>
    <div class="mb-5">
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white">Site Visits</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400">Click a site visit to view details.</p>
    </div>

    <?php if (empty($siteVisits)): ?>
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8 text-center">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">No site visits found</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">There are no site visits assigned to you yet.</p>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
        <?php foreach ($siteVisits as $sv): ?>
            <?php
                $svStatus = $sv['siteVisitStatus'] ?? 'Booked';
                $svStatusColor = match ($svStatus) {
                    'Completed'   => 'bg-green-600',
                    'Cancelled' => 'bg-red-600',
                    default  => 'bg-yellow-500',
                };
            ?>

            <form method="post" action="index.php?route=siteVisitDetails" class="block">
                <input type="hidden" name="sitevisit_id" value="<?= htSiteVisitListE($sv['siteVisitID']) ?>">

                <button type="submit" class="group w-full text-left bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-green-500">

                    <div class="p-4 flex justify-between items-start gap-4">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                                <?= htSiteVisitListE(trim(($sv['clientFName'] ?? '') . ' ' . ($sv['clientLName'] ?? '')) ?: 'Client') ?>
                            </h3>
                            <p class="text-sm text-slate-400">
                                <?= htSiteVisitListE($sv['propertyName'] ?? $sv['propertyID']) ?>
                            </p>
                        </div>

                        <span class="<?= $svStatusColor ?> text-white text-xs px-2.5 py-1 rounded-full whitespace-nowrap">
                            <?= htSiteVisitListE($svStatus) ?>
                        </span>
                    </div>

                    <div class="px-4 pb-4 text-sm text-slate-500 dark:text-slate-400">
                        <p class="line-clamp-1">
                            <?= htSiteVisitListE($sv['propertyType'] ?? '') ?>
                            <?php if (!empty($sv['propertyCity']) || !empty($sv['propertyBrgy'])): ?>
                                &mdash; <?= htSiteVisitListE(trim(($sv['propertyCity'] ?? '') . ', ' . ($sv['propertyBrgy'] ?? ''), ', ')) ?>
                            <?php endif; ?>
                        </p>
                        <p class="mt-1">
                            Price: <?= htSiteVisitListMoney($sv['propertyPrice'] ?? null) ?>
                        </p>
                        <p class="mt-1 flex items-center gap-1">
                            <i class="mdi mdi-calendar text-base text-green-600"></i>
                            <?= htSiteVisitListE($sv['siteVisitDate'] ?? 'No date') ?>
                            <?php if (!empty($sv['siteVisitTime'])): ?>
                                &nbsp;at&nbsp;
                                <i class="mdi mdi-clock-outline text-base text-green-600"></i>
                                <?= htSiteVisitListE($sv['siteVisitTime']) ?>
                            <?php endif; ?>
                        </p>
                    </div>

                </button>
            </form>

        <?php endforeach; ?>
    </div>
</div>
