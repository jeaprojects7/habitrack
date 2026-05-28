<?php
/**
 * Consolidated AJAX endpoint for dashboard filters
 * Parameters:
 *   - action: 'getFilters' or 'getProperties'
 *   - type: Property type (House/Lot) for filtering
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/habitrack/models/connection.php");

header('Content-Type: application/json');

try {
    $action = isset($_GET['action']) ? $_GET['action'] : 'getFilters';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    
    $connection = new Connection();
    $db = $connection->connect();

    if ($action === 'getProperties') {
        // Get property names by type
        if (empty($type)) {
            echo json_encode([
                'success' => false,
                'error' => 'Property type required'
            ]);
            exit;
        }

        $stmt = $db->prepare("SELECT DISTINCT propertyName FROM properties WHERE propertyType = :type AND propertyStatus = 'Available' ORDER BY propertyName");
        $stmt->execute([':type' => $type]);
        $properties = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode([
            'success' => true,
            'data' => $properties
        ]);

    } else if ($action === 'getAmenities') {
        // Get amenities where value = 1
        $amenityColumns = [
            'housePowderRoom' => 'Powder Room',
            'houseGarage' => 'Garage',
            'houseBalcony' => 'Balcony',
            'houseTerrace' => 'Terrace',
            'housePool' => 'Pool',
            'houseLaundryArea' => 'Laundry Area',
            'houseMaidRoom' => 'Maid Room',
            'houseCabinets' => 'Cabinets',
            'houseBilliardRoom' => 'Billiard Room',
            'houseClubhouse' => 'Clubhouse',
            'houseGarden' => 'Garden'
        ];

        $amenities = [];

        foreach ($amenityColumns as $column => $label) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM properties WHERE $column = 1 AND propertyStatus = 'Available'");
            $stmt->execute();
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $amenities[] = [
                    'value' => $column,
                    'label' => $label
                ];
            }
        }

        echo json_encode([
            'success' => true,
            'data' => $amenities
        ]);

    } else {
        // Get filter options (default action)
        $filters = [
            'propertyType' => [],
            'locations' => [],
            'houseStorey' => [],
            'houseBedroom' => [],
            'houseTandB' => [],
            'houseFloorArea' => [],
            'propertyLotArea' => [],
            'propertyStatus' => []
        ];

        // Get distinct property types
        $stmtType = $db->query("SELECT DISTINCT propertyType FROM properties WHERE propertyType IS NOT NULL AND propertyStatus = 'Available' ORDER BY propertyType");
        $filters['propertyType'] = $stmtType->fetchAll(PDO::FETCH_COLUMN);

        if ($type) {
            // Get distinct locations for specific property type
            $stmtLocation = $db->prepare("SELECT DISTINCT propertyCity, propertyBrgy FROM properties WHERE propertyType = :type AND propertyCity IS NOT NULL AND propertyBrgy IS NOT NULL AND propertyStatus = 'Available' ORDER BY propertyCity, propertyBrgy");
            $stmtLocation->execute([':type' => $type]);
            $locations = $stmtLocation->fetchAll(PDO::FETCH_ASSOC);
            $filters['locations'] = array_map(function($loc) {
                return [
                    'city' => $loc['propertyCity'],
                    'brgy' => $loc['propertyBrgy'],
                    'display' => $loc['propertyCity'] . ' - ' . $loc['propertyBrgy']
                ];
            }, $locations);

            // Get distinct storeys for specific property type
            $stmtStorey = $db->prepare("SELECT DISTINCT houseStorey FROM properties WHERE propertyType = :type AND houseStorey IS NOT NULL AND houseStorey > 0 AND propertyStatus = 'Available' ORDER BY houseStorey");
            $stmtStorey->execute([':type' => $type]);
            $filters['houseStorey'] = $stmtStorey->fetchAll(PDO::FETCH_COLUMN);

            // Get distinct bedrooms for specific property type
            $stmtBedroom = $db->prepare("SELECT DISTINCT houseBedroom FROM properties WHERE propertyType = :type AND houseBedroom IS NOT NULL AND houseBedroom > 0 AND propertyStatus = 'Available' ORDER BY houseBedroom");
            $stmtBedroom->execute([':type' => $type]);
            $filters['houseBedroom'] = $stmtBedroom->fetchAll(PDO::FETCH_COLUMN);

            // Get distinct bathrooms for specific property type
            $stmtTandB = $db->prepare("SELECT DISTINCT houseTandB FROM properties WHERE propertyType = :type AND houseTandB IS NOT NULL AND houseTandB > 0 AND propertyStatus = 'Available' ORDER BY houseTandB");
            $stmtTandB->execute([':type' => $type]);
            $filters['houseTandB'] = $stmtTandB->fetchAll(PDO::FETCH_COLUMN);

            // Get distinct floor areas for specific property type
            $stmtFloorArea = $db->prepare("SELECT DISTINCT houseFloorArea FROM properties WHERE propertyType = :type AND houseFloorArea IS NOT NULL AND houseFloorArea > 0 AND propertyStatus = 'Available' ORDER BY houseFloorArea");
            $stmtFloorArea->execute([':type' => $type]);
            $filters['houseFloorArea'] = $stmtFloorArea->fetchAll(PDO::FETCH_COLUMN);

            // Get distinct lot areas for specific property type
            $stmtLotArea = $db->prepare("SELECT DISTINCT propertyLotArea FROM properties WHERE propertyType = :type AND propertyLotArea IS NOT NULL AND propertyLotArea > 0 AND propertyStatus = 'Available' ORDER BY propertyLotArea");
            $stmtLotArea->execute([':type' => $type]);
            $filters['propertyLotArea'] = $stmtLotArea->fetchAll(PDO::FETCH_COLUMN);
        } else {
            // Get all locations if no type specified
            $stmtLocation = $db->query("SELECT DISTINCT propertyCity, propertyBrgy FROM properties WHERE propertyCity IS NOT NULL AND propertyBrgy IS NOT NULL AND propertyStatus = 'Available' ORDER BY propertyCity, propertyBrgy");
            $locations = $stmtLocation->fetchAll(PDO::FETCH_ASSOC);
            $filters['locations'] = array_map(function($loc) {
                return [
                    'city' => $loc['propertyCity'],
                    'brgy' => $loc['propertyBrgy'],
                    'display' => $loc['propertyCity'] . ' - ' . $loc['propertyBrgy']
                ];
            }, $locations);

            // Get all storeys
            $stmtStorey = $db->query("SELECT DISTINCT houseStorey FROM properties WHERE houseStorey IS NOT NULL AND houseStorey > 0 AND propertyStatus = 'Available' ORDER BY houseStorey");
            $filters['houseStorey'] = $stmtStorey->fetchAll(PDO::FETCH_COLUMN);

            // Get all bedrooms
            $stmtBedroom = $db->query("SELECT DISTINCT houseBedroom FROM properties WHERE houseBedroom IS NOT NULL AND houseBedroom > 0 AND propertyStatus = 'Available' ORDER BY houseBedroom");
            $filters['houseBedroom'] = $stmtBedroom->fetchAll(PDO::FETCH_COLUMN);

            // Get all bathrooms
            $stmtTandB = $db->query("SELECT DISTINCT houseTandB FROM properties WHERE houseTandB IS NOT NULL AND houseTandB > 0 AND propertyStatus = 'Available' ORDER BY houseTandB");
            $filters['houseTandB'] = $stmtTandB->fetchAll(PDO::FETCH_COLUMN);

            // Get all floor areas
            $stmtFloorArea = $db->query("SELECT DISTINCT houseFloorArea FROM properties WHERE houseFloorArea IS NOT NULL AND houseFloorArea > 0 AND propertyStatus = 'Available' ORDER BY houseFloorArea");
            $filters['houseFloorArea'] = $stmtFloorArea->fetchAll(PDO::FETCH_COLUMN);

            // Get all lot areas
            $stmtLotArea = $db->query("SELECT DISTINCT propertyLotArea FROM properties WHERE propertyLotArea IS NOT NULL AND propertyLotArea > 0 AND propertyStatus = 'Available' ORDER BY propertyLotArea");
            $filters['propertyLotArea'] = $stmtLotArea->fetchAll(PDO::FETCH_COLUMN);
        }

        echo json_encode([
            'success' => true,
            'data' => $filters
        ]);
    }

} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>