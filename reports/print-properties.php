<?php

require_once __DIR__ . '/../controllers/edit-property.controller.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

$selectedType = trim($_GET['type'] ?? '');
$selectedCity = trim($_GET['city'] ?? '');
$selectedMinPrice = trim($_GET['minPrice'] ?? '');
$selectedMaxPrice = trim($_GET['maxPrice'] ?? '');
$allowedTypes = ['House', 'Lot'];

if (!in_array($selectedType, $allowedTypes, true)) {
    $selectedType = '';
}

// Reuse the same filters as the Explore page so the PDF matches the screen.
$filters = [
    'type' => $selectedType,
    'city' => $selectedCity,
    'minPrice' => $selectedMinPrice,
    'maxPrice' => $selectedMaxPrice
];

$properties = PropertyController::ctrGetPropertiesFiltered($filters);

$safe = function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$price = function ($value) {
    return is_numeric($value) ? 'PHP ' . number_format((float) $value, 2) : '';
};

$filterLabels = [];

if ($selectedType !== '') {
    $filterLabels[] = 'Type: ' . $safe($selectedType);
}

if ($selectedCity !== '') {
    $filterLabels[] = 'City: ' . $safe($selectedCity);
}

if ($selectedMinPrice !== '') {
    $filterLabels[] = 'Min Price: ' . $safe($price($selectedMinPrice));
}

if ($selectedMaxPrice !== '') {
    $filterLabels[] = 'Max Price: ' . $safe($price($selectedMaxPrice));
}

$html = '
    <h2 style="text-align:center;">Habitrack Properties Report</h2>
    <p><strong>Filters:</strong> ' . (!empty($filterLabels) ? implode(' | ', $filterLabels) : 'All Properties') . '</p>
    <p><strong>Total Properties:</strong> ' . count($properties) . '</p>
    <table border="1" cellpadding="5">
        <thead>
            <tr style="background-color:#e8f5e9;font-weight:bold;">
                <th width="13%">Property ID</th>
                <th width="22%">Name</th>
                <th width="11%">Type</th>
                <th width="15%">City</th>
                <th width="15%">Barangay</th>
                <th width="10%">Lot Area</th>
                <th width="14%">Price</th>
            </tr>
        </thead>
        <tbody>
';

if (empty($properties)) {
    $html .= '
        <tr>
            <td colspan="7" align="center">No properties matched the selected filters.</td>
        </tr>
    ';
}

foreach ($properties as $property) {
    $html .= '
        <tr>
            <td width="13%">' . $safe($property['propertyID'] ?? '') . '</td>
            <td width="22%">' . $safe($property['propertyName'] ?? '') . '</td>
            <td width="11%">' . $safe($property['propertyType'] ?? '') . '</td>
            <td width="15%">' . $safe($property['propertyCity'] ?? '') . '</td>
            <td width="15%">' . $safe($property['propertyBrgy'] ?? '') . '</td>
            <td width="10%">' . $safe($property['propertyLotArea'] ?? '') . ' sqm</td>
            <td width="14%">' . $safe($price($property['propertyPrice'] ?? '')) . '</td>
        </tr>
    ';
}

$html .= '
        </tbody>
    </table>
';

$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle('Filtered Properties Report');
$pdf->SetMargins(10, 12, 10);
$pdf->SetAutoPageBreak(true, 12);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('filtered-properties.pdf', 'I');
exit;