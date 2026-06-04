<?php

require_once __DIR__ . '/../controllers/edit-property.controller.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

$selectedType = trim($_GET['type'] ?? '');
$selectedStatus = trim($_GET['status'] ?? '');
$selectedCity = trim($_GET['city'] ?? '');
$selectedMinPrice = trim($_GET['minPrice'] ?? '');
$selectedMaxPrice = trim($_GET['maxPrice'] ?? '');
$allowedTypes = ['House', 'Lot'];
$allowedStatus = ['Available', 'Reserved','Archived']; //gn add kolng

if (!in_array($selectedType, $allowedTypes, true)) {
    $selectedType = '';
}

if (!in_array($selectedStatus, $allowedStatus, true)) { //gn add kolng 
    $selectedStatus = '';
}

// Reuse the same filters as the Explore page so the PDF matches the screen.
$filters = [
    'type' => $selectedType,
    'status' => $selectedStatus, //gn add kolng
    'city' => $selectedCity,
    'minPrice' => $selectedMinPrice,
    'maxPrice' => $selectedMaxPrice
];

// LOGO 

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';


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
//gn add kolng
if ($selectedStatus !== '') {
    $filterLabels[] = 'Status: ' . $safe($selectedStatus);
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
$htmlHeader = '
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0f172a; color:#ffffff;">
    <tr>

        <td width="10%" align="right" valign="middle">
            <img src="' . $logoPath . '" width="50">
        </td>

        <td width="90%" align="left" valign="middle" style="padding-left:5px; padding-top:10px;">
            <span style="font-size:18px; font-weight:bold; line-height:40px;">
                Habitrack
            </span>
            <br>
            <span style="font-size:9px; line-height:20px;">
                Real Estate Management System
            </span>
        </td>

    </tr>
</table>

<br>


';
$html = '

' . $htmlHeader . '
    <h2 style="text-align:center;">Habitrack Properties Report</h2>
    <p><strong>Filters:</strong> ' . (!empty($filterLabels) ? implode(' | ', $filterLabels) : 'All Properties') . '</p>
    <p><strong>Total Properties:</strong> ' . count($properties) . '</p>
    <table border="1" cellpadding="5">
        <thead>
            <tr style="background-color:#9fc2f5;font-weight:bold;">
                <th width="13%">Property ID</th>
                <th width="15%">Name</th>
                <th width="7%">Type</th>
                <th width="15%">City</th>
                <th width="15%">Barangay</th>
                <th width="10%">Lot Area</th>
                <th width="14%">Price</th>
                <th width="11%">Status</th>
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
            <td width="15%">' . $safe($property['propertyName'] ?? '') . '</td>
            <td width="7%">' . $safe($property['propertyType'] ?? '') . '</td>
            <td width="15%">' . $safe($property['propertyCity'] ?? '') . '</td>
            <td width="15%">' . $safe($property['propertyBrgy'] ?? '') . '</td>
            <td width="10%">' . $safe($property['propertyLotArea'] ?? '') . ' sqm</td>
            <td width="14%">' . $safe($price($property['propertyPrice'] ?? '')) . '</td>
             <td width="11%">' . $safe($property['propertyStatus'] ?? '') . '</td>
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