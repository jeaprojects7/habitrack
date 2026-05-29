<?php
require_once '../vendor/autoload.php';

require_once '../controllers/clinicstaff.controller.php';
require_once '../models/clinicstaff.model.php';

class ClinicStaffList {
    public function printStaffList() {
        $clinic_staff = (new ControllerClinicStaff)->ctrClinicStaffList();

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->SetMargins(10, 10, 10);
        // $pdf->AddPage();
        $pdf->AddPage('L');

        $html = '
            <h1>Clinic Staff List</h1>
            <table border="1" cellpadding="5">
                <thead>
                    <tr style="background-color:#f2f2f2;">
                        <th width="60"><b>ID</b></th>
                        <th width="140"><b>First Name</b></th>
                        <th width="40"><b>MI</b></th>
                        <th width="140"><b>Last Name</b></th>
                        <th width="150"><b>Designation</b></th>
                        <th width="110"><b>PRC</b></th>
                        <th width="120"><b>Mobile</b></th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($clinic_staff as $value) {
            $html .= '
                <tr>
                    <td width="60">'.$value["empid"].'</td>
                    <td width="140">'.$value["firstname"].'</td>
                    <td width="40">'.$value["mi"].'</td>
                    <td width="140">'.$value["lastname"].'</td>
                    <td width="150">'.$value["designation"].'</td>
                    <td width="110">'.$value["prc"].'</td>
                    <td width="120">'.$value["mobile"].'</td>
                </tr>
            ';
        }

        $html .= '
                </tbody>
            </table>
        ';

        // Print once
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('clinicstaff.pdf', 'I');
    }
}

$staff_list = new ClinicStaffList();
$staff_list->printStaffList();