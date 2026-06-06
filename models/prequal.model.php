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

    private function resolveFinancingStatus(string $financingType, ?string $contributionStartDate, ?string $currentLoan, ?string $existingHouseLoan, ?string $cancelledHouseLoan): string {
        $existingNo  = strtolower($existingHouseLoan  ?? '') === 'no';
        $cancelledNo = strtolower($cancelledHouseLoan ?? '') === 'no';
        $currentNo = strtolower($currentLoan ?? '') === 'no';
        $noLoans     = $existingNo && $cancelledNo;

        if ($financingType === 'pagibig') {
            $date = DateTime::createFromFormat('Y-m-d', $contributionStartDate ?? '');
            if ($date !== false) {
                $years = (int) $date->diff(new DateTime())->y;
                if ($years >= 2 && $currentNo) {
                    return 'APPROVED';
    
            }
            }
        } elseif ($financingType === 'bank') {
            if ($noLoans) {
                return 'Approved';
            }
        }

        return 'PENDING';
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

        $financingType         = $data['financing_type'];
        $contributionStartDate = $data['contribution_start_date'];
        $currentLoan           = $data['current_loan'];
        $bankName              = $data['bank_name'];
        $existingHouseLoan     = $data['existing_house_loan'];
        $cancelledHouseLoan    = $data['cancelled_house_loan'];

        $stmt->bindValue(':financingID',   $financingID,   PDO::PARAM_STR);
        $stmt->bindValue(':prequalID',     $prequalID,     PDO::PARAM_STR);
        $stmt->bindValue(':financingType', $financingType, PDO::PARAM_STR);

        $stmt->bindValue(':contributionStartDate', ($contributionStartDate === null || $contributionStartDate === '') ? null : $contributionStartDate, ($contributionStartDate === null || $contributionStartDate === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':currentLoan',           ($currentLoan           === null || $currentLoan           === '') ? null : $currentLoan,           ($currentLoan           === null || $currentLoan           === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':bankName',              ($bankName              === null || $bankName              === '') ? null : $bankName,              ($bankName              === null || $bankName              === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':existingHouseLoan',     ($existingHouseLoan     === null || $existingHouseLoan     === '') ? null : $existingHouseLoan,     ($existingHouseLoan     === null || $existingHouseLoan     === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':cancelledHouseLoan',    ($cancelledHouseLoan    === null || $cancelledHouseLoan    === '') ? null : $cancelledHouseLoan,    ($cancelledHouseLoan    === null || $cancelledHouseLoan    === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // FIX: Added missing $currentLoan argument
        $status = $this->resolveFinancingStatus($financingType, $contributionStartDate, $currentLoan, $existingHouseLoan, $cancelledHouseLoan);
        $stmt->bindValue(':financingStatus', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $financingID;
        }

        return false;
    }

    public function savecoOwner($prequalID, $financingID, $coOwner, $financingData = []) {
        // If a row already exists for this prequalID, update it instead of inserting
        $existing = $this->getCoOwnerByPrequalID($prequalID);
        if ($existing) {
            $coOwnerID = $existing['coOwnerID'];
            $this->updateCoOwner($coOwnerID, $coOwner);
            $this->saveCoOwnerFinancing($coOwnerID, $financingData);
            return $coOwnerID;
        }

        $coOwnerID = $this->generateId('CP');

        $coFinancingType      = $financingData['co_financing_type']          ?? '';
        $coContributionStart  = $financingData['co_contribution_start_date'] ?? null;
        $coCurrentLoan        = $financingData['co_current_loan']            ?? null;
        $coBankName           = $financingData['co_bank_name']               ?? null;
        $coExistingHouseLoan  = $financingData['co_existing_house_loan']     ?? null;
        $coCancelledHouseLoan = $financingData['co_cancelled_house_loan']    ?? null;
        $coFinancingStatus    = $this->resolveFinancingStatus($coFinancingType, $coContributionStart, $coCurrentLoan, $coExistingHouseLoan, $coCancelledHouseLoan);

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
                    coOwnerMonthlyIncome,
                    coFinancingType,
                    coContributionStart,
                    coCurrentLoan,
                    coBankName,
                    coExistingHouseLoan,
                    coCancelledHouseLoan,
                    coFinancingStatus
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
                    :coOwnerMonthlyIncome,
                    :coFinancingType,
                    :coContributionStart,
                    :coCurrentLoan,
                    :coBankName,
                    :coExistingHouseLoan,
                    :coCancelledHouseLoan,
                    :coFinancingStatus
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':coOwnerID',            $coOwnerID,                   PDO::PARAM_STR);
        $stmt->bindValue(':prequalID',            $prequalID,                   PDO::PARAM_STR);
        $stmt->bindValue(':financingID',          $financingID,                 PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerRelationship',  $coOwner['relationship'],      PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerFName',         $coOwner['firstname'],         PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMName',         $coOwner['mi'],                PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerLName',         $coOwner['lastname'],          PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerSuffix',        $coOwner['suffix'],            PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmail',         $coOwner['email'],             PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerPhoneNum',      $coOwner['phone'],             PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmpStatus',     $coOwner['employment_status'], PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMonthlyIncome', $coOwner['monthly_income'],    PDO::PARAM_STR);
        $stmt->bindValue(':coFinancingType',      $coFinancingType,              PDO::PARAM_STR);

        $stmt->bindValue(':coContributionStart',  ($coContributionStart  === null || $coContributionStart  === '') ? null : $coContributionStart,  ($coContributionStart  === null || $coContributionStart  === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coCurrentLoan',        ($coCurrentLoan        === null || $coCurrentLoan        === '') ? null : $coCurrentLoan,        ($coCurrentLoan        === null || $coCurrentLoan        === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coBankName',           ($coBankName           === null || $coBankName           === '') ? null : $coBankName,           ($coBankName           === null || $coBankName           === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coExistingHouseLoan',  ($coExistingHouseLoan  === null || $coExistingHouseLoan  === '') ? null : $coExistingHouseLoan,  ($coExistingHouseLoan  === null || $coExistingHouseLoan  === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coCancelledHouseLoan', ($coCancelledHouseLoan === null || $coCancelledHouseLoan === '') ? null : $coCancelledHouseLoan, ($coCancelledHouseLoan === null || $coCancelledHouseLoan === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coFinancingStatus',    $coFinancingStatus,            PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $coOwnerID;
        }

        return false;
    }

    public function saveCoOwnerFinancing($coOwnerID, $data) {
        $sql = "UPDATE clientcoprequal SET
                    coFinancingType = :coFinancingType,
                    coContributionStart = :coContributionStart,
                    coCurrentLoan = :coCurrentLoan,
                    coBankName = :coBankName,
                    coExistingHouseLoan = :coExistingHouseLoan,
                    coCancelledHouseLoan = :coCancelledHouseLoan,
                    coFinancingStatus = :coFinancingStatus
                WHERE coOwnerID = :coOwnerID";

        $stmt = $this->db->prepare($sql);

        $coFinancingType         = $data['co_financing_type'];
        $coContributionStart     = $data['co_contribution_start_date'];
        $coCurrentLoan           = $data['co_current_loan'];
        $coBankName              = $data['co_bank_name'];
        $coExistingHouseLoan     = $data['co_existing_house_loan'];
        $coCancelledHouseLoan    = $data['co_cancelled_house_loan'];

        $stmt->bindValue(':coOwnerID',            $coOwnerID,            PDO::PARAM_STR);
        $stmt->bindValue(':coFinancingType',      $coFinancingType,      PDO::PARAM_STR);

        $stmt->bindValue(':coContributionStart',  ($coContributionStart === null || $coContributionStart === '') ? null : $coContributionStart, ($coContributionStart === null || $coContributionStart === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coCurrentLoan',        ($coCurrentLoan       === null || $coCurrentLoan       === '') ? null : $coCurrentLoan,       ($coCurrentLoan       === null || $coCurrentLoan       === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coBankName',           ($coBankName          === null || $coBankName          === '') ? null : $coBankName,          ($coBankName          === null || $coBankName          === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coExistingHouseLoan',  ($coExistingHouseLoan === null || $coExistingHouseLoan === '') ? null : $coExistingHouseLoan, ($coExistingHouseLoan === null || $coExistingHouseLoan === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':coCancelledHouseLoan', ($coCancelledHouseLoan === null || $coCancelledHouseLoan === '') ? null : $coCancelledHouseLoan, ($coCancelledHouseLoan === null || $coCancelledHouseLoan === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // Apply the same financing status resolution logic for co-owners
        $status = $this->resolveFinancingStatus($coFinancingType, $coContributionStart, $coCurrentLoan, $coExistingHouseLoan, $coCancelledHouseLoan);
        $stmt->bindValue(':coFinancingStatus', $status, PDO::PARAM_STR);

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

        $stmt->bindValue(':prequalID',          $prequalID,        PDO::PARAM_STR);
        $stmt->bindValue(':clientID',           $clientID,         PDO::PARAM_STR);
        $stmt->bindValue(':agentID',            $agentID,          PDO::PARAM_STR);
        $stmt->bindValue(':propertyID',         $propertyID,       PDO::PARAM_STR);
        $stmt->bindValue(':financingID',        $financingID,      PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerID',          $coOwnerID,        $coOwnerID === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':clientCivilStatus',  $civilStatus,      PDO::PARAM_STR);
        $stmt->bindValue(':clientEmpStatus',    $employmentStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientMonthlyIncome',$monthlyIncome,    PDO::PARAM_STR);
        $stmt->bindValue(':submissionDate',     $submissionDate,   PDO::PARAM_STR);
        $stmt->bindValue(':prequalStatus',      'Pending',         PDO::PARAM_STR);

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
                    c.coOwnerMonthlyIncome,
                    c.coFinancingType,
                    c.coContributionStart,
                    c.coCurrentLoan,
                    c.coBankName,
                    c.coExistingHouseLoan,
                    c.coCancelledHouseLoan
                FROM prequal p
                LEFT JOIN financing f ON p.financingID = f.financingID
                LEFT JOIN clientcoprequal c ON p.coOwnerID = c.coOwnerID
                WHERE p.clientID  = :clientID 
                AND   p.propertyID = :propertyID 
                AND   p.agentID   = :agentID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID',   $clientID,   PDO::PARAM_STR);
        $stmt->bindValue(':propertyID', $propertyID, PDO::PARAM_STR);
        $stmt->bindValue(':agentID',    $agentID,    PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function getLatestPrequalByClientAgent($clientID, $agentID) {
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
                    c.coOwnerMonthlyIncome,
                    c.coFinancingType,
                    c.coContributionStart,
                    c.coCurrentLoan,
                    c.coBankName,
                    c.coExistingHouseLoan,
                    c.coCancelledHouseLoan
                FROM prequal p
                LEFT JOIN financing f ON p.financingID = f.financingID
                LEFT JOIN clientcoprequal c ON p.coOwnerID = c.coOwnerID
                WHERE p.clientID = :clientID 
                AND   p.agentID  = :agentID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);
        $stmt->bindValue(':agentID',  $agentID,  PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function getLatestPrequalByClient($clientID) {
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
                    c.coOwnerMonthlyIncome,
                    c.coFinancingType,
                    c.coContributionStart,
                    c.coCurrentLoan,
                    c.coBankName,
                    c.coExistingHouseLoan,
                    c.coCancelledHouseLoan
                FROM prequal p
                LEFT JOIN financing f ON p.financingID = f.financingID
                LEFT JOIN clientcoprequal c ON p.coOwnerID = c.coOwnerID
                WHERE p.clientID = :clientID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function updateFinancing($financingID, $data) {
        $sql = "UPDATE financing SET
                    financingType          = :financingType,
                    contributionStartDate  = :contributionStartDate,
                    currentLoan            = :currentLoan,
                    bankName               = :bankName,
                    existingHouseLoan      = :existingHouseLoan,
                    cancelledHouseLoan     = :cancelledHouseLoan,
                    financingStatus        = :financingStatus
                WHERE financingID = :financingID";

        $stmt = $this->db->prepare($sql);

        $financingType         = $data['financing_type'];
        $contributionStartDate = $data['contribution_start_date'];
        $currentLoan           = $data['current_loan'];
        $bankName              = $data['bank_name'];
        $existingHouseLoan     = $data['existing_house_loan'];
        $cancelledHouseLoan    = $data['cancelled_house_loan'];

        $stmt->bindValue(':financingID',   $financingID,   PDO::PARAM_STR);
        $stmt->bindValue(':financingType', $financingType, PDO::PARAM_STR);

        $stmt->bindValue(':contributionStartDate', ($contributionStartDate === null || $contributionStartDate === '') ? null : $contributionStartDate, ($contributionStartDate === null || $contributionStartDate === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':currentLoan',           ($currentLoan           === null || $currentLoan           === '') ? null : $currentLoan,           ($currentLoan           === null || $currentLoan           === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':bankName',              ($bankName              === null || $bankName              === '') ? null : $bankName,              ($bankName              === null || $bankName              === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':existingHouseLoan',     ($existingHouseLoan     === null || $existingHouseLoan     === '') ? null : $existingHouseLoan,     ($existingHouseLoan     === null || $existingHouseLoan     === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':cancelledHouseLoan',    ($cancelledHouseLoan    === null || $cancelledHouseLoan    === '') ? null : $cancelledHouseLoan,    ($cancelledHouseLoan    === null || $cancelledHouseLoan    === '') ? PDO::PARAM_NULL : PDO::PARAM_STR);

        // FIX: Added missing $currentLoan argument
        $status = $this->resolveFinancingStatus($financingType, $contributionStartDate, $currentLoan, $existingHouseLoan, $cancelledHouseLoan);
        $stmt->bindValue(':financingStatus', $status, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateCoOwner($coOwnerID, $coOwner) {
        $sql = "UPDATE clientcoprequal SET
                    coOwnerRelationship  = :coOwnerRelationship,
                    coOwnerFName         = :coOwnerFName,
                    coOwnerMName         = :coOwnerMName,
                    coOwnerLName         = :coOwnerLName,
                    coOwnerSuffix        = :coOwnerSuffix,
                    coOwnerEmail         = :coOwnerEmail,
                    coOwnerPhoneNum      = :coOwnerPhoneNum,
                    coOwnerEmpStatus     = :coOwnerEmpStatus,
                    coOwnerMonthlyIncome = :coOwnerMonthlyIncome
                WHERE coOwnerID = :coOwnerID";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':coOwnerID',           $coOwnerID,                   PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerRelationship', $coOwner['relationship'],      PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerFName',        $coOwner['firstname'],         PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMName',        $coOwner['mi'],                PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerLName',        $coOwner['lastname'],          PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerSuffix',       $coOwner['suffix'],            PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmail',        $coOwner['email'],             PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerPhoneNum',     $coOwner['phone'],             PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerEmpStatus',    $coOwner['employment_status'], PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerMonthlyIncome',$coOwner['monthly_income'],    PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updatePrequal($prequalID, $clientID, $agentID, $propertyID, $financingID, $coOwnerID, $civilStatus, $employmentStatus, $monthlyIncome) {
        $sql = "UPDATE prequal SET
                    clientCivilStatus   = :clientCivilStatus,
                    clientEmpStatus     = :clientEmpStatus,
                    clientMonthlyIncome = :clientMonthlyIncome,
                    coOwnerID           = :coOwnerID,
                    submissionDate      = :submissionDate
                WHERE prequalID = :prequalID";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':prequalID',          $prequalID,        PDO::PARAM_STR);
        $stmt->bindValue(':clientCivilStatus',  $civilStatus,      PDO::PARAM_STR);
        $stmt->bindValue(':clientEmpStatus',    $employmentStatus, PDO::PARAM_STR);
        $stmt->bindValue(':clientMonthlyIncome',$monthlyIncome,    PDO::PARAM_STR);
        $stmt->bindValue(':coOwnerID',          $coOwnerID,        $coOwnerID === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':submissionDate',     date('Y-m-d'),     PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getCoOwnerByPrequalID($prequalID) {
        $sql = "SELECT coOwnerID FROM clientcoprequal
                WHERE prequalID = :prequalID
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':prequalID', $prequalID, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }
        return false;
    }

    public function getCoOwnerById($coOwnerID) {
        $sql = "SELECT
                    coOwnerID,
                    coOwnerRelationship,
                    coOwnerFName,
                    coOwnerMName,
                    coOwnerLName,
                    coOwnerSuffix,
                    coOwnerEmail,
                    coOwnerPhoneNum,
                    coOwnerEmpStatus,
                    coOwnerMonthlyIncome,
                    coFinancingType,
                    coContributionStart,
                    coCurrentLoan,
                    coBankName,
                    coExistingHouseLoan,
                    coCancelledHouseLoan
                FROM clientcoprequal
                WHERE coOwnerID = :coOwnerID
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':coOwnerID', $coOwnerID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function getFullCoOwnerByClient($clientID) {
        $sql = "SELECT
                    c.coOwnerID,
                    c.coOwnerRelationship,
                    c.coOwnerFName,
                    c.coOwnerMName,
                    c.coOwnerLName,
                    c.coOwnerSuffix,
                    c.coOwnerEmail,
                    c.coOwnerPhoneNum,
                    c.coOwnerEmpStatus,
                    c.coOwnerMonthlyIncome,
                    c.coFinancingType,
                    c.coContributionStart,
                    c.coCurrentLoan,
                    c.coBankName,
                    c.coExistingHouseLoan,
                    c.coCancelledHouseLoan
                FROM clientcoprequal c
                JOIN prequal p ON c.prequalID = p.prequalID
                WHERE p.clientID = :clientID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function getCoOwnerByClient($clientID) {
        $sql = "SELECT c.coOwnerID 
                FROM clientcoprequal c
                JOIN prequal p ON c.prequalID = p.prequalID
                WHERE p.clientID = :clientID
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID', $clientID, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function getCoOwnerByClientDetails($clientID, $coOwnerData) {
        $sql = "SELECT c.coOwnerID 
                FROM clientcoprequal c
                JOIN prequal p ON c.prequalID = p.prequalID
                WHERE p.clientID        = :clientID
                AND   c.coOwnerFName    = :firstName
                AND   c.coOwnerLName    = :lastName
                AND   c.coOwnerEmail    = :email
                AND   c.coOwnerPhoneNum = :phone
                ORDER BY p.submissionDate DESC
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':clientID',  $clientID,                        PDO::PARAM_STR);
        $stmt->bindValue(':firstName', $coOwnerData['firstname'] ?? '',   PDO::PARAM_STR);
        $stmt->bindValue(':lastName',  $coOwnerData['lastname']  ?? '',   PDO::PARAM_STR);
        $stmt->bindValue(':email',     $coOwnerData['email']     ?? '',   PDO::PARAM_STR);
        $stmt->bindValue(':phone',     $coOwnerData['phone']     ?? '',   PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        }

        return false;
    }

    public function createReservation($prequalID, $agentID) {
        $stmt = $this->db->query("SELECT MAX(id) AS max_id FROM reservations");
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);

        $nextId        = ((int) ($row['max_id'] ?? 0)) + 1;
        $reservationID = 'R' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $sql = "INSERT INTO reservations (
                    reservationID,
                    prequalID,
                    agentID,
                    reserveStatus
                ) VALUES (
                    :reservationID,
                    :prequalID,
                    :agentID,
                    'Pending'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':reservationID', $reservationID, PDO::PARAM_STR);
        $stmt->bindValue(':prequalID',     $prequalID,     PDO::PARAM_STR);
        $stmt->bindValue(':agentID',       $agentID,       PDO::PARAM_STR);

        return $stmt->execute();
    }
}