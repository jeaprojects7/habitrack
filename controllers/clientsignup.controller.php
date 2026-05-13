<?php
class ControllerClient{
	static public function ctrSaveClient($data){
	   	$answer = (new ModelClient)->mdlSaveClient($data);
		return $answer;
	}

}