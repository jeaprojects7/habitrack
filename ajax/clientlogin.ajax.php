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
    $_SESSION["role"] = "Client"; /* added 51726 */
    $_SESSION["email"] = $answer["clientEmail"]; /* added 52126 */
    $_SESSION["fname"] = $answer["clientFName"]; /* added 52126 */


    echo "success";
} else {
    echo "error";
}
exit();