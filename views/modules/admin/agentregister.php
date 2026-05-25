
<?php
/* $base_dir = views/ ;  */ 
$static_url = '/habitrack/views/Adminassets';
/* $route = 'add-property';
require_once __DIR__ . '/../../controllers/add-property.controller.php'; */



/*  ob_start();
$navlink_content = ob_get_clean();

ob_start() */; 
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="
        left:300px;
        bottom:0;
        z-index:20;
    "
    >

    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="grid grid-cols-1">
                <div class="profile-banner relative text-transparent rounded-md shadow dark:shadow-gray-700 overflow-hidden">
                    <input id="pro-banner" name="profile-banner" type="file" class="hidden" onchange="loadFile(event)">
                    <div class="relative shrink-0">
                        <img src="<?php echo $static_url; ?>/images/bg.jpg" class="h-80 w-full object-cover" id="profile-banner" alt="">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <label class="absolute inset-0 cursor-pointer" for="pro-banner"></label>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-12 grid-cols-1 gap-6 mt-6">
                <div class="xl:col-span-3 lg:col-span-4 md:col-span-4">
                    <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                        <div class="profile-pic text-center">
                            <div>
                                <!-- IMAGE UPLOADER (REPLACED ONLY THIS PART) -->
                            <div class="space-y-3">

                                <!-- PREVIEW AREA -->
                                <div id="preview" class="flex flex-wrap gap-2"></div>

                                <!-- UPLOAD BOX -->
                                <div class="border border-dashed border-gray-300 dark:border-slate-700 rounded-md p-4 text-center">

                                    <p class="text-sm text-slate-500">
                                        Upload profile / property images
                                    </p>

                                    <input id="agentPhoto"
                                        name="agentPic"
                                        type="file"
                                        class="hidden"
                                        accept="image/*"
                                        onchange="previewAgentPhoto(this)">

                                    <!--  <label for="pro-img"
                                        class="btn bg-green-600 hover:bg-green-700 text-white rounded-md mt-3 cursor-pointer  block text-center">
                                        Upload Images
                                    </label> -->
                                    <label class="btn-upload btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-6 cursor-pointer" for="agentPhoto">Upload Image</label>

                                </div>

                            </div>

                                <!-- <div class="mt-4">
                                    <h5 class="text-lg font-semibold">Calvin Carlo</h5>
                                    <p class="text-slate-400">calvin@hotmail.com</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div id="imageModal"
                    class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-70 z-[9999] p-6">

                    <div class="relative bg-white p-2 rounded-lg shadow-lg max-w-2xl w-full">
                        <button id="closeModal"
                            type="button"
                            class="absolute -top-3 -right-3 bg-red-500 hover:bg-green-500 text-white w-8 h-8 rounded-full flex items-center justify-center">
                            X
                        </button>

                        <img id="modalImg"
                            class="w-full max-h-[70vh] object-contain rounded-md"
                            alt="Agent preview">
                    </div>

                </div>

                <div class="xl:col-span-9 lg:col-span-8 md:col-span-8">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                            <h5 class="text-lg font-semibold mb-4">Agent Personal Details :</h5>
                            <form>
                                
                                <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
                                    <div class>
                                        <label class="form-label font-medium">First Name : <span class="text-red-600">*</span></label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="user" class="size-4 absolute top-3 start-4"></i>
                                            <input type="text" id="agentFName" name="agentFName" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="First Name:" id="firstname" name="name" required="">
                                        </div>
                                    </div>
                                    <!--  <div class="grid lg:grid-cols-2 grid-cols-1 gap-5"> -->
                                    <div>
                                        <label class="form-label font-medium">Middle Name : <span class="text-red-600">*</span></label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="user" class="size-4 absolute top-3 start-4"></i>
                                            <input type="text" id="agentMName" name="agentMName" class="form-input ps-12 w-full py-2 px-3 h-10 bg-white dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Middle Name:" id="middlename" name="name" required="">
                                        </div>
                                    </div>
                              
                              
                                    <div>
                                        <label class="form-label font-medium">Last Name : <span class="text-red-600">*</span></label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="user-check" class="size-4 absolute top-3 start-4"></i>
                                            <input type="text" id="agentLName" name="agentLName" class="form-input ps-11 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Last Name:" id="lastname" name="name" required="">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="form-label font-medium">Suffix : </label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="user-check" class="size-4 absolute top-3 start-4"></i>
                                            <input type="text" id="agentSuffix" name="agentSuffix" class="form-input ps-11 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Suffix:" id="suffixname" name="name">
                                        </div>
                                    </div>
                                        <!-- Gender + Birthdate (single grid cell) -->
                                        <div class="grid grid-cols-2 gap-5">

                                            <!-- Gender -->
                                            <div>
                                                <label class="form-label font-medium">Gender : <span class="text-red-600">*</span></label>
                                                <select id="agentGender" name="agentGender" class="form-input w-full mt-2 bg-white dark:bg-slate-800 text-gray-800 white:text-gray-200 border-gray-300 dark:border-slate-700">
                                                    <option value="">Select Gender</option>
                                                    <option>Male</option>
                                                    <option>Female</option>
                                                </select>
                                            </div>

                                            <!-- Birthdate -->
                                            <div>
                                                <label class="form-label font-medium">Birthdate : <span class="text-red-600">*</span></label>
                                                <input type="date" id="agentBirthdate" name="agentBirthdate"
                                                    class="form-input w-full mt-2 bg-transparent dark:bg-slate-900 text-gray-800 white:text-gray-200 border border-gray-200 dark:border-slate-700 rounded">
                                            </div>

                                        </div>

                                   
                                    
                                   <!--  <div>
                                        <label class="form-label font-medium">Agent Current Position : <span class="text-red-600">*</span></label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="mail" class="size-4 absolute top-3 start-4"></i>
                                            <input type="email" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Email" name="email" required="">
                                        </div>
                                    </div> -->
                    
                                    <div>
                                        <label class="form-label font-medium">Sold Units : </label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="bookmark" class="size-4 absolute top-3 start-4"></i>
                                            <input name="agentSoldUnits" id="agentSoldUnits" type="text" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Sold Units :">
                                        </div>
                                    </div>
                                    <!-- <div>
                                        <label class="form-label font-medium">Agent Level: </label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="bookmark" class="size-4 absolute top-3 start-4"></i>
                                            <input name="name" id="occupation" type="text" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Level :">
                                        </div>
                                    </div> -->
                                </div><!--end grid-->

                                <div class="grid grid-cols-1">
                                    <div class="mt-5">
                                        <label class="form-label font-medium">Address: </label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="message-circle" class="size-4 absolute top-3 start-4"></i>
                                            <textarea name="agentAddress" id="agentAddress" class="form-input ps-11 w-full py-2 px-3 h-28 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Address :"></textarea>
                                        </div>
                                    </div>
                                </div><!--end row-->

                                <!-- <input type="submit" id="submit" name="send" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5" value="Save Changes"> -->
                            </form><!--end form-->
                        </div>

                        <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                            <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
                                <div>
                                    <h5 class="text-lg font-semibold mb-4">Contact Info :</h5>

                                    <form>
                                        <div class="grid grid-cols-1 gap-5">
                                            <div>
                                                <label class="form-label font-medium">Agent Phone No. :</label>
                                                <div class="form-icon relative mt-2">
                                                    <i data-feather="phone" class="size-4 absolute top-3 start-4"></i>
                                                    <input name="agentPhoneNum" id="agentPhoneNum" type="number" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Phone :">
                                                </div>
                                            </div>

                                            <div>
                                                <label class="form-label font-medium">Agent Email :</label>
                                                <div class="form-icon relative mt-2">
                                                    <i data-feather="globe" class="size-4 absolute top-3 start-4"></i>
                                                    <input name="agentEmail" id="agentEmail" type="url" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Email :">
                                                </div>
                                            </div>

                                            <div>
                                        <label class="form-label font-medium">Agent Facebook Account : </label>
                                        <div class="form-icon relative mt-2">
                                            <i data-feather="bookmark" class="size-4 absolute top-3 start-4"></i>
                                            <input name="agentFB" id="agentFB" type="text" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 white:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="FB Name :">
                                        </div>
                                    </div>


                                        </div><!--end grid-->

                                        <button type="submit" id="btn-register" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5">Register Agent</button>
                                    </form>
                                </div><!--end col-->
                                
                                <!-- <div> 
                                    <h5 class="text-lg font-semibold mb-4">Change password :</h5>
                                    <form>
                                        <div class="grid grid-cols-1 gap-5">
                                            <div>
                                                <label class="form-label font-medium">Old password :</label>
                                                <div class="form-icon relative mt-2">
                                                    <i data-feather="key" class="size-4 absolute top-3 start-4"></i>
                                                    <input type="password" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Old password" required="">
                                                </div>
                                            </div>
    
                                            <div>
                                                <label class="form-label font-medium">New password :</label>
                                                <div class="form-icon relative mt-2">
                                                    <i data-feather="key" class="size-4 absolute top-3 start-4"></i>
                                                    <input type="password" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="New password" required="">
                                                </div>
                                            </div>
    
                                            <div>
                                                <label class="form-label font-medium">Re-type New password :</label>
                                                <div class="form-icon relative mt-2">
                                                    <i data-feather="key" class="size-4 absolute top-3 start-4"></i>
                                                    <input type="password" class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0" placeholder="Re-type New password" required="">
                                                </div>
                                            </div>
                                        </div>
    
                                        <button class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5">Save password</button>
                                    </form>
                                </div>
                            </div> -->
                        </div>

                       <!--  <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                            <h5 class="text-lg font-semibold mb-4 text-red-600">Delete Account :</h5>

                            <p class="text-slate-400 mb-4">Do you want to delete the account? Please press below "Delete" button</p>

                            <a href="" class="btn bg-red-600 hover:bg-red-700 border-red-600 hover:border-red-700 text-white rounded-md">Delete</a>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- End Content -->
        </div>
    </div><!--end container-->


