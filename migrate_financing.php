<?php
/**
 * Migration Script: Make financing fields nullable
 * This script fixes the database schema to allow NULL values in financing fields
 * since not all fields are used for every financing type (e.g., Bank doesn't need contributionStartDate)
 */

require_once __DIR__ . '/models/connection.php';

try {
    $connection = new Connection();
    $db = $connection->connect();
    
    // List of SQL commands to run
    $migrations = [
        "ALTER TABLE `financing` MODIFY COLUMN `contributionStartDate` varchar(10) NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `currentLoan` enum('Yes','No') NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `bankName` varchar(50) NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `existingHouseLoan` enum('Yes','No') NULL DEFAULT NULL",
        "ALTER TABLE `financing` MODIFY COLUMN `cancelledHouseLoan` enum('Yes','No') NULL DEFAULT NULL"
    ];
    
    foreach ($migrations as $sql) {
        echo "Executing: $sql\n";
        $db->exec($sql);
        echo "✓ Success\n\n";
    }
    
    echo "Migration completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    http_response_code(500);
    exit;
}
?>
