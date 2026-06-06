<?php
session_start();

require_once "../controllers/coowner.controller.php";
require_once "../models/coowner.model.php";

class CoOwnerInfoSheet {

    // ===== PAGE 1 =====
    public $coownerISID;
    public $coOwnerID;
    public $gender;
    public $birthdate;

    public $civilstatus;
    public $citizenship;
    public $religion;
    public $placeofbirth;

    // ===== PAGE 2 =====
    public $address;
    public $prov_address;

    // ===== PAGE 3 =====
    public $tin;
    public $sss_gsis;

    public $elem;
    public $highschool;
    public $college;
    public $notstudying;

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

    public function saveCoOwnerInfoSheet() {

        $data = array(

            // session (change if your session key differs)
            // "coOwnerID" => $_SESSION["coOwnerID"] ?? null,
            "coownerISID" => $this->coownerISID,

            // ===== PAGE 1 =====
            "coOwnerID" => $this->coOwnerID,
            "coGender" => $this->gender,
            "coBirthdate" => $this->birthdate,

            "coCivilStatus" => $this->civilstatus,
            "coCitizenship" => $this->citizenship,
            "coReligion" => $this->religion,
            "coPlaceOfBirth" => $this->placeofbirth,

            // ===== PAGE 2 =====
            "coAddress" => $this->address,
            "coProvinceAddress" => $this->prov_address,

            // ===== PAGE 3 =====
            "coTaxIdenNum" => $this->tin,
            "coSSS_GSISnumber" => $this->sss_gsis,

            "coDependentsElem" => $this->elem,
            "coDependentsHS" => $this->highschool,
            "coDependentsC" => $this->college,
            "coDependentsNotStud" => $this->notstudying,

            // ===== PAGE 4 =====
            "coSourceOfIncome" => $this->sourceofincome,
            "coEmployerBusinessName" => $this->empbusinessname,
            "coNatureOfBusiness" => $this->natureofbusiness,
            "coBusinessAddress" => $this->businessaddress,

            "coAppointment" => $this->appointment,
            "coPlaceOfWork" => $this->placeofwork,
            "coDateHired" => $this->datehired,

            "coPosition" => $this->position,
            "coDepartment" => $this->department,
            "coEmpPhoneNum" => $this->employerphonenumber,
            "coEmployerEmail" => $this->employeremail,

            // ===== PAGE 5 =====
            "coParentsAddress" => $this->parentsaddress,
            "coParentsPhoneNum" => $this->parentsphonenumber,

            "coFathersName" => $this->fathersfullname,
            "coMothersMaidenName" => $this->mothersfullname
        );

        $answer = (new ControllerCoOwner)->ctrSaveCoOwnerInfo($data);

        echo $answer;
    }
}

$save = new CoOwnerInfoSheet();

// ===== PAGE 1 =====
$save->coownerISID = $_POST["coownerISID"] ?? null;
$save->coOwnerID = $_POST["coOwnerID"] ?? null;
$save->gender = $_POST["gender"] ?? null;

// date conversion
$date = DateTime::createFromFormat('m-d-Y', $_POST["birthdate"] ?? '');
$save->birthdate = $date ? $date->format('Y-m-d') : null;

$save->civilstatus = $_POST["civilstatus"] ?? null;
$save->citizenship = $_POST["citizenship"] ?? null;
$save->religion = $_POST["religion"] ?? null;
$save->placeofbirth = $_POST["placeofbirth"] ?? null;

// ===== PAGE 2 =====
$save->address = $_POST["address"] ?? null;
$save->prov_address = $_POST["prov_address"] ?? null;

// ===== PAGE 3 =====
$save->tin = $_POST["tin"] ?? null;
$save->sss_gsis = $_POST["sss_gsis"] ?? null;

$save->elem = $_POST["elem"] ?? null;
$save->highschool = $_POST["highschool"] ?? null;
$save->college = $_POST["college"] ?? null;
$save->notstudying = $_POST["notstudying"] ?? null;

// ===== PAGE 4 =====
$save->sourceofincome = $_POST["sourceofincome"] ?? null;
$save->empbusinessname = $_POST["empbusinessname"] ?? null;
$save->natureofbusiness = $_POST["natureofbusiness"] ?? null;
$save->businessaddress = $_POST["businessaddress"] ?? null;

$save->appointment = $_POST["appointment"] ?? null;
$save->placeofwork = $_POST["placeofwork"] ?? null;

// date conversion
$date2 = DateTime::createFromFormat('m-d-Y', $_POST["datehired"] ?? '');
$save->datehired = $date2 ? $date2->format('Y-m-d') : null;

$save->position = $_POST["position"] ?? null;
$save->department = $_POST["department"] ?? null;
$save->employerphonenumber = $_POST["employerphonenumber"] ?? null;
$save->employeremail = $_POST["employeremail"] ?? null;

// ===== PAGE 5 =====
$save->parentsaddress = $_POST["parentsaddress"] ?? null;
$save->parentsphonenumber = $_POST["parentsphonenumber"] ?? null;

$save->fathersfullname = $_POST["fathersfullname"] ?? null;
$save->mothersfullname = $_POST["mothersfullname"] ?? null;

$save->saveCoOwnerInfoSheet();
?>