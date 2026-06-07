<?php

require_once "connection.php";

class ModelReservation {

    ///Cards
    static public function mdlGetReservations() {
        $stmt = (new Connection)->connect()->prepare("
            SELECT
            r.reservationID,
            r.reserveDate,
            r.reserveTime,
            r.reserveStatus,

            pq.prequalID,
            pq.prequalStatus,

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

        JOIN prequal pq
            ON r.prequalID = pq.prequalID

        JOIN client c
            ON pq.clientID = c.clientID

        JOIN properties p
            ON pq.propertyID = p.propertyID

        ORDER BY r.reserveDate DESC;
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
        r.clientValidID,

        pq.prequalID,
        pq.prequalStatus,
        pq.submissionDate,
        COALESCE(cc.coOwnerID, pq.coOwnerID) AS coOwnerID,

        cc.coOwnerFName,
        cc.coOwnerMName,
        cc.coOwnerLName,
        cc.coOwnerEmail,
        cc.coOwnerPhoneNum,
        cc.coOwnerRelationship,
        pq.agentID,
        a.agentFName,
        a.agentMName,
        a.agentLName,

        p.propertyID,
        p.propertyName,
        p.propertyType,
        p.propertyPrice,
        p.propertyLotArea,
        p.houseFloorArea,
        p.propertyCity,
        p.propertyBrgy,

        c.clientID,
        c.clientFName,
        c.clientLName,

        ci.clientCISID,

        pi.imagePath

        FROM reservations r

        LEFT JOIN client_information ci
            ON r.prequalID = ci.prequalID

        JOIN prequal pq
            ON r.prequalID = pq.prequalID

        JOIN client c
            ON pq.clientID = c.clientID

        LEFT JOIN clientcoprequal cc
            ON pq.prequalID = cc.prequalID

        LEFT JOIN agent a
            ON pq.agentID = a.agentID

        JOIN properties p
            ON pq.propertyID = p.propertyID

        LEFT JOIN property_images pi
            ON p.propertyID = pi.propertyID
            AND pi.imageOrder = 0
            AND pi.is_deleted = 0

        WHERE r.reservationID = :id

        LIMIT 1;
    ");

        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlGetReservationsByClient($clientID) {
        $stmt = (new Connection)->connect()->prepare("
            SELECT
                r.reservationID,
                r.reserveDate,
                r.reserveTime,
                r.reserveStatus,
                r.clientValidID,

                pq.prequalID,
                pq.prequalStatus,
                cc.coOwnerID,
                cc.coOwnerRelationship,

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

            JOIN prequal pq
                ON r.prequalID = pq.prequalID

            JOIN client c
                ON pq.clientID = c.clientID

            JOIN properties p
                ON pq.propertyID = p.propertyID

            LEFT JOIN clientcoprequal cc
                ON r.prequalID = cc.prequalID

            WHERE c.clientID = :clientID

            ORDER BY r.reserveDate DESC
        ");
        $stmt->bindParam(':clientID', $clientID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function mdlSaveValidID($reservationID, $imagePath)
    {
            $stmt = (new Connection)->connect()->prepare("
            UPDATE reservations
            SET clientValidID = :clientValidID
            WHERE reservationID = :reservationID
        ");

        $stmt->bindParam(":clientValidID", $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        return "error";
    }

    public static function mdlApproveReservation($reservationID)
    {
        $stmt = (new Connection)->connect()->prepare("
            UPDATE reservations
            SET
                reserveStatus = 'Reserved',
                reserveDate = :reserveDate,
                reserveTime = :reserveTime
            WHERE reservationID = :reservationID
        ");

        $reserveDate = date('Y-m-d');
        $reserveTime = date('H:i:s');

        $stmt->bindParam(":reserveDate", $reserveDate, PDO::PARAM_STR);
        $stmt->bindParam(":reserveTime", $reserveTime, PDO::PARAM_STR);
        $stmt->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        return "error";
    }
}