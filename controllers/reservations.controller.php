<?php

require_once __DIR__ . '/../models/reservations.model.php';

class ReservationController {

    public static function ctrGetReservations() {
        return ModelReservation::mdlGetReservations();
    }

    public static function ctrGetReservationById($id) {
        return ModelReservation::mdlGetReservationById($id);
    }
    public static function ctrGetReservationsByClient($clientID) {
        return ModelReservation::mdlGetReservationsByClient($clientID);
    }

    public static function ctrSaveValidID($reservationID, $clientValidID)
    {
        return ModelReservation::mdlSaveValidID(
            $reservationID,
            $clientValidID
        );
    }

    public static function ctrApproveReservation($reservationID)
    {
        return ModelReservation::mdlApproveReservation($reservationID);
    }
}