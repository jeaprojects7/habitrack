<?php

require_once "connection.php";

class ModelReservation {

    static public function mdlGetReservations() {
        $stmt = (new Connection)->connect()->prepare("
            SELECT 
                r.reservationID,
                r.reserveDate,
                r.reserveTime,
                r.reserveStatus,
                c.clientID,
                c.clientFName,
                c.clientLName,
                p.propertyID,
                p.propertyName,
                p.propertyType,
                p.propertyCity,
                p.propertyBrgy,
                p.propertyPrice,
                p.propertyLotArea
            FROM reservations r
            JOIN client c ON r.clientID = c.clientID
            JOIN properties p ON r.propertyID = p.propertyID
            ORDER BY r.reserveDate DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlGetReservationById($id) {

        $stmt = (new Connection)->connect()->prepare("
        SELECT 
            r.reservationID,
            r.reserveDate,
            r.reserveTime,
            r.reserveStatus,

            p.propertyID,
            p.propertyName,
            p.propertyType,
            p.propertyPrice,
            p.propertyLotArea,
            p.houseFloorArea,
            p.propertyCity,
            p.propertyBrgy,

            pi.imagePath

        FROM reservations r

        JOIN properties p 
            ON r.propertyID = p.propertyID

        LEFT JOIN property_images pi
            ON p.propertyID = pi.propertyID
            AND pi.imageOrder = 0
            AND pi.is_deleted = 0

        WHERE r.reservationID = :id

        LIMIT 1
    ");

        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}