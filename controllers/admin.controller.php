<?php
class ControllerAdmin{
	static public function ctrSaveAdmin($data){
	   	$answer = (new ModelAdmin)->mdlSaveAdmin($data);
		return $answer;
	}

	static public function ctrAdminLogin(){
		if (isset($_POST["adminLoginEmail"])) {
				$encryptpass = $_POST["adminLoginPass"];
				$table = 'admin';
				$item = 'adminEmail';
				$value = $_POST["adminLoginEmail"];
				$answer = (new ModelAdmin)->mdlGetAdminCredentials($table, $item, $value);

				if(!empty($answer) && $answer["adminEmail"] == $_POST["adminLoginEmail"] && $answer["adminPass"] == $encryptpass){
					$_SESSION["loggedIn"] = "ok";
					$_SESSION["id"] = $answer["id"];
					
					//$_SESSION["empid"] = $answer["empid"];
					$_SESSION["adminID"] = $answer["adminID"];
					
					$adminUser = $_SESSION["adminID"]; /* changed adminID to adminUser 51426 */
				
				    /* if ($answer == 'ok') {
                        echo '<script>
									window.location = "adminDashboard";
								</script>';
				    } changed this ^ to this v */
					echo "success"; /* added 51626 */
    				exit(); /* added 51626 */
				}else{
					// echo '<br><div style="text-align:center;" class="alert alert-danger">User or password incorrect</div>';
					//changed this ^ to this v 51626
					echo "error";
					exit();
				}
			
		}
	}

}