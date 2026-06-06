<?php
$prequalID = $_GET['id'] ?? null;

require_once __DIR__ . '/../../../controllers/coowner.controller.php';

$coOwner = ControllerCoOwner::ctrGetCoOwnerIS($prequalID);

if (!$coOwner) {
    echo "<div class='text-red-500'>No Co-Owner Information Found.</div>";
    return;
}
function e($value)
{
    return htmlspecialchars($value ?? '');
}

function formatDate($date)
{
    if (empty($date) || $date == '0000-00-00') {
        return '';
    }
    return date('m/d/Y', strtotime($date));
}

// echo "<pre>";
// print_r($coOwner);
// echo "</pre>";
// die();
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 overflow-y-auto px-6 pb-10"
    style="left:300px; bottom:0; z-index:20;"
>

<div class="layout-spacing">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-xl shadow-lg p-6 text-white mb-6">

        <h1 class="text-3xl font-bold">
            Client Information Sheet
        </h1>

        <p class="text-emerald-100 mt-2">
            View submitted client information and requirements.
        </p>

    </div>

    <!-- PERSONAL INFORMATION -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Personal Information
        </h2>

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">First Name</label>
                <input disabled value="<?= e($coOwner['coOwnerFName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Middle Name</label>
                <input disabled value="<?= e($coOwner['coOwnerMName']) ?>" class="form-input w-full" placeholder="None">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Last Name</label>
                <input disabled value="<?= e($coOwner['coOwnerLName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Suffix</label>
                <input disabled value="<?= e($coOwner['coOwnerSuffix']) ?>" class="form-input w-full" placeholder="None">
            </div>

        </div>

        <div class="grid md:grid-cols-5 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input disabled value="<?= e($coOwner['coOwnerEmail']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Phone Number</label>
                <input disabled value="<?= e($coOwner['coOwnerPhoneNum']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Civil Status</label>
                <input disabled value="<?= e($coOwner['coCivilStatus']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Gender</label>
                <input disabled value="<?= e($coOwner['coGender']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Birth Date</label>
                <input disabled value="<?= formatDate($coOwner['coBirthdate']) ?>" class="form-input w-full">
            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Citizenship</label>
                <input disabled value="<?= e($coOwner['coCitizenship']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Religion</label>
                <input disabled value="<?= e($coOwner['coReligion']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Place of Birth</label>
                <input disabled value="<?= e($coOwner['coPlaceOfBirth']) ?>" class="form-input w-full">
            </div>

        </div>

    </div>

    <!-- ADDRESS INFORMATION -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Address Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">Home Address</label>
                <input disabled rows="3" class="form-input w-full"value="<?= e($coOwner['coAddress']) ?>"></input>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Provincial Address</label>
                <input disabled rows="3" class="form-input w-full"value="<?= e($coOwner['coProvinceAddress']) ?>"></input>
            </div>

        </div>

    </div>

    <!-- GOVERNMENT INFO -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Government Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">TIN Number</label>
                <input disabled value="<?= e($coOwner['coTaxIdenNum']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">SSS / GSIS Number</label>
                <input disabled value="<?= e($coOwner['coSSS_GSISnumber']) ?>" class="form-input w-full">
            </div>

        </div>

    </div>

    <!-- DEPENDENTS -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Dependents
        </h2>

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">Elementary</label>
                <input disabled value="<?= e($coOwner['coDependentsElem']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">High School</label>
                <input disabled value="<?= e($coOwner['coDependentsHS']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">College</label>
                <input disabled value="<?= e($coOwner['coDependentsC']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Not Studying</label>
                <input disabled value="<?= e($coOwner['coDependentsNotStud']) ?>" class="form-input w-full">
            </div>

        </div>

    </div>

    <!-- EMPLOYMENT -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Employment Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">Monthly Income</label>
                <input disabled value="<?= e($coOwner['coOwnerMonthlyIncome']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Source of Income</label>
                <input disabled value="<?= e($coOwner['coSourceOfIncome']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Employer / Business Name</label>
                <input disabled value="<?= e($coOwner['coEmployerBusinessName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nature of Business</label>
                <input disabled value="<?= e($coOwner['coNatureOfBusiness']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Business Address</label>
                <input disabled value="<?= e($coOwner['coBusinessAddress']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Appointment</label>
                <input disabled value="<?= e($coOwner['coAppointment']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Place of Work</label>
                <input disabled value="<?= e($coOwner['coPlaceOfWork']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date Hired</label>
                <input disabled value="<?= formatDate($coOwner['coDateHired']) ?>" class="form-input w-full">
            </div>

        </div>

    </div>

    <!-- PARENTS -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Parents Information
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">Father's Name</label>
                <input disabled value="<?= e($coOwner['coFathersName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mother's Maiden Name</label>
                <input disabled value="<?= e($coOwner['coMothersMaidenName']) ?>" class="form-input w-full">
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Parents Address</label>
                <input disabled rows="3" class="form-input w-full"value="<?= e($coOwner['coParentsAddress']) ?>"></input>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Parents Phone Number</label>
                <input disabled value="<?= e($coOwner['coParentsPhoneNum']) ?>" class="form-input w-full">
            </div>

        </div>

    </div>

    <!-- SPA -->
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow p-6 mt-6">

        <h2 class="text-xl font-semibold border-b pb-3 mb-5">
            Special Power of Attorney
        </h2>

        <div class="grid md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">Representative Name</label>
                <input disabled value="<?= e($coOwner['coSpaName']) ?>" class="form-input w-full" placeholder="None">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Address</label>
                <input disabled value="<?= e($coOwner['coSpaAddress']) ?>" class="form-input w-full" placeholder="None">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Phone Number</label>
                <input disabled value="<?= e($coOwner['coSpaPhoneNum']) ?>" class="form-input w-full" placeholder="None">
            </div>

        </div>

    </div>

    <!-- BACK BUTTON -->
    <div class="mt-6">
        <a href="javascript:history.back()"
           class="inline-flex items-center px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
            ← Back
        </a>
    </div>

</div>

</div>