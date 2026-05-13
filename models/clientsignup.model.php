<?php
require_once "connection.php";
class ModelClient{
    static public function mdlSaveClient($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Generate ID
            $client_id = $pdo->prepare("
                SELECT CONCAT('C', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM client
            ");
            $client_id->execute();
            $clientID = $client_id->fetch(PDO::FETCH_ASSOC);
            $clientcode = $clientID['gen_id'];

            // OPTIONAL: Manual check (extra safety)
            $check = $pdo->prepare("SELECT clientID FROM client WHERE clientID = :clientID");
            $check->bindParam(":clientID", $clientcode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO client(
                    clientID, clientFName, clientLName, clientMName,
                    clientSuffix, clientEmail, clientPhoneNum, clientPass
                ) VALUES (
                    :clientID, :clientFName, :clientLName, :clientMName, 
                    :clientSuffix, :clientEmail, :clientPhoneNum, :clientPass
                )
            ");

            $stmt->bindParam(":clientID", $clientcode, PDO::PARAM_STR);
            $stmt->bindParam(":clientFName", $data["firstname"], PDO::PARAM_STR);
            $stmt->bindParam(":clientLName", $data["lastname"], PDO::PARAM_STR);
            $stmt->bindParam(":clientMName", $data["middlename"], PDO::PARAM_STR);
            $stmt->bindParam(":clientSuffix", $data["suffix"], PDO::PARAM_STR);
            $stmt->bindParam(":clientEmail", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":clientPhoneNum", $data["phonenumber"], PDO::PARAM_STR);
            $stmt->bindParam(":clientPass", $data["password"], PDO::PARAM_STR);

            
            $stmt->execute();

            $pdo->commit();
            return $clientcode;

        }catch (PDOException $e){
            $pdo->rollBack();
            // If duplicate entry error (MySQL error code 1062)
            if($e->errorInfo[1] == 1062){
                return "existing";
            }
            return "error";
        }
    }

    static public function mdlGetClientLogin($username, $upassword){
		$encryptpass = $upassword;
		$stmt = (new Connection)->connect()->prepare("SELECT clientID, clientEmail, clientPass FROM client WHERE (clientEmail = '$username') AND (clientPass = '$encryptpass')");
		$stmt -> execute();
		return $stmt -> fetch();
	}
}
