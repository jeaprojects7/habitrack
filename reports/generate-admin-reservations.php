<?php

require_once __DIR__ . '/../models/clientReservation.model.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

if (session_status() === PHP_SESSION_NONE) session_start();

$allowedStatuses = ['All', 'Pending', 'Approved', 'Rejected'];
$status = trim($_GET['status'] ?? 'All');

if (!in_array($status, $allowedStatuses, true)) {
    $status = 'All';
}

$model = new ClientReservationModel();
$reservations = $model->getReservationsByStatus($status);

$safe = function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$money = function ($value) {
    return is_numeric($value) ? 'PHP ' . number_format((float) $value, 2) : 'N/A';
};

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';

// TCPDF SETUP
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle(($status === 'All' ? 'All' : $status) . ' Reservations Report');
$pdf->SetMargins(10, 12, 10);
$pdf->SetAutoPageBreak(true, 12);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$statusColors = [
    'Approved' => '#16a34a',
    'Rejected' => '#dc2626',
    'Pending'  => '#ca8a04',
    'All'      => '#1d4ed8',
];
$statusColor = $statusColors[$status] ?? '#1d4ed8';

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
<p><strong>Status Filter:</strong> <span style="color:' . $statusColor . '; font-weight:bold;">' . $safe($status === 'All' ? 'All Reservations' : $status) . '</span></p>
<p><strong>Total Records:</strong> ' . count($reservations) . '</p>


<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#9fc2f5; font-weight:bold;">
            <th width="12%">Reservation ID</th>
            <th width="14%">Client Name</th>
            <th width="16%">Property Name</th>
            <th width="7%">Type</th>
            <th width="14%">Location</th>
            <th width="12%">Price</th>
            <th width="10%">Date</th>
            <th width="8%">Prequal</th>
            <th width="8%">Status</th>
        </tr>
    </thead>
    <tbody>
';

if (empty($reservations)) {
    $html .= '
        <tr>
            <td colspan="9" align="center">No reservations found.</td>
        </tr>
    ';
} else {
    foreach ($reservations as $res) {
        $clientName = trim(($res['clientFName'] ?? '') . ' ' . ($res['clientLName'] ?? '')) ?: 'N/A';
        $location   = trim(($res['propertyCity'] ?? '') . ', ' . ($res['propertyBrgy'] ?? ''), ', ') ?: 'N/A';

        $resStatus    = $res['reserveStatus'] ?? 'Pending';
        $prequalStatus = $res['prequalStatus'] ?? 'Pending';

        $resColor = match($resStatus) {
            'Approved' => '#16a34a',
            'Rejected' => '#dc2626',
            default    => '#ca8a04',
        };

        $prequalColor = match($prequalStatus) {
            'Approved' => '#16a34a',
            'Rejected' => '#dc2626',
            default    => '#ca8a04',
        };

        $html .= '
            <tr>
                <td width="12%">' . $safe($res['reservationID'] ?? '') . '</td>
                <td width="14%">' . $safe($clientName) . '</td>
                <td width="16%">' . $safe($res['propertyName'] ?? '') . '</td>
                <td width="7%">' . $safe($res['propertyType'] ?? '') . '</td>
                <td width="14%">' . $safe($location) . '</td>
                <td width="12%">' . $safe($money($res['propertyPrice'] ?? '')) . '</td>
                <td width="10%">' . $safe($res['reserveDate'] ?? '') . '</td>
                <td width="8%" style="color:' . $prequalColor . '; font-weight:bold;">' . $safe($prequalStatus) . '</td>
                <td width="8%" style="color:' . $resColor . '; font-weight:bold;">' . $safe($resStatus) . '</td>
            </tr>
        ';
    }
}

$html .= '
    </tbody>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->SetXY(10, $pdf->getPageHeight() - 10);
$pdf->Cell(0, 10, 'Generated: ' . (new DateTime('now', new DateTimeZone('Asia/Manila')))->format('F d, Y h:i A'), 0, 0, 'L');
$pdf->Output('reservations-' . strtolower($status) . '-' . date('Ymd') . '.pdf', 'I');
exit;