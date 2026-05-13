<?php
require_once "connection.php";
class ModelUserRights{
	static public function mdlGetUserCredentials($tableUsers, $item, $value){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
	}

	static public function mdlGetUserLogin($username, $upassword){
		$encryptpass = $upassword;
		$stmt = (new Connection)->connect()->prepare("SELECT userid, username, upassword FROM userrights WHERE (username = '$username') AND (upassword = '$encryptpass')");
		$stmt -> execute();
		return $stmt -> fetch();
	}

	static public function mdlAddUserLogin($data){
        $db = new Connection();
        $pdo = $db->connect();

        try{
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();



            // Insert
            $stmt = $pdo->prepare("
                INSERT INTO userrights(
                    userid, username, upassword
                ) VALUES (
                    :userid, :username, :upassword
                )
            ");

            $stmt->bindParam(":userid", $data["clientID"], PDO::PARAM_STR);
            $stmt->bindParam(":username", $data["email"], PDO::PARAM_STR);
            $stmt->bindParam(":upassword", $data["password"], PDO::PARAM_STR);

            
            $stmt->execute();

            $pdo->commit();
            return "success";

        }catch (PDOException $e){
            $pdo->rollBack();
            // If duplicate entry error (MySQL error code 1062)
            if($e->errorInfo[1] == 1062){
                return "existing";
            }
            return "error";
        }
    

	}

	
}