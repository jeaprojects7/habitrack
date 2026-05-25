<?php
require_once "connection.php";
require_once __DIR__ . "/../helpers/Mailer.php";

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
                $data[$key] = $value === null || trim((string) $value) === '' ? null : $value;
            }

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO agent(
                    agentID, agentPass, agentFName, agentLName,agentMName, agentSuffix,agentEmail,agentPhoneNum, 
                    agentAddress, agentSoldUnits, agentFB, agentGender, agentBirthdate, agentPic
                ) VALUES (
                    :agentID, :agentPass, :agentFName, :agentLName, :agentMName, :agentSuffix, :agentEmail, :agentPhoneNum, 
                    :agentAddress, :agentSoldUnits, :agentFB, :agentGender, :agentBirthdate, :agentPic
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
            $stmt->bindParam(":agentPic", $data["agentPic"], PDO::PARAM_STR);
           
          
            $stmt->execute();

            $pdo->commit();

            // Send the generated temporary password after the agent is saved.
            // Email failure should not undo the registration, so the mail helper logs failures only.
            $agentName = trim(($data["agentFName"] ?? '') . ' ' . ($data["agentLName"] ?? ''));
            Mailer::sendAgentTemporaryPassword($data["agentEmail"], $agentName, $agentpasswordcode);

            return $agentcode;

        } 
        catch (PDOException $e){
            $pdo->rollBack();

            // 🔥 IMPORTANT FIX: show REAL error instead of hiding it
            return "error: " . $e->getMessage();
        }
    }

    //this one if for displaying the list
      static public function mdlGetAgents(){
        $stmt = (new Connection)->connect()->prepare("
            SELECT *
            FROM agent
            ORDER BY id ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        //this one is for getting the stuff gd sng matumok nga agent

        static public function mdlGetAgent($agentID){

    $db = new Connection();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("
        SELECT *
        FROM agent
        WHERE agentID = :agentID
        LIMIT 1
    ");

    $stmt->bindParam(":agentID", $agentID, PDO::PARAM_STR);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
     static public function mdlUpdateAgent($data){

    $db = new Connection();
    $pdo = $db->connect();

    try{

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            UPDATE agent SET

                agentFName = :agentFName,
                agentMName = :agentMName,
                agentLName = :agentLName,
                agentSuffix = :agentSuffix,
                agentEmail = :agentEmail,
                agentPhoneNum = :agentPhoneNum,
                agentPic = COALESCE(:agentPic, agentPic),
                agentAddress = :agentAddress,
                agentGender = :agentGender,
                agentBirthdate = :agentBirthdate,
                agentSoldUnits = :agentSoldUnits,
                agentFB = :agentFB
              

            WHERE agentID = :agentID
        ");

         // Convert empty strings to NULL
           /*  foreach ($data as $key => $value) {
                $data[$key] = trim($value) === '' ? null : $value;} */
                foreach ($data as $key => $value) {

                if ($value === null || trim((string)$value) === '') {
                    $data[$key] = null;
                } else {
                    $data[$key] = $value;
                }
            }

        

        // bindings
        $stmt->bindParam(":agentID", $data["agentID"], PDO::PARAM_STR);
        $stmt->bindParam(":agentFName", $data["agentFName"], PDO::PARAM_STR);
        $stmt->bindParam(":agentMName", $data["agentMName"], PDO::PARAM_STR);
        $stmt->bindParam(":agentLName", $data["agentLName"], PDO::PARAM_STR);
        $stmt->bindParam(":agentSuffix", $data["agentSuffix"], PDO::PARAM_STR);
        $stmt->bindParam(":agentGender", $data["agentGender"], PDO::PARAM_STR);
        $stmt->bindParam(":agentBirthdate", $data["agentBirthdate"], PDO::PARAM_STR);
        $stmt->bindParam(":agentSoldUnits", $data["agentSoldUnits"], PDO::PARAM_STR);
        $stmt->bindParam(":agentAddress", $data["agentAddress"], PDO::PARAM_STR);

        $stmt->bindParam(":agentPic", $data["agentPic"], PDO::PARAM_STR);
        $stmt->bindParam(":agentPhoneNum", $data["agentPhoneNum"], PDO::PARAM_STR);
        $stmt->bindParam(":agentEmail", $data["agentEmail"], PDO::PARAM_STR);
        $stmt->bindParam(":agentFB", $data["agentFB"], PDO::PARAM_STR);

       
        return $stmt->execute();

    } catch(PDOException $e){
        return "error: " . $e->getMessage();
    }
}


   
}