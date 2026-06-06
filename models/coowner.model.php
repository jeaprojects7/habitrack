<?php
require_once "connection.php";
class ModelCoOwner{
    // static public function mdlGetClientCoOwnerInfoByPrequalID($prequalID){
    //         $stmt = (new Connection)->connect()->prepare("
    //             SELECT *
    //             FROM clientcoprequal
    //             WHERE prequalID = :prequalID
    //             LIMIT 1
    //         ");

    //         $stmt->bindParam(":prequalID", $prequalID, PDO::PARAM_STR);
    //         $stmt->execute();

    //         return $stmt->fetch(PDO::FETCH_ASSOC);
    //     }
    public static function mdlGetCoOwnerByID($coOwnerID){
        $stmt = (new Connection)->connect()->prepare("
            SELECT * 
            FROM clientcoprequal 
            WHERE coOwnerID = :coOwnerID
            LIMIT 1
        ");

        $stmt->bindParam(":coOwnerID", $coOwnerID, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlSaveCoOwnerInfo($data){

        $db = new Connection();
        $pdo = $db->connect();

        try{

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            // ===== CHECK IF PREQUAL ALREADY HAS CO-OWNER INFO =====
            $checkPrequal = $pdo->prepare("
                SELECT coOwnerID
                FROM coowner_information
                WHERE coOwnerID = :coOwnerID
                LIMIT 1
            ");

            $checkPrequal->bindParam(":coOwnerID", $data["coOwnerID"], PDO::PARAM_STR);
            $checkPrequal->execute();

            if($checkPrequal->fetch()){
                $pdo->rollBack();
                return "already_exists";
            }

            // ===== GENERATE COOWNER ID =====
            $co_id = $pdo->prepare("
                SELECT CONCAT('CO', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM coowner_information
            ");
            $co_id->execute();
            $coID = $co_id->fetch(PDO::FETCH_ASSOC);
            $coCode = $coID['gen_id'];

            // OPTIONAL SAFETY CHECK
            $check = $pdo->prepare("
                SELECT coownerISID 
                FROM coowner_information 
                WHERE coownerISID = :coOwnerID
            ");
            $check->bindParam(":coOwnerID", $coCode, PDO::PARAM_STR);
            $check->execute();

            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }

            // ===== INSERT QUERY =====
            $stmt = $pdo->prepare("

                INSERT INTO coowner_information(

                    coownerISID,
                    coOwnerID,

                    coCitizenship,
                    coGender,
                    coReligion,
                    coBirthdate,
                    coPlaceOfBirth,

                    coAddress,
                    coProvinceAddress,

                    coTaxIdenNum,
                    coSSS_GSISnumber,

                    coDependentsElem,
                    coDependentsHS,
                    coDependentsC,
                    coDependentsNotStud,

                    coSourceOfIncome,
                    coEmployerBusinessName,
                    coNatureOfBusiness,
                    coBusinessAddress,

                    coPosition,
                    coDepartment,
                    coDateHired,
                    coAppointment,
                    coPlaceOfWork,

                    coEmpPhoneNum,
                    coEmployerEmail,

                    coFathersName,
                    coMothersMaidenName,

                    coParentsAddress,
                    coParentsPhoneNum

                ) VALUES (

                    :coownerISID,
                    :coOwnerID,

                    :coCitizenship,
                    :coGender,
                    :coReligion,
                    :coBirthdate,
                    :coPlaceOfBirth,

                    :coAddress,
                    :coProvinceAddress,

                    :coTaxIdenNum,
                    :coSSS_GSISnumber,

                    :coDependentsElem,
                    :coDependentsHS,
                    :coDependentsC,
                    :coDependentsNotStud,

                    :coSourceOfIncome,
                    :coEmployerBusinessName,
                    :coNatureOfBusiness,
                    :coBusinessAddress,

                    :coPosition,
                    :coDepartment,
                    :coDateHired,
                    :coAppointment,
                    :coPlaceOfWork,

                    :coEmpPhoneNum,
                    :coEmployerEmail,

                    :coFathersName,
                    :coMothersMaidenName,

                    :coParentsAddress,
                    :coParentsPhoneNum

                )

            ");

            // ===== BIND VALUES =====
            $stmt->bindParam(":coownerISID", $coCode, PDO::PARAM_STR);
            $stmt->bindParam(":coOwnerID", $data["coOwnerID"], PDO::PARAM_STR);

            $stmt->bindParam(":coCitizenship", $data["coCitizenship"], PDO::PARAM_STR);
            $stmt->bindParam(":coGender", $data["coGender"], PDO::PARAM_STR);
            $stmt->bindParam(":coReligion", $data["coReligion"], PDO::PARAM_STR);
            $stmt->bindParam(":coBirthdate", $data["coBirthdate"], PDO::PARAM_STR);
            $stmt->bindParam(":coPlaceOfBirth", $data["coPlaceOfBirth"], PDO::PARAM_STR);

            $stmt->bindParam(":coAddress", $data["coAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":coProvinceAddress", $data["coProvinceAddress"], PDO::PARAM_STR);

            $stmt->bindParam(":coTaxIdenNum", $data["coTaxIdenNum"], PDO::PARAM_STR);
            $stmt->bindParam(":coSSS_GSISnumber", $data["coSSS_GSISnumber"], PDO::PARAM_STR);

            $stmt->bindParam(":coDependentsElem", $data["coDependentsElem"], PDO::PARAM_STR);
            $stmt->bindParam(":coDependentsHS", $data["coDependentsHS"], PDO::PARAM_STR);
            $stmt->bindParam(":coDependentsC", $data["coDependentsC"], PDO::PARAM_STR);
            $stmt->bindParam(":coDependentsNotStud", $data["coDependentsNotStud"], PDO::PARAM_STR);

            $stmt->bindParam(":coSourceOfIncome", $data["coSourceOfIncome"], PDO::PARAM_STR);
            $stmt->bindParam(":coEmployerBusinessName", $data["coEmployerBusinessName"], PDO::PARAM_STR);
            $stmt->bindParam(":coNatureOfBusiness", $data["coNatureOfBusiness"], PDO::PARAM_STR);
            $stmt->bindParam(":coBusinessAddress", $data["coBusinessAddress"], PDO::PARAM_STR);

            $stmt->bindParam(":coPosition", $data["coPosition"], PDO::PARAM_STR);
            $stmt->bindParam(":coDepartment", $data["coDepartment"], PDO::PARAM_STR);
            $stmt->bindParam(":coDateHired", $data["coDateHired"], PDO::PARAM_STR);
            $stmt->bindParam(":coAppointment", $data["coAppointment"], PDO::PARAM_STR);
            $stmt->bindParam(":coPlaceOfWork", $data["coPlaceOfWork"], PDO::PARAM_STR);

            $stmt->bindParam(":coEmpPhoneNum", $data["coEmpPhoneNum"], PDO::PARAM_STR);
            $stmt->bindParam(":coEmployerEmail", $data["coEmployerEmail"], PDO::PARAM_STR);

            $stmt->bindParam(":coFathersName", $data["coFathersName"], PDO::PARAM_STR);
            $stmt->bindParam(":coMothersMaidenName", $data["coMothersMaidenName"], PDO::PARAM_STR);

            $stmt->bindParam(":coParentsAddress", $data["coParentsAddress"], PDO::PARAM_STR);
            $stmt->bindParam(":coParentsPhoneNum", $data["coParentsPhoneNum"], PDO::PARAM_STR);

            $stmt->execute();

            $pdo->commit();
            return "success";

        }catch (PDOException $e){

            $pdo->rollBack();
            return $e->getMessage();
        }
    }
}