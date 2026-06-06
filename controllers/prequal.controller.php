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
        $financingID      = trim($data['financing_id']      ?? ''); // From edit mode
        $coOwnerID        = trim($data['co_owner_id']       ?? ''); // From edit mode

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
        $coOwnerData = null;

        if ($coOwner === 'yes') {
            $raw = $data['coOwner'] ?? [];

            $coOwnerData = [
                'relationship'      => trim($raw['relationship']      ?? ''),
                'firstname'         => trim($raw['firstname']         ?? ''),
                'lastname'          => trim($raw['lastname']          ?? ''),
                'mi'                => trim($raw['mi']                ?? ''),
                'suffix'            => trim($raw['suffix']            ?? ''),
                'email'             => trim($raw['email']             ?? ''),
                'phone'             => trim($raw['phone']             ?? ''),
                'employment_status' => trim($raw['employment_status'] ?? ''),
                'monthly_income'    => trim($raw['monthly_income']    ?? '')
            ];
        }

        // ── Save ─────────────────────────────────────────────────────────────
        try {
            if ($this->db->beginTransaction() === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Unable to start transaction.'], 500);
                return;
            }

            // If a prequal already exists for this client+property+agent, update it — never insert a duplicate
            $existingPrequal = $this->prequalModel->getPrequalByClientPropertyAgent($clientID, $propertyID, $agentID);
            if ($existingPrequal) {
                $this->db->rollBack();
                $data = $this->parseRequestData();
                $data['prequal_id']   = $existingPrequal['prequalID'];
                $data['financing_id'] = $existingPrequal['financingID'];
                $data['co_owner_id']  = $existingPrequal['coOwnerID'] ?? '';
                $this->updatePrequal($data);
                return;
            }

            $prequalID = $this->prequalModel->generateId('PQ');

            // If financingID provided (edit mode), update it; otherwise create new (copy mode)
            if (empty($financingID)) {
                // Copy mode: Create NEW financing record
                $financingID = $this->prequalModel->saveFinancing($prequalID, $financingData);
                if (!$financingID) {
                    $this->db->rollBack();
                    $this->jsonResponse(['success' => false, 'message' => 'Unable to save financing.'], 500);
                    return;
                }
            } else {
                // Edit mode: Update existing financing record
                if (!$this->prequalModel->updateFinancing($financingID, $financingData)) {
                    $this->db->rollBack();
                    $this->jsonResponse(['success' => false, 'message' => 'Unable to update financing.'], 500);
                    return;
                }
            }

            // Handle co-owner
            if ($coOwner === 'yes' && $coOwnerData !== null) {

                // Build co-owner financing data (used for both insert and update paths)
                $coFinancingType = trim($data['coOwner']['financing_type'] ?? $financingType);
                $coOwnerFinancingData = [
                    'co_financing_type'          => $coFinancingType,
                    'co_contribution_start_date' => null,
                    'co_current_loan'            => null,
                    'co_bank_name'               => null,
                    'co_existing_house_loan'     => null,
                    'co_cancelled_house_loan'    => null,
                ];
                if ($coFinancingType === 'pagibig') {
                    $coContributionDate = trim($data['coOwner']['pagibig']['contribution_start_date'] ?? '');
                    $coOwnerFinancingData['co_contribution_start_date'] = !empty($coContributionDate) ? $coContributionDate : null;
                    $coCurrentLoan = trim($data['coOwner']['pagibig']['current_loan'] ?? '');
                    $coOwnerFinancingData['co_current_loan'] = !empty($coCurrentLoan) ? $coCurrentLoan : null;
                } elseif ($coFinancingType === 'bank') {
                    $coBankName = trim($data['coOwner']['bank']['bank_name'] ?? '');
                    $coOwnerFinancingData['co_bank_name'] = !empty($coBankName) ? $coBankName : null;
                    $coExistingLoan = trim($data['coOwner']['bank']['existing_house_loan'] ?? '');
                    $coOwnerFinancingData['co_existing_house_loan'] = !empty($coExistingLoan) ? $coExistingLoan : null;
                    $coCancelledLoan = trim($data['coOwner']['bank']['cancelled_house_loan'] ?? '');
                    $coOwnerFinancingData['co_cancelled_house_loan'] = !empty($coCancelledLoan) ? $coCancelledLoan : null;
                }

                if (!empty($coOwnerID)) {
                    // Edit mode: update existing co-owner record and financing
                    if (!$this->prequalModel->updateCoOwner($coOwnerID, $coOwnerData)) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to update co-owner details.'], 500);
                        return;
                    }
                    if (!$this->prequalModel->saveCoOwnerFinancing($coOwnerID, $coOwnerFinancingData)) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to update co-owner financing.'], 500);
                        return;
                    }
                } else {
                    // Fresh save: insert co-owner with financing in one shot
                    $coOwnerID = $this->prequalModel->savecoOwner($prequalID, $financingID, $coOwnerData, $coOwnerFinancingData);
                    if (!$coOwnerID) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to save co-owner details.'], 500);
                        return;
                    }
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

            // CREATE RESERVATION AFTER PREQUAL SUCCESS
            $createdReservation = $this->prequalModel->createReservation(
                $savedPrequalID,
                $agentID
            );

            if (!$createdReservation) {
                $this->db->rollBack();
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Prequal saved but reservation failed.'
                ], 500);
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
            // Step 1: Try exact match (same client + same property + same agent)
            $prequalRecord = $this->prequalModel->getPrequalByClientPropertyAgent($clientID, $propertyID, $agentID);
            
            // Step 2: If no exact match, try same client + same agent (different property)
            if (!$prequalRecord) {
                $prequalRecord = $this->prequalModel->getLatestPrequalByClientAgent($clientID, $agentID);
            }

            // Step 3: If still no match, try same client only (different agent and/or property)
            if (!$prequalRecord) {
                $prequalRecord = $this->prequalModel->getLatestPrequalByClient($clientID);
            }

            if (!$prequalRecord) {
                $this->jsonResponse(['success' => false, 'message' => 'No pre-qualification record found.'], 404);
                return;
            }

            $response = [
                'success' => true,
                'data' => [
                    'prequalID' => $prequalRecord['prequalID'],
                    'financingID' => $prequalRecord['financingID'],
                    'coOwnerID' => $prequalRecord['coOwnerID'],
                    'sourcePropertyID' => $prequalRecord['propertyID'],
                    'sourceAgentID' => $prequalRecord['agentID'],
                    'isSameProperty' => ($prequalRecord['propertyID'] === $propertyID),
                    'isSameAgent' => ($prequalRecord['agentID'] === $agentID),
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
                    'existing_house_loan' => strtolower($prequalRecord['existingHouseLoan'] ?? ''),
                    'cancelled_house_loan' => strtolower($prequalRecord['cancelledHouseLoan'] ?? '')
                ];
            } elseif ($prequalRecord['financingType'] === 'pagibig') {
                $response['data']['pagibig'] = [
                    'contribution_start_date' => $prequalRecord['contributionStartDate'] ?? '',
                    'current_loan' => strtolower($prequalRecord['currentLoan'] ?? '')
                ];
            }

            // Determine co_owner status from current prequal record only
            if ($prequalRecord['coOwnerID'] && !empty($prequalRecord['coOwnerID'])) {
                $response['data']['co_owner'] = 'yes';
                $coOwnerRow = $prequalRecord;
            } else {
                $response['data']['co_owner'] = 'no';
                // Fallback: get most recent co-owner data for availability (but don't set flag)
                $coOwnerRow = $this->prequalModel->getFullCoOwnerByClient($clientID);
            }

            // Return co-owner data if available (regardless of co_owner flag)
            if ($coOwnerRow && !empty($coOwnerRow['coOwnerID'])) {
                $response['data']['coOwner'] = [
                    'relationship'      => $coOwnerRow['coOwnerRelationship'] ?? '',
                    'firstname'         => $coOwnerRow['coOwnerFName']        ?? '',
                    'mi'                => $coOwnerRow['coOwnerMName']        ?? '',
                    'lastname'          => $coOwnerRow['coOwnerLName']        ?? '',
                    'suffix'            => $coOwnerRow['coOwnerSuffix']       ?? '',
                    'email'             => $coOwnerRow['coOwnerEmail']        ?? '',
                    'phone'             => $coOwnerRow['coOwnerPhoneNum']     ?? '',
                    'employment_status' => $coOwnerRow['coOwnerEmpStatus']    ?? '',
                    'monthly_income'    => $coOwnerRow['coOwnerMonthlyIncome'] ?? '',
                    'financing_type'    => $coOwnerRow['coFinancingType']     ?? ''
                ];

                $coFinancingType = $coOwnerRow['coFinancingType'] ?? '';
                if ($coFinancingType === 'bank') {
                    $response['data']['coOwner']['bank'] = [
                        'bank_name'           => $coOwnerRow['coBankName']           ?? '',
                        'existing_house_loan'  => strtolower($coOwnerRow['coExistingHouseLoan']  ?? ''),
                        'cancelled_house_loan' => strtolower($coOwnerRow['coCancelledHouseLoan'] ?? '')
                    ];
                } elseif ($coFinancingType === 'pagibig') {
                    $response['data']['coOwner']['pagibig'] = [
                        'contribution_start_date' => $coOwnerRow['coContributionStart'] ?? '',
                        'current_loan'             => strtolower($coOwnerRow['coCurrentLoan'] ?? '')
                    ];
                }
            }


            $this->jsonResponse($response);

        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    private function updatePrequal(array $injectedData = []): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;
        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $data = !empty($injectedData) ? $injectedData : $this->parseRequestData();

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

                // Build co-owner financing data upfront (shared by both paths)
                $coFinancingType = trim($data['coOwner']['financing_type'] ?? $financingType);
                $coOwnerFinancingData = [
                    'co_financing_type'          => $coFinancingType,
                    'co_contribution_start_date' => null,
                    'co_current_loan'            => null,
                    'co_bank_name'               => null,
                    'co_existing_house_loan'     => null,
                    'co_cancelled_house_loan'    => null,
                ];
                if ($coFinancingType === 'pagibig') {
                    $coContributionDate = trim($data['coOwner']['pagibig']['contribution_start_date'] ?? '');
                    $coOwnerFinancingData['co_contribution_start_date'] = !empty($coContributionDate) ? $coContributionDate : null;
                    $coCurrentLoan = trim($data['coOwner']['pagibig']['current_loan'] ?? '');
                    $coOwnerFinancingData['co_current_loan'] = !empty($coCurrentLoan) ? $coCurrentLoan : null;
                } elseif ($coFinancingType === 'bank') {
                    $coBankName = trim($data['coOwner']['bank']['bank_name'] ?? '');
                    $coOwnerFinancingData['co_bank_name'] = !empty($coBankName) ? $coBankName : null;
                    $coExistingLoan = trim($data['coOwner']['bank']['existing_house_loan'] ?? '');
                    $coOwnerFinancingData['co_existing_house_loan'] = !empty($coExistingLoan) ? $coExistingLoan : null;
                    $coCancelledLoan = trim($data['coOwner']['bank']['cancelled_house_loan'] ?? '');
                    $coOwnerFinancingData['co_cancelled_house_loan'] = !empty($coCancelledLoan) ? $coCancelledLoan : null;
                }

                if ($oldCoOwnerID) {
                    // Existing co-owner: update personal details then financing
                    if (!$this->prequalModel->updateCoOwner($oldCoOwnerID, $coOwnerData)) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to update co-owner details.'], 500);
                        return;
                    }
                    if (!$this->prequalModel->saveCoOwnerFinancing($oldCoOwnerID, $coOwnerFinancingData)) {
                        $this->db->rollBack();
                        $this->jsonResponse(['success' => false, 'message' => 'Unable to update co-owner financing.'], 500);
                        return;
                    }
                    $coOwnerID = $oldCoOwnerID;
                } else {
                    // No existing co-owner: insert with all fields in one shot
                    $coOwnerID = $this->prequalModel->savecoOwner($prequalID, $financingID, $coOwnerData, $coOwnerFinancingData);
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