<?php
require_once "../controllers/add-property.controller.php";
require_once "../models/add-property.model.php";

 class addProperty{
  public $trans_type; 
  public $propertyID;
  public $propertyName;
  public $propertyType;
  public $propertyLat;
  public $propertyLng;
  public $propertyCity;
  public $propertyBrgy; 
  public $propertyPrice;
  public $houseFloorArea;
  public $houseStorey;
  public $houseBedroom;
  public $houseTandB;
  public $propertyLotArea;
  public $amenities = [];


  public function saveProperty(){
    $trans_type = $this->trans_type;
    $propertyID = $this->propertyID;
  	$propertyName = $this->propertyName;
  	$propertyType = $this->propertyType;
    $propertyLat = $this->propertyLat;
  	$propertyLng = $this->propertyLng;
    $propertyCity = $this->propertyCity;
    $propertyBrgy = $this->propertyBrgy;
    $propertyPrice = $this->propertyPrice;
    $houseFloorArea = $this->houseFloorArea;
    $houseStorey = $this->houseStorey;
    $houseBedroom = $this->houseBedroom;
    $propertyLotArea = $this->propertyLotArea;
    $houseTandB = $this->houseTandB;


    $data = array("propertyID"=>$propertyID,
                  "propertyName"=>$propertyName,
                  "propertyType"=>$propertyType,
                  "propertyLat"=>$propertyLat,
                  "propertyLng"=>$propertyLng,
                  "propertyCity"=>$propertyCity,
                  "propertyBrgy"=>$propertyBrgy,
                  "propertyLotArea"=>$propertyLotArea,
                  "propertyPrice"=>$propertyPrice,
                  "houseFloorArea"=>$houseFloorArea,
                  "houseStorey"=>$houseStorey,
                  "houseBedroom"=>$houseBedroom,
                  "houseTandB"=>$houseTandB,
                  "housePowderRoom" => in_array("Powder Room", $this->amenities) ? 1 : 0,
                  "houseGarage" => in_array("Garage", $this->amenities) ? 1 : 0,
                  "houseBalcony" => in_array("Balcony", $this->amenities) ? 1 : 0,
                  "houseTerrace" => in_array("Terrace", $this->amenities) ? 1 : 0,
                  "houseGarden" => in_array("Garden", $this->amenities) ? 1 : 0,
                  "houseLaundryArea" => in_array("Laundry Area", $this->amenities) ? 1 : 0,
                  "houseMaidRoom" => in_array("Maid's Room", $this->amenities) ? 1 : 0,
                  "housePool" => in_array("Swimming Pool", $this->amenities) ? 1 : 0,
                  "houseCabinets" => in_array("Built-in Cabinets", $this->amenities) ? 1 : 0,
                  "houseBilliardRoom" => in_array("Billiard Room", $this->amenities) ? 1 : 0,
                  "houseClubhouse" => in_array("Clubhouse", $this->amenities) ? 1 : 0,);

    if ($trans_type == 'New'){
      $answer = (new ControllerAddProperty)->ctrAddProperty($data);
      echo $answer;
     }else{
       $answer = (new ControllerAddProperty)->ctrUpdateProperty($data);
      echo $answer;
    } 

   }
  }
 

$add_property = new addProperty();

$add_property -> trans_type = $_POST["trans_type"];
//$save_clinicstaff -> encodedby = !empty($_POST["encodedby"]) ? $_POST["encodedby"] : 'SYSTEM';
$add_property -> propertyID = $_POST["propertyID"];
$add_property -> propertyName = $_POST["propertyName"];
$add_property -> propertyType = $_POST["propertyType"];
$add_property -> propertyLat = $_POST["propertyLat"];
$add_property -> propertyLng = $_POST["propertyLng"];
$add_property -> propertyCity = $_POST["propertyCity"];
$add_property -> propertyBrgy = $_POST["propertyBrgy"];
$add_property -> propertyLotArea = $_POST["propertyLotArea"];
$add_property -> propertyPrice = $_POST["propertyPrice"];
$add_property -> houseFloorArea = $_POST["houseFloorArea"];
$add_property -> houseStorey = $_POST["houseStorey"];
$add_property -> houseBedroom = $_POST["houseBedroom"];
$add_property -> houseTandB = $_POST["houseTandB"];

$add_property->amenities = $_POST["amenities"] ?? [];
$add_property -> saveProperty();
 

