<?php

class Connection{
	public function connect(){
		$link = new PDO("mysql:host=localhost;dbname=habitrack", "root", "yourpassword");

		$link -> exec("set names utf8");
		return $link;
	}
}