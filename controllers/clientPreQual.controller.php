<?php

require_once __DIR__ . "/../models/clientPreQual.model.php";

class PrequalController {

    static public function ctrGetPrequal($status) {

        $model = new PrequalModel();
        return $model->getPreQualByStatus($status);
    }

}

   

