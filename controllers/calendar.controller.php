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
            case 'getReservationDetails':
                $this->getReservationDetails();
                break;
            case 'saveSiteVisit':
                $this->saveSiteVisit();
                break;
            case 'getClientBookings':
                $this->getClientBookings();
                break;
            case 'cancelSiteVisit':
                $this->cancelSiteVisit();
                break;
            default:
                $this->jsonResponse(['success' => false, 'message' => 'Unknown action.'], 400);
                break;
        }
    }

    /**
     * Return all agents as JSON for the dropdown.
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
     * Return reservation details (agent and property info) for auto-fill.
     * Expects: reservationID in GET/POST
     */
    private function getReservationDetails(): void {
        $reservationID = isset($_GET['reservationID']) ? $_GET['reservationID'] : (isset($_POST['reservationID']) ? $_POST['reservationID'] : null);

        if (!$reservationID) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing reservationID.'], 400);
            return;
        }

        require_once __DIR__ . '/../models/reservations.model.php';
        $reservation = ModelReservation::mdlGetReservationById($reservationID);

        if (!$reservation) {
            $this->jsonResponse(['success' => false, 'message' => 'Reservation not found.'], 404);
            return;
        }

        $agent = null;
        $agentID = $reservation['agentID'];

        if (is_numeric($agentID)) {
            $agent = $this->agentModel->getAgentById((int)$agentID);
        }

        if (!$agent) {
            $agents = $this->agentModel->getAllAgents();
            foreach ($agents as $a) {
                if ($a['agentID'] === $agentID) {
                    $agent = $a;
                    break;
                }
            }
        }

        $agentName = $agent ? AgentModel::buildFullName($agent) : '';
        $agentDbId = $agent ? $agent['id'] : $agentID;

        $this->jsonResponse([
            'success'      => true,
            'agentID'      => $agentDbId,
            'agentCode'    => $agentID,
            'agentName'    => $agentName,
            'propertyID'   => $reservation['propertyID'],
            'propertyName' => $reservation['propertyName'],
        ]);
    }

    /**
     * Return all BOOKED site visits for the currently logged-in client.
     * Used to populate the cancel-visit selection modal.
     */
    private function getClientBookings(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $bookings = $this->agentModel->getBookingsByClientId((string)$clientID);
        $this->jsonResponse(['success' => true, 'bookings' => $bookings]);
    }

    /**
     * Cancel a site visit booking.
     * Expects: siteVisitID in POST.
     * Only cancels visits that belong to the logged-in client.
     */
    private function cancelSiteVisit(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $siteVisitID = isset($_POST['siteVisitID']) ? trim($_POST['siteVisitID']) : null;

        if (!$siteVisitID) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing siteVisitID.'], 400);
            return;
        }

        $cancelled = $this->agentModel->cancelSiteVisit($siteVisitID, (string)$clientID);

        if ($cancelled) {
            $this->jsonResponse(['success' => true, 'message' => 'Booking cancelled successfully.']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Could not cancel booking. It may already be cancelled or not belong to your account.'], 409);
        }
    }

    /**
     * Handle saving a site visit booking via AJAX POST.
     * Expects: agentID, propertyID, siteVisitDate, siteVisitTime
     */
    private function saveSiteVisit(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

        if (!$clientID) {
            $this->jsonResponse(['success' => false, 'message' => 'User not authenticated.'], 401);
            return;
        }

        $agentID       = isset($_POST['agentID'])       ? trim($_POST['agentID'])       : null;
        $propertyID    = isset($_POST['propertyID'])    ? trim($_POST['propertyID'])    : null;
        $siteVisitDate = isset($_POST['siteVisitDate']) ? trim($_POST['siteVisitDate']) : null;
        $siteVisitTime = isset($_POST['siteVisitTime']) ? trim($_POST['siteVisitTime']) : null;

        if (!$agentID || !$propertyID || !$siteVisitDate || !$siteVisitTime) {
            $this->jsonResponse(['success' => false, 'message' => 'Missing required fields.'], 400);
            return;
        }

        $normalizedTime = strtoupper(date('h:i A', strtotime($siteVisitTime)));
        if (!$normalizedTime) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid time format.'], 400);
            return;
        }
        $siteVisitTime = $normalizedTime;

        $bookingDate = DateTime::createFromFormat('Y-m-d', $siteVisitDate);
        $today = new DateTime('today');
        if (!$bookingDate) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid booking time for date.'], 400);
            return;
        }
        if ($bookingDate < $today) {
            $this->jsonResponse(['success' => false, 'message' => 'Cannot book past dates. Please choose a current or future date.'], 400);
            return;
        }

        $todayString = $today->format('Y-m-d');
        if ($siteVisitDate === $todayString) {
            $bookingDateTime = DateTime::createFromFormat('Y-m-d h:i A', $siteVisitDate . ' ' . $siteVisitTime);
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

        try {
            $saved = $this->agentModel->saveSiteVisit($clientID, $agentID, $propertyID, $siteVisitDate, $siteVisitTime);
            if ($saved === false) {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to save booking.']);
                return;
            }

            $this->jsonResponse([
                'success'     => true,
                'message'     => 'Booking saved.',
                'id'          => $saved['id'],
                'siteVisitID' => $saved['siteVisitID'],
            ]);
        } catch (Exception $e) {
            $this->jsonResponse(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
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
}
