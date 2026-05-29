<?php

class PrequalModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function generateSequentialId($table, $prefix, $pad = 4) {
        $allowedTables = ['prequal', 'financing', 'clientcoprequal'];
        if (!in_array($table, $allowedTables, true)) {
            throw new InvalidArgumentException('Invalid table for ID generation');
        }

        $stmt = $this->db->query("SELECT MAX(id) AS max_id FROM $table");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nextId = ((int) ($result['max_id'] ?? 0)) + 1;
        return $prefix . str_pad((string) $nextId, $pad, '0', STR_PAD_LEFT);
    }

    public function generateId($prefix) {
        $prefixToTable = [
            'PQ' => 'prequal',
            'FN' => 'financing',
            'CP' => 'clientcoprequal'
        ];

        if (!isset($prefixToTable[$prefix])) {
            throw new InvalidArgumentException('Unsupported ID prefix: ' . $prefix);
        }

        return $this->generateSequentialId($prefixToTable[$prefix], $prefix);
    }

    public function saveFinancing($prequalID, $data) {
        $financingID = $this->generateId('FN');

        $sql = "INSERT INTO financing (
                    financingID,
                    prequalID,
                    financingType,
                    contributionStartDate,
                    currentLoan,
                    bankName,
                    existingHouseLoan,
                    cancelledHouseLoan,
                    financingStatus
                ) VALUES (
                    :financingID,
                    :prequalID,
                    :financingType,
                    :contributionStartDate,
                    :currentLoan,
                    :bankName,
                    :existingHouseLoan,
                    :cancelledHouseLoan,
                    :financingStatus
                )";

        $stmt = $this->db->prepare($sql);

        // Use local variables for binding to avoid bindParam reference issues
        $financingType = $data['financing_type'];
        $contributionStartDate = $data['contribution_start_date'];
        $currentLoan = $data['current_loan'];
        $bankName = $data['bank_name'];
        $existingHouseLoan = $data['existing_house_loan'];
        $cancelledHouseLoan = $data['cancelled_house_loan'];

        $stmt->bindValue(':financingID', $financingID, PDO::PARAM_STR);
        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        $stmt->bindValue(':financingType', $financingType, PDO::PARAM_STR);

        if ($contributionStartDate === null || $contributionStartDate === '') {
            $stmt->bindValue(':contributionStartDate', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':contributionStartDate', $contributionStartDate, PDO::PARAM_STR);
        }

        if ($currentLoan === null || $currentLoan === '') {
            $stmt->bindValue(':currentLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':currentLoan', $currentLoan, PDO::PARAM_STR);
        }

        if ($bankName === null || $bankName === '') {
            $stmt->bindValue(':bankName', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':bankName', $bankName, PDO::PARAM_STR);
        }

        if ($existingHouseLoan === null || $existingHouseLoan === '') {
            $stmt->bindValue(':existingHouseLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':existingHouseLoan', $existingHouseLoan, PDO::PARAM_STR);
        }

        if ($cancelledHouseLoan === null || $cancelledHouseLoan === '') {
            $stmt->bindValue(':cancelledHouseLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':cancelledHouseLoan', $cancelledHouseLoan, PDO::PARAM_STR);
        }

        $status = 'PENDING';
        $stmt->bindValue(':financingStatus', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $financingID;
        }

        return false;
    }

    public function savecoOwner($prequalID, $financingID, $coOwner) {
        $coOwnerID = $this->generateId('CP');

        $sql = "INSERT INTO clientcoprequal (
                    coOwnerID,
                    prequalID,
                    financingID,
                    coOwnerRelationship,
                    coOwnerFName,
                    coOwnerMName,
                    coOwnerLName,
                    coOwnerSuffix,
                    coOwnerEmail,
                    coOwnerPhoneNum,
                    coOwnerEmpStatus,
                    coOwnerMonthlyIncome
                ) VALUES (
                    :coOwnerID,
                    :prequalID,
                    :financingID,
                    :coOwnerRelationship,
                    :coOwnerFName,
                    :coOwnerMName,
                    :coOwnerLName,
                    :coOwnerSuffix,
                    :coOwnerEmail,
                    :coOwnerPhoneNum,
                    :coOwnerEmpStatus,
                    :coOwnerMonthlyIncome
                )";

        $stmt = $this->db->prepare($sql);
        // Use local vars for safe binding
        $coOwnerRelationship = $coOwner['relationship'];
        $coOwnerFName = $coOwner['firstname'];
        $coOwnerMName = $coOwner['mi'];
        $coOwnerLName = $coOwner['lastname'];
        $coOwnerSuffix = $coOwner['suffix'];
        $coOwnerEmail = $coOwner['email'];
        $coOwnerPhoneNum = $coOwner['phone'];
        $coOwnerEmpStatus = $coOwner['employment_status'];
        $coOwnerMonthlyIncome = $coOwner['monthly_income'];

        $stmt->bindValue(':coOwnerID', $coOwnerID, PDO::PARAM_STR);
        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        $stmt->bindValue(':financingID', $financingID, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerRelationship', $coOwnerRelationship, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerFName', $coOwnerFName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMName', $coOwnerMName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerLName', $coOwnerLName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerSuffix', $coOwnerSuffix, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmail', $coOwnerEmail, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerPhoneNum', $coOwnerPhoneNum, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmpStatus', $coOwnerEmpStatus, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMonthlyIncome', $coOwnerMonthlyIncome, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $coOwnerID;
        }

        return false;
    }

    public function savePrequal($clientID, $agentID, $propertyID, $financingID, $coOwnerID, $civilStatus, $employmentStatus, $monthlyIncome, $prequalID, $submissionDate = null) {
        if ($prequalID === null) {
            $prequalID = $this->generateId('PQ');
        }

        $sql = "INSERT INTO prequal (
                    prequalID,
                    clientID,
                    agentID,
                    propertyID,
                    financingID,
                    coOwnerID,
                    clientCivilStatus,
                    clientEmpStatus,
                    clientMonthlyIncome,
                    prequalStatus,
                    submissionDate
                ) VALUES (
                    :prequalID,
                    :clientID,
                    :agentID,
                    :propertyID,
                    :financingID,
                    :coOwnerID,
                    :clientCivilStatus,
                    :clientEmpStatus,
                    :clientMonthlyIncome,
                    :prequalStatus,
                    :submissionDate
                )";

        $stmt = $this->db->prepare($sql);
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);
        $stmt->bindValue(':agentID', $agentID, PDO::PARAM_STR);
        $stmt->bindValue(':propertyID', $propertyID, PDO::PARAM_STR);
        $stmt->bindValue(':financingID', $financingID, PDO::PARAM_STR);
        if ($coOwnerID === null) {
            $stmt->bindValue(':coOwnerID', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':coOwnerID', $coOwnerID, PDO::PARAM_STR);
        }
        $stmt->bindValue(':clientCivilStatus', $civilStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmpStatus', $employmentStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientMonthlyIncome', $monthlyIncome, PDO::PARAM_STR);
        $stmt->bindValue(':submissionDate', $submissionDate, PDO::PARAM_STR);
        $status = 'Pending';
        $stmt->bindValue(':prequalStatus', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $prequalID;
        }

        return false;
    }

    public function getPrequalByClientPropertyAgent($clientID, $propertyID, $agentID) {
        $sql = "SELECT 
                    p.prequalID,
                    p.clientID,
                    p.agentID,
                    p.propertyID,
                    p.financingID,
                    p.coOwnerID,
                    p.clientCivilStatus,
                    p.clientEmpStatus,
                    p.clientMonthlyIncome,
                    p.prequalStatus,
                    p.submissionDate,
                    f.financingType,
                    f.contributionStartDate,
                    f.currentLoan,
                    f.bankName,
                    f.existingHouseLoan,
                    f.cancelledHouseLoan,
                    c.coOwnerRelationship,
                    c.coOwnerFName,
                    c.coOwnerMName,
                    c.coOwnerLName,
                    c.coOwnerSuffix,
                    c.coOwnerEmail,
                    c.coOwnerPhoneNum,
                    c.coOwnerEmpStatus,
                    c.coOwnerMonthlyIncome
                FROM prequal p
                LEFT JOIN financing f ON p.financingID = f.financingID
                LEFT JOIN clientcoprequal c ON p.coOwnerID = c.coOwnerID
                WHERE p.clientID = :clientID 
                AND p.propertyID = :propertyID 
                AND p.agentID = :agentID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);
        $stmt->bindValue(':propertyID', $propertyID, PDO::PARAM_STR);
        $stmt->bindValue(':agentID', $agentID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function updateFinancing($financingID, $data) {
        $sql = "UPDATE financing SET
                    financingType = :financingType,
                    contributionStartDate = :contributionStartDate,
                    currentLoan = :currentLoan,
                    bankName = :bankName,
                    existingHouseLoan = :existingHouseLoan,
                    cancelledHouseLoan = :cancelledHouseLoan
                WHERE financingID = :financingID";

        $stmt = $this->db->prepare($sql);

        $financingType = $data['financing_type'];
        $contributionStartDate = $data['contribution_start_date'];
        $currentLoan = $data['current_loan'];
        $bankName = $data['bank_name'];
        $existingHouseLoan = $data['existing_house_loan'];
        $cancelledHouseLoan = $data['cancelled_house_loan'];

        $stmt->bindValue(':financingID', $financingID, PDO::PARAM_STR);
        $stmt->bindValue(':financingType', $financingType, PDO::PARAM_STR);

        if ($contributionStartDate === null || $contributionStartDate === '') {
            $stmt->bindValue(':contributionStartDate', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':contributionStartDate', $contributionStartDate, PDO::PARAM_STR);
        }

        if ($currentLoan === null || $currentLoan === '') {
            $stmt->bindValue(':currentLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':currentLoan', $currentLoan, PDO::PARAM_STR);
        }

        if ($bankName === null || $bankName === '') {
            $stmt->bindValue(':bankName', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':bankName', $bankName, PDO::PARAM_STR);
        }

        if ($existingHouseLoan === null || $existingHouseLoan === '') {
            $stmt->bindValue(':existingHouseLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':existingHouseLoan', $existingHouseLoan, PDO::PARAM_STR);
        }

        if ($cancelledHouseLoan === null || $cancelledHouseLoan === '') {
            $stmt->bindValue(':cancelledHouseLoan', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':cancelledHouseLoan', $cancelledHouseLoan, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function updateCoOwner($coOwnerID, $coOwner) {
        $sql = "UPDATE clientcoprequal SET
                    coOwnerRelationship = :coOwnerRelationship,
                    coOwnerFName = :coOwnerFName,
                    coOwnerMName = :coOwnerMName,
                    coOwnerLName = :coOwnerLName,
                    coOwnerSuffix = :coOwnerSuffix,
                    coOwnerEmail = :coOwnerEmail,
                    coOwnerPhoneNum = :coOwnerPhoneNum,
                    coOwnerEmpStatus = :coOwnerEmpStatus,
                    coOwnerMonthlyIncome = :coOwnerMonthlyIncome
                WHERE coOwnerID = :coOwnerID";

        $stmt = $this->db->prepare($sql);

        $coOwnerRelationship = $coOwner['relationship'];
        $coOwnerFName = $coOwner['firstname'];
        $coOwnerMName = $coOwner['mi'];
        $coOwnerLName = $coOwner['lastname'];
        $coOwnerSuffix = $coOwner['suffix'];
        $coOwnerEmail = $coOwner['email'];
        $coOwnerPhoneNum = $coOwner['phone'];
        $coOwnerEmpStatus = $coOwner['employment_status'];
        $coOwnerMonthlyIncome = $coOwner['monthly_income'];

        $stmt->bindValue(':coOwnerID', $coOwnerID, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerRelationship', $coOwnerRelationship, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerFName', $coOwnerFName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMName', $coOwnerMName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerLName', $coOwnerLName, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerSuffix', $coOwnerSuffix, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmail', $coOwnerEmail, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerPhoneNum', $coOwnerPhoneNum, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmpStatus', $coOwnerEmpStatus, PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMonthlyIncome', $coOwnerMonthlyIncome, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updatePrequal($prequalID, $clientID, $agentID, $propertyID, $financingID, $coOwnerID, $civilStatus, $employmentStatus, $monthlyIncome) {
        $sql = "UPDATE prequal SET
                    clientCivilStatus = :clientCivilStatus,
                    clientEmpStatus = :clientEmpStatus,
                    clientMonthlyIncome = :clientMonthlyIncome,
                    submissionDate = :submissionDate
                WHERE prequalID = :prequalID";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        $stmt->bindValue(':clientCivilStatus', $civilStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmpStatus', $employmentStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientMonthlyIncome', $monthlyIncome, PDO::PARAM_STR);
        $stmt->bindValue(':submissionDate', date('Y-m-d'), PDO::PARAM_STR);

        return $stmt->execute();
    }
}