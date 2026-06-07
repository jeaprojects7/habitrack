<?php

require_once __DIR__ . '/../models/reservations.model.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

if (session_status() === PHP_SESSION_NONE) session_start();

$clientID = $_SESSION['clientID'] ?? $_SESSION['userid'] ?? $_SESSION['clientid'] ?? null;

if (!$clientID) {
    die("No client session found.");
}

$reservations = ModelReservation::mdlGetReservationsByClient($clientID);

if (empty($reservations)) {
    die("No reservations found.");
}

// CLIENT NAME from first record
$clientFName = $reservations[0]['clientFName'] ?? '';
$clientLName = $reservations[0]['clientLName'] ?? '';
$fullClientName = trim($clientFName . ' ' . $clientLName);

$safe = function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$price = function ($value) {
    return is_numeric($value) ? 'PHP ' . number_format((float) $value, 2) : 'N/A';
};

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';

// TCPDF SETUP
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle('Client Reservations Report');
$pdf->SetMargins(10, 12, 10);
$pdf->SetAutoPageBreak(true, 12);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

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

$html = $htmlHeader . '

<h2 style="text-align:center;">Reservations Report</h2>
<p><strong>Client:</strong> ' . $safe($fullClientName) . '</p>
<p><strong>Total Reservations:</strong> ' . count($reservations) . '</p>

<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#9fc2f5; font-weight:bold;">
            <th width="12%">Reservation ID</th>
            <th width="14%">Property Name</th>
            <th width="8%">Type</th>
            <th width="14%">Location</th>
            <th width="10%">Lot Area</th>
            <th width="14%">Price</th>
            <th width="12%">Reserve Date</th>
            <th width="8%">Prequal</th>
            <th width="8%">Status</th>
        </tr>
    </thead>
    <tbody>
';

foreach ($reservations as $res) {
    $location = trim(($res['propertyBrgy'] ?? '') . ', ' . ($res['propertyCity'] ?? ''), ', ');

    $html .= '
        <tr>
            <td width="12%">' . $safe($res['reservationID'] ?? '') . '</td>
            <td width="14%">' . $safe($res['propertyName'] ?? '') . '</td>
            <td width="8%">' . $safe($res['propertyType'] ?? '') . '</td>
            <td width="14%">' . $safe($location) . '</td>
            <td width="10%">' . $safe($res['propertyLotArea'] ?? '') . ' sqm</td>
            <td width="14%">' . $safe($price($res['propertyPrice'] ?? '')) . '</td>
            <td width="12%">' . $safe($res['reserveDate'] ?? '') . '</td>
            <td width="8%">' . $safe($res['prequalStatus'] ?? 'Pending') . '</td>
            <td width="8%">' . $safe($res['reserveStatus'] ?? 'Pending') . '</td>
        </tr>
    ';
}

$html .= '
    </tbody>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Disable auto page break so the footer doesn't push to a new page
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->SetXY(10, $pdf->getPageHeight() - 10);
$pdf->Cell(0, 10, 'Generated: ' . (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('F d, Y h:i A'), 0, 0, 'L');

$pdf->Output('my-reservations-' . date('Ymd') . '.pdf', 'I');
exit;
