<?php
require_once "connection.php";
class ModelAgent{
    static public function mdlSaveAgent($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Generate ID
            $agent_id = $pdo->prepare("
                SELECT CONCAT('AG', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM agent
            ");
            $agent_id->execute();
            $agentID = $agent_id->fetch(PDO::FETCH_ASSOC);
            $agentcode = $agentID['gen_id'];

            // OPTIONAL: Manual check (extra safety)
            $check = $pdo->prepare("SELECT agentID FROM agent WHERE agentID = :agentID");
            $check->bindParam(":agentID", $agentcode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO agent(
                    agentID, agentFName, agentLName, agentMName,agentSuffix, agentEmail, agentPhoneNum, agentPass, 
                    agentPic, agentAddress, agentFirstValidID, agentSecondValidID, agentCurrentEmployment, agentCurrentPosition,
                    agentInsitution, agentDegree, agentPreviousRealty, agentLevel, agentFB, agentTIN, agentGender,
                    agentBirthdate, agentCivilStatPic, agentResumePic, agentNBIPic, agentDiploma, agentTOR 
                ) VALUES (
                    :agentID, :agentFName, :agentLName, :agentMName, :agentSuffix, :agentEmail, :agentPhoneNum, :agentPass, 
                    :agentPic, :agentAddress, :agentFirstValidID, :agentSecondValidID, :agentCurrentEmployment, :agentCurrentPosition,
                    :agentInsitution, :agentDegree, :agentPreviousRealty, :agentLevel, :agentFB, :agentTIN, :agentGender,
                    :agentBirthdate, :agentCivilStatPic, :agentResumePic, :agentNBIPic, :agentDiploma, :agentTOR 
                )
            ");

            $stmt->bindParam(":agentID", $agentcode, PDO::PARAM_STR);
            $stmt->bindParam(":agentFName", $data["firstname"], PDO::PARAM_STR);
            $stmt->bindParam(":agentLName", $data["lastname"], PDO::PARAM_STR);
            $stmt->bindParam(":agentMName", $data["middlename"], PDO::PARAM_STR);
            $stmt->bindParam(":agentSuffix", $data["suffix"], PDO::PARAM_STR);
            $stmt->bindParam(":agentEmail", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":agentPhoneNum", $data["phonenumber"], PDO::PARAM_STR);
            $stmt->bindParam(":agentPass", $data["password"], PDO::PARAM_STR);
            $stmt->bindParam(":agentGender", $data["gender"], PDO::PARAM_STR);
            $stmt->bindParam(":agentBirthdate", $data["birthdate"], PDO::PARAM_STR);
            $stmt->bindParam(":agentFB", $data["fb"], PDO::PARAM_STR);
            $stmt->bindParam(":agentAddress", $data["address"], PDO::PARAM_STR);
            $stmt->bindParam(":agentPic", $data["picture"], PDO::PARAM_STR);
            $stmt->bindParam(":agentFirstValidID", $data["firstID"], PDO::PARAM_STR);
            $stmt->bindParam(":agentSecondValidID", $data["secondID"], PDO::PARAM_STR);
            $stmt->bindParam(":agentCurrentEmployment", $data["curEmp"], PDO::PARAM_STR);
            $stmt->bindParam(":agentCurrentPosition", $data["curPos"], PDO::PARAM_STR);
            $stmt->bindParam(":agentPreviousRealty", $data["prevRealty"], PDO::PARAM_STR);
            $stmt->bindParam(":agentLevel", $data["level"], PDO::PARAM_STR);
            $stmt->bindParam(":agentTIN", $data["tin"], PDO::PARAM_STR);
            $stmt->bindParam(":agentInstitution", $data["institution"], PDO::PARAM_STR);
            $stmt->bindParam(":agentDegree", $data["degree"], PDO::PARAM_STR);
            $stmt->bindParam(":agentCivilStatPic", $data["civilStatPic"], PDO::PARAM_STR);
            $stmt->bindParam(":agentDiploma", $data["diploma"], PDO::PARAM_STR);
            $stmt->bindParam(":agentNBIPic", $data["nbiPic"], PDO::PARAM_STR);
            $stmt->bindParam(":agentResumePic", $data["resumePic"], PDO::PARAM_STR);
            $stmt->bindParam(":agentTorPic", $data["torPic"], PDO::PARAM_STR);

            
            $stmt->execute();

            $pdo->commit();
            return $agentcode;

        }catch (PDOException $e){
            $pdo->rollBack();
            // If duplicate entry error (MySQL error code 1062)
            if($e->errorInfo[1] == 1062){
                return "existing";
            }
            return "error";
        }
    }

    static public function mdlGetAgentLogin($username, $upassword){
		$encryptpass = $upassword;
		$stmt = (new Connection)->connect()->prepare("SELECT agentID, agentEmail, agentPass FROM agent WHERE (agentEmail = '$username') AND (agentPass = '$encryptpass')");
		$stmt -> execute();
		return $stmt -> fetch();
	}
  
    static public function mdlGetAgentCredentials($tableUsers, $item, $value){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
	}
}
