<?php

session_start();

require_once "../models/connection.php";
require_once "../models/admin.model.php";

$email = $_POST["adminLoginEmail"];
$pass = $_POST["adminLoginPass"];

$answer = (new ModelAdmin)->mdlGetAdminCredentials('admin', 'adminEmail', $email);

if (!empty($answer) && $answer["adminEmail"] == $email && password_verify($pass, $answer["adminPass"])) { /* added 060726 */

    $_SESSION["loggedIn"] = "ok";
    $_SESSION["adminID"] = $answer["adminID"];
    $_SESSION["role"] = "Admin"; /* added 51726 */
    $_SESSION["email"] = $answer["adminEmail"]; /* added 52126 */
    $_SESSION["fname"] = $answer["adminFName"]; /* added 52126 */


    echo "success";
} else {
    echo "error";
}
exit();