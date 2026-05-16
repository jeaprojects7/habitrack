<?php

session_start();

require_once "../models/connection.php";
require_once "../models/clientsignup.model.php";

$email = $_POST["clientLoginEmail"];
$pass = $_POST["clientLoginPass"];

$answer = (new ModelClient)->mdlGetClientCredentials('client', 'clientEmail', $email);

if (!empty($answer) && $answer["clientEmail"] == $email && $answer["clientPass"] == $pass) {

    $_SESSION["loggedIn"] = "ok";
    $_SESSION["clientID"] = $answer["clientID"];

    echo "success";
} else {
    echo "error";
}
exit();