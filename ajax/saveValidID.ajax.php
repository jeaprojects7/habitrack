<?php

session_start();

require_once "../controllers/reservations.controller.php";
require_once "../models/reservations.model.php";

if (
    !isset($_POST["reservationID"]) ||
    !isset($_FILES["validID"])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing data."
    ]);
    exit;
}

$reservationID = $_POST["reservationID"];

if ($_FILES["validID"]["error"] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "status" => "error",
        "message" => "Upload failed."
    ]);
    exit;
}

$uploadDir = "../uploads/valid_ids/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileExt = strtolower(pathinfo($_FILES["validID"]["name"], PATHINFO_EXTENSION));

$newFileName = uniqid("validid_") . "." . $fileExt;

$targetFile = $uploadDir . $newFileName;

if (!move_uploaded_file($_FILES["validID"]["tmp_name"], $targetFile)) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save file."
    ]);
    exit;
}

$imagePath = "/uploads/valid_ids/" . $newFileName;

$result = ReservationController::ctrSaveValidID(
    $reservationID,
    $imagePath
);

if ($result == "ok") {

    echo json_encode([
        "status" => "success"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Database update failed."
    ]);

}