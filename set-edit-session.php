<?php
session_start();

/*
Expected:
type = property | agent | user | etc
id   = the record ID
*/

$type = $_GET['type'] ?? null;
$id   = $_GET['id'] ?? null;

if (!$type || !$id) {
    die("Invalid request.");
}

// whitelist allowed edit types (important for security)
$allowedTypes = ['property', 'agent', 'user'];

if (!in_array($type, $allowedTypes, true)) {
    die("Invalid type.");
}

// store dynamically in session
$_SESSION[$type . 'ID'] = $id;

// redirect back to clean route
header("Location:edit-$type");
exit;