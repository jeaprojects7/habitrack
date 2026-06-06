<?php

require_once __DIR__ . '/../models/coowner.model.php';

class ControllerCoOwner {

    // static public function ctrGetCoOwnerByID($coOwnerID) {
    //     return ModelCoOwner::mdlGetCoOwnerByID($coOwnerID);
    // }


    public static function ctrGetCoOwnerByID($coOwnerID) {
        if (!$coOwnerID) {
            return ["status" => "error", "message" => "Missing coOwnerID"];
        }

        return ModelCoOwner::mdlGetCoOwnerByID($coOwnerID);
    }

    static public function ctrSaveCoOwnerInfo($data){

        require_once __DIR__ . "/../models/coowner.model.php";

        return ModelCoOwner::mdlSaveCoOwnerInfo($data);
    }

    static public function ctrGetCoOwnerIS($prequalID){
        return ModelCoOwner::mdlGetCoOwnerIS($prequalID);
    }
}