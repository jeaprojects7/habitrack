<?php
session_start();

require_once "../controllers/clientsignup.controller.php";
require_once "../models/clientsignup.model.php";

class SpouseInfoSheet {

    // ===== PAGE 1 =====
    // public $civilstatus;
    public $gender;
    public $birthdate;

    public $citizenship;
    public $religion;
    public $placeofbirth;

    // ===== PAGE 2 =====
    public $address;
    public $prov_address;

    // ===== PAGE 3 =====
    public $tin;
    public $sss_gsis;

    // ===== PAGE 4 =====
    public $sourceofincome;
    public $empbusinessname;
    public $natureofbusiness;
    public $businessaddress;

    public $appointment;
    public $placeofwork;
    public $datehired;

    public $position;
    public $department;
    public $employerphonenumber;
    public $employeremail;

    // ===== PAGE 5 =====
    public $parentsaddress;
    public $parentsphonenumber;

    public $fathersfullname;
    public $mothersfullname;

    public function saveSpouseInfoSheet() {

        $data = array(
            // "spouseISID" => $_SESSION["spouseISID"],
            // ===== PAGE 1 =====
            "spouseGender" => $this->gender,
            "spouseBirthdate" => $this->birthdate,

            "spouseCitizenship" => $this->citizenship,
            "spouseReligion" => $this->religion,
            "spousePlaceOfBirth" => $this->placeofbirth,

            // ===== PAGE 2 =====
            "spouseAddress" => $this->address,
            "spouseProvinceAddress" => $this->prov_address,

            // ===== PAGE 3 =====
            "spouseTaxIdenNum" => $this->tin,
            "spouseSSS_GSISnumber" => $this->sss_gsis,

            // ===== PAGE 4 =====
            "spouseSourceOfIncome" => $this->sourceofincome,
            "spouseEmployerBusinessName" => $this->empbusinessname,
            "spouseNatureOfBusiness" => $this->natureofbusiness,
            "spouseBusinessAddress" => $this->businessaddress,

            "spouseAppointment" => $this->appointment,
            "spousePlaceOfWork" => $this->placeofwork,
            "spouseDateHired" => $this->datehired,

            "spousePosition" => $this->position,
            "spouseDepartment" => $this->department,
            "spouseEmpPhoneNum" => $this->employerphonenumber,
            "spouseEmployerEmail" => $this->employeremail,

            // ===== PAGE 5 =====
            "spouseParentsAddress" => $this->parentsaddress,
            "spouseParentsPhoneNum" => $this->parentsphonenumber,

            "spouseFathersName" => $this->fathersfullname,
            "spouseMothersMaidenName" => $this->mothersfullname,


        );

        $answer = (new ControllerClient)->ctrSaveSpouseInfo($data);

        echo $answer;
    }
}

$save_spouse_info = new SpouseInfoSheet();

// ===== PAGE 1 =====
// $save_spouse_info->civilstatus = $_POST["civilstatus"];
$save_spouse_info->gender = $_POST["gender"];
// $save_spouse_info->birthdate = $_POST["birthdate"];
$date = DateTime::createFromFormat('m-d-Y', $_POST["birthdate"]);
$save_spouse_info->birthdate = $date ? $date->format('Y-m-d') : null;

$save_spouse_info->citizenship = $_POST["citizenship"];
$save_spouse_info->religion = $_POST["religion"];
$save_spouse_info->placeofbirth = $_POST["placeofbirth"];

// ===== PAGE 2 =====
$save_spouse_info->address = $_POST["address"];
$save_spouse_info->prov_address = $_POST["prov_address"];

// ===== PAGE 3 =====
$save_spouse_info->tin = $_POST["tin"];
$save_spouse_info->sss_gsis = $_POST["sss_gsis"];


// ===== PAGE 4 =====
$save_spouse_info->sourceofincome = $_POST["sourceofincome"];
$save_spouse_info->empbusinessname = $_POST["empbusinessname"];
$save_spouse_info->natureofbusiness = $_POST["natureofbusiness"];
$save_spouse_info->businessaddress = $_POST["businessaddress"];

$save_spouse_info->appointment = $_POST["appointment"];
$save_spouse_info->placeofwork = $_POST["placeofwork"];

$date = DateTime::createFromFormat('m-d-Y', $_POST["datehired"]);
$save_spouse_info->datehired = $date ? $date->format('Y-m-d') : null;

$save_spouse_info->position = $_POST["position"];
$save_spouse_info->department = $_POST["department"];
$save_spouse_info->employerphonenumber = $_POST["employerphonenumber"];
$save_spouse_info->employeremail = $_POST["employeremail"];

// ===== PAGE 5 =====
$save_spouse_info->parentsaddress = $_POST["parentsaddress"];
$save_spouse_info->parentsphonenumber = $_POST["parentsphonenumber"];

$save_spouse_info->fathersfullname = $_POST["fathersfullname"];
$save_spouse_info->mothersfullname = $_POST["mothersfullname"];


$save_spouse_info->saveSpouseInfoSheet();
?>