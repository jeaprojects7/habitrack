<?php

require_once __DIR__ . '/../models/reservations.model.php';

class ReservationController {

    public static function ctrGetReservations() {
        return ModelReservation::mdlGetReservations();
    }

    public static function ctrGetReservationById($id) {
        return ModelReservation::mdlGetReservationById($id);
    }

}