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

    /* static public function mdlGetClientLogin($username, $upassword){
		$encryptpass = $upassword;
		$stmt = (new Connection)->connect()->prepare("SELECT clientID, clientEmail, clientPass FROM client WHERE (clientEmail = '$username') AND (clientPass = '$encryptpass')");
		$stmt -> execute();
		return $stmt -> fetch();
	} changed ^ to this v 522261*/
     // replace mdlGetClientLogin with this:

    /* added 52126 */
    static public function mdlGetClientLogin($username, $upassword){
        $stmt = (new Connection)->connect()->prepare(
            "SELECT clientID, clientEmail, clientPass FROM client WHERE clientEmail = :email"
        );
        $stmt->bindParam(":email", $username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row && password_verify($upassword, $row["clientPass"])){
            return $row;
        }
        return false;
    }

    static public function mdlGetClientCredentials($tableUsers, $item, $value){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();
	}

    static public function mdlGetClientInfo($tableUsers, $item, $value){
		$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    public static function mdlCheckClientInfo($prequalID){
		$stmt = (new Connection)->connect()->prepare("
			SELECT * FROM client_information 
			WHERE prequalID = :prequalID 
			LIMIT 1
		");

		$stmt->bindParam(":prequalID", $prequalID);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    static public function mdlSaveClientInfo($data){

        $db = new Connection();
        $pdo = $db->connect();

        try{

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // Check if this prequalID already has client information
            $checkPrequal = $pdo->prepare("
                SELECT prequalID
                FROM client_information
                WHERE prequalID = :prequalID
                LIMIT 1
            ");

            $checkPrequal->bindParam(":prequalID", $data["prequalID"], PDO::PARAM_STR);
            $checkPrequal->execute();

            if($checkPrequal->fetch()){
                $pdo->rollBack();
                return "already_exists";
            }
            
            // Generate ID
            $cis_id = $pdo->prepare("
                SELECT CONCAT('CIS', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM client_information
            ");
            $cis_id->execute();
            $cisID = $cis_id->fetch(PDO::FETCH_ASSOC);
            $ciscode = $cisID['gen_id'];

            // OPTIONAL: Manual check (extra safety)
            $check = $pdo->prepare("SELECT clientCISID FROM client_information WHERE clientCISID = :clientCISID");
            $check->bindParam(":clientCISID", $ciscode, PDO::PARAM_STR);
            $check->execute();

            /*  */
            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }/*  */

            $stmt = $pdo->prepare("

                INSERT INTO client_information(

                    clientCISID,
                    prequalID,

                    clientCitizenship,
                    clientGender,
                    clientReligion,
                    clientBirthdate,
                    clientPlaceOfBirth,

                    clientAddress,
                    clientProvinceAddress,

                    clientTaxIdenNum,
                    clientSSS_GSISnumber,

                    clientDependentsElem,
                    clientDependentsHS,
                    clientDependentsC,
                    clientDependentsNotStud,

                    clientSourceOfIncome,
                    clientEmployerBusinessName,
                    clientNatureOfBusiness,
                    clientBusinessAddress,

                    clientPosition,
                    clientDepartment,
                    clientDateHired,
                    clientAppointment,
                    clientPlaceOfWork,

                    clientEmpPhoneNum,
                    clientEmployerEmail,

                    clientFathersName,
                    clientMothersMaidenName,

                    clientParentsAddress,
                    clientParentsPhoneNum,

                    clientSpaName,
                    clientSpaAddress,
                    clientSpaPhoneNum

                ) VALUES (

                    :clientCISID,
                    :prequalID,

                    :clientCitizenship,
                    :clientGender,
                    :clientReligion,
                    :clientBirthdate,
                    :clientPlaceOfBirth,

                    :clientAddress,
                    :clientProvinceAddress,

                    :clientTaxIdenNum,
                    :clientSSS_GSISnumber,

                    :clientDependentsElem,
                    :clientDependentsHS,
                    :clientDependentsC,
                    :clientDependentsNotStud,

                    :clientSourceOfIncome,
                    :clientEmployerBusinessName,
                    :clientNatureOfBusiness,
                    :clientBusinessAddress,

                    :clientPosition,
                    :clientDepartment,
                    :clientDateHired,
                    :clientAppointment,
                    :clientPlaceOfWork,

                    :clientEmpPhoneNum,
                    :clientEmployerEmail,

                    :clientFathersName,
                    :clientMothersMaidenName,

                    :clientParentsAddress,
                    :clientParentsPhoneNum,

                    :clientSpaName,
                    :clientSpaAddress,
                    :clientSpaPhoneNum

                )

            ");
            $stmt->bindParam(":prequalID", $data["prequalID"], PDO::PARAM_STR);
            $stmt->bindParam(":clientCISID", $ciscode, PDO::PARAM_STR);
            $stmt->bindParam(":clientCitizenship", $data["clientCitizenship"], PDO::PARAM_STR);
            $stmt->bindParam(":clientGender", $data["clientGender"], PDO::PARAM_STR);
            $stmt->bindParam(":clientReligion", $data["clientReligion"], PDO::PARAM_STR);
            $stmt->bindParam(":clientBirthdate", $data["clientBirthdate"], PDO::PARAM_STR);
            $stmt->bindParam(":clientPlaceOfBirth", $data["clientPlaceOfBirth"], PDO::PARAM_STR);

            $stmt->bindParam(":clientAddress", $data["clientAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":clientProvinceAddress", $data["clientProvinceAddress"], PDO::PARAM_STR);

            $stmt->bindParam(":clientTaxIdenNum", $data["clientTaxIdenNum"], PDO::PARAM_STR);
            $stmt->bindParam(":clientSSS_GSISnumber", $data["clientSSS_GSISnumber"], PDO::PARAM_STR);

            $stmt->bindParam(":clientDependentsElem", $data["clientDependentsElem"], PDO::PARAM_STR);
            $stmt->bindParam(":clientDependentsHS", $data["clientDependentsHS"], PDO::PARAM_STR);
            $stmt->bindParam(":clientDependentsC", $data["clientDependentsC"], PDO::PARAM_STR);
            $stmt->bindParam(":clientDependentsNotStud", $data["clientDependentsNotStud"], PDO::PARAM_STR);

            $stmt->bindParam(":clientSourceOfIncome", $data["clientSourceOfIncome"], PDO::PARAM_STR);
            $stmt->bindParam(":clientEmployerBusinessName", $data["clientEmployerBusinessName"], PDO::PARAM_STR);
            $stmt->bindParam(":clientNatureOfBusiness", $data["clientNatureOfBusiness"], PDO::PARAM_STR);
            $stmt->bindParam(":clientBusinessAddress", $data["clientBusinessAddress"], PDO::PARAM_STR);

            $stmt->bindParam(":clientPosition", $data["clientPosition"], PDO::PARAM_STR);
            $stmt->bindParam(":clientDepartment", $data["clientDepartment"], PDO::PARAM_STR);
            $stmt->bindParam(":clientDateHired", $data["clientDateHired"], PDO::PARAM_STR);
            $stmt->bindParam(":clientAppointment", $data["clientAppointment"], PDO::PARAM_STR);
            $stmt->bindParam(":clientPlaceOfWork", $data["clientPlaceOfWork"], PDO::PARAM_STR);

            $stmt->bindParam(":clientEmpPhoneNum", $data["clientEmpPhoneNum"], PDO::PARAM_STR);
            $stmt->bindParam(":clientEmployerEmail", $data["clientEmployerEmail"], PDO::PARAM_STR);

            $stmt->bindParam(":clientFathersName", $data["clientFathersName"], PDO::PARAM_STR);
            $stmt->bindParam(":clientMothersMaidenName", $data["clientMothersMaidenName"], PDO::PARAM_STR);

            $stmt->bindParam(":clientParentsAddress", $data["clientParentsAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":clientParentsPhoneNum", $data["clientParentsPhoneNum"], PDO::PARAM_STR);

            $stmt->bindParam(":clientSpaName", $data["clientSpaName"], PDO::PARAM_STR);
            $stmt->bindParam(":clientSpaAddress", $data["clientSpaAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":clientSpaPhoneNum", $data["clientSpaPhoneNum"], PDO::PARAM_STR);

            $stmt->execute();

            $pdo->commit();
            return "success";

        // }catch (PDOException $e){

        //     $pdo->rollBack();
        //     return "error";

        // }
        }catch (PDOException $e){

            $pdo->rollBack();

            return $e->getMessage();
        }
    }

    

    static public function mdlGetClient($clientID){

        $db = new Connection();
        $pdo = $db->connect();

        $stmt = $pdo->prepare("
            SELECT *
            FROM client
            WHERE clientID = :clientID
            LIMIT 1
        ");

        $stmt->bindParam(":clientID", $clientID, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlClientChangePassword($oldpassword, $newpassword){

        $clientID = $_SESSION["clientID"];

        // CHECK OLD PASSWORD
        $stmt = (new Connection)->connect()->prepare("
            SELECT * 
            FROM client 
            WHERE clientID = :clientID 
            AND clientPass = :oldpassword
        ");

        $stmt->bindParam(":clientID", $clientID, PDO::PARAM_STR);
        $stmt->bindParam(":oldpassword", $oldpassword, PDO::PARAM_STR);

        $stmt->execute();

        $answer = $stmt->fetch();

        // IF OLD PASSWORD IS CORRECT
        if(!empty($answer)){

            $stmt = (new Connection)->connect()->prepare("
                UPDATE client 
                SET clientPass = :newpassword 
                WHERE clientID = :clientID
            ");

            $stmt->bindParam(":newpassword", $newpassword, PDO::PARAM_STR);
            $stmt->bindParam(":clientID", $clientID, PDO::PARAM_STR);

            $stmt->execute();

            return "success";

        }else{

            return "incorrect";

        }

    }

    static public function mdlGetClientInfoByPrequalID($prequalID){

        $stmt = (new Connection)->connect()->prepare("
            SELECT
                ci.*,
                p.*,
                c.clientID,
                c.clientFName,
                c.clientMName,
                c.clientLName,
                c.clientSuffix,
                c.clientEmail,
                c.clientPhoneNum
            FROM client_information ci
            INNER JOIN prequal p
                ON ci.prequalID = p.prequalID
            INNER JOIN client c
                ON p.clientID = c.clientID
            WHERE ci.prequalID = :prequalID
            LIMIT 1
        ");

        $stmt->bindParam(":prequalID", $prequalID, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlGetLatestClientInfoByClientID($clientID){

        $stmt = (new Connection)->connect()->prepare("

            SELECT ci.*,
            p.clientCivilStatus AS clientCivilStatus,
            p.clientMonthlyIncome AS clientMonthlyIncome

            FROM client_information ci

            INNER JOIN prequal p
                ON ci.prequalID = p.prequalID

            WHERE p.clientID = :clientID

            ORDER BY ci.id DESC
            LIMIT 1

        ");

        $stmt->bindParam(":clientID", $clientID, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // static public function mdlGetCoOwnerInfo($tableUsers, $item, $value){
	// 	$stmt = (new Connection)->connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");
	// 	$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);
	// 	$stmt -> execute();
	// 	return $stmt->fetch(PDO::FETCH_ASSOC);
	// }

    // static public function mdlGetClientCoOwnerInfoByPrequalID($prequalID){
    //     $stmt = (new Connection)->connect()->prepare("
    //         SELECT *
    //         FROM clientcoprequal
    //         WHERE prequalID = :prequalID
    //         LIMIT 1
    //     ");

    //     $stmt->bindParam(":prequalID", $prequalID, PDO::PARAM_STR);
    //     $stmt->execute();

    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // } ari na ni sa coowner model
}
