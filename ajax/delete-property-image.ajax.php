<?php

require_once "../controllers/add-property.controller.php";
require_once "../models/add-property.model.php";

if(isset($_POST["id"])) {

    $id = $_POST["id"];

    $response = ControllerAddProperty::ctrDeletePropertyImage($id);

    echo $response;

}