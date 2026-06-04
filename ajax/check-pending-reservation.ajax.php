<?php
session_start();

require_once __DIR__ . '/../models/connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['clientID'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Not authenticated'
    ]);
    exit;
}

$clientID = $_SESSION['clientID'];
$propertyID = isset($_GET['propertyID']) ? trim($_GET['propertyID']) : null;

if (!$propertyID) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Property ID is required'
    ]);
    exit;
}

try {
    $stmt = (new Connection)->connect()->prepare("
        SELECT prequalID, prequalStatus, clientID, propertyID
        FROM prequal
        WHERE clientID = :clientID 
        AND propertyID = :propertyID
        LIMIT 1
    ");
    
    $stmt->bindParam(":clientID", $clientID, PDO::PARAM_STR);
    $stmt->bindParam(":propertyID", $propertyID, PDO::PARAM_STR);
    $stmt->execute();
    
    $prequal = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($prequal) {
        echo json_encode([
            'success' => true,
            'hasExisting' => true,
            'prequalID' => $prequal['prequalID'],
            'prequalStatus' => $prequal['prequalStatus']
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'hasExisting' => false
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
