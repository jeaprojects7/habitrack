<?php

require_once "connection.php";

class PropertyModel {

    static public function mdlGetProperties() {

        $db = new Connection();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("
           SELECT p.*,
                   (
                       SELECT imagePath 
                       FROM property_images 
                       WHERE propertyID = p.propertyID 
                       LIMIT 1
                   ) AS imagePath
            FROM properties p
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function mdlGetPropertiesFiltered($filters) {

    $db = new Connection();
    $pdo = $db->connect();

    $sql = "
        SELECT p.*,
        (
            SELECT imagePath
            FROM property_images
            WHERE propertyID = p.propertyID
            LIMIT 1
        ) AS imagePath
        FROM properties p
        WHERE 1=1
    ";

    $params = [];

    // Each filter is optional. We only add its SQL condition when the user
    // filled it in, which lets filters work alone or together.
    if (!empty($filters['type'])) {
        $sql .= " AND LOWER(TRIM(p.propertyType)) = LOWER(TRIM(:type))";
        $params[':type'] = $filters['type'];
    }
    if (!empty($filters['status'])) {
        $sql .= " AND LOWER(TRIM(p.propertyStatus)) = LOWER(TRIM(:status))";
        $params[':status'] = $filters['status'];
    }

    // City uses a partial match, so searching "Bac" can still find "Bacolod".
    if (!empty($filters['city'])) {
        $sql .= " AND LOWER(TRIM(p.propertyCity)) LIKE LOWER(TRIM(:city))";
        $params[':city'] = '%' . $filters['city'] . '%';
    }

    // Price range filters can be used together or separately.
    if (isset($filters['minPrice']) && $filters['minPrice'] !== '' && is_numeric($filters['minPrice'])) {
        $sql .= " AND p.propertyPrice >= :minPrice";
        $params[':minPrice'] = $filters['minPrice'];
    }

    if (isset($filters['maxPrice']) && $filters['maxPrice'] !== '' && is_numeric($filters['maxPrice'])) {
        $sql .= " AND p.propertyPrice <= :maxPrice";
        $params[':maxPrice'] = $filters['maxPrice'];
    }

    $sql .= " ORDER BY p.propertyID ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
