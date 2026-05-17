<?php
class ControllerAddProperty{
	static public function ctrAddProperty($data){
	   	$answer = (new ModelAddProperty)->mdlAddProperty($data);
		return $answer;
	}

	
}