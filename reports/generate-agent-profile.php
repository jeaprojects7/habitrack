<?php

require_once __DIR__ . '/../controllers/agentregister.controller.php';
require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('TCPDF')) {
    require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';
}


// GET AGENT

$agentID = trim($_GET['agentID'] ?? '');

if (!$agentID) {
    die("No agent ID provided.");
}

$agent = ControllerAddAgent::ctrGetAgent($agentID);

if (!$agent) {
    die("Agent not found.");
}

// FORMAT BIRTHDATE 

$birthdateRaw = $agent['agentBirthdate'] ?? '';
$birthdateFormatted = '';

if (!empty($birthdateRaw)) {
    $date = DateTime::createFromFormat('Y-m-d', $birthdateRaw);

    if ($date) {
        $birthdateFormatted = $date->format('m-d-Y');
    } else {
        $birthdateFormatted = $birthdateRaw;
    }
}


// TCPDF SETUP

$pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Habitrack');
$pdf->SetAuthor('Habitrack');
$pdf->SetTitle('Agent Profile');

$pdf->SetMargins(10, 12, 10);
$pdf->SetAutoPageBreak(true, 12);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);


$safe = function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};


// FULL NAME AT THE TABLE

$fullName = trim(
    ($agent['agentFName'] ?? '') . ' ' .
    ($agent['agentMName'] ?? '') . ' ' .
    ($agent['agentLName'] ?? '') . ' ' .
    ($agent['agentSuffix'] ?? '')
);


// LOGO 

$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack/views/assets/images/jeaLogo.png';


// HEADER

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

<div style="text-align:center; font-size:16px; font-weight:bold; margin:10px 0;">
    Agent Information
</div>
';


// IMAGE 

$agentPic = trim($agent['agentPic'] ?? '');

$firstName = $agent['agentFName'] ?? '';
$lastName  = $agent['agentLName'] ?? '';

$initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

if (!empty($agentPic)) {

    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/habitrack' . $agentPic;

    if (file_exists($imagePath)) {

        $imageTag = '
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="padding-top:10px;">
                    <img src="' . $imagePath . '" width="150" height="150">
                </td>
            </tr>
        </table>
        ';
    } else {

        $imageTag = '
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="padding-top:10px;">
                    <div style="font-size:30px;
                                border:1px solid #ccc;
                                width:90px;
                                height:90px;
                                line-height:90px;
                                text-align:center;">
                        ' . $initials . '
                    </div>
                </td>
            </tr>
        </table>
        ';
    }

} else {

    $imageTag = '
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding-top:10px;">
                <div style="font-size:30px;
                            border:1px solid #ccc;
                            width:90px;
                            height:90px;
                            line-height:90px;
                            text-align:center;">
                    ' . $initials . '
                </div>
            </td>
        </tr>
    </table>
    ';
}


// HTML 

$html = '
' . $htmlHeader . '

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td height="20"></td>
    </tr>
</table>

' . $imageTag . '

<h3>Personal Information</h3>

<table border="1" cellpadding="6" width="100%">
    <tbody>

        <tr style="background-color:#9fc2f5;">
            <td width="20%"><strong>Full Name</strong></td>
            <td width="80%" colspan="3">' . $safe($fullName) . '</td>
        </tr>

        <tr>
            <td width="20%"><strong>Gender</strong></td>
            <td width="30%">' . $safe($agent['agentGender'] ?? '') . '</td>

            <td width="20%"><strong>Birthdate</strong></td>
            <td width="30%">' . $safe($birthdateFormatted) . '</td>
        </tr>

        <tr>
            <td width="20%"><strong>Address</strong></td>
            <td width="80%" colspan="3">' . $safe($agent['agentAddress'] ?? '') . '</td>
        </tr>

    </tbody>
</table>

<br>

<h3>Contact Information</h3>

<table border="1" cellpadding="6" width="100%">
    <tbody>

        <tr style="background-color:#9fc2f5;">
            <td width="20%"><strong>Email</strong></td>
            <td width="30%">' . $safe($agent['agentEmail'] ?? '') . '</td>

            <td width="20%"><strong>Phone Number</strong></td>
            <td width="30%">' . $safe($agent['agentPhoneNum'] ?? '') . '</td>
        </tr>

        <tr>
            <td width="20%"><strong>Facebook</strong></td>
            <td width="80%" colspan="3">' . $safe($agent['agentFB'] ?? '') . '</td>
        </tr>

    </tbody>
</table>

<br>

<h3>Performance</h3>

<table border="1" cellpadding="6" width="100%">
    <tbody>

        <tr style="background-color:#9fc2f5;">
            <td width="20%"><strong>Sold Units</strong></td>
            <td width="80%">' . $safe($agent['agentSoldUnits'] ?? '0') . '</td>
        </tr>

    </tbody>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('agent-information-' . $agentID . '.pdf', 'I');
exit;