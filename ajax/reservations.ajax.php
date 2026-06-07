<?php

require_once __DIR__ . '/../controllers/reservations.controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'approve') {
        $reservationID = $_POST['reservationID'] ?? '';

        if (empty($reservationID)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing reservation ID']);
            exit;
        }

        $result = ReservationController::ctrApproveReservation($reservationID);

        if ($result === 'ok') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Reservation approved successfully',
                'reserveDate' => date('Y-m-d'),
                'reserveTime' => date('H:i:s')
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve reservation']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
