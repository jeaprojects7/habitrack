<?php
require_once "connection.php";
class ModelAdmin{
    static public function mdlSaveAdmin($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Generate ID
            $admin_id = $pdo->prepare("
                SELECT CONCAT('AD', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM admin
            ");
            $admin_id->execute();
            $adminID = $admin_id->fetch(PDO::FETCH_ASSOC);
            $admincode = $adminID['gen_id'];

            // OPTIONAL: Manual check (extra safety)
            $check = $pdo->prepare("SELECT adminID FROM admin WHERE adminID = :adminID");
            $check->bindParam(":adminID", $admincode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO admin(
                    adminID, adminFName, adminLName, adminMName,
                    adminSuffix, adminEmail, adminPhoneNum, adminPass
                ) VALUES (
                    :adminID, :adminFName, :adminLName, :adminMName, 
                    :adminSuffix, :adminEmail, :adminPhoneNum, :adminPass
                )
            ");

            $stmt->bindParam(":adminID", $admincode, PDO::PARAM_STR);
            $stmt->bindParam(":adminFName", $data["firstname"], PDO::PARAM_STR);
            $stmt->bindParam(":adminLName", $data["lastname"], PDO::PARAM_STR);
            $stmt->bindParam(":adminMName", $data["middlename"], PDO::PARAM_STR);
            $stmt->bindParam(":adminSuffix", $data["suffix"], PDO::PARAM_STR);
            $stmt->bindParam(":adminEmail", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":adminPhoneNum", $data["phonenumber"], PDO::PARAM_STR);
            $stmt->bindParam(":adminPass", $data["password"], PDO::PARAM_STR);

            
            $stmt->execute();

            $pdo->commit();
            return $admincode;

        }catch (PDOException $e){
            $pdo->rollBack();
            // If duplicate entry error (MySQL error code 1062)
            if($e->errorInfo[1] == 1062){
                return "existing";
            }
            return "error";
        }
    }

    static public function mdlGetAdminLogin($username, $upassword){
		$encryptpass = $upassword;
		$stmt = (new Connection)->connect()->prepare("SELECT adminID, adminEmail, adminPass FROM admin WHERE (adminEmail = '$username') AND (adminPass = '$encryptpass')");
		$stmt -> execute();
		return $stmt -> fetch();
	}

    static public function mdlGetAdminCredentials($tableUsers, $item, $value){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
	}
}
