<?php
// $base_dir = __DIR__ . '/Base';
$static_url = '/habitrack/views/Adminassets';

// Define the content for the navlink block
ob_start();
?>

<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">
    <head>
        <meta charset="UTF-8" />
        <title>Hously -  PHP Real Estate Landing & Admin Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta content="Real Estate Website Landing Page" name="description" />
        <meta content="Real Estate, buy, sell, Rent, tailwind Css" name="keywords" />
        <meta name="author" content="Shreethemes" />
        <meta name="website" content="https://shreethemes.in" />
        <meta name="email" content="support@shreethemes.in" />
        <meta name="version" content="2.3.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo $static_url; ?>/images/favicon.ico" />

        <!-- Css -->
        <!-- Main Css -->
        <link href="<?php echo $static_url; ?>/libs/@iconscout/unicons/css/line.css" type="text/css" rel="stylesheet" />
        <link href="<?php echo $static_url; ?>/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $static_url; ?>/css/tailwind.css" />
        <link rel="stylesheet" href="<?php echo $static_url; ?>/css/output.css" />

    </head>
    
    <body class="dark:bg-slate-900">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    tailwind.config = {
        darkMode: 'class', // or 'media' for system-based dark mode
        // important: true,
    }
    </script>

    <!-- Main Content -->
    <main>
        <?php echo $hero_content ?? '<!-- Default hero content here -->'; ?>
    </main>

        <div class="fixed bottom-3 end-3 z-10">
            <a href="" class="back-button btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full"><i data-feather="arrow-left" class="size-4"></i></a>
        </div>
        
        <!-- Switcher removed 51626-->
        <!-- <div class="fixed top-1/4 -left-2 z-3">
            <span class="relative inline-block rotate-90">
                <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                <label class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8" for="chk">
                    <i class="uil uil-moon text-[20px] text-yellow-500 mt-1"></i>
                    <i class="uil uil-sun text-[20px] text-yellow-500 mt-1"></i>
                    <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] size-7"></span>
                </label>
            </span>
        </div> -->
        <!-- Switcher -->

        <!-- LTR & RTL Mode Code removed 51626-->
        <!-- <div class="fixed top-[40%] -left-3 z-50">
            <a href="" id="switchRtl">
                <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold rtl:block ltr:hidden" >LTR</span>
                <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold ltr:block rtl:hidden">RTL</span>
            </a>
        </div> -->
        <!-- LTR & RTL Mode Code -->

        <!-- JAVASCRIPTS -->
        <script src="<?php echo $static_url; ?>/libs/particles.js/particles.js"></script>
        <script src="<?php echo $static_url; ?>/libs/feather-icons/feather.min.js"></script>
        <script src="<?php echo $static_url; ?>/js/plugins.init.js"></script>
        <script src="<?php echo $static_url; ?>/js/app.js"></script>

        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> added 51326 -->
        <!-- JAVASCRIPTS -->
         <!-- added v 2 lines 51626 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/habitrack/views/js/clientlogin.js"></script>
    </body>
</html>