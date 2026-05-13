<?php


$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets';


?>

        
        <section class="md:h-screen py-36 flex items-center relative overflow-hidden zoom-image">
            <div class="absolute inset-0 image-wrap z-1 bg-[url('<?php echo $static_url; ?>/images/01.jpg')] bg-no-repeat bg-center bg-cover"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
            <div class="container relative z-3">
                <div class="flex justify-center">


                    <div class="max-w-[1000px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                        <a href="home.php"><img src="<?php echo $static_url; ?>/images/logo-icon-64.png" class="mx-auto" alt=""></a>
                        <h5 class="my-6 text-xl font-semibold">CLIENT SIGN-UP</h5>
                        

                        <input type="hidden" name="clientID" id="clientID">
                            
                        <form class="text-start" method="POST">
                            <div class="grid grid-cols-4 gap-4">

                                <div class="mb-4">
                                    <label class="font-medium">First Name:</label>
                                    <input name="firstname" id="firstname" type="text" class="form-input mt-3" placeholder="Enter First Name">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Middle Name:</label>
                                    <input name="middlename" id="middlename" type="text" class="form-input mt-3" placeholder="Enter Middle Name">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Last Name:</label>
                                    <input name="lastname" id="lastname" type="text" class="form-input mt-3" placeholder="Enter Last Name">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Suffix:</label>
                                    <input name="suffix" id="suffix" type="text" class="form-input mt-3" placeholder="Enter Suffix">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Email:</label>
                                    <input name="email" id="email" type="text" class="form-input mt-3" placeholder="Enter Email">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Phone Number:</label>
                                    <input name="phonenumber" id="phonenumber" type="text" class="form-input mt-3" placeholder="Enter Phone Number">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium">Password:</label>
                                    <input name="password" id="password" type="password" class="form-input mt-3" placeholder="Password">
                                </div>

                                

                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex justify-center">
                                    <button type="button" name="btn-signup" id="btn-signup"
                                    class="btn bg-green-600 hover:bg-green-700 text-white rounded-md px-6 py-2">
                                        Sign Up
                                    </button>
                                </div>
                            </div>
                        </form>
                                
                            </div>
                       <!--  </form> -->
                    </div>
                </div>
            </div>
        </section><!--end section -->

