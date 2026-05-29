<?php

require_once __DIR__ . "/../models/edit-property.model.php";

class PropertyController {

    static public function ctrGetProperties() {

        $properties = PropertyModel::mdlGetProperties();

        return $properties;
    }
    public static function ctrGetPropertyImages($id)
{
    return ModelProperty::mdlGetPropertyImages($id);
}

//gn add kolng ni
 public static function ctrGetPropertiesFiltered($filters){

    return (new PropertyModel)->mdlGetPropertiesFiltered($filters);
}
}