<?php
// controllers/AgentController.php

require_once __DIR__ . '/../models/calendar.model.php';

class AgentController {
    private $agentModel;

    public function __construct($db) {
        $this->agentModel = new AgentModel($db);
    }

    /**
     * Handle incoming AJAX requests.
     * Route: ?action=getAgents
     */
    public function handleRequest(): void {
        // Only allow AJAX/XHR requests
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
               && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if (!$isAjax) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request.'], 400);
            return;
        }

        $action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

        switch ($action) {
            case 'getAgents':
                $this->getAgents();
                break;
            case 'getProperties':
                $this->getProperties();
                break;
            case 'getBookedDates':
                $this->getBookedDates();
                break;
            case 'getBookedVisitDetails':
                $this->getBookedVisitDetails();
                break;
            case 'saveSiteVisit':
                $this->saveSiteVisit();
                break;
            default:
                $this->jsonResponse(['success' => false, 'message' => 'Unknown action.'], 400);
                break;
        }
    }

    /**
     * Return all agents as JSON for the dropdown.
     * Response shape:
     * {
     *   "success": true,
     *   "agents": [
     *     { "id": 1, "agentID": "C0001", "fullName": "Juan A. dela Cruz" },
     *     ...
     *   ]
     * }
     */
    private function getAgents(): void {
        $rows   = $this->agentModel->getAllAgents();
        $agents = [];

        foreach ($rows as $row) {
            $agents[] = [
                'id'       => $row['id'],
                'agentID'  => $row['agentID'],
                'fullName' => AgentModel::buildFullName($row),
            ];
        }

        $this->jsonResponse(['success' => true, 'agents' => $agents]);
    }

    /**
     * Return all properties as JSON for the dropdown.
     * Response shape:
     * {
     *   "success": true,
     *   "properties": [
     *     { "id": 1, "propertyID": "P001", "propertyName": "Akina Villas" },
     *     ...
     *   ]
     * }
     */
    private function getProperties(): void {
        $rows       = $this->agentModel->getAllProperties();
        $properties = [];

        foreach ($rows as $row) {
            $properties[] = [
                'id'           => $row['id'],
                'propertyID'   => $row['propertyID'],
                'propertyName' => $row['propertyName'],
            ];
        }

        $this->jsonResponse(['success' => true, 'properties' => $properties]);
    }

    /**
     * Return all booked calendar dates.
     */
    private function getBookedDates(): void {
        $dates = $this->agentModel->getBookedDates();
        $this->jsonResponse(['success' => true, 'dates' => $dates]);
    }

    /**
     * Return booked visit details for calendar display.
     */
    private function getBookedVisitDetails(): void {
        $details = $this->agentModel->getBookedVisitDetails();
        $this->jsonResponse(['success' => true, 'details' => $details]);
    }

    /**
     * Send a JSON response and exit.
     */
    private function jsonResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data);
        exit;
    }

    /**
     * Handle saving a site visit booking via AJAX POST.
     * Expects: agentID, propertyID, siteVisitDate, siteVisitTime
     */
    private function saveSiteVisit(): void {
        // Ensure session is started so we can read current user/client
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Determine client id from session (support common keys)
        // Login sets $_SESSION['clientID'], so check that first (case-sensitive)
        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $agentID = isset($_POST['agentID']) ? trim($_POST['agentID']) : null;
        $propertyID = isset($_POST['propertyID']) ? trim($_POST['propertyID']) : null;
        $siteVisitDate = isset($_POST['siteVisitDate']) ? trim($_POST['siteVisitDate']) : null;
        $siteVisitTime = isset($_POST['siteVisitTime']) ? trim($_POST['siteVisitTime']) : null;

        if (!$agentID || !$propertyID || !$siteVisitDate || !$siteVisitTime) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        // Normalize time to explicit 12-hour AM/PM format to fit VARCHAR(8).
        $normalizedTime = strtoupper(date('h:i A', strtotime($siteVisitTime)));
        if (!$normalizedTime) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid time format.'], 400);
            return;
        }
        $siteVisitTime = $normalizedTime;

        // Prevent booking dates before today.
        $bookingDate = DateTime::createFromFormat('Y-m-d', $siteVisitDate);
        $today = new DateTime('today');
        if (!$bookingDate) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid booking time for date.'], 400);
            return;
        }
        if ($bookingDate < $today) {
            $this->jsonResponse(['success' => false, 'message' => 'Cannot book past dates. Please choose a current or future date.' ], 400);
            return;
        }

        // Prevent selecting a time earlier than now when booking today.
        $todayString = $today->format('Y-m-d');
        if ($siteVisitDate === $todayString) {
            // Parse the booking time - format is like "01:30 AM" or "01:30 PM"
            $bookingDateTime = DateTime::createFromFormat('Y-m-d h:i A', $siteVisitDate . ' ' . $siteVisitTime);
           
            // Get current time
            $now = new DateTime();
            
            if ($bookingDateTime <= $now) {
                $this->jsonResponse(['success' => false, 'message' => 'Please choose a future time for today. Selected time has already passed.'], 400);
                return;
            }
        }

        if ($this->agentModel->isDateBooked($siteVisitDate)) {
            $this->jsonResponse(['success' => false, 'message' => 'That date is already booked. Please choose another day.'], 409);
            return;
        }

        // Save using model
        try {
            $saved = $this->agentModel->saveSiteVisit($clientID, $agentID, $propertyID, $siteVisitDate, $siteVisitTime);
            if ($saved === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to save booking.']);
                return;
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Booking saved.',
                'id' => $saved['id'],
                'siteVisitID' => $saved['siteVisitID'],
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}


// ── Bootstrap (entry point) ──────────────────────────────────────────────────
// Place this block in a dedicated file, e.g. ajax/agents.php
//
// require_once __DIR__ . '/../config/database.php'; // your DB connection
// $controller = new AgentController($db);            // pass PDO instance
// $controller->handleRequest();
