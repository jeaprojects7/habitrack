<?php

require_once __DIR__ . "/../models/clientPreQual.model.php";

class PrequalController {

    static public function ctrGetPrequal($status) {
        $agentId = $_SESSION["agentID"];

        $model = new PrequalModel();
        return $model->getPreQualByStatus($status,$agentId);
    }

    static public function ctrGetSelectedPrequal() {
        $agentId = $_SESSION["agentID"] ?? null;
        $prequalID = $_POST["prequal_id"] ?? ($_SESSION["selectedPrequalID"] ?? null);

        if (!$agentId || !$prequalID) {
            return null;
        }

        $model = new PrequalModel();
        $prequal = $model->getPreQualDetails($prequalID, $agentId);

        if ($prequal) {
            $_SESSION["selectedPrequalID"] = $prequal["prequalID"];
        }

        return $prequal ?: null;
    }

    static public function ctrUpdateSelectedPrequalStatus() {
        $agentId = $_SESSION["agentID"] ?? null;
        $prequalID = $_POST["prequal_id"] ?? null;
        $action = $_POST["prequal_status_action"] ?? null;

        if (!$agentId || !$prequalID || !$action) {
            return null;
        }

        $status = match ($action) {
            'approve' => 'Approved',
            'reject' => 'Rejected',
            default => null,
        };

        if (!$status) {
            return ['success' => false, 'message' => 'Invalid prequalification action.'];
        }

        $model = new PrequalModel();
        $updated = $model->updatePreQualStatus($prequalID, $agentId, $status);

        if ($updated) {
            $_SESSION["selectedPrequalID"] = $prequalID;
            return ['success' => true, 'message' => "Prequalification marked as {$status}."];
        }

        return ['success' => false, 'message' => 'Unable to update this prequalification. It may no longer be pending.'];
    }

}

