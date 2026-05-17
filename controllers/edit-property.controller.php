<?php

require_once __DIR__ . "/../models/edit-property.model.php";

class PropertyController {

    static public function ctrGetProperties() {

        $properties = PropertyModel::mdlGetProperties();

        return $properties;
    }
}