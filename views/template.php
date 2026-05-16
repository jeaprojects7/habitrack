<?php
/* if (session_status() === PHP_SESSION_NONE) {
    session_start();
} */

$static_url = '/habitrack/views/Adminassets';

$allowedRoutes = [
    'clientlogin', //changed login to clientlogin 51626
    //'login', 
    'agentlogin', //added 51626
    'adminlogin', //added 51626
    'logout',
    'clientsignup',
    'index', /* added 51026 */
    'home',
    'agentDashboard', /* added 51326 */
    'adminDashboard', /* added 51326 */
    '404'
];

$route = $_GET['route'] ?? 'clientlogin'; /* added 51226 */
$route = basename($route);

if (!in_array($route, $allowedRoutes)) {
    $route = '404';
}
?>

<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title>Habitrack</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Tailwind CSS Saas & Software Landing Page Template">
        <meta name="keywords" content="agency, application, business, clean, creative, cryptocurrency, it solutions, modern, multipurpose, nft marketplace, portfolio, saas, software, tailwind css">
        <meta name="author" content="Shreethemes">
        <meta name="website" content="https://shreethemes.in">
        <meta name="email" content="support@shreethemes.in">
        <meta name="version" content="2.3.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- favicon -->
        <link rel="shortcut icon" href="<?php echo $static_url; ?>/images/favicon.ico">

        <!-- Css -->
        <link href="<?php echo $static_url; ?>/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet">
        <link href="<?php echo $static_url; ?>/libs/tobii/css/tobii.min.css" rel="stylesheet">
        <!-- Main Css -->
        <link href="<?php echo $static_url; ?>/libs/simplebar/simplebar.min.css" rel="stylesheet">
        <link href="<?php echo $static_url; ?>/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $static_url; ?>/css/tailwind.css">
        <link rel="stylesheet" href="<?php echo $static_url; ?>/css/output.css" />

    </head>
    
    <body class="font-body text-base text-black dark:text-white dark:bg-slate-900">

    <script src="https://cdn.tailwindcss.com"></script>

        <script>
        tailwind.config = {
            darkMode: 'class', // or 'media' for system-based dark mode
            // important: true,
        }
        </script>
            
        
            <main class="page-content bg-gray-50 dark:bg-slate-800">
                

                <!-- Main Content -->
                <main>
                    <?php
                            
                            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == "ok"){
                                /* navbar file */
                                include "modules/navbar.php";

                                /* sidebar file */
                                include "modules/sidebar.php";

                                


                            }else{
                                //include __DIR__ . "/modules/login.php";/* changed to v 51226 */
                                include __DIR__ . "/modules/" . $route . ".php"; /* added 51226 */
                            }
                        ?>
                </main>

                
            </main>
        
        

        <!-- Switcher -->
        <div class="fixed top-[30%] -end-2 z-50">
            <span class="relative inline-block rotate-90">
                <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                <label class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8" for="chk">
                    <i data-feather="moon" class="size-[18px] text-yellow-500"></i>
                    <i data-feather="sun" class="size-[18px] text-yellow-500"></i>
                    <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] size-7"></span>
                </label>
            </span>
        </div>
        <!-- Switcher -->

        <!-- LTR & RTL Mode Code -->
        <div class="fixed top-[40%] -end-3 z-50">
            <a href="" id="switchRtl">
                <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold rtl:block ltr:hidden" >LTR</span>
                <span class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold ltr:block rtl:hidden">RTL</span>
            </a>
        </div>
        <!-- LTR & RTL Mode Code -->

        <!-- JAVASCRIPTS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/jsvectormap/jsvectormap.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/shufflejs/shuffle.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/tobii/js/tobii.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/jsvectormap/maps/world.js"></script>
        <script src="<?php echo $static_url; ?>/js/jsvectormap.init.js"></script>
        <script src="<?php echo $static_url; ?>/libs/apexcharts/apexcharts.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/feather-icons/feather.min.js"></script>
        <script src="<?php echo $static_url; ?>/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo $static_url; ?>/js/plugins.init.js"></script>
        <script src="<?php echo $static_url; ?>/js/app.js"></script>
        

        <!-- JAVASCRIPTS -->

        <?php
            if (isset($route)) {
                $routeScripts = [
                    "clientsignup" => [
                    "clientsignup.js"
                    ],
                    "clientlogin" => ["clientlogin.js"], //added 050726 changed from login to clientlogin 51626
                    "agentlogin" => ["agentlogin.js"], //added 050726 changed from login to clientlogin 51626
                    "adminlogin" => ["adminlogin.js"] //added 51626
                    
                ];

                    if (array_key_exists($route, $routeScripts)) {
                        foreach ($routeScripts[$route] as $script) {
                        $scriptPath = "views/js/" . $script;
                        if (file_exists($scriptPath)) {
                            echo '<script src="/habitrack/' . $scriptPath . '"></script>';
                        }
                    }
                }
            }
        ?>
    </body>
</html>