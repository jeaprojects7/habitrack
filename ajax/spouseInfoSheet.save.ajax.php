<?php
session_start();

require_once "../controllers/clientsignup.controller.php";
require_once "../models/spouse.model.php";

class SpouseInfoSheet {

    // ===== MISSING PAGE 1 =====
    public $spouseFName;
    public $spouseMName;
    public $spouseLName;
    public $spouseSuffix;
    public $spouseEmail;
    public $spousePhoneNum;

    // ===== PAGE 3 DEPENDENTS =====
    public $spouseDependentsElem;
    public $spouseDependentsHS;
    public $spouseDependentsC;
    public $spouseDependentsNotStud;

    // ===== PAGE 4 =====
    public $spouseMonthlyIncome;

    // ===== PAGE 1 =====
    public $clientCISID;
    public $gender;
    public $birthdate;

    public $citizenship;
    public $religion;
    public $placeofbirth;

    // ===== PAGE 2 =====
    public $spouseAddress;
    public $spouseProvinceAddress;

    // ===== PAGE 3 =====
    public $spouseTaxIdenNum;
    public $spouseSSS_GSISnumber;

    // ===== PAGE 4 =====
    public $spouseSourceOfIncome;
    public $spouseEmployerBusinessName;
    public $spouseNatureOfBusiness;
    public $spouseBusinessAddress;

    public $spouseAppointment;
    public $spousePlaceOfWork;
    public $spouseDateHired;

    public $spousePosition;
    public $spouseDepartment;
    public $spouseEmpPhoneNum;
    public $spouseEmployerEmail;

    // ===== PAGE 5 =====
    public $spouseParentsAddress;
    public $spouseParentsPhoneNum;

    public $spouseFathersName;
    public $spouseMothersMaidenName;

    public function saveSpouseInfoSheet() {

        $data = array(
          
        "clientCISID" => $this->clientCISID,

        // ===== PAGE 1 =====
        "spouseFName" => $this->spouseFName,
        "spouseMName" => $this->spouseMName,
        "spouseLName" => $this->spouseLName,
        "spouseSuffix" => $this->spouseSuffix,

        "spouseEmail" => $this->spouseEmail,
        "spousePhoneNum" => $this->spousePhoneNum,
        "spouseGender" => $this->gender,
        "spouseBirthdate" => $this->birthdate,

        "spouseCitizenship" => $this->citizenship,
        "spouseReligion" => $this->religion,
        "spousePlaceOfBirth" => $this->placeofbirth,

        // ===== PAGE 2 =====
        "spouseAddress" => $this->spouseAddress,
        "spouseProvinceAddress" => $this->spouseProvinceAddress,

        // ===== PAGE 3 =====
        "spouseTaxIdenNum" => $this->spouseTaxIdenNum,
        "spouseSSS_GSISnumber" => $this->spouseSSS_GSISnumber,

        "spouseDependentsElem" => $this->spouseDependentsElem,
        "spouseDependentsHS" => $this->spouseDependentsHS,
        "spouseDependentsC" => $this->spouseDependentsC,
        "spouseDependentsNotStud" => $this->spouseDependentsNotStud,

        // ===== PAGE 4 =====
        "spouseMonthlyIncome" => $this->spouseMonthlyIncome,

        // FIX ENUM VALUES BEFORE INSERT
        "spouseSourceOfIncome" => $this->spouseSourceOfIncome,
        "spouseEmployerBusinessName" => $this->spouseEmployerBusinessName,
        "spouseNatureOfBusiness" => $this->spouseNatureOfBusiness,
        "spouseBusinessAddress" => $this->spouseBusinessAddress,

        "spouseAppointment" => $this->spouseAppointment,
        "spousePlaceOfWork" => $this->spousePlaceOfWork,
        "spouseDateHired" => $this->spouseDateHired,

        "spousePosition" => $this->spousePosition,
        "spouseDepartment" => $this->spouseDepartment,
        "spouseEmpPhoneNum" => $this->spouseEmpPhoneNum,
        "spouseEmployerEmail" => $this->spouseEmployerEmail,

        // ===== PAGE 5 =====
        "spouseParentsAddress" => $this->spouseParentsAddress,
        "spouseParentsPhoneNum" => $this->spouseParentsPhoneNum,

        "spouseFathersName" => $this->spouseFathersName,
        "spouseMothersMaidenName" => $this->spouseMothersMaidenName,


        );

        $answer = (new ControllerClient)->ctrSaveSpouseInfo($data);
        /* for 1to1 v */
        if ($answer === "exists") {
            echo json_encode([
                "status" => "error",
                "message" => "Spouse info already submitted for this reservation."
            ]);
            exit;
        }
        /* for 1to1 ^ */
        echo $answer;
    }
}

$save_spouse_info = new SpouseInfoSheet();

// Helper function to safely fetch POST values
function post($key) {
    return $_POST[$key] ?? null;
}

// ===== PAGE 1 =====
$save_spouse_info->clientCISID = post("clientCISID");
$save_spouse_info->gender = post("spouseGender");

$date = DateTime::createFromFormat('Y-m-d', post("spouseBirthdate"));

if (!$date) {
    $date = DateTime::createFromFormat('m-d-Y', post("spouseBirthdate"));
}

$save_spouse_info->birthdate = $date ? $date->format('Y-m-d') : null;

$save_spouse_info->citizenship = post("spouseCitizenship");
$save_spouse_info->religion = post("spouseReligion");
$save_spouse_info->placeofbirth = post("spousePlaceOfBirth");

// 👇 MISSING FIELDS (IMPORTANT FIX)
$save_spouse_info->spouseFName = post("spouseFName");
$save_spouse_info->spouseMName = post("spouseMName");
$save_spouse_info->spouseLName = post("spouseLName");
$save_spouse_info->spouseSuffix = post("spouseSuffix");
$save_spouse_info->spouseEmail = post("spouseEmail");
$save_spouse_info->spousePhoneNum = post("spousePhoneNum");

// ===== PAGE 2 =====
$save_spouse_info->spouseAddress = post("spouseAddress");
$save_spouse_info->spouseProvinceAddress = post("spouseProvinceAddress");

// ===== PAGE 3 =====
$save_spouse_info->spouseTaxIdenNum = post("spouseTaxIdenNum");
$save_spouse_info->spouseSSS_GSISnumber = post("spouseSSS_GSISnumber");

$save_spouse_info->spouseDependentsElem = post("spouseDependentsElem");
$save_spouse_info->spouseDependentsHS = post("spouseDependentsHS");
$save_spouse_info->spouseDependentsC = post("spouseDependentsC");
$save_spouse_info->spouseDependentsNotStud = post("spouseDependentsNotStud");

// ===== PAGE 4 =====
$save_spouse_info->spouseMonthlyIncome = post("spouseMonthlyIncome");
$save_spouse_info->spouseSourceOfIncome = post("spouseSourceOfIncome");
$save_spouse_info->spouseEmployerBusinessName = post("spouseEmployerBusinessName");
$save_spouse_info->spouseNatureOfBusiness = post("spouseNatureOfBusiness");
$save_spouse_info->spouseBusinessAddress = post("spouseBusinessAddress");

$save_spouse_info->spouseAppointment = post("spouseAppointment");
$save_spouse_info->spousePlaceOfWork = post("spousePlaceOfWork");

$date = DateTime::createFromFormat('m-d-Y', post("spouseDateHired"));
$save_spouse_info->spouseDateHired = $date ? $date->format('Y-m-d') : null;

$save_spouse_info->spousePosition = post("spousePosition");
$save_spouse_info->spouseDepartment = post("spouseDepartment");
$save_spouse_info->spouseEmpPhoneNum = post("spouseEmpPhoneNum");
$save_spouse_info->spouseEmployerEmail = post("spouseEmployerEmail");

// ===== PAGE 5 =====
$save_spouse_info->spouseParentsAddress = post("spouseParentsAddress");
$save_spouse_info->spouseParentsPhoneNum = post("spouseParentsPhoneNum");

$save_spouse_info->spouseFathersName = post("spouseFathersName");
$save_spouse_info->spouseMothersMaidenName = post("spouseMothersMaidenName");

// SAVE
// var_dump(post('spouseFName') ?? 'NOT SET');
// var_dump($_POST['spouseMName'] ?? 'NOT SET');
// die();

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// die();
$save_spouse_info->saveSpouseInfoSheet();
?>