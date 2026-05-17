<?php
require_once "../models/connection.php";

$db = new Connection();
$pdo = $db->connect();

$propertyID = $_POST['propertyID'];

$uploadDir = "/views/Adminassets/images/property/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['images'])) {
    die("NO IMAGES RECEIVED");
}

$files = $_FILES['images'];
$orders = $_POST['orders'];

echo "<pre>";
print_r($files);
echo "</pre>";

for ($i = 0; $i < count($files['name']); $i++) {

    // skip empty
    if ($files['error'][$i] !== 0) {
        echo "ERROR FILE: " . $files['name'][$i];
        continue;
    }

    $tmpName = $files['tmp_name'][$i];
    $originalName = $files['name'][$i];

    // unique filename
    //$fileName = time() . "_" . $i . "_" . basename($originalName);
    $fileName = $uploadDir . basename($originalName);

    $destination = $fileName;

    // MOVE FILE
    if (move_uploaded_file($tmpName, $destination)) {

        echo "MOVED: " . $fileName . "<br>";

        $stmt = $pdo->prepare("
            INSERT INTO property_images
            (propertyID, imagePath, imageOrder)
            VALUES
            (:propertyID, :imagePath, :imageOrder)
        ");

        $success = $stmt->execute([
            ":propertyID" => $propertyID,
            ":imagePath" => $fileName,
            ":imageOrder" => $orders[$i]
        ]);

        if ($success) {
            echo "INSERTED: " . $fileName . "<br>";
        } else {
            echo "DB INSERT FAILED<br>";
            print_r($stmt->errorInfo());
        }

    } else {
        echo "MOVE FAILED: " . $originalName . "<br>";
    }
}

echo "DONE";