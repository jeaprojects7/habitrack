<?php
/**
 * HabiTrack – Dashboard Model
 * Handles all database queries for the map dashboard.
 */

class DashboardModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // ─────────────────────────────────────────────
    //  FILTER DROPDOWNS
    // ─────────────────────────────────────────────

    /**
     * Returns every distinct property type.
     */
    public function getPropertyTypes(): array
    {
        $stmt = $this->db->query(
            "SELECT DISTINCT propertyType
             FROM   properties
             WHERE  propertyType IS NOT NULL
               AND  propertyStatus = 'Available'
             ORDER  BY propertyType"
        );
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Returns distinct city/brgy pairs, optionally filtered by type.
     */
    public function getLocations(string $type = ''): array
    {
        if ($type !== '') {
            $stmt = $this->db->prepare(
                "SELECT DISTINCT propertyCity, propertyBrgy
                 FROM   properties
                 WHERE  propertyType = :type
                   AND  propertyCity IS NOT NULL
                   AND  propertyBrgy IS NOT NULL
                   AND  propertyStatus = 'Available'
                 ORDER  BY propertyCity, propertyBrgy"
            );
            $stmt->execute([':type' => $type]);
        } else {
            $stmt = $this->db->query(
                "SELECT DISTINCT propertyCity, propertyBrgy
                 FROM   properties
                 WHERE  propertyCity IS NOT NULL
                   AND  propertyBrgy IS NOT NULL
                   AND  propertyStatus = 'Available'
                 ORDER  BY propertyCity, propertyBrgy"
            );
        }

        return array_map(function ($row) {
            return [
                'city'    => $row['propertyCity'],
                'brgy'    => $row['propertyBrgy'],
                'display' => $row['propertyCity'] . ' - ' . $row['propertyBrgy'],
            ];
        }, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Returns distinct storey counts, optionally filtered by type.
     */
    public function getStoreys(string $type = ''): array
    {
        return $this->fetchDistinctColumn('houseStorey', $type);
    }

    /**
     * Returns distinct bedroom counts, optionally filtered by type.
     */
    public function getBedrooms(string $type = ''): array
    {
        return $this->fetchDistinctColumn('houseBedroom', $type);
    }

    /**
     * Returns distinct toilet-and-bath counts, optionally filtered by type.
     */
    public function getTandBs(string $type = ''): array
    {
        return $this->fetchDistinctColumn('houseTandB', $type);
    }

    /**
     * Returns distinct floor areas, optionally filtered by type.
     */
    public function getFloorAreas(string $type = ''): array
    {
        return $this->fetchDistinctColumn('houseFloorArea', $type);
    }

    /**
     * Returns distinct lot areas, optionally filtered by type.
     */
    public function getLotAreas(string $type = ''): array
    {
        return $this->fetchDistinctColumn('propertyLotArea', $type);
    }

    /**
     * Returns amenity options that have at least one matching property.
     */
    public function getAmenities(): array
    {
        $amenityColumns = [
            'housePowderRoom'   => 'Powder Room',
            'houseGarage'       => 'Garage',
            'houseBalcony'      => 'Balcony',
            'houseTerrace'      => 'Terrace',
            'housePool'         => 'Pool',
            'houseLaundryArea'  => 'Laundry Area',
            'houseMaidRoom'     => 'Maid Room',
            'houseCabinets'     => 'Cabinets',
            'houseBilliardRoom' => 'Billiard Room',
            'houseClubhouse'    => 'Clubhouse',
            'houseGarden'       => 'Garden',
        ];

        $result = [];
        foreach ($amenityColumns as $column => $label) {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) FROM properties WHERE `$column` = 1 AND propertyStatus = 'Available'"
            );
            $stmt->execute();
            if ((int) $stmt->fetchColumn() > 0) {
                $result[] = ['value' => $column, 'label' => $label];
            }
        }
        return $result;
    }

    /**
     * Returns distinct property names by type.
     */
    public function getPropertyNames(string $type): array
    {
        if (empty($type)) {
            return [];
        }
        $stmt = $this->db->prepare(
            "SELECT DISTINCT propertyName
             FROM   properties
             WHERE  propertyType = :type
               AND  propertyStatus = 'Available'
             ORDER  BY propertyName"
        );
        $stmt->execute([':type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Returns all filter dropdown data in one call.
     */
    public function getAllFilters(string $type = ''): array
    {
        return [
            'propertyType'   => $this->getPropertyTypes(),
            'locations'      => $this->getLocations($type),
            'houseStorey'    => $this->getStoreys($type),
            'houseBedroom'   => $this->getBedrooms($type),
            'houseTandB'     => $this->getTandBs($type),
            'houseFloorArea' => $this->getFloorAreas($type),
            'propertyLotArea'=> $this->getLotAreas($type),
        ];
    }

    // ─────────────────────────────────────────────
    //  PROPERTY SEARCH  (returns lat/lng for map)
    // ─────────────────────────────────────────────

    /**
     * Searches properties matching all supplied filters and returns
     * only the columns needed to render map markers + popups.
     *
     * @param array $filters  Associative array of filter values from the form.
     * @return array
     */
    public function searchProperties(array $filters): array
    {
        $where  = ['propertyLat IS NOT NULL', 'propertyLng IS NOT NULL', 'propertyStatus = :status'];
        $params = [':status' => 'Available'];

        // Property type (required to know which filter panel is active)
        if (!empty($filters['type'])) {
            $where[]          = 'propertyType = :type';
            $params[':type']  = $filters['type'];
        }

        // ── Location (city – brgy) ──
        if (!empty($filters['location'])) {
            // value format: "City - Brgy"  (set in JS)
            $parts = array_map('trim', explode(' - ', $filters['location'], 2));
            if (count($parts) === 2) {
                $where[]           = 'propertyCity = :city AND propertyBrgy = :brgy';
                $params[':city']   = $parts[0];
                $params[':brgy']   = $parts[1];
            }
        }

        // ── House-only filters ──
        if (!empty($filters['storey'])) {
            $where[]            = 'houseStorey = :storey';
            $params[':storey']  = (int) $filters['storey'];
        }

        if (!empty($filters['bedroom'])) {
            $where[]              = 'houseBedroom = :bedroom';
            $params[':bedroom']   = (int) $filters['bedroom'];
        }

        if (!empty($filters['tb'])) {
            $where[]          = 'houseTandB = :tb';
            $params[':tb']    = (int) $filters['tb'];
        }

        if (!empty($filters['floorArea'])) {
            $where[]                = 'houseFloorArea = :floorArea';
            $params[':floorArea']   = (float) $filters['floorArea'];
        }

        if (!empty($filters['lotAreaHouse'])) {
            $where[]                  = 'propertyLotArea = :lotAreaHouse';
            $params[':lotAreaHouse']  = (float) $filters['lotAreaHouse'];
        }

        // ── Amenities (multiple) ──
        if (!empty($filters['amenities']) && is_array($filters['amenities'])) {
            $allowed = [
                'housePowderRoom', 'houseGarage', 'houseBalcony', 'houseTerrace',
                'housePool', 'houseLaundryArea', 'houseMaidRoom', 'houseCabinets',
                'houseBilliardRoom', 'houseClubhouse', 'houseGarden',
            ];
            foreach ($filters['amenities'] as $amenity) {
                if (in_array($amenity, $allowed, true)) {
                    $where[] = "`$amenity` = 1";
                }
            }
        }

        // ── Lot-only filters ──
        if (!empty($filters['sizeRange'])) {
            $where[]                 = 'propertyLotArea = :sizeRange';
            $params[':sizeRange']    = (float) $filters['sizeRange'];
        }

        if (!empty($filters['lotArea'])) {
            $where[]               = 'propertyLotArea = :lotArea';
            $params[':lotArea']    = (float) $filters['lotArea'];
        }

        // ── Property name ──
        if (!empty($filters['propertyName'])) {
            $where[]                    = 'propertyName = :propertyName';
            $params[':propertyName']    = $filters['propertyName'];
        }

        // ── Price range ──
        if (!empty($filters['priceStart']) && is_numeric($filters['priceStart'])) {
            $where[]                  = 'propertyPrice >= :priceStart';
            $params[':priceStart']    = (float) $filters['priceStart'];
        }

        if (!empty($filters['priceEnd']) && is_numeric($filters['priceEnd'])) {
            $where[]                = 'propertyPrice <= :priceEnd';
            $params[':priceEnd']    = (float) $filters['priceEnd'];
        }

        $sql = "SELECT
                    propertyID,
                    propertyName,
                    propertyType,
                    propertyCity,
                    propertyBrgy,
                    propertyPrice,
                    houseStorey,
                    houseBedroom,
                    houseTandB,
                    houseFloorArea,
                    propertyLotArea,
                    propertyLat   AS lat,
                    propertyLng   AS lng
                FROM properties
                WHERE " . implode(' AND ', $where) . "
                ORDER BY propertyName";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─────────────────────────────────────────────
    //  HELPERS
    // ─────────────────────────────────────────────

    /**
     * Fetches distinct non-null, non-zero values for a numeric column.
     */
    private function fetchDistinctColumn(string $column, string $type = ''): array
    {
        if ($type !== '') {
            $stmt = $this->db->prepare(
                "SELECT DISTINCT `$column`
                 FROM   properties
                 WHERE  propertyType = :type
                   AND  `$column` IS NOT NULL
                   AND  `$column` > 0
                   AND  propertyStatus = 'Available'
                 ORDER  BY `$column`"
            );
            $stmt->execute([':type' => $type]);
        } else {
            $stmt = $this->db->query(
                "SELECT DISTINCT `$column`
                 FROM   properties
                 WHERE  `$column` IS NOT NULL
                   AND  `$column` > 0
                   AND  propertyStatus = 'Available'
                 ORDER  BY `$column`"
            );
        }
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
