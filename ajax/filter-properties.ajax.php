<?php

require_once __DIR__ . "/../controllers/edit-property.controller.php";

header("Content-Type: application/json");

$type = trim($_GET["type"] ?? "");
$city = trim($_GET["city"] ?? "");
$minPrice = trim($_GET["minPrice"] ?? "");
$maxPrice = trim($_GET["maxPrice"] ?? "");
$allowedTypes = ["House", "Lot"];

$filters = [];

if ($type !== "" && in_array($type, $allowedTypes, true)) {
    $filters["type"] = $type;
}

// Keep the AJAX endpoint aligned with the Explore page filters.
// Invalid numeric price values are ignored instead of being sent to SQL.
if ($city !== "") {
    $filters["city"] = $city;
}

if ($minPrice !== "" && is_numeric($minPrice)) {
    $filters["minPrice"] = $minPrice;
}

if ($maxPrice !== "" && is_numeric($maxPrice)) {
    $filters["maxPrice"] = $maxPrice;
}

echo json_encode(PropertyController::ctrGetPropertiesFiltered($filters));
