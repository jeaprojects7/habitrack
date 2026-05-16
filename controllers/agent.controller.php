<?php
class ControllerAgent{
	static public function ctrSaveAgent($data){
	   	$answer = (new ModelAgent)->mdlSaveAgent($data);
		return $answer;
	}

	static public function ctrAgentLogin(){
		if (isset($_POST["agentLoginEmail"])) {
				$encryptpass = $_POST["agentLoginPass"];
				$table = 'agent';
				$item = 'agentEmail';
				$value = $_POST["agentLoginEmail"];
				$answer = (new ModelAgent)->mdlGetAgentCredentials($table, $item, $value);

				if(!empty($answer) && $answer["agentEmail"] == $_POST["agentLoginEmail"] && $answer["agentPass"] == $encryptpass){
					$_SESSION["loggedIn"] = "ok";
					$_SESSION["id"] = $answer["id"];
					
					//$_SESSION["empid"] = $answer["empid"];
					$_SESSION["agentID"] = $answer["agentID"];
					
					$agentUser = $_SESSION["agentID"];  /* changed agentID to agentUser 51426 */
				
				    /* if ($answer == 'ok') {
                        echo '<script>
									window.location = "agentDashboard";
								</script>';
				    } changed this ^ to this v 51626*/
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