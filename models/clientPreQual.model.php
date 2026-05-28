<?php
require_once "connection.php";
class PrequalModel{

public function getPreQualByStatus($status)
{
    $db = new Connection();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        SELECT * 
        FROM prequal 
        WHERE prequalStatus = :status
        ORDER BY id ASC
    ");

    $stmt->bindParam(':status', $status);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}


?>