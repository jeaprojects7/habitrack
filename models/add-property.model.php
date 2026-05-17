<?php
require_once "connection.php";

class ModelAddProperty{

    static public function mdlAddProperty($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Generate ID (UNCHANGED as requested)
            $property_id = $pdo->prepare("
                SELECT CONCAT('PR', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM properties
            ");
            $property_id->execute();
            $propertyid = $property_id->fetch(PDO::FETCH_ASSOC);
            $propertycode = $propertyid['gen_id'];

            // Manual duplicate check (KEPT as requested)
            $check = $pdo->prepare("
                SELECT propertyID FROM properties WHERE propertyID = :propertyID
            ");
            $check->bindParam(":propertyID", $propertycode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

            // Convert empty strings to NULL
            foreach ($data as $key => $value) {
                $data[$key] = trim($value) === '' ? null : $value;
}

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO properties(
                    propertyID, propertyName, propertyType,propertyLat, propertyLng,housePowderRoom,propertyCity, 
                    propertyBrgy, propertyPrice, houseFloorArea, houseStorey, houseBedroom, houseTandB, propertyLotArea,
                    houseGarage, houseGarden, houseBalcony, housePool, houseMaidRoom, houseLaundryArea, houseTerrace,
                    houseCabinets, houseBilliardRoom
                ) VALUES (
                    :propertyID, :propertyName, :propertyType, :propertyLat, :propertyLng, :housePowderRoom, :propertyCity, 
                    :propertyBrgy, :propertyPrice, :houseFloorArea, :houseStorey, :houseBedroom, :houseTandB, :propertyLotArea,
                    :houseGarage, :houseGarden, :houseBalcony, :housePool, :houseMaidRoom, :houseLaundryArea, :houseTerrace,
                    :houseCabinets, :houseBilliardRoom
                )
            ");

            $stmt->bindParam(":propertyID", $propertycode, PDO::PARAM_STR);
            $stmt->bindParam(":propertyName", $data["propertyName"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyType", $data["propertyType"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyLat", $data["propertyLat"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyLng", $data["propertyLng"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyCity", $data["propertyCity"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyBrgy", $data["propertyBrgy"], PDO::PARAM_STR);
            $stmt->bindParam(":propertyPrice", $data["propertyPrice"], PDO::PARAM_STR);
            $stmt->bindParam(":houseFloorArea", $data["houseFloorArea"], PDO::PARAM_STR);
            $stmt->bindParam(":houseStorey", $data["houseStorey"], PDO::PARAM_STR);
            $stmt->bindParam(":houseBedroom", $data["houseBedroom"], PDO::PARAM_STR);
            $stmt->bindParam(":houseTandB", $data["houseTandB"], PDO::PARAM_STR); 
            $stmt->bindParam(":propertyLotArea", $data["propertyLotArea"], PDO::PARAM_STR);      
            
            $stmt->bindParam(":housePowderRoom", $data["housePowderRoom"], PDO::PARAM_STR);
            $stmt->bindParam(":houseGarage", $data["houseGarage"], PDO::PARAM_STR);
            $stmt->bindParam(":houseGarden", $data["houseGarden"], PDO::PARAM_STR);
            $stmt->bindParam(":houseBalcony", $data["houseBalcony"], PDO::PARAM_STR);
            $stmt->bindParam(":housePool", $data["housePool"], PDO::PARAM_STR);
            $stmt->bindParam(":houseMaidRoom", $data["houseMaidRoom"], PDO::PARAM_STR);
            $stmt->bindParam(":houseLaundryArea", $data["houseLaundryArea"], PDO::PARAM_STR);
            $stmt->bindParam(":houseTerrace", $data["houseTerrace"], PDO::PARAM_STR);
            $stmt->bindParam(":houseCabinets", $data["houseCabinets"], PDO::PARAM_STR);
            $stmt->bindParam(":houseBilliardRoom", $data["houseBilliardRoom"], PDO::PARAM_STR); 

          
            $stmt->execute();

            $pdo->commit();
            return $propertycode;

        } 
        catch (PDOException $e){
            $pdo->rollBack();

            // 🔥 IMPORTANT FIX: show REAL error instead of hiding it
            return "error: " . $e->getMessage();
        }
    }


   
}