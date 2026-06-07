<?php

require_once __DIR__ . "/../../../controllers/clientPreQual.controller.php";

$status = $_GET['status'] ?? 'Pending';
$agentID = $_SESSION['agentID'] ?? null;

/* $prequals should come from your controller/model */
/* $prequals = $prequals ?? []; */
$prequals = PrequalController::ctrGetPrequal($status);

function htPrequalListE($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
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
<div class="mb-5 flex items-center justify-between">
    <div>
    <h1 class="text-2xl font-semibold text-slate-900 dark:text-white"><?= htPrequalListE($status) ?> Prequalifications</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400">Click a prequalification to view the submitted details.</p>
    </div>

     <!-- PRINT BUTTON -->
    <?php if (!empty($prequals)): ?>
        <a href="/habitrack/reports/generate-agent-prequals.php?status=<?= urlencode($status) ?>"
           target="_blank"
           class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
            <i class="mdi mdi-printer"></i> Print PDF
        </a>
        <?php endif; ?>
</div>


<?php if (empty($prequals)): ?>
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 p-8 text-center">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">No prequalifications found</h2>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">There are no <?= htPrequalListE(strtolower($status)) ?> prequalifications assigned to you.</p>
    </div>
<?php endif; ?>


<?php foreach ($prequals as $app): ?>

<form method="post" action="index.php?route=clientPreDetails" class="block">
<input type="hidden" name="prequal_id" value="<?= htPrequalListE($app['prequalID']) ?>">

<button type="submit" class="group w-full text-left bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-green-500">

    <!-- HEADER -->
    <div class="p-4 flex justify-between items-center">

        <div>
            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                <?= htPrequalListE(trim(($app['clientFName'] ?? '') . ' ' . ($app['clientLName'] ?? '')) ?: 'Applicant') ?>
            </h3>

            <p class="text-sm text-slate-400">
                <?= htPrequalListE($app['propertyName'] ?? $app['propertyID']) ?>
            </p>
        </div>

        <!-- DYNAMIC STATUS BADGE -->
        <?php
            $statusColor = match($app['prequalStatus'] ?? 'Pending') {
                'Approved' => 'bg-green-600',
                'Rejected' => 'bg-red-600',
                'Archived' => 'bg-gray-500',
                default => 'bg-yellow-500'
            };
        ?>

        <span class="<?= $statusColor ?> text-white text-xs px-2.5 py-1 rounded-full">
            <?= htPrequalListE($app['prequalStatus'] ?? 'Pending') ?>
        </span>
        

    </div>

    <!-- BODY -->
    <div class="px-4 pb-4 text-sm text-slate-500">

        <p class="line-clamp-1">
            Property: <?= htPrequalListE($app['propertyType'] ?? '') ?>
            <?= !empty($app['propertyCity']) || !empty($app['propertyBrgy']) ? ' - ' . htPrequalListE(trim(($app['propertyCity'] ?? '') . ', ' . ($app['propertyBrgy'] ?? ''), ', ')) : '' ?>
        </p>

        <p class="mt-1">
            Submitted: <?= htPrequalListE($app['submissionDate'] ?? 'Not recorded') ?>
        </p>

        <!-- <p class="mt-1">
            Includes:
            <?= $app['has_spouse'] ? 'Applicant + Spouse' : 'Applicant' ?>
            <?= !empty($app['has_spa']) ? '+ SPA' : '' ?>
        </p> -->

    </div>

</button>

</form>

<?php endforeach; ?>
