<?php

require_once __DIR__ . '/../controllers/agentregister.controller.php';
require_once __DIR__ . '/../models/agentregister.model.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}

/* =========================
   GET FILTERS
========================= */

$search = trim($_GET['agent'] ?? '');
$selectedAgentStatus = trim($_GET['status'] ?? '');
$selectedMinSoldUnits = trim($_GET['minSoldUnits'] ?? '');
$selectedMaxSoldUnits = trim($_GET['maxSoldUnits'] ?? '');

/* =========================
   FILTER ARRAY
========================= */

$filters = [
    'agentID'       => $search,
    'agent'         => $search,
    'status'        => $selectedAgentStatus,
    'minSoldUnits'  => $selectedMinSoldUnits,
    'maxSoldUnits'  => $selectedMaxSoldUnits
];

/* =========================
   GET AGENTS
========================= */

$agents = ControllerAddAgent::ctrGetAgentFiltered($filters);

/* =========================
   LOGO
========================= */

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';

/* =========================
   SAFE FUNCTIONS
========================= */

$safe = function ($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
};

/* =========================
   FILTER LABELS
========================= */

$filterLabels = [];

if ($search !== '') {
    $filterLabels[] = 'Search: ' . $safe($search);
}

if ($selectedAgentStatus !== '') {
    $filterLabels[] = 'Status: ' . $safe($selectedAgentStatus);
}

if ($selectedMinSoldUnits !== '') {
    $filterLabels[] = 'Min Sold Units: ' . $safe($selectedMinSoldUnits);
}

if ($selectedMaxSoldUnits !== '') {
    $filterLabels[] = 'Max Sold Units: ' . $safe($selectedMaxSoldUnits);
}

/* =========================
   HEADER
========================= */

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

/* =========================
   MAIN HTML
========================= */

$html = '

' . $htmlHeader . '

<h2 style="text-align:center;">Habitrack Agents Report</h2>

<p>
<strong>Filters:</strong>
' . (!empty($filterLabels) ? implode(' | ', $filterLabels) : 'All Agents') . '
</p>

<p>
<strong>Total Agents:</strong> ' . count($agents) . '
</p>

<table border="1" cellpadding="5">
    <thead>
        <tr style="background-color:#9fc2f5;font-weight:bold;">
            <th width="12%">Agent ID</th>
            <th width="20%">Full Name</th>
            <th width="10%">Gender</th>
            <th width="20%">Email</th>
            <th width="15%">Phone</th>
            <th width="13%">Status</th>
            <th width="10%">Sold Units</th>
        </tr>
    </thead>
    <tbody>
';

/* =========================
   NO RESULTS
========================= */

if (empty($agents)) {

    $html .= '
        <tr>
            <td colspan="7" align="center">
                No agents matched the selected filters.
            </td>
        </tr>
    ';
}

/* =========================
   LOOP AGENTS
========================= */

foreach ($agents as $agent) {

    $fullName = trim(
        ($agent['agentFName'] ?? '') . ' ' .
        ($agent['agentMName'] ?? '') . ' ' .
        ($agent['agentLName'] ?? '') . ' ' .
        ($agent['agentSuffix'] ?? '')
    );

    $html .= '
        <tr>
            <td width="12%">' . $safe($agent['agentID'] ?? '') . '</td>

            <td width="20%">' . $safe($fullName) . '</td>

            <td width="10%">' . $safe($agent['agentGender'] ?? '') . '</td>

            <td width="20%">' . $safe($agent['agentEmail'] ?? '') . '</td>

            <td width="15%">' . $safe($agent['agentPhoneNum'] ?? '') . '</td>

            <td width="13%">' . $safe($agent['agentStatus'] ?? '') . '</td>

            <td width="10%">' . $safe($agent['agentSoldUnits'] ?? '0') . '</td>
        </tr>
    ';
}

$html .= '
    </tbody>
</table>
';

/* =========================
   TCPDF
========================= */

$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle('Filtered Agents Report');

$pdf->SetMargins(10, 12, 10);
$pdf->SetAutoPageBreak(true, 12);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10);

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('filtered-agents.pdf', 'I');

exit;