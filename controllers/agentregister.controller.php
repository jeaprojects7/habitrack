<?php
class ControllerAddAgent{
	static public function ctrAddAgent($data){
	   	$answer = (new ModelAddAgent)->mdlAddAgent($data);
		return $answer;
	}

	
}