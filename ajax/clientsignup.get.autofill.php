<?php

session_start();

require_once "../controllers/clientsignup.controller.php";
require_once "../models/clientsignup.model.php";

if(!isset($_SESSION["clientID"])){

    echo json_encode([
        "status" => "error"
    ]);

    exit;
}

$clientID = $_SESSION["clientID"];

$data = ControllerClient::ctrGetLatestClientInfoByClientID($clientID);

if($data){

    echo json_encode([
        "status" => "found",
        "data" => $data
    ]);

}else{

    echo json_encode([
        "status" => "not_found"
    ]);

}