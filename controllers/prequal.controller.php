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
        // Ensure the client-side code can read the error from `json.error`
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

        $agentID = trim($data['agent_id'] ?? '');
        $propertyID = trim($data['property_id'] ?? '');
        $civilStatus = trim($data['civil_status'] ?? '');
        $employmentStatus = trim($data['employment_status'] ?? '');
        $monthlyIncome = trim($data['monthly_income'] ?? '');
        $financingType = trim($data['financing_type'] ?? '');

        if (!$agentID || !$propertyID || !$civilStatus || !$employmentStatus || $monthlyIncome === '' || !$financingType) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        $financingData = [
            'financing_type' => $financingType,
            'contribution_start_date' => null,
            'current_loan' => null,
            'bank_name' => null,
            'existing_house_loan' => null,
            'cancelled_house_loan' => null,
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

        $spouseID = null;
        $spouseData = null;

        // Only require spouse details when married AND spouse is a co-owner
        $coOwner = strtolower(trim($data['ownership']['co_owner'] ?? 'no'));
        if (strtolower($civilStatus) === 'married' && $coOwner === 'yes') {
            $spouseData = [
                'firstname' => trim($data['spouse']['firstname'] ?? ''),
                'lastname' => trim($data['spouse']['lastname'] ?? ''),
                'mi' => trim($data['spouse']['mi'] ?? ''),
                'suffix' => trim($data['spouse']['suffix'] ?? ''),
                'email' => trim($data['spouse']['email'] ?? ''),
                'phone' => trim($data['spouse']['phone'] ?? ''),
                'employment_status' => trim($data['spouse']['employment_status'] ?? ''),
                'monthly_income' => trim($data['spouse']['monthly_income'] ?? ''),
                'spouse_cisid' => '',
            ];

            if (!$spouseData['firstname'] || !$spouseData['lastname'] || !$spouseData['email'] || !$spouseData['phone'] || !$spouseData['employment_status']) {
                $this->jsonResponse(['success' => false, 'message' => 'Missing spouse information.'], 400);
                return;
            }
        }

        try {
            if ($this->db->beginTransaction() === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Unable to start transaction.'], 500);
                return;
            }

            $prequalID = $this->prequalModel->generateId('PQ');
            $financingID = $this->prequalModel->saveFinancing($prequalID, $financingData);
            if (!$financingID) {
                $this->db->rollBack();
                $this->jsonResponse(['success' => false, 'message' => 'Unable to save financing.'], 500);
                return;
            }

            if ($spouseData !== null) {
                $spouseID = $this->prequalModel->saveSpouse($prequalID, $financingID, $spouseData);
                if (!$spouseID) {
                    $this->db->rollBack();
                    $this->jsonResponse(['success' => false, 'message' => 'Unable to save spouse details.'], 500);
                    return;
                }
            }

            $submissionDate = date('Y-m-d');
            
            $savedPrequalID = $this->prequalModel->savePrequal(
                $clientID,
                $agentID,
                $propertyID,
                $financingID,
                $spouseID,
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
}
