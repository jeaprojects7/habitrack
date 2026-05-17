<?php

session_start();

require_once "../models/connection.php";
require_once "../models/admin.model.php";

$email = $_POST["adminLoginEmail"];
$pass = $_POST["adminLoginPass"];

$answer = (new ModelAdmin)->mdlGetAdminCredentials('admin', 'adminEmail', $email);

if (!empty($answer) && $answer["adminEmail"] == $email && $answer["adminPass"] == $pass) {

    $_SESSION["loggedIn"] = "ok";
    $_SESSION["adminID"] = $answer["adminID"];
    $_SESSION["role"] = "admin"; /* added 51726 */

    echo "success";
} else {
    echo "error";
}
exit();