<?php
$static_url = '/habitrack/views/Adminassets';
?>

<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px; bottom:0; z-index:20;"
>

    <div class="container-fluid relative px-3">

        <div class="layout-specing">

            <!-- PROFILE HEADER -->
            <div class="grid grid-cols-1">

                <div class="profile-banner relative rounded-md overflow-hidden shadow">

                    <img
                        src="<?= $static_url ?>/images/bg.jpg"
                        class="h-80 w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-black/70"></div>
                </div>
            </div>

            <div class="grid md:grid-cols-12 gap-6 mt-6">

                <!-- LEFT SIDE -->
                <div class="xl:col-span-3 lg:col-span-4 md:col-span-4">

                    <div class="p-6 bg-white dark:bg-slate-900 rounded-md shadow text-center">

                        <input type="hidden" id="clientID">

                        <img
                            id="clientProfilePic"
                            src="<?= $static_url ?>/images/client/07.jpg"
                            class="rounded-full w-24 h-24 mx-auto object-cover ring-4"
                        >

                        <div class="mt-4">
                            <h5 id="clientFullName" class="text-lg font-semibold"></h5>
                            
                        </div>

                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="xl:col-span-9 lg:col-span-8 md:col-span-8">

                    <!-- PERSONAL DETAILS -->
                    <div class="p-6 bg-white dark:bg-slate-900 rounded-md shadow">

                        <h5 class="text-lg font-semibold mb-4">
                            Client Personal Details
                        </h5>

                        <div class="grid lg:grid-cols-2 gap-5">

                            <div>
                                <label class="form-label">First Name</label>
                                <input id="clientFName" class="form-input" placeholder="First Name" disabled>
                            </div>

                            <div>
                                <label class="form-label">Middle Name</label>
                                <input id="clientMName" class="form-input" placeholder="Middle Name" disabled>
                            </div>

                            <div>
                                <label class="form-label">Last Name</label>
                                <input id="clientLName" class="form-input" placeholder="Last Name" disabled>
                            </div>

                            <div>
                                <label class="form-label">Suffix</label>
                                <input id="clientSuffix" class="form-input" placeholder="Suffix" disabled>
                            </div>

                            <!-- NO DROPDOWN -->
                            <div>
                                <label class="form-label">Gender</label>
                                <input id="clientGender" class="form-input" placeholder="Gender" disabled>
                            </div>

                            <div>
                                <label class="form-label">Birthdate</label>
                                <input type="text" id="clientBirthdate" class="form-input" disabled>
                            </div>

                        </div>

                        <div class="mt-5">
                            <label class="form-label">Address</label>
                            <textarea
                                id="clientAddress"
                                class="form-input w-full h-28"
                                placeholder="Address"
                            disabled></textarea>
                        </div>

                    </div>

                    <!-- CONTACT INFO -->
                    <div class="p-6 mt-6 bg-white dark:bg-slate-900 rounded-md shadow">

                        <h5 class="text-lg font-semibold mb-4">
                            Contact Info
                        </h5>

                        <div class="grid gap-5">

                            <div>
                                <label class="form-label">Phone Number</label>
                                <input id="clientPhoneNum" class="form-input" placeholder="Phone" disabled>
                            </div>

                            <div>
                                <label class="form-label">Email</label>
                                <input id="clientEmail" class="form-input" placeholder="Email" disabled>
                            </div>

                        </div>

                        <button
                            id="btn-register"
                            class="btn bg-green-600 text-white mt-5"
                        >
                            Client Profile
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>