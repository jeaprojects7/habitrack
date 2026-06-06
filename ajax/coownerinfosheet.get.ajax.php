<?php
session_start();

require_once __DIR__ . '/../controllers/reservations.controller.php';
require_once __DIR__ . '/../controllers/coowner.controller.php';

header('Content-Type: application/json');

$reservationID = $_GET['id'] ?? null;

if (!$reservationID) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing reservationID"
    ]);
    exit;
}

// Get reservation
$res = ReservationController::ctrGetReservationById($reservationID);

if (!$res) {
    echo json_encode([
        "status" => "error",
        "message" => "Reservation not found"
    ]);
    exit;
}

// Get coOwnerID from reservation
$coOwnerID = $res['coOwnerID'] ?? null;

if (!$coOwnerID) {
    echo json_encode([
        "status" => "error",
        "message" => "No coOwnerID in reservation"
    ]);
    exit;
}

// Get co-owner data
$coOwner = ControllerCoOwner::ctrGetCoOwnerByID($coOwnerID);

if (!$coOwner) {
    echo json_encode([
        "status" => "error",
        "message" => "Co-owner not found"
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "data" => $coOwner
]);