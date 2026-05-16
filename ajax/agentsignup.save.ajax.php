<?php
require_once "../controllers/agentsignup.controller.php";
require_once "../models/agentsignup.model.php";

class Agent{
  public $firstname;
  public $lastname;
  public $middlename;
  public $suffix;


  public $email;
  public $phonenumber;
  public $password;

  public $gender;
  public $birthdate;
  public $fb;
  public $address;
  public $picture;
  public $firstID;
  public $secondID;
  public $curEmp;
  public $curPos;
  public $prevRealty;
  public $level;
  public $tin;
  public $institution;
  public $degree;
  public $civilStatPic;
  public $diploma;
  public $nbiPic;
  public $resumePic;
  public $torPic;




  public function saveAgentDetails(){
  	$firstname = $this->firstname;
  	$lastname = $this->lastname;
  	$middlename = $this->middlename;
    $suffix = $this->suffix;
  	$email = $this->email;
  	$phonenumber = $this->phonenumber;
  	$password = $this->password;
  	$gender = $this->gender;
  	$birthdate = $this->birthdate;
  	$fb = $this->fb;
  	$address = $this->address;
  	$picture = $this->picture;
  	$firstID = $this->firstID;
  	$secondID = $this->secondID;
  	$curEmp = $this->curEmp;
  	$curPos = $this->curPos;
  	$prevRealty = $this->prevRealty;
  	$tin = $this->tin;
  	$institution = $this->institution;
  	$degree = $this->degree;
  	$civilStatPic = $this->civilStatPic;
  	$diploma = $this->diploma;
  	$nbiPic = $this->nbiPic;
  	$resumePic = $this->resumePic;
  	$torPic = $this->torPic;


    $data = array("firstname"=>$firstname,
    	            "lastname"=>$lastname,
                  "middlename"=>$middlename,
                  "suffix"=>$suffix,
                  "email"=>$email,
                  "phonenumber"=>$phonenumber,
                  "password"=>$password,
                    "gender"=> $gender, 
                    "birthdate"=> $birthdate,
                    "fb"=> $fb,
                    "address"=> $address,
                    "picture"=> $picture,
                    "firstID"=> $firstID,
                    "secondID"=> $secondID,
                    "curEmp"=> $curEmp,
                    "curPos"=> $curPos,
                    "prevRealty"=> $prevRealty,
                    "tin"=> $tin,
                    "institution"=> $institution,
                    "degree"=> $degree,
                    "civilStatPic"=> $civilStatPic,
                    "diploma"=> $diploma,
                    "nbiPic"=> $nbiPic,
                    "resumePic"=> $resumePic,
                    "torPic"=> $torPic
                  ); ///
   
    $answer = (new ControllerAgent)->ctrSaveAgent($data);
    echo $answer;

  }
}

$save_agent = new Agent();

$save_agent -> firstname = $_POST["firstname"];
$save_agent -> lastname = $_POST["lastname"];
$save_agent -> middlename = $_POST["middlename"];
$save_agent -> suffix = $_POST["suffix"];
$save_agent -> email = $_POST["email"];
$save_agent -> phonenumber = $_POST["phonenumber"];
$save_agent -> password = $_POST["password"];
$save_agent -> gender = $_POST["gender"];
$save_agent -> birthdate = $_POST["birthdate"];
$save_agent -> fb = $_POST["fb"];
$save_agent -> address = $_POST["address"];
$save_agent -> picture = $_POST["picture"];
$save_agent -> firstID = $_POST["firstID"];
$save_agent -> secondID = $_POST["secondID"];
$save_agent -> curEmp = $_POST["curEmp"];
$save_agent -> curPos = $_POST["curPos"];
$save_agent -> prevRealty = $_POST["prevRealty"];
$save_agent -> tin = $_POST["tin"];
$save_agent -> institution = $_POST["institution"];
$save_agent -> degree = $_POST["degree"];
$save_agent -> civilStatPic = $_POST["civilStatPic"];
$save_agent -> diploma = $_POST["diploma"];
$save_agent -> nbiPic = $_POST["nbiPic"];
$save_agent -> resumePic = $_POST["resumePic"];
$save_agent -> torPic = $_POST["torPic"];


$save_agent -> saveAgentDetails();
