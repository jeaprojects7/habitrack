<?php

require_once __DIR__ . "/../models/clientReservation.model.php";

class ClientReservationController {

    static public function ctrGetReservations($status) {
        $model = new ClientReservationModel();
        return $model->getReservationsByStatus($status);
    }

    static public function ctrGetSelectedReservation() {
        $reservationID = $_POST["reservation_id"] ?? ($_SESSION["selectedReservationID"] ?? null);

        if (!$reservationID) {
            return null;
        }

        $model = new ClientReservationModel();
        $reservation = $model->getReservationDetails($reservationID);

        if ($reservation) {
            $_SESSION["selectedReservationID"] = $reservation["reservationID"];
        }

        return $reservation ?: null;
    }

    static public function ctrUpdateSelectedReservationStatus() {
        $reservationID = $_POST["reservation_id"] ?? null;
        $action = $_POST["reservation_status_action"] ?? null;

        if (!$reservationID || !$action) {
            return null;
        }

        $status = match ($action) {
            'approve' => 'Approved',
            'reject' => 'Rejected',
            default => null,
        };

        if (!$status) {
            return ['success' => false, 'message' => 'Invalid reservation action.'];
        }

        $model = new ClientReservationModel();
        $updated = $model->updateReservationStatus($reservationID, $status);

        if ($updated) {
            $_SESSION["selectedReservationID"] = $reservationID;
            return ['success' => true, 'message' => "Reservation marked as {$status}."];
        }

        return ['success' => false, 'message' => 'Unable to update this reservation. It may no longer be pending.'];
    }
}
