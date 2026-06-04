<?php
require_once __DIR__ . "/../models/agentregister.model.php";
class ControllerAddAgent{
	static public function ctrGetAgents(){
	   	$answer = (new ModelAddAgent)->mdlGetAgents();
		return $answer;
	}

	static public function ctrAddAgent($data){
	   	$answer = (new ModelAddAgent)->mdlAddAgent($data);
		return $answer;
	}

/* 	     GET SINGLE AGENT (FOR EDIT)
    ==========================  */
    static public function ctrGetAgent($agentID){

        $answer = (new ModelAddAgent)->mdlGetAgent($agentID);
        return $answer;
    }

    /* =========================
       UPDATE AGENT
    ========================== */
    static public function ctrUpdateAgent($data){

        $answer = (new ModelAddAgent)->mdlUpdateAgent($data);
        return $answer;
    }

     public static function ctrGetAgentFiltered($filters){

    return (new ModelAddAgent)->mdlGetAgentFiltered($filters);
}


	
}
