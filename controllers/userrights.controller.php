<?php
class ControllerUserRights{
	static public function ctrUserLogin(){
		if (isset($_POST["loginUser"])) {
				$encryptpass = $_POST["loginPass"];
				$table = 'userrights';
				$item = 'username';
				$value = $_POST["loginUser"];
				$answer = (new ModelUserRights)->mdlGetUserCredentials($table, $item, $value);

				if(!empty($answer) && $answer["username"] == $_POST["loginUser"] && $answer["upassword"] == $encryptpass){
					$_SESSION["loggedIn"] = "ok";
					$_SESSION["id"] = $answer["id"];
					
					//$_SESSION["empid"] = $answer["empid"];
					$_SESSION["userid"] = $answer["userid"];
					
					//$empid = $_SESSION["empid"];
					$answer = (new ModelUserRights)->mdlAddLogin($empid);
				    if ($answer == 'ok') {
                        echo '<script>
									window.location = "sidebar.php";
								</script>'; //changed to v 51326
						/* echo ' 
						<script>
						Swal.fire({
							title: "Login Successful!",
							icon: "success",
							confirmButtonText: "Continue"
						}).then(() => {
							window.location = "sidebar.php";
						});
						</script> 
						'; added 51326*/
				   /*  }
				}else{ */
					/* echo '<br><div style="text-align:center;" class="alert alert-danger">User or password incorrect</div>'; changed to v 51326 */
					/* echo '
					<script>
					document.addEventListener("DOMContentLoaded", function() {
						Swal.fire({
							title: "Login Failed",
							text: "User or password incorrect",
							icon: "error",
							confirmButtonText: "Try Again"
						});
					});
					</script> 
					';added 51326 */
				}
			}
			
		}
	}


}