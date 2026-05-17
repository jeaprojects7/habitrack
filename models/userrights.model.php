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

	
}