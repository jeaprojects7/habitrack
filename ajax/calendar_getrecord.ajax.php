<?php
// ajax/calendar_getrecord.ajax.php
// Entry point for calendar AJAX actions (e.g. ?action=getAgents)

require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../controllers/calendar.controller.php';

// Create PDO connection using existing Connection class
$conn = new Connection();
$db   = $conn->connect();

$controller = new AgentController($db);
$controller->handleRequest();