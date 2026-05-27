<?php
$static_url = '/habitrack/views/Adminassets';
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

            <!-- HEADER -->
            <div class="grid grid-cols-1">

                <div class="profile-banner relative text-transparent rounded-md shadow dark:shadow-gray-700 overflow-hidden">

                    <img
                        src="<?php echo $static_url; ?>/images/bg.jpg"
                        class="h-80 w-full object-cover"
                        alt=""
                    >

                    <div class="absolute inset-0 bg-black/70"></div>

                </div>

            </div>

            <!-- MAIN CONTENT -->
            <div class="grid md:grid-cols-12 grid-cols-1 gap-6 mt-6 items-start justify-center">

                <!-- LEFT SIDE -->
                <div class="xl:col-span-3 lg:col-span-4 md:col-span-4 flex justify-center">

                    <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 w-full">

                        <div class="profile-pic text-center">

                            <input
                                id="pro-img"
                                name="profile-image"
                                type="file"
                                class="hidden"
                            />

                            <div>

                                <div class="relative size-24 mx-auto">

                                    <img
                                        src="<?php echo $static_url; ?>/images/client/07.jpg"
                                        class="rounded-full shadow dark:shadow-gray-700 ring-4 ring-slate-50 dark:ring-slate-800"
                                        id="profile-image"
                                        alt=""
                                    >

                                    <label
                                        class="absolute inset-0 cursor-pointer size-24 rounded-full"
                                        for="pro-img"
                                    ></label>

                                </div>

                                <div class="mt-4">

                                    <h5 class="text-lg font-semibold">
                                        Calvin Carlo
                                    </h5>

                                    <p class="text-slate-400">
                                        calvin@hotmail.com
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="xl:col-span-7 lg:col-span-7 md:col-span-7 mx-auto">

                    <div class="grid grid-cols-1 gap-6">

                        <!-- CHANGE PASSWORD -->
                        <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">

                            <h5 class="text-lg font-semibold mb-4">
                                Change Password :
                            </h5>

                            <form>

                                <div class="grid grid-cols-1 gap-5">

                                    <!-- OLD PASSWORD -->
                                    <div>

                                        <label class="form-label font-medium">
                                            Old Password :
                                        </label>

                                        <div class="form-icon relative mt-2">

                                            <i
                                                data-feather="key"
                                                class="size-4 absolute top-3 start-4"
                                            ></i>

                                            <input
                                                type="password"
                                                id="oldpassword"
                                                class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                                placeholder="Old password"
                                            >

                                            
                                        </div>

                                    </div>

                                    <!-- NEW PASSWORD -->
                                    <div>

                                        <label class="form-label font-medium">
                                            New Password :
                                        </label>

                                        <div class="form-icon relative mt-2">

                                            <i
                                                data-feather="key"
                                                class="size-4 absolute top-3 start-4"
                                            ></i>

                                            <input
                                                type="password"
                                                id="newpassword"
                                                class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                                placeholder="New password"
                                            >

                                        </div>


                                    </div>

                                    <!-- RETYPE PASSWORD -->
                                    <div>

                                        <label class="form-label font-medium">
                                            Re-type New Password :
                                        </label>

                                        <div class="form-icon relative mt-2">

                                            <i
                                                data-feather="key"
                                                class="size-4 absolute top-3 start-4"
                                            ></i>

                                            <input
                                                type="password"
                                                id="retypepassword"
                                                class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                                placeholder="Re-type New password"
                                            >

                                        </div>

                                    </div>

                                </div>

                                <button
                                    type="button"
                                    id="btn-change-password"    
                                    class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5"
                                >
                                    Save Password
                                </button>

                            </form>

                        </div>

                        <!-- DELETE ACCOUNT -->
                        <div class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">

                            <h5 class="text-lg font-semibold mb-4 text-red-600">
                                Delete Account :
                            </h5>

                            <p class="text-slate-400 mb-4">
                                Do you want to delete the account? Please press below "Delete" button
                            </p>

                            <a
                                href=""
                                class="btn bg-red-600 hover:bg-red-700 border-red-600 hover:border-red-700 text-white rounded-md"
                            >
                                Delete
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>