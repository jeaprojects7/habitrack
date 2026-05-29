<?php

require_once __DIR__ . '/../models/prequal.model.php';

class PrequalController {
    private $db;
    private $prequalModel;

    public function __construct($db) {
        $this->db = $db;
        $this->prequalModel = new PrequalModel($db);
    }

    public function handleRequest(): void {
        header('Content-Type: application/json; charset=UTF-8');

        if (!$this->isAjaxRequest()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.'], 400);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method.'], 405);
            return;
        }

        $action = isset($_GET['action']) ? trim($_GET['action']) : '';

        switch ($action) {
            case 'savePrequal':
                $this->savePrequal();
                break;
            case 'getPrequal':
                $this->getPrequal();
                break;
            case 'updatePrequal':
                $this->updatePrequal();
                break;
            default:
                $this->jsonResponse(['success' => false, 'message' => 'Unknown action.'], 400);
                break;
        }
    }

    private function isAjaxRequest(): bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function parseRequestData(): array {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (stripos($contentType, 'application/json') !== false) {
            $body = file_get_contents('php://input');
            $data = json_decode($body, true);
            if (is_array($data)) {
                return $data;
            }
        }

        return $_POST;
    }

    private function jsonResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        if (isset($data['success']) && $data['success'] === false && !isset($data['error']) && isset($data['message'])) {
            $data['error'] = $data['message'];
        }

        echo json_encode($data);
        exit;
    }

    private function savePrequal(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;
        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $data = $this->parseRequestData();

        $agentID          = trim($data['agent_id']          ?? '');
        $propertyID       = trim($data['property_id']       ?? '');
        $civilStatus      = trim($data['civil_status']      ?? '');
        $employmentStatus = trim($data['employment_status'] ?? '');
        $monthlyIncome    = trim($data['monthly_income']    ?? '');
        $financingType    = trim($data['financing_type']    ?? '');

        if (!$agentID || !$propertyID || !$civilStatus || !$employmentStatus || $monthlyIncome === '' || !$financingType) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        // ── Financing ────────────────────────────────────────────────────────
        $financingData = [
            'financing_type'          => $financingType,
            'contribution_start_date' => null,
            'current_loan'            => null,
            'bank_name'               => null,
            'existing_house_loan'     => null,
            'cancelled_house_loan'    => null,
        ];

        if ($financingType === 'pagibig') {
            $contributionDate = trim($data['pagibig']['contribution_start_date'] ?? '');
            $financingData['contribution_start_date'] = !empty($contributionDate) ? $contributionDate : null;
            $currentLoan = trim($data['pagibig']['current_loan'] ?? '');
            $financingData['current_loan'] = !empty($currentLoan) ? $currentLoan : null;
        } elseif ($financingType === 'bank') {
            $bankName = trim($data['bank']['bank_name'] ?? '');
            $financingData['bank_name'] = !empty($bankName) ? $bankName : null;
            $existingLoan = trim($data['bank']['existing_house_loan'] ?? '');
            $financingData['existing_house_loan'] = !empty($existingLoan) ? $existingLoan : null;
            $cancelledLoan = trim($data['bank']['cancelled_house_loan'] ?? '');
            $financingData['cancelled_house_loan'] = !empty($cancelledLoan) ? $cancelledLoan : null;
        }

        // ── Co-owner ─────────────────────────────────────────────────────────
        // JS sends co_owner = 'yes'|'no' and coOwner object when yes
        $coOwner    = strtolower(trim($data['co_owner'] ?? 'no'));
        $coOwnerID   = null;
        $coOwnerData = null;

        if ($coOwner === 'yes') {
            $coOwnerData = $data['coOwner'] ?? [];

            $coOwnerData = [
                'relationship'      => trim($coOwnerData['relationship']      ?? ''),
                'firstname'         => trim($coOwnerData['firstname']         ?? ''),
                'lastname'          => trim($coOwnerData['lastname']          ?? ''),
                'mi'                => trim($coOwnerData['mi']                ?? ''),
                'suffix'            => trim($coOwnerData['suffix']            ?? ''),
                'email'             => trim($coOwnerData['email']             ?? ''),
                'phone'             => trim($coOwnerData['phone']             ?? ''),
                'employment_status' => trim($coOwnerData['employment_status'] ?? ''),
                'monthly_income'    => trim($coOwnerData['monthly_income']    ?? '')
            ];

           /*  if (!$coOwnerData['firstname'] || !$coOwnerData['lastname'] || !$coOwnerData['email'] || !$coOwnerData['phone'] || !$coOwnerData['employment_status']) {
                $this->jsonResponse(['success' => false, 'message' => 'Missing co-owner information.'], 400);
                return;
            } */
        }

        // ── Save ─────────────────────────────────────────────────────────────
        try {
            if ($this->db->beginTransaction() === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Unable to start transaction.'], 500);
                return;
            }

            $prequalID   = $this->prequalModel->generateId('PQ');
            $financingID = $this->prequalModel->saveFinancing($prequalID, $financingData);
            if (!$financingID) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Unable to save financing.'], 500);
                return;
            }

            if ($coOwnerData !== null) {
                $coOwnerID = $this->prequalModel->savecoOwner($prequalID, $financingID, $coOwnerData);
                if (!$coOwnerID) {
                    $this->db->rollBack();
                    $this->jsonResponse(['success' => false, 'message' => 'Unable to save co-owner details.'], 500);
                    return;
                }
            }

            $submissionDate  = date('Y-m-d');
            $savedPrequalID  = $this->prequalModel->savePrequal(
                $clientID,
                $agentID,
                $propertyID,
                $financingID,
                $coOwnerID,
                $civilStatus,
                $employmentStatus,
                preg_replace('/[^0-9\.]/', '', $monthlyIncome),
                $prequalID,
                $submissionDate
            );

            if (!$savedPrequalID) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Unable to save pre-qualification record.'], 500);
                return;
            }

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'prequalID' => $savedPrequalID]);

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    private function getPrequal(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;
        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $data = $this->parseRequestData();

        $agentID    = trim($data['agent_id']    ?? '');
        $propertyID = trim($data['property_id'] ?? '');

        if (!$agentID || !$propertyID) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        try {
            $prequalRecord = $this->prequalModel->getPrequalByClientPropertyAgent($clientID, $propertyID, $agentID);
            
            if (!$prequalRecord) {
                $this->jsonResponse(['success' => false, 'message' => 'No pre-qualification record found.'], 404);
                return;
            }

            $response = [
                'success' => true,
                'data' => [
                    'prequalID' => $prequalRecord['prequalID'],
                    'civil_status' => $prequalRecord['clientCivilStatus'],
                    'employment_status' => $prequalRecord['clientEmpStatus'],
                    'monthly_income' => $prequalRecord['clientMonthlyIncome'],
                    'financing_type' => $prequalRecord['financingType'],
                ]
            ];

            // Add financing specific data
            if ($prequalRecord['financingType'] === 'bank') {
                $response['data']['bank'] = [
                    'bank_name' => $prequalRecord['bankName'] ?? '',
                    'existing_house_loan' => $prequalRecord['existingHouseLoan'] ?? '',
                    'cancelled_house_loan' => $prequalRecord['cancelledHouseLoan'] ?? ''
                ];
            } elseif ($prequalRecord['financingType'] === 'pagibig') {
                $response['data']['pagibig'] = [
                    'contribution_start_date' => $prequalRecord['contributionStartDate'] ?? '',
                    'current_loan' => $prequalRecord['currentLoan'] ?? ''
                ];
            }

            // Add co-owner data if exists
            if ($prequalRecord['coOwnerID']) {
                $response['data']['co_owner'] = 'yes';
                $response['data']['coOwner'] = [
                    'relationship' => $prequalRecord['coOwnerRelationship'] ?? '',
                    'firstname' => $prequalRecord['coOwnerFName'] ?? '',
                    'mi' => $prequalRecord['coOwnerMName'] ?? '',
                    'lastname' => $prequalRecord['coOwnerLName'] ?? '',
                    'suffix' => $prequalRecord['coOwnerSuffix'] ?? '',
                    'email' => $prequalRecord['coOwnerEmail'] ?? '',
                    'phone' => $prequalRecord['coOwnerPhoneNum'] ?? '',
                    'employment_status' => $prequalRecord['coOwnerEmpStatus'] ?? '',
                    'monthly_income' => $prequalRecord['coOwnerMonthlyIncome'] ?? ''
                ];
            } else {
                $response['data']['co_owner'] = 'no';
            }

            $this->jsonResponse($response);

        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    private function updatePrequal(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;
        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $data = $this->parseRequestData();

        $prequalID        = trim($data['prequal_id']        ?? '');
        $agentID          = trim($data['agent_id']          ?? '');
        $propertyID       = trim($data['property_id']       ?? '');
        $civilStatus      = trim($data['civil_status']      ?? '');
        $employmentStatus = trim($data['employment_status'] ?? '');
        $monthlyIncome    = trim($data['monthly_income']    ?? '');
        $financingType    = trim($data['financing_type']    ?? '');

        if (!$prequalID || !$agentID || !$propertyID || !$civilStatus || !$employmentStatus || $monthlyIncome === '' || !$financingType) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        // ── Financing ────────────────────────────────────────────────────────
        $financingData = [
            'financing_type'          => $financingType,
            'contribution_start_date' => null,
            'current_loan'            => null,
            'bank_name'               => null,
            'existing_house_loan'     => null,
            'cancelled_house_loan'    => null,
        ];

        if ($financingType === 'pagibig') {
            $contributionDate = trim($data['pagibig']['contribution_start_date'] ?? '');
            $financingData['contribution_start_date'] = !empty($contributionDate) ? $contributionDate : null;
            $currentLoan = trim($data['pagibig']['current_loan'] ?? '');
            $financingData['current_loan'] = !empty($currentLoan) ? $currentLoan : null;
        } elseif ($financingType === 'bank') {
            $bankName = trim($data['bank']['bank_name'] ?? '');
            $financingData['bank_name'] = !empty($bankName) ? $bankName : null;
            $existingLoan = trim($data['bank']['existing_house_loan'] ?? '');
            $financingData['existing_house_loan'] = !empty($existingLoan) ? $existingLoan : null;
            $cancelledLoan = trim($data['bank']['cancelled_house_loan'] ?? '');
            $financingData['cancelled_house_loan'] = !empty($cancelledLoan) ? $cancelledLoan : null;
        }

        // ── Co-owner ─────────────────────────────────────────────────────────
        $coOwner    = strtolower(trim($data['co_owner'] ?? 'no'));
        $coOwnerID   = $data['co_owner_id'] ?? null;
        $coOwnerData = null;

        if ($coOwner === 'yes') {
            $coOwnerData = $data['coOwner'] ?? [];
            $coOwnerData = [
                'relationship'      => trim($coOwnerData['relationship']      ?? ''),
                'firstname'         => trim($coOwnerData['firstname']         ?? ''),
                'lastname'          => trim($coOwnerData['lastname']          ?? ''),
                'mi'                => trim($coOwnerData['mi']                ?? ''),
                'suffix'            => trim($coOwnerData['suffix']            ?? ''),
                'email'             => trim($coOwnerData['email']             ?? ''),
                'phone'             => trim($coOwnerData['phone']             ?? ''),
                'employment_status' => trim($coOwnerData['employment_status'] ?? ''),
                'monthly_income'    => trim($coOwnerData['monthly_income']    ?? '')
            ];
        }

        // ── Update ───────────────────────────────────────────────────────────
        try {
            if ($this->db->beginTransaction() === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Unable to start transaction.'], 500);
                return;
            }

            // Get existing prequal to retrieve financing and co-owner IDs
            $existingPrequal = $this->prequalModel->getPrequalByClientPropertyAgent($clientID, $propertyID, $agentID);
            if (!$existingPrequal || $existingPrequal['prequalID'] !== $prequalID) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Pre-qualification record not found.'], 404);
                return;
            }

            $financingID = $existingPrequal['financingID'];
            $oldCoOwnerID = $existingPrequal['coOwnerID'];

            // Update financing
            if (!$this->prequalModel->updateFinancing($financingID, $financingData)) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Unable to update financing.'], 500);
                return;
            }

            // Update or create co-owner
            if ($coOwner === 'yes') {
                if ($oldCoOwnerID) {
                    if (!$this->prequalModel->updateCoOwner($oldCoOwnerID, $coOwnerData)) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to update co-owner details.'], 500);
                        return;
                    }
                    $coOwnerID = $oldCoOwnerID;
                } else {
                    $coOwnerID = $this->prequalModel->savecoOwner($prequalID, $financingID, $coOwnerData);
                    if (!$coOwnerID) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to save co-owner details.'], 500);
                        return;
                    }
                }
            } else {
                $coOwnerID = null;
            }

            // Update main prequal record
            if (!$this->prequalModel->updatePrequal($prequalID, $clientID, $agentID, $propertyID, $financingID, $coOwnerID, $civilStatus, $employmentStatus, preg_replace('/[^0-9\.]/', '', $monthlyIncome))) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Unable to update pre-qualification record.'], 500);
                return;
            }

            $this->db->commit();
            $this->jsonResponse(['success' => true, 'prequalID' => $prequalID, 'message' => 'Pre-qualification updated successfully.']);

        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}