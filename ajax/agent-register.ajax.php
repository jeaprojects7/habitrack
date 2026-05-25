<?php
require_once "../controllers/agentregister.controller.php";
require_once "../models/agentregister.model.php";

 class addAgent{
  public $trans_type; 
  public $agentID;
  public $agentFName;
  public $agentMName;
  public $agentLName;
  public $agentSuffix;
  public $agentEmail;
  public $agentPhoneNum; 
  public $agentAddress;
  public $agentSoldUnits;
  public $agentFB;
  public $agentGender;
  public $agentBirthdate;
  public $agentPass;
  public $agentPic;


  public function saveAgent(){
    $trans_type = $this->trans_type;
    $agentID = $this->agentID;
    //$agentPass = $this->agentPass;
  	$agentFName = $this->agentFName;
  	$agentMName = $this->agentMName;
    $agentLName = $this->agentLName;
  	$agentSuffix = $this->agentSuffix;
    $agentGender = $this->agentGender;
    $agentBirthdate = $this->agentBirthdate;
    $agentSoldUnits = $this->agentSoldUnits;
    $agentAddress = $this->agentAddress;
    $agentPhoneNum = $this->agentPhoneNum;
    $agentEmail = $this->agentEmail;
    $agentFB = $this->agentFB;
    $agentPic = $this->agentPic;
   


    $data = array("agentID"=>$agentID,
                  "agentFName"=>$agentFName,
                  "agentMName"=>$agentMName,
                  "agentLName"=>$agentLName,
                  "agentSuffix"=>$agentSuffix,
                  "agentGender"=>$agentGender,
                  "agentBirthdate"=>$agentBirthdate,
                  "agentSoldUnits"=>$agentSoldUnits,
                  "agentAddress"=>$agentAddress,
                  "agentPhoneNum"=>$agentPhoneNum,
                  "agentEmail"=>$agentEmail,
                  "agentFB"=>$agentFB,
                  "agentPic"=>$agentPic,);

    if ($trans_type == 'New'){
      $answer = (new ControllerAddAgent)->ctrAddAgent($data);
      echo $answer;
     }else{
      $answer = (new ControllerAddAgent)->ctrUpdateAgent($data);
      echo $answer;
    } 

   }
  }
 

$add_agent = new addAgent();

$add_agent -> trans_type = $_POST["trans_type"];
//$save_clinicstaff -> encodedby = !empty($_POST["encodedby"]) ? $_POST["encodedby"] : 'SYSTEM';
$add_agent -> agentID = $_POST["agentID"];
$add_agent -> agentFName = $_POST["agentFName"];
$add_agent -> agentMName = $_POST["agentMName"];
$add_agent -> agentLName = $_POST["agentLName"];
$add_agent -> agentSuffix = $_POST["agentSuffix"];
$add_agent -> agentGender = $_POST["agentGender"];
$add_agent -> agentBirthdate = $_POST["agentBirthdate"];
$add_agent -> agentEmail = $_POST["agentEmail"];
$add_agent -> agentPhoneNum = $_POST["agentPhoneNum"];
$add_agent -> agentSoldUnits = $_POST["agentSoldUnits"];
$add_agent -> agentFB = $_POST["agentFB"];
$add_agent -> agentAddress = $_POST["agentAddress"];
$add_agent -> agentPic = null;

if (isset($_FILES["agentPic"]) && $_FILES["agentPic"]["error"] === UPLOAD_ERR_OK) {
  $allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
  $mimeType = mime_content_type($_FILES["agentPic"]["tmp_name"]);

  if (isset($allowedTypes[$mimeType])) {
    $uploadDir = __DIR__ . "/../uploads/agents/";

    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $fileName = "agent_" . date("YmdHis") . "_" . bin2hex(random_bytes(4)) . "." . $allowedTypes[$mimeType];
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["agentPic"]["tmp_name"], $destination)) {
      $add_agent -> agentPic = "/uploads/agents/" . $fileName;
    }
  }
}

$add_agent -> saveAgent();
 

