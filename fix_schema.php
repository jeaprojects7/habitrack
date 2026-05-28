<?php
/**
 * Database migration helper - Call this once to fix schema
 * Access via: http://localhost/habitrack/fix_schema.php
 */

require_once __DIR__ . '/models/connection.php';

header('Content-Type: application/json');

try {
    $connection = new Connection();
    $db = $connection->connect();
    
    // List of SQL commands to make financing fields nullable
    $migrations = [
        "ALTER TABLE `financing` MODIFY COLUMN `contributionStartDate` varchar(10) NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `currentLoan` enum('Yes','No') NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `bankName` varchar(50) NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `existingHouseLoan` enum('Yes','No') NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `cancelledHouseLoan` enum('Yes','No') NULL DEFAULT NULL"
    ];
    
    $results = [];
    foreach ($migrations as $sql) {
        try {
            $db->exec($sql);
            $results[] = [
                'sql' => $sql,
                'status' => 'success'
            ];
        } catch (Exception $e) {
            $results[] = [
                'sql' => $sql,
                'status' => 'error',
                'error' => $e->getMessage()
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Schema migration completed',
        'migrations' => $results
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
