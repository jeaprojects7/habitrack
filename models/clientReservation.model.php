<?php

require_once "connection.php";

class ClientReservationModel {

    public function getReservationsByStatus($status) {
        $whereStatus = '';
        if ($status !== 'All') {
            $whereStatus = "WHERE r.reserveStatus = :status";
        }

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
            JOIN prequal pq ON r.prequalID = pq.prequalID
            JOIN client c ON pq.clientID = c.clientID
            JOIN properties p ON pq.propertyID = p.propertyID
            $whereStatus
            ORDER BY r.reserveDate DESC, r.reservationID DESC
        ");

        if ($status !== 'All') {
            $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationDetails($reservationID) {
        $stmt = (new Connection)->connect()->prepare("
            SELECT
                r.reservationID,
                r.reserveDate,
                r.reserveTime,
                r.reserveStatus,

                pq.prequalID,
                pq.clientCivilStatus,
                pq.clientEmpStatus,
                pq.clientMonthlyIncome,
                pq.prequalStatus,
                pq.submissionDate,

                c.clientID,
                c.clientFName,
                c.clientLName,
                c.clientMName,
                c.clientSuffix,
                c.clientEmail,
                c.clientPhoneNum,

                p.propertyID,
                p.propertyName,
                p.propertyType,
                p.propertyStatus,
                p.propertyCity,
                p.propertyBrgy,
                p.propertyPrice,
                p.propertyLotArea,
                p.houseFloorArea,

                f.financingType,
                f.contributionStartDate,
                f.currentLoan,
                f.bankName,
                f.existingHouseLoan,
                f.cancelledHouseLoan,
                f.financingStatus,

                cp.coOwnerID,
                cp.coOwnerRelationship,
                cp.coOwnerFName,
                cp.coOwnerMName,
                cp.coOwnerLName,
                cp.coOwnerSuffix,
                cp.coOwnerEmail,
                cp.coOwnerPhoneNum,
                cp.coOwnerEmpStatus,
                cp.coOwnerMonthlyIncome,

                ci.clientCISID,
                ci.spouseCISID,
                ci.clientCitizenship,
                ci.clientGender,
                ci.clientReligion,
                ci.clientBirthdate,
                ci.clientPlaceOfBirth,
                ci.clientAddress,
                ci.clientProvinceAddress,
                ci.clientTaxIdenNum,
                ci.clientSSS_GSISnumber,
                ci.clientDependentsElem,
                ci.clientDependentsHS,
                ci.clientDependentsC,
                ci.clientDependentsNotStud,
                ci.clientSourceOfIncome,
                ci.clientEmployerBusinessName,
                ci.clientNatureOfBusiness,
                ci.clientBusinessAddress,
                ci.clientPosition,
                ci.clientDepartment,
                ci.clientDateHired,
                ci.clientAppointment,
                ci.clientPlaceOfWork,
                ci.clientEmpPhoneNum,
                ci.clientEmployerEmail,
                ci.clientFathersName,
                ci.clientMothersMaidenName,
                ci.clientParentsAddress,
                ci.clientParentsPhoneNum,
                ci.clientSpaName,
                ci.clientSpaAddress,
                ci.clientSpaPhoneNum
            FROM reservations r
            JOIN prequal pq ON r.prequalID = pq.prequalID
            JOIN client c ON pq.clientID = c.clientID
            JOIN properties p ON pq.propertyID = p.propertyID
            LEFT JOIN financing f ON pq.financingID = f.financingID
            LEFT JOIN clientcoprequal cp ON pq.coOwnerID = cp.coOwnerID
            LEFT JOIN client_information ci ON ci.prequalID = pq.prequalID
            WHERE r.reservationID = :reservationID
            LIMIT 1
        ");

        $stmt->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

  /*   public function updateReservationStatus($reservationID, $status) {
        $allowedStatuses = ['Approved', 'Rejected'];
        if (!in_array($status, $allowedStatuses, true)) {
            return false;
        }

        $stmt = (new Connection)->connect()->prepare("
            UPDATE reservations
            SET reserveStatus = :status
            WHERE reservationID = :reservationID
            AND reserveStatus = 'Pending'
        ");

        $stmt->bindParam(":status", $status, PDO::PARAM_STR);
        $stmt->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);

        return $stmt->execute() && $stmt->rowCount() > 0;
    } */
  public function updateReservationStatus($reservationID, $status) {
    $allowedStatuses = ['Approved', 'Rejected'];
    if (!in_array($status, $allowedStatuses, true)) {
        return false;
    }

    $db = (new Connection)->connect();

    // 1. Update reservation status
    $stmt = $db->prepare("
        UPDATE reservations
        SET reserveStatus = :status
        WHERE reservationID = :reservationID
        AND reserveStatus = 'Pending'
    ");

    $stmt->bindParam(":status", $status, PDO::PARAM_STR);
    $stmt->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);

    $success = $stmt->execute();

    if (!$success || $stmt->rowCount() === 0) {
        return false;
    }

    // 2. If Approved → get property via prequal
    if ($status === 'Approved') {

        $stmt2 = $db->prepare("
            SELECT pq.propertyID
            FROM reservations r
            JOIN prequal pq ON r.prequalID = pq.prequalID
            WHERE r.reservationID = :reservationID
            LIMIT 1
        ");

        $stmt2->bindParam(":reservationID", $reservationID, PDO::PARAM_STR);
        $stmt2->execute();

        $row = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $stmt3 = $db->prepare("
                UPDATE properties
                SET propertyStatus = 'Reserved'
                WHERE propertyID = :propertyID
            ");

            $stmt3->bindParam(":propertyID", $row['propertyID'], PDO::PARAM_STR);
            $stmt3->execute();
        }
    }

    return true;
}
}
