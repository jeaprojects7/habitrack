<?php
/**
 * HabiTrack – Dashboard Controller
 * Handles AJAX requests for map filtering and property searches.
 * All AJAX actions are processed here and return JSON.
 */

session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/habitrack/models/connection.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/habitrack/models/dashboard.model.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/habitrack/models/prequal.model.php");

header('Content-Type: application/json');

try {
    $connection = new Connection();
    $db = $connection->connect();
    $dashboardModel = new DashboardModel($db);
    
    $action = isset($_GET['action']) ? $_GET['action'] : 'search';
    
    // ────────────────────────────────────────────────
    //  SEARCH: Filter properties and return markers
    // ────────────────────────────────────────────────
    if ($action === 'search') {
        $filters = [
            'type'           => $_REQUEST['type'] ?? '',
            'location'       => $_REQUEST['location'] ?? '',
            'storey'         => $_REQUEST['storey'] ?? '',
            'bedroom'        => $_REQUEST['bedroom'] ?? '',
            'tb'             => $_REQUEST['tb'] ?? '',
            'floorArea'      => $_REQUEST['floorArea'] ?? '',
            'lotAreaHouse'   => $_REQUEST['lotAreaHouse'] ?? '',
            'lotArea'        => $_REQUEST['lotArea'] ?? '',
            'sizeRange'      => $_REQUEST['sizeRange'] ?? '',
            'propertyName'   => $_REQUEST['propertyName'] ?? '',
            'priceStart'     => $_REQUEST['priceStart'] ?? '',
            'priceEnd'       => $_REQUEST['priceEnd'] ?? '',
            'amenities'      => isset($_REQUEST['amenities']) ? (array) $_REQUEST['amenities'] : [],
        ];
        
        $filters = array_filter($filters, function($v) {
            return $v !== '' && (!is_array($v) || !empty($v));
        });
        
        $results = $dashboardModel->searchProperties($filters);
        
        // FIX: use explicit variables to avoid PHP string-concat operator precedence bug
        $data = array_map(function($p) {
            $city = $p['propertyCity'] ?? '';
            $brgy = $p['propertyBrgy'] ?? '';
            return [
                'id'       => $p['propertyID'] ?? 0,
                'name'     => $p['propertyName'] ?? '',
                'type'     => $p['propertyType'] ?? '',
                'location' => $city . ' - ' . $brgy,
                'addr'     => $city . ', ' . $brgy,
                'bedroom'  => $p['houseBedroom'] ?? 0,
                'tb'       => $p['houseTandB'] ?? 0,
                'price'    => $p['propertyPrice'] ?? 0,
                'lat'      => floatval($p['lat'] ?? 0),
                'lng'      => floatval($p['lng'] ?? 0),
            ];
        }, $results);
        
        echo json_encode([
            'success'  => true,
            'count'    => count($data),
            'data'     => $data,
            'filters'  => $filters
        ]);
    }
    // ────────────────────────────────────────────────
    //  GET-ALL: Return all properties for initial load
    // ────────────────────────────────────────────────
    else if ($action === 'getAll') {
        $sql = "SELECT 
                    propertyID,
                    propertyName,
                    propertyType,
                    propertyCity,
                    propertyBrgy,
                    propertyPrice,
                    houseBedroom,
                    houseTandB,
                    propertyLat   AS lat,
                    propertyLng   AS lng
                FROM properties
                WHERE propertyLat IS NOT NULL 
                  AND propertyLng IS NOT NULL
                  AND propertyStatus = 'Available'
                ORDER BY propertyName";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // FIX: same string concatenation fix
        $data = array_map(function($p) {
            $city = $p['propertyCity'] ?? '';
            $brgy = $p['propertyBrgy'] ?? '';
            return [
                'id'       => $p['propertyID'] ?? 0,
                'name'     => $p['propertyName'] ?? '',
                'type'     => $p['propertyType'] ?? '',
                'location' => $city . ' - ' . $brgy,
                'addr'     => $city . ', ' . $brgy,
                'bedroom'  => $p['houseBedroom'] ?? 0,
                'tb'       => $p['houseTandB'] ?? 0,
                'price'    => $p['propertyPrice'] ?? 0,
                'lat'      => floatval($p['lat'] ?? 0),
                'lng'      => floatval($p['lng'] ?? 0),
            ];
        }, $results);
        
        echo json_encode([
            'success' => true,
            'count'   => count($data),
            'data'    => $data
        ]);
    }
    // ────────────────────────────────────────────────
    //  GET-DETAIL: Get full property details by ID
    // ────────────────────────────────────────────────
    else if ($action === 'getDetail') {
        $propertyID = isset($_GET['id']) ? trim($_GET['id']) : '';
        
        if (empty($propertyID)) {
            echo json_encode(['success' => false, 'error' => 'Invalid property ID']);
            exit;
        }
        
        $sql = "SELECT p.*,
                    (
                        SELECT imagePath 
                        FROM property_images 
                        WHERE propertyID = p.propertyID 
                        ORDER BY imageOrder ASC
                        LIMIT 1
                    ) AS imagePath
                FROM properties p
                WHERE p.propertyID = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $propertyID]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($property) {
            echo json_encode(['success' => true, 'data' => $property]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Property not found']);
        }
    }
    else if ($action === 'getAgents') {
        $stmt = $db->query("SELECT * FROM agent ORDER BY agentFName");
        $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $agents]);
    }
    else {
        echo json_encode([
            'success' => false,
            'error'   => 'Invalid action: ' . htmlspecialchars($action)
        ]);
    }
    
} catch (Exception $e) {
    error_log("Dashboard Controller Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error'   => 'Server error: ' . $e->getMessage()
    ]);
}

?>