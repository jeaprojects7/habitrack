<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$prequalID = $_GET['prequalID'] ?? null;

if (!$prequalID) {
    die("Invalid prequal ID");
}

require_once __DIR__ . '/../../../models/spouse.model.php';
$spouseIS = ModelSpouse::mdlGetSpouseIS($prequalID);

if (!$spouseIS) {
    die("Spouse not found.");
}

// if (!isset($_SESSION['clientID']) || $spouseIS['clientID'] !== $_SESSION['clientID']) {
//     http_response_code(403);
//     die("Access denied.");
// }

function e($value) {
    if(trim($value) == ''){return;}
    return htmlspecialchars($value ?? '');
}

function formatDate($date) {
    if (empty($date) || $date === '0000-00-00') return '';
    return date('m/d/Y', strtotime($date));
}
?>

<div id="main-area"
     class="fixed top-[90px] right-0 overflow-y-auto px-6 pb-10"
     style="left:300px; bottom:0; z-index:20;">

<div class="layout-spacing">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white mb-6">
        <h1 class="text-3xl font-bold">Spouse Information Sheet</h1>
        <p class="text-indigo-100 mt-2">View submitted spouse reservation details.</p>
    </div>

    <!-- BASIC INFO -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Personal Information</h2>

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm font-medium">First Name</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseFName'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Middle Name</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseMName']) ?>" placeholder="None">
            </div>

            <div>
                <label class="text-sm font-medium">Last Name</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseLName'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Suffix</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseSuffix']) ?>" placeholder="None">
            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-4 mt-4">

            <div>
                <label class="text-sm font-medium">Email</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseEmail'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Phone</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spousePhoneNum'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Civil Status</label>
                <input disabled class="form-input w-full"
                       value="Married">
            </div>

        </div>
    </div>

    <!-- ADDRESS -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Address Information</h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium">Home Address</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseAddress'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Provincial Address</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseProvinceAddress'] ?? '') ?>">
            </div>

        </div>
    </div>

    <!-- GOVERNMENT -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Government Information</h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium">TIN</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseTaxIdenNum'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">SSS / GSIS</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseSSS_GSISnumber'] ?? '') ?>">
            </div>

        </div>
    </div>

    <!-- EMPLOYMENT -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Employment</h2>

        <div class="grid md:grid-cols-3 gap-4">

            <div>
                <label class="text-sm font-medium">Income</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseMonthlyIncome'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Source</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseSourceOfIncome'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Employer</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseEmployerBusinessName'] ?? '') ?>">
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-4 mt-4">

            <div>
                <label class="text-sm font-medium">Nature of Business</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseNatureOfBusiness'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Business Address</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseBusinessAddress'] ?? '') ?>">
            </div>

        </div>
    </div>

    <!-- DEPENDENTS -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Dependents</h2>

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm font-medium">Elementary</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseDependentsElem'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">High School</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseDependentsHS'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">College</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseDependentsC'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Not Studying</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseDependentsNotStud'] ?? '') ?>">
            </div>

        </div>
    </div>

    <!-- PARENTS -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-semibold border-b pb-3 mb-5">Parents Information</h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="text-sm font-medium">Father's Name</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseFathersName'] ?? '') ?>">
            </div>

            <div>
                <label class="text-sm font-medium">Mother's Name</label>
                <input disabled class="form-input w-full"
                       value="<?= e($spouseIS['spouseMothersMaidenName'] ?? '') ?>">
            </div>

        </div>

        <div class="mt-4">
            <label class="text-sm font-medium">Parents Address</label>
            <input disabled class="form-input w-full"
                   value="<?= e($spouseIS['spouseParentsAddress'] ?? '') ?>" placeholder="None">
        </div>

        <div>
            <label class="text-sm font-medium">Parents Phone Number</label>
            <input disabled class="form-input w-full"
                value="<?= e($spouseIS['spouseParentsPhoneNum'] ?? '') ?>" placeholder="None">
        </div>

    </div>

    <!-- BACK -->
    <div class="mt-6">
        <a href="javascript:history.back()"
           class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
            ← Back
        </a>
    </div>

</div>
</div>