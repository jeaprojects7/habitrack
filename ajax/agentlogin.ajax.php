<?php

session_start();

require_once "../models/connection.php";
require_once "../models/agent.model.php";

$email = $_POST["agentLoginEmail"];
$pass = $_POST["agentLoginPass"];

$answer = (new ModelAgent)->mdlGetAgentCredentials('agent', 'agentEmail', $email);

if (!empty($answer) && $answer["agentEmail"] == $email && $answer["agentPass"] == $pass) {

    $_SESSION["loggedIn"] = "ok";
    $_SESSION["agentID"] = $answer["agentID"];

    echo "success";
} else {
    echo "error";
}
exit();