<?php
header('Content-Type: application/json');

try {
    require_once 'models/connection.php';
    
    $changes = [];
    $errors = [];
    
    // Make coFinancingType nullable (change from NOT NULL)
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coFinancingType` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coFinancingType - Changed to nullable";
    } catch (Exception $e) {
        $errors[] = "coFinancingType: " . $e->getMessage();
    }
    
    // Ensure coContributionStart is date type and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coContributionStart` date NULL DEFAULT NULL");
        $changes[] = "✓ coContributionStart - Ensured as DATE and nullable";
    } catch (Exception $e) {
        $errors[] = "coContributionStart: " . $e->getMessage();
    }
    
    // Ensure coCurrentLoan is enum and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coCurrentLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coCurrentLoan - Ensured as ENUM and nullable";
    } catch (Exception $e) {
        $errors[] = "coCurrentLoan: " . $e->getMessage();
    }
    
    // Ensure coBankName is varchar and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coBankName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coBankName - Ensured as VARCHAR(50) and nullable";
    } catch (Exception $e) {
        $errors[] = "coBankName: " . $e->getMessage();
    }
    
    // Ensure coExistingHouseLoan is enum and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coExistingHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coExistingHouseLoan - Ensured as ENUM and nullable";
    } catch (Exception $e) {
        $errors[] = "coExistingHouseLoan: " . $e->getMessage();
    }
    
    // Ensure coCancelledHouseLoan is enum and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coCancelledHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coCancelledHouseLoan - Ensured as ENUM and nullable";
    } catch (Exception $e) {
        $errors[] = "coCancelledHouseLoan: " . $e->getMessage();
    }
    
    // Ensure coFinancingStatus is enum and nullable
    try {
        $db->exec("ALTER TABLE `clientcoprequal` MODIFY COLUMN `coFinancingStatus` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL");
        $changes[] = "✓ coFinancingStatus - Ensured as ENUM and nullable";
    } catch (Exception $e) {
        $errors[] = "coFinancingStatus: " . $e->getMessage();
    }
    
    echo json_encode([
        'success' => empty($errors),
        'changes' => $changes,
        'errors' => $errors,
        'message' => empty($errors) ? 'All cofinancing columns successfully aligned with financing table' : 'Some columns had issues'
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
?>
