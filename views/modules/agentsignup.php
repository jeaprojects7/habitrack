<?php


$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets';


?>

        
<!-- <section class="md:h-screen py-36 flex items-center relative overflow-hidden zoom-image"> changed to v 51326-->
<section class="min-h-screen py-36 flex items-center relative overflow-y-auto zoom-image"> <!-- added 51326 -->
    <div class="absolute inset-0 z-1 bg-[#0a192f]"></div> <!-- changed this line 51326 --> <!-- another option bg-slate-950 -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
    <div class="container relative z-3">
        <div class="flex justify-center">


            <div class="max-w-[1000px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md">
                <a href="home.php"><img src="<?php echo $static_url; ?>/images/logo-icon-64.png" class="mx-auto" alt=""></a>
                <h5 class="my-6 text-xl font-semibold">AGENT SIGN-UP</h5>
                

                <input type="hidden" name="agentID" id="agentID">
                    
                <form class="text-start" method="POST">
                    <!-- <div class="grid grid-cols-4 gap-4"> changed this to v 51326-->
                    <div class="grid grid-cols-12 gap-4"> <!-- added 51326 -->
                        <div class="col-span-3">
                            <label class="font-medium">First Name:</label>
                            <input name="firstname" id="firstname" type="text" class="form-input mt-3" placeholder="Enter First Name">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Middle Name:</label>
                            <input name="middlename" id="middlename" type="text" class="form-input mt-3" placeholder="Enter Middle Name">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Last Name:</label>
                            <input name="lastname" id="lastname" type="text" class="form-input mt-3" placeholder="Enter Last Name">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Suffix:</label>
                            <input name="suffix" id="suffix" type="text" class="form-input mt-3" placeholder="Enter Suffix">
                        </div>
                                            
                        <div class="col-span-2">
                            <label class="font-medium">Gender:</label>
                            <input name="gender" id="gender" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-2">
                            <label class="font-medium">Birthdate:</label>
                            <input name="birthdate" id="birthdate" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Email:</label>
                            <input name="email" id="email" type="text" class="form-input mt-3" placeholder="Enter Email">
                        </div>

                        <div class="col-span-2">
                            <label class="font-medium">Phone Number:</label>
                            <input name="phonenumber" id="phonenumber" type="text" class="form-input mt-3" placeholder="">
                        </div>
                    
                        <div class="col-span-3">
                            <label class="font-medium">Facebook:</label>
                            <input name="fb" id="fb" type="text" class="form-input mt-3" placeholder="">
                        </div>
    
                        
                         <div class="col-span-6">
                            <label class="font-medium">Address:</label>
                            <input name="address" id="address" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        




                        <div class="col-span-2">
                            <label class="font-medium">2x2 Picture:</label>
                            <input name="picture" id="picture" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-2">
                            <label class="font-medium">Valid ID (1):</label>
                            <input name="firstID" id="firstID" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-2">
                            <label class="font-medium">Valid ID (2):</label>
                            <input name="secondID" id="secondID" type="text" class="form-input mt-3" placeholder="">
                        </div>





                        <div class="col-span-4">
                            <label class="font-medium">Current Employment:</label>
                            <input name="curEmp" id="curEmp" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-4">
                            <label class="font-medium">Current Position:</label>
                            <input name="curPos" id="curPos" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-4">
                            <label class="font-medium">Previous Realty:</label>
                            <input name="prevRealty" id="prevRealty" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Level:</label>
                            <input name="level" id="level" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Tax Identification Number:</label>
                            <input name="tin" id="tin" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Institution:</label>
                            <input name="institution" id="institution" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-3">
                            <label class="font-medium">Degree:</label>
                            <input name="degree" id="degree" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-6">
                            <label class="font-medium">Picture of Civil Status:</label>
                            <input name="civilStatPic" id="civilStatPic" type="text" class="form-input mt-3" placeholder="">
                        </div>
                        
                        <div class="col-span-6">
                            <label class="font-medium">Picture of Diploma:</label>
                            <input name="diploma" id="diploma" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-6">
                            <label class="font-medium">Picture of National Bureau:</label>
                            <input name="nbiPic" id="nbiPic" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-6">
                            <label class="font-medium">Picture of Resume:</label>
                            <input name="resumePic" id="resumePic" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        <div class="col-span-6">
                            <label class="font-medium">Picture of Transcript of Records:</label>
                            <input name="torPic" id="torPic" type="text" class="form-input mt-3" placeholder="">
                        </div>

                        

                        <div class="col-span-6">
                            <label class="font-medium">Password:</label>
                            <input name="password" id="password" type="password" class="form-input mt-3" placeholder="Enter Password">
                        </div>

                        

                    </div>

                    <div class="grid grid-cols-1 gap-4 mt-4">
                        <div class="flex justify-center">
                            <button type="button" name="btn-signup-agent" id="btn-signup-agent"
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

