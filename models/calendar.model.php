<?php
// models/AgentModel.php

class AgentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all agents with their full name parts.
     * Returns: id, agentID, full name fields.
     */
    public function getAllAgents() {
        $sql = "SELECT 
                    id,
                    agentID,
                    agentFName,
                    agentMName,
                    agentLName,
                    agentSuffix
                FROM agent
                ORDER BY agentLName ASC, agentFName ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single agent by ID.
     */
    public function getAgentById($id) {
        $sql = "SELECT 
                    id,
                    agentID,
                    agentFName,
                    agentMName,
                    agentLName,
                    agentSuffix
                FROM agent
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Build a formatted full name from agent row.
     * Format: First Middle Last Suffix
     */
    public static function buildFullName(array $agent): string {
        $parts = [
            trim($agent['agentFName'] ?? ''),
            trim($agent['agentMName'] ?? ''),
            trim($agent['agentLName'] ?? ''),
            trim($agent['agentSuffix'] ?? ''),
        ];

        // Filter out empty parts
        return implode(' ', array_filter($parts));
    }

    /**
     * Get all properties with id, propertyID and propertyName.
     * Returns: id, propertyID, propertyName
     */
    public function getAllProperties() {
        $sql = "SELECT 
                    id,
                    propertyID,
                    propertyName
                FROM properties
                ORDER BY propertyName ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single property by ID.
     */
    public function getPropertyById($id) {
        $sql = "SELECT 
                    id,
                    propertyID,
                    propertyName
                FROM properties
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check whether a given date is already booked.
     */
    public function isDateBooked($siteVisitDate)
    {
        $sql = "SELECT COUNT(*) AS count FROM sitevisit WHERE siteVisitDate = :siteVisitDate";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':siteVisitDate', $siteVisitDate);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($row['count']);
    }

    /**
     * Return all booked dates for calendar highlighting.
     */
    public function getBookedDates()
    {
        $sql = "SELECT DISTINCT siteVisitDate FROM sitevisit ORDER BY siteVisitDate ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'siteVisitDate');
    }

    public function getBookedVisitDetails()
    {
        $sql = "SELECT siteVisitDate, siteVisitTime FROM sitevisit WHERE siteVisitStatus = :status ORDER BY siteVisitDate ASC";
        $stmt = $this->db->prepare($sql);
        $status = 'BKD';
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Save a site visit booking.
     * Returns inserted row data on success, or false on failure.
     */
    public function saveSiteVisit($clientID, $agentID, $propertyID, $siteVisitDate, $siteVisitTime)
    {
        $sql = "INSERT INTO sitevisit (siteVisitID, clientID, agentID, propertyID, siteVisitStatus, siteVisitDate, siteVisitTime)
                VALUES (:siteVisitID, :clientID, :agentID, :propertyID, :status, :siteVisitDate, :siteVisitTime)";

        $siteVisitID = 'SV' . str_pad((string)mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $status = 'BKD';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':siteVisitID', $siteVisitID);
        $stmt->bindParam(':clientID', $clientID);
        $stmt->bindParam(':agentID', $agentID);
        $stmt->bindParam(':propertyID', $propertyID);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':siteVisitDate', $siteVisitDate);
        $stmt->bindParam(':siteVisitTime', $siteVisitTime);

        if ($stmt->execute()) {
            return [
                'id' => (int)$this->db->lastInsertId(),
                'siteVisitID' => $siteVisitID,
            ];
        }

        return false;
    }
}
