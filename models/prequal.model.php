<?php

class PrequalModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    private function generateSequentialId($table, $prefix, $pad = 6) {
        $allowedTables = ['prequal', 'financing', 'clientspouseprequal'];
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
            'SP' => 'clientspouseprequal'
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

    public function saveSpouse($prequalID, $financingID, $spouse) {
        $spouseID = $this->generateId('SP');

        $sql = "INSERT INTO clientspouseprequal (
                    spouseID,
                    prequalID,
                    financingID,
                    spouseFName,
                    spouseMName,
                    spouseLName,
                    spouseSuffix,
                    spouseEmail,
                    spousePhoneNum,
                    spouseEmpStatus,
                    spouseMonthlyIncome
                ) VALUES (
                    :spouseID,
                    :prequalID,
                    :financingID,
                    :spouseFName,
                    :spouseMName,
                    :spouseLName,
                    :spouseSuffix,
                    :spouseEmail,
                    :spousePhoneNum,
                    :spouseEmpStatus,
                    :spouseMonthlyIncome
                )";

        $stmt = $this->db->prepare($sql);
        // Use local vars for safe binding
        $spouseFName = $spouse['firstname'];
        $spouseMName = $spouse['mi'];
        $spouseLName = $spouse['lastname'];
        $spouseSuffix = $spouse['suffix'];
        $spouseEmail = $spouse['email'];
        $spousePhoneNum = $spouse['phone'];
        $spouseEmpStatus = $spouse['employment_status'];
        $spouseMonthlyIncome = $spouse['monthly_income'];

        $stmt->bindValue(':spouseID', $spouseID, PDO::PARAM_STR);
        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        $stmt->bindValue(':financingID', $financingID, PDO::PARAM_STR);
        $stmt->bindValue(':spouseFName', $spouseFName, PDO::PARAM_STR);
        $stmt->bindValue(':spouseMName', $spouseMName, PDO::PARAM_STR);
        $stmt->bindValue(':spouseLName', $spouseLName, PDO::PARAM_STR);
        $stmt->bindValue(':spouseSuffix', $spouseSuffix, PDO::PARAM_STR);
        $stmt->bindValue(':spouseEmail', $spouseEmail, PDO::PARAM_STR);
        $stmt->bindValue(':spousePhoneNum', $spousePhoneNum, PDO::PARAM_STR);
        $stmt->bindValue(':spouseEmpStatus', $spouseEmpStatus, PDO::PARAM_STR);
        $stmt->bindValue(':spouseMonthlyIncome', $spouseMonthlyIncome, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $spouseID;
        }

        return false;
    }

    public function savePrequal($clientID, $agentID, $propertyID, $financingID, $spouseID, $civilStatus, $employmentStatus, $monthlyIncome, $prequalID, $submissionDate = null) {
        if ($prequalID === null) {
            $prequalID = $this->generateId('PQ');
        }

        $sql = "INSERT INTO prequal (
                    prequalID,
                    clientID,
                    agentID,
                    propertyID,
                    financingID,
                    spouseID,
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
                    :spouseID,
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
        if ($spouseID === null) {
            $stmt->bindValue(':spouseID', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':spouseID', $spouseID, PDO::PARAM_STR);
        }
        $stmt->bindValue(':clientCivilStatus', $civilStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientEmpStatus', $employmentStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientMonthlyIncome', $monthlyIncome, PDO::PARAM_STR);
        $stmt->bindValue(':submissionDate', $submissionDate, PDO::PARAM_STR);
        $status = 'PENDING';
        $stmt->bindValue(':prequalStatus', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $prequalID;
        }

        return false;
    }
}
