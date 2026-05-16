<?php
$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets'; // Ensure this is the correct path

// Define the content for the navlink block
ob_start();
?>
<?php
$navlink_content = ob_get_clean(); // Capture the navlink content
ob_start();

//session_start();


require_once __DIR__ . "/../../models/connection.php"; 
require_once __DIR__ . "/../../models/admin.model.php"; //added 51626
require_once __DIR__ . "/../../controllers/admin.controller.php"; //added 51626

?>

        
        <section class="md:h-screen py-36 flex items-center relative overflow-hidden zoom-image">
            <div class="absolute inset-0 image-wrap z-1 bg-[url('<?php echo $static_url; ?>/images/01.jpg')] bg-no-repeat bg-center bg-cover"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
            <div class="container relative z-3">
                <div class="flex justify-center">
                    <div class="max-w-[400px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                        <a href="home.php"><img src="<?php echo $static_url; ?>/images/logo-icon-64.png" class="mx-auto" alt=""></a>
                        <h5 class="my-6 text-xl font-semibold">Login</h5>
          
                            
<form class="text-start" method="POST">
    <div class="grid grid-cols-1">

        <div class="mb-4">
            <label class="font-medium">Email:</label>
            <input name="adminLoginEmail" id="adminLoginEmail" type="text" class="form-input mt-3" placeholder="Enter Email">
        </div>

        <div class="mb-4">
            <label class="font-medium">Password:</label>
            <input name="adminLoginPass" id="adminLoginPass" type="password" class="form-input mt-3" placeholder="Enter Password">
        </div>

        <div class="mb-4">
            <!-- <button type="submit" name="login" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                Login / Sign in
            </button> changed this ^ to this v 51626 -->
            <button type="button" id="btn-admin-login"
            class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">
                Login
            </button>
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