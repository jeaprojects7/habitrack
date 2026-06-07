<?php

require_once __DIR__ . '/../models/clientPreQual.model.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

if (session_status() === PHP_SESSION_NONE) session_start();

$agentID = $_SESSION['agentID'] ?? null;

if (!$agentID) {
    die("No agent session found.");
}

$allowedStatuses = ['Pending', 'Approved', 'Rejected'];
$status = trim($_GET['status'] ?? 'Pending');

if (!in_array($status, $allowedStatuses, true)) {
    $status = 'Pending';
}

$model = new PrequalModel();
$prequals = $model->getPreQualByStatus($status, $agentID);

$safe = function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';

// TCPDF SETUP
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle($status . ' Prequalifications Report');
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
];
$statusColor = $statusColors[$status] ?? '#ca8a04';

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

<h2 style="text-align:center;">' . $safe($status) . ' Prequalifications Report</h2>
<p><strong>Agent ID:</strong> ' . $safe($agentID) . '</p>
<p><strong>Status Filter:</strong> <span style="color:' . $statusColor . '; font-weight:bold;">' . $safe($status) . '</span></p>
<p><strong>Total Records:</strong> ' . count($prequals) . '</p>


<table border="1" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#9fc2f5; font-weight:bold;">
            <th width="12%">Prequal ID</th>
            <th width="18%">Client Name</th>
            <th width="18%">Property Name</th>
            <th width="8%">Type</th>
            <th width="16%">Location</th>
            <th width="14%">Submitted</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
';

if (empty($prequals)) {
    $html .= '
        <tr>
            <td colspan="7" align="center">No ' . $safe(strtolower($status)) . ' prequalifications found.</td>
        </tr>
    ';
} else {
    foreach ($prequals as $pq) {
        $clientName = trim(($pq['clientFName'] ?? '') . ' ' . ($pq['clientLName'] ?? '')) ?: 'N/A';
        $location   = trim(($pq['propertyCity'] ?? '') . ', ' . ($pq['propertyBrgy'] ?? ''), ', ') ?: 'N/A';

        $html .= '
            <tr>
                <td width="12%">' . $safe($pq['prequalID'] ?? '') . '</td>
                <td width="18%">' . $safe($clientName) . '</td>
                <td width="18%">' . $safe($pq['propertyName'] ?? '') . '</td>
                <td width="8%">' . $safe($pq['propertyType'] ?? '') . '</td>
                <td width="16%">' . $safe($location) . '</td>
                <td width="14%">' . $safe($pq['submissionDate'] ?? 'Not recorded') . '</td>
                <td width="10%" style="color:' . $statusColor . '; font-weight:bold;">' . $safe($pq['prequalStatus'] ?? '') . '</td>
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
$pdf->Output('prequals-' . strtolower($status) . '-' . date('Ymd') . '.pdf', 'I');





exit;