<?php
session_start();

require_once "../models/spouse.model.php";



$prequalID = $_POST["prequalID"];

$answer = (new ModelSpouse)->mdlGetSpouseInfo($prequalID);

if (!empty($answer)) { 
    echo json_encode($answer);
} else {
    echo json_encode([]);
}
exit();





