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
}