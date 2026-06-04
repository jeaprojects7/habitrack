<?php
require_once "connection.php";
class PrequalModel{

public function getPreQualByStatus($status, $agentId)
{
    $db = new Connection();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        SELECT
            pq.id,
            pq.prequalID,
            pq.clientID,
            pq.agentID,
            pq.propertyID,
            pq.prequalStatus,
            pq.submissionDate,
            c.clientFName,
            c.clientLName,
            p.propertyName,
            p.propertyType,
            p.propertyCity,
            p.propertyBrgy
        FROM prequal pq
        LEFT JOIN client c ON pq.clientID = c.clientID
        LEFT JOIN properties p ON pq.propertyID = p.propertyID
        WHERE pq.prequalStatus = :status
        AND pq.agentID = :agentId
        ORDER BY pq.submissionDate DESC, pq.id DESC
    ");

    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':agentId', $agentId);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPreQualDetails($prequalID, $agentId)
{
    $db = new Connection();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        SELECT
            pq.prequalID,
            pq.clientID,
            pq.agentID,
            pq.propertyID,
            pq.financingID,
            pq.coOwnerID,
            pq.clientCivilStatus,
            pq.clientEmpStatus,
            pq.clientMonthlyIncome,
            pq.prequalStatus,
            pq.submissionDate,

            c.clientFName,
            c.clientLName,
            c.clientMName,
            c.clientSuffix,
            c.clientEmail,
            c.clientPhoneNum,

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

            cp.coOwnerRelationship,
            cp.coOwnerFName,
            cp.coOwnerMName,
            cp.coOwnerLName,
            cp.coOwnerSuffix,
            cp.coOwnerEmail,
            cp.coOwnerPhoneNum,
            cp.coOwnerEmpStatus,
            cp.coOwnerMonthlyIncome
        FROM prequal pq
        LEFT JOIN client c ON pq.clientID = c.clientID
        LEFT JOIN properties p ON pq.propertyID = p.propertyID
        LEFT JOIN financing f ON pq.financingID = f.financingID
        LEFT JOIN clientcoprequal cp ON pq.coOwnerID = cp.coOwnerID
        WHERE pq.prequalID = :prequalID
        AND pq.agentID = :agentId
        LIMIT 1
    ");

    $stmt->bindParam(':prequalID', $prequalID);
    $stmt->bindParam(':agentId', $agentId);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updatePreQualStatus($prequalID, $agentId, $status)
{
    $allowedStatuses = ['Approved', 'Rejected'];
    if (!in_array($status, $allowedStatuses, true)) {
        return false;
    }

    $db = new Connection();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        UPDATE prequal
        SET prequalStatus = :status
        WHERE prequalID = :prequalID
        AND agentID = :agentId
        AND prequalStatus = 'Pending'
    ");

    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':prequalID', $prequalID);
    $stmt->bindParam(':agentId', $agentId);

    return $stmt->execute() && $stmt->rowCount() > 0;
}


}


?>
