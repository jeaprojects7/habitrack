<?php
require_once "../controllers/clientsignup.controller.php";
require_once "../models/clientsignup.model.php";

class Client{
  public $firstname;
  public $lastname;
  public $middlename;
  public $suffix;


  public $email;
  public $phonenumber;
  public $password;




  public function saveClientDetails(){
  	$firstname = $this->firstname;
  	$lastname = $this->lastname;
  	$middlename = $this->middlename;
    $suffix = $this->suffix;
  	$email = $this->email;
  	$phonenumber = $this->phonenumber;
  	$password = $this->password;


    $data = array("firstname"=>$firstname,
    	            "lastname"=>$lastname,
                  "middlename"=>$middlename,
                  "suffix"=>$suffix,
                  "email"=>$email,
                  "phonenumber"=>$phonenumber,
                  "password"=>$password); ///
   
    $answer = (new ControllerClient)->ctrSaveClient($data);
    echo $answer;

  }
}

$save_client = new Client();

$save_client -> firstname = $_POST["firstname"];
$save_client -> lastname = $_POST["lastname"];
$save_client -> middlename = $_POST["middlename"];
$save_client -> suffix = $_POST["suffix"];
$save_client -> email = $_POST["email"];
$save_client -> phonenumber = $_POST["phonenumber"];
// $save_client -> password = $_POST["password"];
$save_client -> password = password_hash($_POST["password"], PASSWORD_BCRYPT);/* added 52226 */



$save_client -> saveClientDetails();