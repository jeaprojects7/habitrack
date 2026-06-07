<?php

require_once "connection.php";

class SiteVisitModel {

    public function getSiteVisitsByAgent($agentID) {
        $stmt = (new Connection)->connect()->prepare("
            SELECT
                sv.siteVisitID,
                sv.siteVisitDate,
                sv.siteVisitTime,
                sv.siteVisitStatus,

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
            FROM sitevisit sv
            JOIN client c ON sv.clientID = c.clientID
            JOIN properties p ON sv.propertyID = p.propertyID
            WHERE sv.agentID = :agentID
            ORDER BY sv.siteVisitDate DESC, sv.siteVisitID DESC
        ");

        $stmt->bindParam(":agentID", $agentID, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSiteVisitDetails($siteVisitID) {
        $stmt = (new Connection)->connect()->prepare("
            SELECT
                sv.siteVisitID,
                sv.siteVisitDate,
                sv.siteVisitTime,
                sv.siteVisitStatus,

                c.clientID,
                c.clientFName,
                c.clientLName,
                c.clientEmail,
                c.clientPhoneNum,

                p.propertyID,
                p.propertyName,
                p.propertyType,
                p.propertyCity,
                p.propertyBrgy,
                p.propertyPrice,
                p.propertyLotArea,
                p.houseFloorArea
            FROM sitevisit sv
            JOIN client c ON sv.clientID = c.clientID
            JOIN properties p ON sv.propertyID = p.propertyID
            WHERE sv.siteVisitID = :siteVisitID
            LIMIT 1
        ");

        $stmt->bindParam(":siteVisitID", $siteVisitID, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markSiteVisitDone($siteVisitID) {
        $stmt = (new Connection)->connect()->prepare("
            UPDATE sitevisit
            SET siteVisitStatus = 'Completed'
            WHERE siteVisitID = :siteVisitID
            AND siteVisitStatus = 'Booked'
        ");

        $stmt->bindParam(":siteVisitID", $siteVisitID, PDO::PARAM_STR);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }
}
