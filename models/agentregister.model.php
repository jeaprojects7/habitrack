<?php
require_once "connection.php";

class ModelAddAgent{

    static public function mdlAddAgent($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Generate ID (UNCHANGED as requested)
            $agent_id = $pdo->prepare("
                SELECT CONCAT('AG', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM agent
            ");
            $agent_id->execute();
            $agentid = $agent_id->fetch(PDO::FETCH_ASSOC);
            $agentcode = $agentid['gen_id'];

            // Manual duplicate check (KEPT as requested)
            $check = $pdo->prepare("
                SELECT agentID FROM agent WHERE agentID = :agentID
            ");
            $check->bindParam(":agentID", $agentcode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

             $agentpassword = $pdo->prepare("
                SELECT CONCAT('ABCD', LPAD((COUNT(id)+1),6,'0')) as agentPass
                FROM agent
            ");
            $agentpassword->execute();
            $agentpasswordcode = $agentpassword->fetch(PDO::FETCH_ASSOC)['agentPass'];

            $check = $pdo->prepare("
                SELECT id FROM agent WHERE agentPass = :agentPass
            ");
            $check->bindParam(":agentPass", $agentpasswordcode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing_password";
            }


            // Convert empty strings to NULL
            foreach ($data as $key => $value) {
                $data[$key] = trim($value) === '' ? null : $value;
}

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO agent(
                    agentID, agentPass, agentFName, agentLName,agentMName, agentSuffix,agentEmail,agentPhoneNum, 
                    agentAddress, agentSoldUnits, agentFB, agentGender, agentBirthdate
                ) VALUES (
                    :agentID, :agentPass, :agentFName, :agentLName, :agentMName, :agentSuffix, :agentEmail, :agentPhoneNum, 
                    :agentAddress, :agentSoldUnits, :agentFB, :agentGender, :agentBirthdate
                )
            ");

            $stmt->bindParam(":agentID", $agentcode, PDO::PARAM_STR);
            $stmt->bindParam(":agentPass", $agentpasswordcode, PDO::PARAM_STR);
            $stmt->bindParam(":agentFName", $data["agentFName"], PDO::PARAM_STR);
            $stmt->bindParam(":agentMName", $data["agentMName"], PDO::PARAM_STR);
            $stmt->bindParam(":agentLName", $data["agentLName"], PDO::PARAM_STR);
            $stmt->bindParam(":agentSuffix", $data["agentSuffix"], PDO::PARAM_STR);
            $stmt->bindParam(":agentGender", $data["agentGender"], PDO::PARAM_STR);
            $stmt->bindParam(":agentBirthdate", $data["agentBirthdate"], PDO::PARAM_STR);
            $stmt->bindParam(":agentSoldUnits", $data["agentSoldUnits"], PDO::PARAM_STR);
            $stmt->bindParam(":agentAddress", $data["agentAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":agentPhoneNum", $data["agentPhoneNum"], PDO::PARAM_STR);
            $stmt->bindParam(":agentEmail", $data["agentEmail"], PDO::PARAM_STR);
            $stmt->bindParam(":agentFB", $data["agentFB"], PDO::PARAM_STR);
           
          
            $stmt->execute();

            $pdo->commit();
            return $agentcode;

        } 
        catch (PDOException $e){
            $pdo->rollBack();

            // 🔥 IMPORTANT FIX: show REAL error instead of hiding it
            return "error: " . $e->getMessage();
        }
    }


   
}