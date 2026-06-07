<?php

require_once __DIR__ . "/../models/siteVisit_model.php";

class SiteVisitController {

    static public function ctrGetSiteVisits($agentID) {
        $model = new SiteVisitModel();
        return $model->getSiteVisitsByAgent($agentID);
    }

    static public function ctrGetSelectedSiteVisit() {
        $siteVisitID = $_POST["sitevisit_id"] ?? ($_SESSION["selectedSiteVisitID"] ?? null);

        if (!$siteVisitID) {
            return null;
        }

        $model = new SiteVisitModel();
        $siteVisit = $model->getSiteVisitDetails($siteVisitID);

        if ($siteVisit) {
            $_SESSION["selectedSiteVisitID"] = $siteVisit["siteVisitID"];
        }

        return $siteVisit ?: null;
    }

    static public function ctrMarkSiteVisitDone() {
        $siteVisitID = $_POST["sitevisit_id"] ?? null;
        $action      = $_POST["sitevisit_action"] ?? null;

        if (!$siteVisitID || $action !== 'completed') {
            return null;
        }

        // Server-side date guard: block if visit date is in the future
        $model     = new SiteVisitModel();
        $siteVisit = $model->getSiteVisitDetails($siteVisitID);

        if ($siteVisit && !empty($siteVisit['siteVisitDate'])) {
            $visitDate = date_create($siteVisit['siteVisitDate']);
            $today     = date_create(date('Y-m-d'));
            if ($visitDate && $visitDate > $today) {
                return ['success' => false, 'message' => 'This site visit cannot be marked as completed before its scheduled date (' . htmlspecialchars($siteVisit['siteVisitDate'], ENT_QUOTES, 'UTF-8') . ').'];
            }
        }

        $updated = $model->markSiteVisitDone($siteVisitID);

        if ($updated) {
            $_SESSION["selectedSiteVisitID"] = $siteVisitID;
            return ['success' => true, 'message' => 'Site visit marked as Completed.'];
        }

        return ['success' => false, 'message' => 'Unable to update. It may already be Completed or not found.'];
    }
}