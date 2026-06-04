<?php
require_once __DIR__ . "/../models/add-property.model.php";
class ControllerAddProperty{

    /* =========================
       ADD PROPERTY
    ========================== */
    static public function ctrAddProperty($data){

        $answer = (new ModelAddProperty)->mdlAddProperty($data);
        return $answer;
    }

    /* =========================
       GET SINGLE PROPERTY (FOR EDIT)
    ========================== */
    static public function ctrGetProperty($propertyID){

        $answer = (new ModelAddProperty)->mdlGetProperty($propertyID);
        return $answer;
    }

    /* =========================
       UPDATE PROPERTY
    ========================== */
    static public function ctrUpdateProperty($data){

        $answer = (new ModelAddProperty)->mdlUpdateProperty($data);
        return $answer;
    }

	static public function ctrGetProperties(){

    return (new ModelAddProperty)->mdlGetProperties();
}
 public static function ctrGetPropertyImages($id)
{
    return (new ModelAddProperty)->mdlGetPropertyImages($id);
}

public static function ctrDeletePropertyImage($id)
{
    return (new ModelAddProperty)->mdlDeletePropertyImage($id);
}



	/* static public function ctrGetProperty($id){
		return ModelAddProperty::mdlGetProperty($id);
	}

	static public function ctrUpdateProperty($data){
		return ModelAddProperty::mdlUpdateProperty($data);
	}  */
}