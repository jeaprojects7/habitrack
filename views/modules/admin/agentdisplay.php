<?php

require_once __DIR__ . '/../../../controllers/agentregister.controller.php';
require_once __DIR__ . '/../../../models/agentregister.model.php';

/* $agents = ControllerAddAgent::ctrGetAgents(); */

/* $selectedAgentID = trim($_GET['agentID'] ?? '');
$selectedAgent = trim($_GET['agent'] ?? '');  */
/* $selectedCity = trim($_GET['city'] ?? '');
$selectedMinPrice = trim($_GET['minPrice'] ?? '');
$selectedMaxPrice = trim($_GET['maxPrice'] ?? '');
$allowedTypes = ['House', 'Lot'];
$allowedStatus = ['Available', 'Reserved','Archived']; */ //gn add kolng
$search = trim($_GET['agent'] ?? '');
$selectedAgentStatus = trim($_GET['status'] ?? ''); //gn add kolng
$selectedMinSoldUnits = trim($_GET['minSoldUnits'] ?? '');
$selectedMaxSoldUnits = trim($_GET['maxSoldUnits'] ?? '');





/* if (!in_array($selectedType, $allowedTypes, true)) {
    $selectedType = '';
}

if (!in_array($selectedStatus, $allowedStatus, true)) { 
    $selectedStatus = '';
} */

// Build one clean filter array for the model. Empty values are ignored there,
// so users can combine any filters they want without needing separate queries.
$filters =[
    'agentID' => $search,
    'agent'   => $search,
    'status' => $selectedAgentStatus,
    'minSoldUnits' => $selectedMinSoldUnits,
    'maxSoldUnits' => $selectedMaxSoldUnits//gn add kolng
];


// check if user is searching
$hasFilter =  !empty($search) || !empty($selectedAgentStatus) || !empty($selectedMinSoldUnits) || !empty($selectedMaxSoldUnits);

if ($hasFilter) {
    $agents = ControllerAddAgent::ctrGetAgentFiltered($filters);
} else {
    $agents = ControllerAddAgent::ctrGetAgents();
}

$printQuery = http_build_query([
    'route' => 'print-agents',
    'agentID' => $search,
    'agent' => $search, 
    'status' => $selectedAgentStatus,
    'minSoldUnits' => $selectedMinSoldUnits,
    'maxSoldUnits' => $selectedMaxSoldUnits
]);

//wla pni
/* $printQuery = http_build_query([
    'route' => 'print-properties',
    'type' => $selectedType,
    'status' => $selectedStatus, //gn add kolng
    'city' => $selectedCity,
    'minPrice' => $selectedMinPrice,
    'maxPrice' => $selectedMaxPrice
]); */
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
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 white:text-gray/100 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                        <a href="adminDashboard">Habitrack</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">
                        Agents
                    </li>
                </ul>
            </div>
            
            <form method="GET" action="/habitrack/index.php" class="flex flex-wrap gap-3 items-end">

    <input type="hidden" name="route" value="agentdisplay">

        <!-- ID -->
  <!--   <input type="text"
        name="agentID"
        placeholder="Agent ID"
        value="<?= htmlspecialchars($selectedAgentID) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">
 -->
        <!-- NAME -->
  <!--   <input type="text"
        name="agent"
        placeholder="Agent Name"
        value="<?= htmlspecialchars($selectedAgent) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]"> -->

        

        <!-- STATUS (ADD LNG NI) -->
    <select name="status"
        class="px-4 py-3 text-lg rounded-full border border-gray-300 bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[180px]">
        <option value="">Status</option>
        <option value="Active" <?= ($selectedAgentStatus == 'Active') ? 'selected' : '' ?>>Active</option>
        <option value="Archived" <?= ($selectedAgentStatus == 'Archived') ? 'selected' : '' ?>>Archived</option>
    </select>

      <!-- SEARCH (NAME OR ID) -->
    <input type="text"
        name="agent"
        placeholder="Search Agent ID or Name"
        value="<?= htmlspecialchars($search) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">

    <!-- MIN SOLD -->
    <input type="number"
        name="minSoldUnits"
        placeholder="Min Sold Units"
        value="<?= htmlspecialchars($selectedMinSoldUnits) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">

     <!-- MAX SOLD -->
    <input type="number"
        name="maxSoldUnits"
        placeholder="Max Sold Units"
        value="<?= htmlspecialchars($selectedMaxSoldUnits) ?>"
        class="px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 min-w-[140px]">


<!-- Filter    -->
     <button type="submit"
        class="px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-semibold transition">
        Filter
    </button>

    <!-- PRINT -->
    <a href="/habitrack/index.php?<?= htmlspecialchars($printQuery) ?>" target="_blank"
        class="px-4 py-3 rounded-full border border-gray-300 text-black hover:bg-gray-100 transition">
        Print PDF
    </a> 

</form>

           


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
                                        alt="<?= htmlspecialchars(trim($fullName ?? '')) ?>"
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
