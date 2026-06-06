-- Align clientcoprequal (cofinancing) table structure with financing table
-- Make all cofinancing fields nullable and match financing table data types

-- Make coFinancingType nullable (it was NOT NULL, now should be nullable like financingType)
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coFinancingType` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- Ensure coContributionStart is DATE type and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coContributionStart` date NULL DEFAULT NULL;

-- Ensure coCurrentLoan is enum and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coCurrentLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- Ensure coBankName is varchar and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coBankName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- Ensure coExistingHouseLoan is enum and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coExistingHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- Ensure coCancelledHouseLoan is enum and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coCancelledHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

-- Ensure coFinancingStatus is enum and nullable
ALTER TABLE `clientcoprequal` MODIFY COLUMN `coFinancingStatus` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;
