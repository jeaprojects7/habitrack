<?php
require_once "../controllers/adminsignup.controller.php";
require_once "../models/adminsignup.model.php";

class Admin{
  public $firstname;
  public $lastname;
  public $middlename;
  public $suffix;


  public $email;
  public $phonenumber;
  public $password;




  public function saveAdminDetails(){
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
   
    $answer = (new ControllerAdmin)->ctrSaveAdmin($data);
    echo $answer;

  }
}

$save_admin = new Admin();

$save_admin -> firstname = $_POST["firstname"];
$save_admin -> lastname = $_POST["lastname"];
$save_admin -> middlename = $_POST["middlename"];
$save_admin -> suffix = $_POST["suffix"];
$save_admin -> email = $_POST["email"];
$save_admin -> phonenumber = $_POST["phonenumber"];
$save_admin -> password = $_POST["password"];



$save_admin -> saveAdminDetails();