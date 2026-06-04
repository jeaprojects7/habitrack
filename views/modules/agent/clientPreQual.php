<?php

require_once __DIR__ . "/../../../controllers/clientPreQual.controller.php";

$status = $_GET['status'] ?? 'Pending';

/* $prequals should come from your controller/model */
/* $prequals = $prequals ?? []; */
$prequals = PrequalController::ctrGetPrequal($status);
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
<?php foreach ($prequals as $app): ?>

<a href="prequal-details.php?id=<?= $app['id'] ?>" class="block">

<div class="group bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">

    <!-- HEADER -->
    <div class="p-4 flex justify-between items-center">

        <div>
            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                Applicant #<?= $app['id'] ?>
            </h3>

            <!-- <p class="text-sm text-slate-400">
                <?= $app['application_type'] ?? 'Individual' ?> Application
            </p> -->
        </div>

        <!-- DYNAMIC STATUS BADGE -->
        <?php
            $statusColor = match($app['prequalStatus']) {
                'Approved' => 'bg-green-600',
                'Archived' => 'bg-gray-500',
                default => 'bg-yellow-500'
            };
        ?>

        <span class="<?= $statusColor ?> text-white text-xs px-2.5 py-1 rounded-full">
            <?= $app['prequalStatus'] ?>
        </span>

    </div>

    <!-- BODY -->
    <div class="px-4 pb-4 text-sm text-slate-500">

        <p class="line-clamp-1">
            Property: <?= $app['prequalID'] ?>
        </p>

        <p class="mt-1">
            Submitted: <?= $app['propertyID'] ?>
        </p>

        <!-- <p class="mt-1">
            Includes:
            <?= $app['has_spouse'] ? 'Applicant + Spouse' : 'Applicant' ?>
            <?= !empty($app['has_spa']) ? '+ SPA' : '' ?>
        </p> -->

    </div>

</div>

</a>

<?php endforeach; ?>