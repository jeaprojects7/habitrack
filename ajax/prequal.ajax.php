<?php
require_once __DIR__ . '/../models/connection.php';
require_once __DIR__ . '/../controllers/prequal.controller.php';

$connection = new Connection();
$db = $connection->connect();
$controller = new PrequalController($db);
$controller->handleRequest();
