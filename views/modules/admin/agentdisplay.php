<?php

require_once __DIR__ . '/../../../controllers/agentregister.controller.php';
require_once __DIR__ . '/../../../models/agentregister.model.php';

$agents = ControllerAddAgent::ctrGetAgents();

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
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Agent List</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                        <a href="index.php">Habitrack</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">
                        Agents
                    </li>
                </ul>
            </div>

           


            <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 mt-6">
             

                <?php if (empty($agents)): ?>
                    <div class="lg:col-span-2 rounded-md bg-white dark:bg-slate-900 shadow p-6 text-center">
                        <p class="text-slate-500">No agents registered yet.</p>
                    </div>
                <?php endif; ?>

                
                <?php foreach ($agents as $agent): ?>
                     <a
                            href="index.php?route=edit-agentprofile&agentID=<?= $agent['agentID'] ?>"
                            class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
                        >
                    <?php
                        $agentPic = trim($agent['agentPic'] ?? '');
                        $fullName = trim(($agent['agentFName'] ?? '') . ' ' . ($agent['agentMName'] ?? '') . ' ' . ($agent['agentLName'] ?? '') . ' ' . ($agent['agentSuffix'] ?? ''));
                        // If no profile photo was uploaded, show initials instead of a default image.
                        $firstInitial = strtoupper(substr(trim($agent['agentFName'] ?? ''), 0, 1));
                        $lastInitial = strtoupper(substr(trim($agent['agentLName'] ?? ''), 0, 1));
                        $initials = trim($firstInitial . $lastInitial) !== '' ? $firstInitial . $lastInitial : 'AG';
                    ?>
                    

                    <div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 w-full mx-auto">
                        <div class="md:flex">
                            <div class="relative md:shrink-0 bg-slate-100 dark:bg-slate-800">
                                <?php if ($agentPic !== ''): ?>
                                    <img
                                        class="h-56 w-full object-cover md:w-48"
                                        src="<?= htmlspecialchars('/habitrack' . $agentPic) ?>"
                                        alt="<?= htmlspecialchars($fullName) ?>"
                                    >
                                <?php else: ?>
                                    <div class="h-56 w-full md:w-48 flex items-center justify-center bg-green-100 dark:bg-slate-800 text-green-700 dark:text-green-400 text-4xl font-semibold">
                                        <?= htmlspecialchars($initials) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="p-6 w-full">
                                <div class="md:pb-4 pb-6">
                                    <h6 class="text-lg font-medium">
                                        <?= htmlspecialchars($fullName !== '' ? $fullName : 'Unnamed Agent') ?>
                                    </h6>
                                    <p class="text-slate-400">
                                        <?= htmlspecialchars($agent['agentID'] ?? '') ?>
                                    </p>
                                </div>

                                <ul class="md:py-4 py-6 border-y border-slate-100 dark:border-gray-800 list-none space-y-2">
                                    <li class="flex items-center">
                                        <i class="mdi mdi-email-outline text-2xl me-2 text-green-600"></i>
                                        <span><?= htmlspecialchars($agent['agentEmail'] ?? '') ?></span>
                                    </li>

                                    <li class="flex items-center">
                                        <i class="mdi mdi-phone text-2xl me-2 text-green-600"></i>
                                        <span><?= htmlspecialchars($agent['agentPhoneNum'] ?? '') ?></span>
                                    </li>

                                    <li class="flex items-center">
                                        <i class="mdi mdi-map-marker text-2xl me-2 text-green-600"></i>
                                        <span><?= htmlspecialchars($agent['agentAddress'] ?? '') ?></span>
                                    </li>
                                </ul>

                                <ul class="md:pt-4 pt-6 flex justify-between items-center list-none">
                                    <li>
                                        <span class="text-slate-400">Gender</span>
                                        <p class="text-lg font-medium"><?= htmlspecialchars($agent['agentGender'] ?? '') ?></p>
                                    </li>

                                    <li>
                                        <span class="text-slate-400">Sold Units</span>
                                        <p class="text-lg font-medium"><?= htmlspecialchars($agent['agentSoldUnits'] ?? '0') ?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                                
                    </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
