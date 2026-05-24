<?php
class ControllerClient{
	static public function ctrSaveClient($data){
	   	$answer = (new ModelClient)->mdlSaveClient($data);
		return $answer;
	}


	// static public function ctrClientLogin(){
	// 	if (isset($_POST["clientLoginEmail"])) {
	// 			$encryptpass = $_POST["clientLoginPass"];
	// 			$table = 'client';
	// 			$item = 'clientEmail';
	// 			$value = $_POST["clientLoginEmail"];
	// 			$answer = (new ModelClient)->mdlGetClientCredentials($table, $item, $value);

	// 			if(!empty($answer) && $answer["clientEmail"] == $_POST["clientLoginEmail"] && $answer["clientPass"] == $encryptpass){
	// 				$_SESSION["loggedIn"] = "ok";
	// 				$_SESSION["id"] = $answer["id"];
					
					//$_SESSION["empid"] = $answer["empid"];
					// $_SESSION["clientID"] = $answer["clientID"];
					
					// $clientUser = $_SESSION["clientID"]; /* changed clientID to clientUser 51426 */
				
				    /* if ($answer == 'ok') {
                        echo '<script>
									window.location = "home";
								</script>';
				    } changed this ^ to this v */
	// 				echo "success"; /* added 51626 */
    // 				exit(); /* added 51626 */
	// 			}else{
	// 				// echo '<br><div style="text-align:center;" class="alert alert-danger">User or password incorrect</div>';
	// 				//changed this ^ to this v
	// 				echo "error";
	// 				exit();
	// 			}
			
	// 	}
	// }

	/* added 52126 */
	static public function ctrClientLogin(){
		if (isset($_POST["clientLoginEmail"])) {
			$answer = (new ModelClient)->mdlGetClientLogin(
				$_POST["clientLoginEmail"],
				$_POST["clientLoginPass"]
			);

			if($answer){
				$_SESSION["loggedIn"] = "ok";
				$_SESSION["clientID"] = $answer["clientID"];
				echo "success";
				exit();
			} else {
				echo "error";
				exit();
			}
		}
	}

	static public function ctrGetClientInfo($tableUsers, $item, $value){
		$answer = (new ModelClient)->mdlGetClientInfo($tableUsers, $item, $value);
		return $answer;
	}

	static public function ctrSaveClientInfo($data){

		$answer = (new ModelClient)->mdlSaveClientInfo($data);

		return $answer;
	}

	static public function ctrGetSpouseInfo($tableUsers, $item, $value){
		$answer = (new ModelClient)->mdlGetSpouseInfo($tableUsers, $item, $value);
		return $answer;
	}

	static public function ctrSaveSpouseInfo($data){

		$answer = (new ModelClient)->mdlSaveSpouseInfo($data);

		return $answer;
	}

}