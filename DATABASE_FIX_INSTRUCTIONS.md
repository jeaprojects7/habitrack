# Database Schema Fix Required

## Problem
The `financing` table has `contributionStartDate` and other fields defined as `NOT NULL`, but the application tries to insert NULL values for Bank financing (which doesn't have a contribution start date).

## Solution

Run ONE of the following methods:

### Method 1: Using phpMyAdmin (Easiest)
1. Go to http://localhost/phpmyadmin
2. Select database `habitrack`
3. Click on the `financing` table
4. Click on Structure tab
5. Edit each of these columns and change "Null" to "Yes":
   - contributionStartDate
   - currentLoan
   - bankName
   - existingHouseLoan
   - cancelledHouseLoan

### Method 2: Using the browser (Automatic)
1. Open http://localhost/habitrack/fix_schema.php
2. Check if the message says "success": true
3. Done!

### Method 3: Using MySQL command line
```sql
ALTER TABLE `financing` MODIFY COLUMN `contributionStartDate` varchar(10) NULL DEFAULT NULL;
ALTER TABLE `financing` MODIFY COLUMN `currentLoan` enum('Yes','No') NULL DEFAULT NULL;
ALTER TABLE `financing` MODIFY COLUMN `bankName` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `financing` MODIFY COLUMN `existingHouseLoan` enum('Yes','No') NULL DEFAULT NULL;
ALTER TABLE `financing` MODIFY COLUMN `cancelledHouseLoan` enum('Yes','No') NULL DEFAULT NULL;
```

## After Fix
The application will now properly save pre-qualifications with either Bank or Pag-Ibig financing.

- Bank financing: contribution_start_date will be NULL
- Pag-Ibig financing: other bank-related fields will be NULL
