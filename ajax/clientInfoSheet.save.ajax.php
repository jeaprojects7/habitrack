<?php
session_start();

require_once "../controllers/clientsignup.controller.php";
require_once "../models/clientsignup.model.php";

class ClientInfoSheet {

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

    // ===== PAGE 6 =====
    // public $spafirstname;
    // public $spamiddlename;
    // public $spalastname;
    // public $spasuffix;

    public $spafullname;
    public $spaaddress;
    public $spaphonenumber;

    public function saveClientInfoSheet() {

        $data = array(
            "clientID" => $_SESSION["clientID"],
            // ===== PAGE 1 =====
            // "clientCitizenship" => $this->civilstatus,
            "clientGender" => $this->gender,
            "clientBirthdate" => $this->birthdate,

            "clientCitizenship" => $this->citizenship,
            "clientReligion" => $this->religion,
            "clientPlaceOfBirth" => $this->placeofbirth,

            // ===== PAGE 2 =====
            "clientAddress" => $this->address,
            "clientProvinceAddress" => $this->prov_address,

            // ===== PAGE 3 =====
            "clientTaxIdenNum" => $this->tin,
            "clientSSS_GSISnumber" => $this->sss_gsis,

            "clientDependentsElem" => $this->elem,
            "clientDependentsHS" => $this->highschool,
            "clientDependentsC" => $this->college,
            "clientDependentsNotStud" => $this->notstudying,

            // ===== PAGE 4 =====
            "clientSourceOfIncome" => $this->sourceofincome,
            "clientEmployerBusinessName" => $this->empbusinessname,
            "clientNatureOfBusiness" => $this->natureofbusiness,
            "clientBusinessAddress" => $this->businessaddress,

            "clientAppointment" => $this->appointment,
            "clientPlaceOfWork" => $this->placeofwork,
            "clientDateHired" => $this->datehired,

            "clientPosition" => $this->position,
            "clientDepartment" => $this->department,
            "clientEmpPhoneNum" => $this->employerphonenumber,
            "clientEmployerEmail" => $this->employeremail,

            // ===== PAGE 5 =====
            "clientParentsAddress" => $this->parentsaddress,
            "clientParentsPhoneNum" => $this->parentsphonenumber,

            "clientFathersName" => $this->fathersfullname,
            "clientMothersMaidenName" => $this->mothersfullname,

            // ===== PAGE 6 =====
            // "spafirstname" => $this->spafirstname,
            // "spamiddlename" => $this->spamiddlename,
            // "spalastname" => $this->spalastname,
            // "spasuffix" => $this->spasuffix,

            "clientSpaName" => $this->spafullname,
            "clientSpaAddress" => $this->spaaddress,
            "clientSpaPhoneNum" => $this->spaphonenumber

        );

        // $answer = (new ClientInfoSheetController)->ctrSaveClientInfo($data);
        $answer = (new ControllerClient)->ctrSaveClientInfo($data);

        echo $answer;
    }
}

$save_client_info = new ClientInfoSheet();

// ===== PAGE 1 =====
// $save_client_info->civilstatus = $_POST["civilstatus"];
$save_client_info->gender = $_POST["gender"];
// $save_client_info->birthdate = $_POST["birthdate"];
$date = DateTime::createFromFormat('m-d-Y', $_POST["birthdate"]);
$save_client_info->birthdate = $date ? $date->format('Y-m-d') : null;

$save_client_info->citizenship = $_POST["citizenship"];
$save_client_info->religion = $_POST["religion"];
$save_client_info->placeofbirth = $_POST["placeofbirth"];

// ===== PAGE 2 =====
$save_client_info->address = $_POST["address"];
$save_client_info->prov_address = $_POST["prov_address"];

// ===== PAGE 3 =====
$save_client_info->tin = $_POST["tin"];
$save_client_info->sss_gsis = $_POST["sss_gsis"];

$save_client_info->elem = $_POST["elem"];
$save_client_info->highschool = $_POST["highschool"];
$save_client_info->college = $_POST["college"];
$save_client_info->notstudying = $_POST["notstudying"];

// ===== PAGE 4 =====
$save_client_info->sourceofincome = $_POST["sourceofincome"];
$save_client_info->empbusinessname = $_POST["empbusinessname"];
$save_client_info->natureofbusiness = $_POST["natureofbusiness"];
$save_client_info->businessaddress = $_POST["businessaddress"];

$save_client_info->appointment = $_POST["appointment"];
$save_client_info->placeofwork = $_POST["placeofwork"];
// $save_client_info->datehired = $_POST["datehired"];
$date = DateTime::createFromFormat('m-d-Y', $_POST["datehired"]);
$save_client_info->datehired = $date ? $date->format('Y-m-d') : null;

$save_client_info->position = $_POST["position"];
$save_client_info->department = $_POST["department"];
$save_client_info->employerphonenumber = $_POST["employerphonenumber"];
$save_client_info->employeremail = $_POST["employeremail"];

// ===== PAGE 5 =====
$save_client_info->parentsaddress = $_POST["parentsaddress"];
$save_client_info->parentsphonenumber = $_POST["parentsphonenumber"];

$save_client_info->fathersfullname = $_POST["fathersfullname"];
$save_client_info->mothersfullname = $_POST["mothersfullname"];

// ===== PAGE 6 =====
// $save_client_info->spafirstname = $_POST["spafirstname"];
// $save_client_info->spamiddlename = $_POST["spamiddlename"];
// $save_client_info->spalastname = $_POST["spalastname"];
// $save_client_info->spasuffix = $_POST["spasuffix"];

$save_client_info->spafullname = $_POST["spafullname"];
$save_client_info->spaaddress = $_POST["spaaddress"];
$save_client_info->spaphonenumber = $_POST["spaphonenumber"];

$save_client_info->saveClientInfoSheet();
?>