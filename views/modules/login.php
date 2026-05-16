<?php
$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets'; // Ensure this is the correct path

// Define the content for the navlink block
ob_start();
?>
<?php
$navlink_content = ob_get_clean(); // Capture the navlink content
ob_start();

session_start();


/* require_once __DIR__ . "/../../controllers/login.controller.php";

ControllerLogin::ctrLogin(); */

//require_once __DIR__ . "/../../models/connection.php"; 
//require_once __DIR__ . "/../../models/clientsignup.model.php"; 

require_once __DIR__ . "/../../controllers/clientsignup.controller.php"; /* added 51426 */



//removed changed to line 23 51426 
// if(isset($_POST['login'])){

//     $username = $_POST['username'];
//     $password = $_POST['password'];
 
//     $userClient = ModelClient::mdlGetClientLogin($username, $password); /* changed user to userClient 51326 */

    
//     if($userClient){ /* changed $user to $userClient 51326*/

//         $_SESSION["clientID"] = $userClient["clientID"]; 
//         $_SESSION["clientEmail"] = $userClient["clientEmail"]; 

//         $_SESSION["loggedIn"] = "ok";
        
//         $clientUser = $_SESSION["clientID"]; /* added from sir 51426 */
        
        
//         exit();

//     }else{
//         echo "<script>alert('Invalid username or password');</script>";
//     }
// }
?>

        
        <section class="md:h-screen py-36 flex items-center relative overflow-hidden zoom-image">
            <div class="absolute inset-0 image-wrap z-1 bg-[url('<?php echo $static_url; ?>/images/01.jpg')] bg-no-repeat bg-center bg-cover"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
            <div class="container relative z-3">
                <div class="flex justify-center">
                    <div class="max-w-[400px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                        <a href="home.php"><img src="<?php echo $static_url; ?>/images/logo-icon-64.png" class="mx-auto" alt=""></a>
                        <h5 class="my-6 text-xl font-semibold">Login</h5>
                        <!-- <form class="text-start" method="POST">
                            <div class="grid grid-cols-1">
                                <div class="mb-4">
                                    <label class="font-medium" for="LoginEmail">Email Address:</label>
                                    <input id="LoginEmail" name="username" type="text" class="form-input mt-3" placeholder="name@example.com">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium" for="LoginPassword">Password:</label>
                                    <input id="LoginPassword" name="upassword" type="password" class="form-input mt-3" placeholder="Password:">
                                </div>

                                <div class="flex justify-between mb-4">
                                    <div class="flex items-center mb-0">
                                        <input class="form-checkbox rounded border-gray-200 dark:border-gray-800 text-green-600 focus:border-green-300 focus:ring focus:ring-offset-0 focus:ring-green-200 focus:ring-opacity-50 me-2" type="checkbox" value="" id="RememberMe">
                                        <label class="form-checkbox-label text-slate-400" for="RememberMe">Remember me</label>
                                    </div>
                                    <p class="text-slate-400 mb-0"><a href="auth-re-password.php" class="text-slate-400">Forgot password ?</a></p>
                                </div>

                                 <div class="mb-4">
                                <button type="submit" name="login" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                                    Login / Sign in
                                </button>
                            </div> -->
                            
<form class="text-start" method="POST">
    <div class="grid grid-cols-1">

        <div class="mb-4">
            <label class="font-medium">Username:</label>
            <input name="username" type="text" class="form-input mt-3" placeholder="Enter username">
        </div>

        <div class="mb-4">
            <label class="font-medium">Password:</label>
            <input name="password" type="password" class="form-input mt-3" placeholder="Password">
        </div>

        <div class="mb-4">
            <button type="submit" name="login" id = "login"class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                Login / Sign in
            </button>
            <?php
            
            $login = new ControllerClient();
            $login -> ctrClientLogin();
        
        //    if(isset($_SESSION["clientID"])){ /* chat 51426 */
        //         // client logged in
        //     }else if(isset($_SESSION["agentID"])){
        //         // agent logged in
        //     }else if(isset($_SESSION["adminID"])){
        //         // admin logged in
        //     }
            ?>
        </div>
        <div class="text-center">
                                    <span class="text-slate-400 me-2">Don't have an account ?</span> <a href="clientsignup" class="text-black dark:text-white font-bold">Sign Up</a>
                                </div>

    </div>
</form>
                                <!-- <div class="text-center">
                                    <span class="text-slate-400 me-2">Don't have an account ?</span> <a href="auth-signup.php" class="text-black dark:text-white font-bold">Sign Up</a>
                                </div> -->
                            </div>
                       <!--  </form> -->
                    </div>
                </div>
            </div>
        </section><!--end section -->

<?php
$hero_content = ob_get_clean(); // Capture the hero content

// Include the base template
include "$base_dir/../no-header.php";
?>