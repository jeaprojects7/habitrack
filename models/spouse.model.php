<?php

require_once "connection.php";

class ModelSpouse {
    static public function mdlGetSpouseInfo($prequalID){

        $stmt = (new Connection)->connect()->prepare("
            SELECT ccp.*, ci.clientCISID
            FROM clientcoprequal ccp
            INNER JOIN client_information ci
                ON ci.prequalID = ccp.prequalID
            LEFT JOIN spouse_information si
                ON si.clientCISID = ci.clientCISID
            WHERE ccp.prequalID = :prequalID
            AND ccp.coOwnerRelationship = 'Spouse'
            LIMIT 1
        ");

        $stmt->bindParam(":prequalID", $prequalID, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    static public function mdlGetSpouseIS($prequalID){
        $stmt = null;

        try {
            $stmt = (new Connection)->connect()->prepare("
                SELECT 
                    si.*
                FROM reservations r
                INNER JOIN client_information ci 
                    ON ci.prequalID = r.prequalID
                INNER JOIN spouse_information si 
                    ON si.clientCISID = ci.clientCISID
                WHERE r.prequalID = :prequalID
                LIMIT 1
            ");

            $stmt->bindParam(":prequalID", $prequalID, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return "error: " . $e->getMessage();
        } finally {
            $stmt = null;
        }
    }

    static public function mdlSaveSpouseInfo($data){

        $db = new Connection();
        $pdo = $db->connect();

        try{

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction();

            
            // Generate ID
            $sis_id = $pdo->prepare("
                SELECT CONCAT('SIS', LPAD((COUNT(id)+1),4,'0')) as gen_id 
                FROM spouse_information
            ");
            $sis_id->execute();
            $sisID = $sis_id->fetch(PDO::FETCH_ASSOC);
            $siscode = $sisID['gen_id'];

            // OPTIONAL: Manual check (extra safety)
            $check = $pdo->prepare("SELECT spouseISID FROM spouse_information WHERE spouseISID = :spouseISID");
            $check->bindParam(":spouseISID", $siscode, PDO::PARAM_STR);
            $check->execute();

            /*  */
            if($check->rowCount() > 0){
                $pdo->rollBack();
                return "existing";
            }/*  */
            
            /* for 1to1 v */
            $check = $pdo->prepare("
                SELECT 1 FROM spouse_information 
                WHERE clientCISID = :clientCISID
                LIMIT 1
            ");

            $check->bindParam(":clientCISID", $data["clientCISID"]);
            $check->execute();

            if ($check->rowCount() > 0) {
                return "exists";
            }
            /* for 1to1 ^ */

            $stmt = $pdo->prepare("
        INSERT INTO spouse_information(
            spouseISID,
            clientCISID,

            spouseFName,
            spouseMName,
            spouseLName,
            spouseSuffix,
            spouseEmail,
            spousePhoneNum,

            spouseCitizenship,
            spouseGender,
            spouseReligion,
            spouseBirthdate,
            spousePlaceOfBirth,

            spouseAddress,
            spouseProvinceAddress,

            spouseTaxIdenNum,
            spouseSSS_GSISnumber,

            spouseDependentsElem,
            spouseDependentsHS,
            spouseDependentsC,
            spouseDependentsNotStud,

            spouseMonthlyIncome,
            spouseSourceOfIncome,
            spouseEmployerBusinessName,
            spouseNatureOfBusiness,
            spouseBusinessAddress,

            spousePosition,
            spouseDepartment,
            spouseDateHired,
            spouseAppointment,
            spousePlaceOfWork,

            spouseEmpPhoneNum,
            spouseEmployerEmail,

            spouseFathersName,
            spouseMothersMaidenName,

            spouseParentsAddress,
            spouseParentsPhoneNum

        ) VALUES (
            :spouseISID,
            :clientCISID,

            :spouseFName,
            :spouseMName,
            :spouseLName,
            :spouseSuffix,
            :spouseEmail,
            :spousePhoneNum,

            :spouseCitizenship,
            :spouseGender,
            :spouseReligion,
            :spouseBirthdate,
            :spousePlaceOfBirth,

            :spouseAddress,
            :spouseProvinceAddress,

            :spouseTaxIdenNum,
            :spouseSSS_GSISnumber,

            :spouseDependentsElem,
            :spouseDependentsHS,
            :spouseDependentsC,
            :spouseDependentsNotStud,

            :spouseMonthlyIncome,
            :spouseSourceOfIncome,
            :spouseEmployerBusinessName,
            :spouseNatureOfBusiness,
            :spouseBusinessAddress,

            :spousePosition,
            :spouseDepartment,
            :spouseDateHired,
            :spouseAppointment,
            :spousePlaceOfWork,

            :spouseEmpPhoneNum,
            :spouseEmployerEmail,

            :spouseFathersName,
            :spouseMothersMaidenName,

            :spouseParentsAddress,
            :spouseParentsPhoneNum
        )
    ");

    $stmt->bindParam(':spouseISID',                $siscode,                        PDO::PARAM_STR);
    $stmt->bindParam(':clientCISID',               $data['clientCISID'],            PDO::PARAM_STR);

    $stmt->bindParam(':spouseFName',               $data['spouseFName'],            PDO::PARAM_STR);
    $stmt->bindParam(':spouseMName',               $data['spouseMName'],            PDO::PARAM_STR);
    $stmt->bindParam(':spouseLName',               $data['spouseLName'],            PDO::PARAM_STR);
    $stmt->bindParam(':spouseSuffix',              $data['spouseSuffix'],           PDO::PARAM_STR);
    $stmt->bindParam(':spouseEmail',               $data['spouseEmail'],            PDO::PARAM_STR);
    $stmt->bindParam(':spousePhoneNum',            $data['spousePhoneNum'],         PDO::PARAM_STR);

    $stmt->bindParam(':spouseCitizenship',         $data['spouseCitizenship'],      PDO::PARAM_STR);
    $stmt->bindParam(':spouseGender',              $data['spouseGender'],           PDO::PARAM_STR);
    $stmt->bindParam(':spouseReligion',            $data['spouseReligion'],         PDO::PARAM_STR);
    $stmt->bindParam(':spouseBirthdate',           $data['spouseBirthdate'],        PDO::PARAM_STR);
    $stmt->bindParam(':spousePlaceOfBirth',        $data['spousePlaceOfBirth'],     PDO::PARAM_STR);

    $stmt->bindParam(':spouseAddress',             $data['spouseAddress'],          PDO::PARAM_STR);
    $stmt->bindParam(':spouseProvinceAddress',     $data['spouseProvinceAddress'],  PDO::PARAM_STR);

    $stmt->bindParam(':spouseTaxIdenNum',          $data['spouseTaxIdenNum'],       PDO::PARAM_STR);
    $stmt->bindParam(':spouseSSS_GSISnumber',      $data['spouseSSS_GSISnumber'],   PDO::PARAM_STR);

    $stmt->bindParam(':spouseDependentsElem',      $data['spouseDependentsElem'],   PDO::PARAM_INT);
    $stmt->bindParam(':spouseDependentsHS',        $data['spouseDependentsHS'],     PDO::PARAM_INT);
    $stmt->bindParam(':spouseDependentsC',         $data['spouseDependentsC'],      PDO::PARAM_INT);
    $stmt->bindParam(':spouseDependentsNotStud',   $data['spouseDependentsNotStud'],PDO::PARAM_INT);

    $stmt->bindParam(':spouseMonthlyIncome',       $data['spouseMonthlyIncome'],    PDO::PARAM_STR);
    $stmt->bindParam(':spouseSourceOfIncome',      $data['spouseSourceOfIncome'],   PDO::PARAM_STR);
    $stmt->bindParam(':spouseEmployerBusinessName',$data['spouseEmployerBusinessName'], PDO::PARAM_STR);
    $stmt->bindParam(':spouseNatureOfBusiness',    $data['spouseNatureOfBusiness'], PDO::PARAM_STR);
    $stmt->bindParam(':spouseBusinessAddress',     $data['spouseBusinessAddress'],  PDO::PARAM_STR);

    $stmt->bindParam(':spousePosition',            $data['spousePosition'],         PDO::PARAM_STR);
    $stmt->bindParam(':spouseDepartment',          $data['spouseDepartment'],       PDO::PARAM_STR);
    $stmt->bindParam(':spouseDateHired',           $data['spouseDateHired'],        PDO::PARAM_STR);
    $stmt->bindParam(':spouseAppointment',         $data['spouseAppointment'],      PDO::PARAM_STR);
    $stmt->bindParam(':spousePlaceOfWork',         $data['spousePlaceOfWork'],      PDO::PARAM_STR);

    $stmt->bindParam(':spouseEmpPhoneNum',         $data['spouseEmpPhoneNum'],      PDO::PARAM_STR);
    $stmt->bindParam(':spouseEmployerEmail',       $data['spouseEmployerEmail'],    PDO::PARAM_STR);

    $stmt->bindParam(':spouseFathersName',         $data['spouseFathersName'],      PDO::PARAM_STR);
    $stmt->bindParam(':spouseMothersMaidenName',   $data['spouseMothersMaidenName'],PDO::PARAM_STR);

    $stmt->bindParam(':spouseParentsAddress',      $data['spouseParentsAddress'],   PDO::PARAM_STR);
    $stmt->bindParam(':spouseParentsPhoneNum',     $data['spouseParentsPhoneNum'],  PDO::PARAM_STR);

            $stmt->execute();

            $pdo->commit();
            return "success";

    
        }catch (PDOException $e){

            $pdo->rollBack();

            return $e->getMessage();
        }
    }
}