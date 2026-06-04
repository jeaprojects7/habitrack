<?php


$role = $_SESSION['role'] ?? null;



if (!$role) {
    header("Location: login");
    exit;
}

switch ($role) {

    case 'Admin':
        require 'views/pages/profile/adminProfile.php';
        break;

    case 'Agent':
        require 'agent/agentuserProfile.php';
        break;

    case 'Client':
        require 'views/pages/profile/clientProfile.php';
        break;

    default:
        die("Invalid role");
}
?>