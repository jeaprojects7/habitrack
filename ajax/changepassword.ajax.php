<?php
session_start();

require_once "../controllers/clientsignup.controller.php";
require_once "../models/clientsignup.model.php";

class ChangePassword{

    public $oldpassword;
    public $newpassword;

    public function changeClientPassword(){

        $oldpassword = $this->oldpassword;
        $newpassword = $this->newpassword;

        try{

            $answer = (new ControllerClient)->ctrClientChangePassword($oldpassword, $newpassword);


        }catch(Exception $e){

            echo $e->getMessage();

        }

    }

}

$change_password = new ChangePassword();

$change_password->oldpassword = $_POST["oldpassword"];
$change_password->newpassword = $_POST["newpassword"];

$change_password->changeClientPassword();
?>