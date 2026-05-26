<?php
$reservationID = $_GET['id'] ?? null;
// $reservationID = $_GET['id'] ?? $_GET['reservationID'] ?? null; /* this works */
if (!$reservationID) {
    die("Invalid reservation ID");
}
// if (!$reservationID) {
//     die("No reservation selected");
// } this works
?>
<!-- <?php
// $reservationID = $_POST['reservationID'] ?? null;

// $reservationID = $_GET['reservationID'] ?? '';
// $reservationID = $_GET['id'] ?? null;
// $reservationID = $_GET['reservationID'] ?? null;
// $reservationID = $_GET['id'] ?? null;
?> -->


<div
    id="main-area"
    class="fixed top-[90px] right-0 mb-10 overflow-y-auto px-6 transition-all duration-300"
    style="left:300px; bottom:0; z-index:20;"
>
    <div class="layout-spacing">
        <!-- Header -->
        <div class="md:flex justify-between items-center">
            <h5 class="text-lg font-semibold text-gray-800 dark:text-white">Basic Information Sheet</h5>
            <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-blue-600 dark:hover:text-white"><a href="home">Habitrack</a></li>
                <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5"><i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block capitalize text-[16px] font-medium text-blue-600 dark:text-white" aria-current="page">Reservation Form</li>
            </ul>
        </div>

        <!-- Step Indicator -->
        <div class="flex items-center gap-2 mt-4">
        <!-- <div class="flex items-center justify-center gap-2 mt-4"> -->
            <div id="step-1-indicator" class="w-8 h-8 rounded-full bg-blue-600 text-white text-sm flex items-center justify-center font-medium transition-colors duration-300">1</div>
            <div class="h-1 w-10 bg-gray-200 dark:bg-slate-700 rounded"></div>
            <div id="step-2-indicator" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-white/30 text-sm flex items-center justify-center font-medium transition-colors duration-300">2</div>
            <div class="h-1 w-10 bg-gray-200 dark:bg-slate-700 rounded"></div>
            <div id="step-3-indicator" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-white/30 text-sm flex items-center justify-center font-medium transition-colors duration-300">3</div>
            <div class="h-1 w-10 bg-gray-200 dark:bg-slate-700 rounded"></div>
            <div id="step-4-indicator" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-white/30 text-sm flex items-center justify-center font-medium transition-colors duration-300">4</div>
            <div class="h-1 w-10 bg-gray-200 dark:bg-slate-700 rounded"></div>
            <div id="step-5-indicator" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-white/30 text-sm flex items-center justify-center font-medium transition-colors duration-300">5</div>
            <div class="h-1 w-10 bg-gray-200 dark:bg-slate-700 rounded"></div>
            <div id="step-6-indicator" class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-400 dark:text-white/30 text-sm flex items-center justify-center font-medium transition-colors duration-300">6</div>
        </div>

        <div class="grid grid-cols-1 mt-4">

            <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">

                <!-- ===== PAGE 1 ===== -->
                <div id="page-1">
                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Personal Information</h2>

                    <!-- Row 1: Name -->
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">First Name</label>
                            <input name="firstname" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" disabled> <!-- placeholder="Kairi" -->
                        </div>
                        <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Middle Name</label>
                            <input name="middlename" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" disabled> <!-- placeholder="Benson" -->
                        </div>
                        <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Last Name</label>
                            <input name="lastname" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" disabled> <!-- placeholder="McClain" -->
                        </div>
                        <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Suffix</label>
                            <input name="suffix" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" disabled> <!-- placeholder="Enter Suffix" -->
                        </div>
                    </div>

                    <!-- Row 2: Contact -->
                    <div class="grid grid-cols-12 gap-4">
                        <div class="mb-4 col-span-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Email</label>
                            <input name="email" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" disabled> <!-- placeholder="kaimcclain@gmail.com"  -->
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Phone Number</label>
                            <input name="phonenumber" type="text" class="form-input mt-3 cursor-not-allowed font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'')" disabled> <!--  placeholder="09876543211" -->
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Civil Status</label>
                            <div class="relative mt-3" id="civstat-wrapper">
                                <input type="hidden" name="civilstatus" id="civilstatus" required>
                                <div id="civstat-display" onclick="toggleCivilStatusDropdown()" 
                                class="form-input w-full font-normal text-gray-400 dark:text-white/30 cursor-pointer flex justify-between items-center select-none bg-white 
                                dark:bg-slate-800 border-gray-200 dark:border-slate-700">
                                    <span id="civstat-label">Select Civil Status</span>
                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30 transition-transform duration-200" id="civstat-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div id="civstat-options" class="hidden absolute z-50 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg mt-1 overflow-hidden">
                                    <div onclick="selectCivilStatus('single', 'Single')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Single</div>
                                    <div onclick="selectCivilStatus('married', 'Married')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Married</div>
                                    <div onclick="selectCivilStatus('widow', 'Widow')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Widow</div>
                                    <div onclick="selectCivilStatus('divorced', 'Divorced')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Divorced</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Gender</label>
                            <div class="relative mt-3" id="gender-wrapper">
                                <input type="hidden" name="gender" id="gender" required>
                                <div id="gender-display" onclick="toggleGenderDropdown()" 
                                class="form-input w-full font-normal text-gray-400 dark:text-white/30 cursor-pointer flex justify-between items-center select-none bg-white 
                                dark:bg-slate-800 border-gray-200 dark:border-slate-700">
                                    <span id="gender-label">Select Gender</span>
                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30 transition-transform duration-200" id="gender-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div id="gender-options" class="hidden absolute z-50 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg mt-1 overflow-hidden">
                                    <div onclick="selectGender('male', 'Male')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Male</div>
                                    <div onclick="selectGender('female', 'Female')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 
                                    dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Female</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Birthdate:</label>
                            <div class="relative mt-3">
                                <input name="birthdate" id="birthdate" type="text" readonly
                                    class="form-input w-full font-normal bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 dark:placeholder-white/30 cursor-pointer"
                                    placeholder="Select Birthdate">
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Birthdate</label>
                            <div class="relative mt-3">
                                <input id="birthdate" name="birthdate" type="text" class="form-input pr-10 font-normal bg-white 
                                dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 rounded-lg"
                                placeholder="Select Birthdate">

                                 Clear Button 
                                <button type="button" id="clearBirthdate" onclick="clearBirthdateField()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 
                                transition-colors duration-200 hidden">✕</button>
                            </div>
                        </div> chat-->


                    <!-- Row 3: Personal -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="mb-4 col-span-1">
                            <label class="font-medium text-gray-800 dark:text-white/70">Citizenship</label>
                            <input name="citizenship" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Japanese">
                        </div>
                        <div class="mb-4 col-span-1">
                            <label class="font-medium text-gray-800 dark:text-white/70">Religion</label>
                            <input name="religion" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Buddhism">
                        </div>
                        <!-- <div class="mb-4">
                            <label class="font-medium text-gray-800 dark:text-white/70">Birthdate</label>
                            <input name="birthdate" type="date" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Buddhism">
                        </div> -->
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Place of Birth</label>
                            <input name="placeofbirth" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Bacolod City">
                        </div>
                    </div>
                    
                    <!-- Next Button -->
                    <!-- <div class="flex justify-end mt-6">
                        <button onclick="goToPage(2)" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div> -->
                    
                    <!-- Next Button -->
                    <div class="flex justify-between items-center mt-6">
                    
                    <!-- ths works ang a -->
                        <!-- <a href="index.php?route=reservation-view&id=<?= $reservationID ?>"  -->
                         <a href="index.php?route=reservation-view&id=<?= urlencode($reservationID) ?>"
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to Reservation View
                        </a>
                        <button id= next-btn onclick="goToPage(2)" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- ===== PAGE 2 ===== -->
                <div id="page-2" class="hidden">
                    <!-- Home Address -->
                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Home Address</h2>
                    <div class="grid grid-cols-12 gap-4 mt-4">
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Unit No.</label>
                            <input name="unitno" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Block 10 Lot 1">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Street</label>
                            <input name="street" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Mulberry Street">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Subdivision</label>
                            <input name="subdivision" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="City Heights">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Barangay</label>
                            <input name="barangay" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Barangay Taculing">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">City / Municipality</label>
                            <input name="city" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Bacolod City">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Province</label>
                            <input name="province" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Negros Occidental">
                        </div>
                    </div>

                    <!-- Provincial Address -->
                    <h2 class="text-gray-800 dark:text-white font-bold text-lg mt-4">Provincial Address</h2>
                    <div class="grid grid-cols-12 gap-4 mt-4">
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Unit No.</label>
                            <input name="prov_unitno" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Block 5 Lot 4">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Street</label>
                            <input name="prov_street" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Galo-Mabini Street">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Subdivision</label>
                            <input name="prov_subdivision" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Lucia Street">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Barangay</label>
                            <input name="prov_barangay" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Barangay 19">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">City / Municipality</label>
                            <input name="prov_city" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Bacolod City">
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Province</label>
                            <input name="prov_province" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Negros Occidental">
                        </div>
                        
                    </div>
                    <!-- Same as Home Address Checkbox -->
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            id="sameAddress"
                            onchange="copyHomeAddress(this)"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <span class="text-sm font-medium text-gray-700 dark:text-white/70">
                            Same as Home Address
                        </span>
                    </label>

                    <div class="flex justify-between items-center mt-6">
    
                        <!-- Back Button -->
                        <button onclick="goToPage(1)" 
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </button>

                        <!-- Next Button -->
                        <button onclick="goToPage(3)" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                    </div>

                </div>

               <div id="page-3" class="hidden">

                    <!-- Two Column Section -->
                    <div class="grid grid-cols-2 gap-8">

                        <!-- LEFT SIDE -->
                        <div>
                            <h2 class="text-gray-800 dark:text-white font-bold text-lg">
                                Govt
                            </h2>

                            <div class="grid grid-cols-2 gap-4 mt-4">

                                <div class="mb-4">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        Tax Identification Number
                                    </label>

                                    <input name="tin" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30" placeholder="TIN Number">
                                </div>

                                <div class="mb-4">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        SSS / GSIS Number
                                    </label>

                                    <input name="sss_gsis" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30"placeholder="SSS / GSIS Number">
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT SIDE -->
                        <div>
                            <h2 class="text-gray-800 dark:text-white font-bold text-lg">
                                Total Number of Dependents
                            </h2>

                            <div class="grid grid-cols-8 gap-4 mt-4">

                                <div class="mb-4 col-span-2">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        In Elementary
                                    </label>

                                    <input name="elem" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="0">
                                </div>

                                <div class="mb-4 col-span-2">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        In Highschool
                                    </label>

                                    <input name="highschool" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="0">
                                </div>

                                <div class="mb-4 col-span-2">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        In College
                                    </label>

                                    <input name="college" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="0">
                                </div>

                                <div class="mb-4 col-span-2">
                                    <label class="font-medium text-gray-800 dark:text-white/70">
                                        Not yet studying
                                    </label>

                                    <input name="notstudying" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 
                                    placeholder-gray-400 dark:placeholder-white/30" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    


                    <div class="flex justify-between items-center mt-6">
    
                        <!-- Back Button -->
                        <button onclick="goToPage(2)" 
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </button>

                        <!-- Next Button -->
                        <button onclick="goToPage(4)" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                    </div>

                </div>



                <div id="page-4" class="hidden">
                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Employment</h2>
                    <div class="grid grid-cols-8 gap-4 mt-4">

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Gross Monthly Income</label>
                            <input name="gmi" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" 
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" placeholder="20000">
                        </div>

                        <!-- <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Source of Income</label>
                            <input name="sourceofincome" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="a">
                        </div> -->

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Source of Income</label>
                            <div class="relative mt-3" id="sourceofincome-wrapper">
                                <input type="hidden" name="sourceofincome" id="sourceofincome" required>
                                <div id="sourceofincome-display" onclick="toggleSourceOfIncomeDropdown()"
                                    class="form-input w-full font-normal text-gray-400 dark:text-white/30 cursor-pointer flex justify-between items-center select-none bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700">
                                    <span id="sourceofincome-label">Select Source of Income</span>
                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30 transition-transform duration-200" id="sourceofincome-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div id="sourceofincome-options" class="hidden absolute z-50 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg mt-1 overflow-hidden">
                                    <div onclick="selectSourceOfIncome('employed', 'Employed')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Employed</div>
                                    <div onclick="selectSourceOfIncome('professional', 'Professional')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Professional</div>
                                    <div onclick="selectSourceOfIncome('selfemployed', 'Self-Employed')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Self-Employed</div>
                                    <div onclick="selectSourceOfIncome('soleproprietorship', 'Sole Proprietorship')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Sole Proprietorship</div>
                                    <div onclick="selectSourceOfIncome('partnershipcorporation', 'Partnership Corporation')" class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">Partnership Corporation</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Employer / Business Name</label>
                            <input name="empbusinessname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Manolo Javier">
                        </div>
                       
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Nature of Business</label>
                            <input name="natureofbusiness" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Manufacturing">
                        </div>
                    </div>
                       

                    <div class="grid grid-cols-12 gap-4 mt-4">
                        <div class="mb-4 col-span-6">
                            <label class="font-medium text-gray-800 dark:text-white/70">Business Address</label>
                            <input name="businessaddress" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="L'Fisher Building, Lacson Street, Bacolod City">
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Appointment </label>
                            <div class="relative mt-3" id="appointment-wrapper">
                                <input type="hidden" name="appointment" id="appointment" required>
                                <div id="appointment-display"
                                    onclick="toggleAppointmentDropdown()"
                                    class="form-input w-full font-normal text-gray-400 dark:text-white/30 cursor-pointer flex justify-between items-center select-none bg-white 
                                    dark:bg-slate-800 border-gray-200 dark:border-slate-700">

                                    <span id="appointment-label">Select Appointment</span>

                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30 transition-transform duration-200"
                                        id="appointment-arrow"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>

                                <div id="appointment-options"
                                class="hidden absolute z-50 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg mt-1 max-h-48 overflow-y-auto">
                                    <div onclick="selectAppointment('regular', 'Regular')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Regular
                                    </div>

                                    <div onclick="selectAppointment('probationary', 'Probationary')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Probationary
                                    </div>

                                    <div onclick="selectAppointment('contractual', 'Contractual')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Contractual
                                    </div>

                                    <div onclick="selectAppointment('ofw', 'OFW')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        OFW
                                    </div>

                                    <div onclick="selectAppointment('morethan2years', 'More than 2 years')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        More than 2 years
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">
                                Place of Work
                            </label>

                            <div class="relative mt-3" id="workplace-wrapper">
                                <input type="hidden" name="placeofwork" id="placeofwork" required>

                                <div id="workplace-display"
                                    onclick="toggleWorkplaceDropdown()"
                                    class="form-input w-full font-normal text-gray-400 dark:text-white/30 cursor-pointer flex justify-between 
                                    items-center select-none bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700">

                                    <span id="workplace-label">Select Place of Work</span>

                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30 transition-transform duration-200"
                                        id="workplace-arrow"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>

                                <div id="workplace-options"
                                    class="hidden absolute z-50 w-full bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-lg mt-1 overflow-hidden">

                                    <div onclick="selectWorkplace('office', 'Office')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Office
                                    </div>

                                    <div onclick="selectWorkplace('field', 'Field')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Field
                                    </div>

                                    <div onclick="selectWorkplace('overseas', 'Overseas')"
                                        class="px-4 py-2.5 text-gray-700 dark:text-white/70 font-normal hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 dark:hover:text-white cursor-pointer transition-colors duration-150">
                                        Overseas
                                    </div>

                                </div>
                            </div>
                        </div>

                          <!-- <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Date Hired</label>
                            <input name="datehired" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="2026">
                        </div> -->
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Date Hired</label>
                            <div class="relative mt-3">
                                <input name="datehired" id="datehired" type="text" readonly
                                    class="form-input w-full font-normal bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 dark:placeholder-white/30 cursor-pointer"
                                    placeholder="Select Date Hired">
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                    </div>
                       
                    <div class="grid grid-cols-12 gap-4 mt-4">

                        <div class="mb-4 col-span-3">
                            <label class="font-medium text-gray-800 dark:text-white/70">Position</label>
                            <input name="position" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Manager">
                        </div>
                       
                        <div class="mb-4 col-span-3">
                            <label class="font-medium text-gray-800 dark:text-white/70">Department</label>
                            <input name="department" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="Accounting">
                        </div>

                        <div class="mb-4 col-span-3">
                            <label class="font-medium text-gray-800 dark:text-white/70">Employer Phone Number</label>
                            <input name="employerphonenumber" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="09876543213" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>

                        <div class="mb-4 col-span-3">
                            <label class="font-medium text-gray-800 dark:text-white/70">Employer Email</label>
                            <input name="employeremail" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="manolojavier@gmail.com">
                        </div>

                    </div>



                    <div class="flex justify-between items-center mt-6">
    
                        <!-- Back Button -->
                        <button onclick="goToPage(3)" 
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </button>

                        <!-- Next Button -->
                        <button onclick="goToPage(5)" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                    </div>


                </div>


                <div id="page-5" class="hidden">
                    <h2 class="text-gray-800 dark:text-white font-bold text-xl">Parents' Information</h2>

                     <div class="grid grid-cols-8 gap-4 mt-4">
                        <div class="mb-4 col-span-6">
                            <label class="font-medium text-gray-800 dark:text-white/70">Parents' Address</label>
                            <input name="parentsaddress" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Block 12 Lot 4 Third Street, New View, Barangay Mandalagan">
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Parents' Phone Number</label>
                            <input name="parentsphonenumber" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="09876543214" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                    </div>


                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Father's Full Name</h2>

                    <div class="grid grid-cols-8 gap-4 mt-2">

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Father's First Name</label>
                            <input name="fathersfirstname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Oliver">
                        </div>
                       
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Father's Middle Name</label>
                            <input name="fathersmiddlename" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Pieck">
                        </div>   

                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Father's Last Name</label>
                            <input name="fatherslastname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Ostern">
                        </div>
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Father's Suffix</label>
                            <input name="fatherssuffix" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="III">
                        </div>
                    </div>


                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Mother's Maiden Name</h2>
                    <div class="grid grid-cols-8 gap-4 mt-2">

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Mother's First Name</label>
                            <input name="mothersfirstname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Elizabeth">
                        </div>
                         
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Mother's Middle Name</label>
                            <input name="mothersmiddlename" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Dove">
                        </div>
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Mother's Last Name</label>
                            <input name="motherslastname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="Wickman">
                        </div>
                        

                    </div>

                   


                    <div class="flex justify-between items-center mt-6">
    
                        <!-- Back Button -->
                        <button onclick="goToPage(4)" 
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </button>

                        <!-- Next Button -->
                        <button onclick="goToPage(6)" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                    </div>

                </div>


                <div id="page-6" class="hidden">

                    <h2 class="text-gray-800 dark:text-white font-bold text-lg">Special Power of Attorney Information</h2>

                    <div class="grid grid-cols-8 gap-4 mt-4">

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">First Name</label>
                            <input name="spafirstname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="a">
                        </div>
                       
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Middle Name</label>
                            <input name="spamiddlename" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="a">
                        </div>
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Last Name</label>
                            <input name="spalastname" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="a">
                        </div>
                        
                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Suffix</label>
                            <input name="spasuffix" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                                dark:placeholder-white/30" placeholder="a">
                        </div>
                    </div>

                     <div class="grid grid-cols-8 gap-4 mt-2">
                        <div class="mb-4 col-span-6">
                            <label class="font-medium text-gray-800 dark:text-white/70">Address</label>
                            <input name="spaaddress" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 dark:placeholder-white/30" placeholder="a">
                        </div>

                        <div class="mb-4 col-span-2">
                            <label class="font-medium text-gray-800 dark:text-white/70">Phone Number</label>
                            <input name="spaphonenumber" type="text" class="form-input mt-3 font-normal placeholder:font-bold bg-white 
                            dark:bg-slate-800 border-gray-200 dark:border-slate-700 text-gray-800 dark:text-white/70 placeholder-gray-400 
                            dark:placeholder-white/30" placeholder="09876543215" maxlength="11" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-6">
    
                        <!-- Back Button -->
                        <button onclick="goToPage(5)" 
                            class="px-6 py-2 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-700 dark:text-white font-medium rounded-md transition-colors duration-200 flex items-center gap-2">
                            
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back
                        </button>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-center">
                                <button type="submit" name="btn-submit" id="btn-submit"
                                    class="btn bg-green-600 hover:bg-green-700 text-white rounded-md px-6 py-2 flex items-center gap-2">

                                    Submit

                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"/>
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>



                    <!-- House No. / Unit No.
Street Name
Subdivision / Village
Barangay
City / Municipality
Province / State -->