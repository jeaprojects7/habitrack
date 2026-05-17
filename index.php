<?php	
require_once "controllers/template.controller.php";

require_once "controllers/userrights.controller.php";
require_once "controllers/sidebar.controller.php";
require_once "controllers/clientsignup.controller.php";

$template = new ControllerTemplate();
$template -> ctrTemplate();