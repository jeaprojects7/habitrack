<?php
$prequalID = $_GET['prequalID'] ?? null;

if (!$prequalID) {
    die("Invalid Prequal ID");
}

require_once 'controllers/clientsignup.controller.php';

$client = ControllerClient::ctrGetClientInfoByPrequalID($prequalID);

if (!$client) {
    die("No client information found.");
}

/* ESCAPE OUTPUT */
function e($value)
{
    return htmlspecialchars($value ?? '');
}

/* DATE FORMAT: MM/DD/YYYY */
function formatDate($date)
{
    if (empty($date) || $date == '0000-00-00') {
        return '';
    }
    return date('m/d/Y', strtotime($date));
}
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
                <input disabled value="<?= e($client['clientFName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Middle Name</label>
                <input disabled value="<?= e($client['clientMName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Last Name</label>
                <input disabled value="<?= e($client['clientLName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Suffix</label>
                <input disabled value="<?= e($client['clientSuffix']) ?>" class="form-input w-full">
            </div>

        </div>

        <div class="grid md:grid-cols-5 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input disabled value="<?= e($client['clientEmail']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Phone Number</label>
                <input disabled value="<?= e($client['clientPhoneNum']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Civil Status</label>
                <input disabled value="<?= e($client['clientCivilStatus']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Gender</label>
                <input disabled value="<?= e($client['clientGender']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Birth Date</label>
                <input disabled value="<?= formatDate($client['clientBirthdate']) ?>" class="form-input w-full">
            </div>

        </div>

        <div class="grid md:grid-cols-3 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Citizenship</label>
                <input disabled value="<?= e($client['clientCitizenship']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Religion</label>
                <input disabled value="<?= e($client['clientReligion']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Place of Birth</label>
                <input disabled value="<?= e($client['clientPlaceOfBirth']) ?>" class="form-input w-full">
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
                <input disabled rows="3" class="form-input w-full"value="<?= e($client['clientAddress']) ?>"></input>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Provincial Address</label>
                <input disabled rows="3" class="form-input w-full"value="<?= e($client['clientProvinceAddress']) ?>"></input>
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
                <input disabled value="<?= e($client['clientTaxIdenNum']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">SSS / GSIS Number</label>
                <input disabled value="<?= e($client['clientSSS_GSISnumber']) ?>" class="form-input w-full">
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
                <input disabled value="<?= e($client['clientDependentsElem']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">High School</label>
                <input disabled value="<?= e($client['clientDependentsHS']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">College</label>
                <input disabled value="<?= e($client['clientDependentsC']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Not Studying</label>
                <input disabled value="<?= e($client['clientDependentsNotStud']) ?>" class="form-input w-full">
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
                <input disabled value="<?= e($client['clientMonthlyIncome']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Source of Income</label>
                <input disabled value="<?= e($client['clientSourceOfIncome']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Employer / Business Name</label>
                <input disabled value="<?= e($client['clientEmployerBusinessName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nature of Business</label>
                <input disabled value="<?= e($client['clientNatureOfBusiness']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Business Address</label>
                <input disabled value="<?= e($client['clientBusinessAddress']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Appointment</label>
                <input disabled value="<?= e($client['clientAppointment']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Place of Work</label>
                <input disabled value="<?= e($client['clientPlaceOfWork']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date Hired</label>
                <input disabled value="<?= formatDate($client['clientDateHired']) ?>" class="form-input w-full">
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
                <input disabled value="<?= e($client['clientFathersName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mother's Maiden Name</label>
                <input disabled value="<?= e($client['clientMothersMaidenName']) ?>" class="form-input w-full">
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-4 mt-4">

            <div>
                <label class="block text-sm font-medium mb-1">Parents Address</label>
                <input disabled rows="3" class="form-input w-full"value="<?= e($client['clientParentsAddress']) ?>"></input>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Parents Phone Number</label>
                <input disabled value="<?= e($client['clientParentsPhoneNum']) ?>" class="form-input w-full">
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
                <input disabled value="<?= e($client['clientSpaName']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Address</label>
                <input disabled value="<?= e($client['clientSpaAddress']) ?>" class="form-input w-full">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Phone Number</label>
                <input disabled value="<?= e($client['clientSpaPhoneNum']) ?>" class="form-input w-full">
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