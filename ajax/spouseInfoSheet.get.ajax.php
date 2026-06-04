<?php
session_start();

require_once "../models/clientsignup.model.php";
require_once "../controllers/clientsignup.controller.php";

$clientID = $_SESSION["clientID"];

$answer = (new ModelClient)->mdlGetSpouseInfo('spouse', "spouseID", $spouseID);

if (!empty($answer)) { 
    echo json_encode($answer);
} else {
    echo json_encode([]);
}
exit();





