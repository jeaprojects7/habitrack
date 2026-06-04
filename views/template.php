<?php
session_start();

$static_url = '/habitrack/views/Adminassets';
$logo_url = '/habitrack/views/assets'; // // added 52126

if (($_GET['route'] ?? '') === 'print-properties') {
    if (($_SESSION['loggedIn'] ?? '') === 'ok' && ($_SESSION['role'] ?? '') === 'Admin') {
        include __DIR__ . "/../reports/print-properties.php";
        exit;
    }

    http_response_code(403);
    exit('Forbidden');
}

if (($_GET['route'] ?? '') === 'print-agents') {
    if (($_SESSION['loggedIn'] ?? '') === 'ok' && ($_SESSION['role'] ?? '') === 'Admin') {
        include __DIR__ . "/../reports/print-agents.php";
        exit;
    }

    http_response_code(403);
    exit('Forbidden');
}

?>

<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">

    <title>Habitrack</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Tailwind CSS Saas & Software Landing Page Template">

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo $logo_url; ?>/images/jeaLogo.png">

    <!-- Css -->
    <link href="<?php echo $static_url; ?>/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet">
    <link href="<?php echo $static_url; ?>/libs/tobii/css/tobii.min.css" rel="stylesheet">

    <!-- Main Css -->
    <link href="<?php echo $static_url; ?>/libs/simplebar/simplebar.min.css" rel="stylesheet">

    <link href="<?php echo $static_url; ?>/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet"
        type="text/css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/tailwind.css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/output.css">

    <!-- Leaflet CSS from dashboard 51826-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- SlimSelect CSS from dashboard 51826-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slim-select@2.9.0/dist/slimselect.css" />

    <!-- SlimSelect JS from dashboard 51826--> <!-- moved here 52126-->
    <script src="https://cdn.jsdelivr.net/npm/slim-select@2.9.0/dist/slimselect.min.js"></script>

    <!-- Map Module CSS from dashboard 51826-->
    <link rel="stylesheet" href="/habitrack/views/Adminassets/css/map.css" />

    <!-- Bootstrap from dashboard 51826-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Flatpickr CSS added 52326-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr Theme (optional but nicer) 52326-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

    <!-- Flatpickr Custom Styling added 52326 chat-->
    <!-- <style>
    .flatpickr-calendar {
        transform: scale(0.92);
        transform-origin: top left;
    }

    .flatpickr-day {
        max-width: 34px;
        height: 34px;
        line-height: 34px;
    }

    .flatpickr-months .flatpickr-month {
        height: 40px;
    }

    .flatpickr-current-month {
        font-size: 14px;
    }
    </style> -->
<style>
.flatpickr-calendar {
    font-size: 14px !important;
}

.flatpickr-day {
    max-width: 34px !important;
    height: 34px !important;
    line-height: 34px !important;
}

.flatpickr-months .flatpickr-month {
    height: 40px !important;
    background: #354f97 !important;
}

.flatpickr-current-month {
    font-size: 14px !important;
    padding-top: 8px !important;
}

.flatpickr-weekdays {
    background: #354f97 !important;
}

span.flatpickr-weekday {
    background: #354f97 !important;
}

.flatpickr-current-month .flatpickr-monthDropdown-months {
    background: #354f97 !important;
}

.flatpickr-current-month .flatpickr-monthDropdown-months option {
    background: #354f97 !important;
}

span.flatpickr-weekday {
    color: #ffffffcb !important;
}

/*  */
.dark .flatpickr-calendar {
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3) !important;
}

.dark .flatpickr-months,
.dark .flatpickr-month,
.dark .flatpickr-weekdays,
.dark .flatpickr-days {
    background: #1e293b !important;
}

.dark .flatpickr-current-month,
.dark .flatpickr-current-month .cur-month,
.dark .flatpickr-current-month input.cur-year {
    color: #f1f5f9 !important;
}

.dark span.flatpickr-weekday {
    color: #94a3b8 !important;
    background: #1e293b !important;
}

.dark .flatpickr-day {
    color: #e2e8f0 !important;
}

.dark .flatpickr-days,
.dark .dayContainer {
    background: #293548 !important;
}

.dark .flatpickr-innerContainer {
    border-bottom: none !important;
    background: #293548 !important;
}

.dark .flatpickr-day:hover {
    background: #334155 !important;
    border-color: #334155 !important;
    color: #f1f5f9 !important;
}

.dark .flatpickr-day.today {
    border-color: #3b82f6 !important;
    color: #e2e8f0 !important;
}

.dark .flatpickr-day.selected {
    background: #2563eb !important;
    border-color: #2563eb !important;
    color: #ffffff !important;
}

.dark .flatpickr-calendar.arrowTop:before,
.dark .flatpickr-calendar.arrowTop:after {
    border-bottom-color: #ffffff !important;
}

.dark .flatpickr-calendar.arrowBottom:before,
.dark .flatpickr-calendar.arrowBottom:after {
    border-top-color: #293548 !important;
}

.dark .flatpickr-day.flatpickr-disabled,
.dark .flatpickr-day.prevMonthDay,
.dark .flatpickr-day.nextMonthDay {
    color: #475569 !important;
}

.dark .flatpickr-months .flatpickr-prev-month,
.dark .flatpickr-months .flatpickr-next-month {
    color: #94a3b8 !important;
    fill: #94a3b8 !important;
}

.dark .flatpickr-months .flatpickr-prev-month:hover,
.dark .flatpickr-months .flatpickr-next-month:hover {
    color: #f1f5f9 !important;
    fill: #f1f5f9 !important;
}

.dark .flatpickr-current-month .flatpickr-monthDropdown-months {
    background: #1e293b !important;
    color: #f1f5f9 !important;
}

.dark .flatpickr-current-month .flatpickr-monthDropdown-months option {
    background: #1e293b !important;
    color: #f1f5f9 !important;
}



</style>
</head>

<body class="font-body text-base text-black dark:text-white light:bg-slate-900">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <main class="page-content bg-gray-50 dark:bg-slate-800">

        <!-- MAIN CONTENT -->
        <main>
            <?php

            if (!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok") && isset($_GET["route"])) {
                $route = basename($_GET["route"]);
                $allowedRoutes = [
                    'start',
                    'clientlogin',
                    'agentlogin',
                    'adminlogin',
                    'clientsignup',
                    'home',
                    'dashboard',
                    'agentDashboard',
                    'adminDashboard',
                    'logout'
                ];
                if (in_array($route, $allowedRoutes)) {
                    if ($route == "clientsignup") {
                        include "modules/client/clientsignup.php";
                    } else if ($route == "dashboard") {
                        // <!-- <div style="display:flex; height:100vh; width:100vw; overflow:hidden;"> changed to this v 51726 for collapse thingy -->
                        echo '<div id="layout" style="display:flex; height:100vh; width:100%; overflow:hidden;">';

                        // <!-- SIDEBAR -->
                        // <!-- <div style="width:250px; flex-shrink:0;"> changed to this for collapse thingy v 51726 -->
                        echo '<div id="sidebar-container" style="width:250px; flex-shrink:0; transition:0.3s">';
                        include "modules/sidebar.php";
                        echo '</div>';

                        // <!-- MAIN -->
                        echo '<div style="flex:1; display:flex; flex-direction:column; min-width:0">';

                        // <!-- NAVBAR -->
                        // <!-- <div style="height:60px; flex-shrink:0;"> changed to this for collapse thingy v 51726 -->
                        echo '<div id="navbar-container" style="height:60px; flex-shrink:0; width:100%; transition:0.3s">';
                        include "modules/navbar.php";
                        echo '</div>';
                        include "modules/dashboard.php";

                    } else {
                        include "modules/" . $route . ".php";
                    }
                } else {
                    include "modules/404.php";
                }
            } else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok") {
                $role = $_SESSION["role"] ?? '';
                $routeMap = include "configs/routes.php";
                $modulePaths = include "configs/modulePaths.php";

                $allowedRoutes = $routeMap[$role] ?? [];


                // <!-- <div style="display:flex; height:100vh; width:100vw; overflow:hidden;"> changed to this v 51726 for collapse thingy -->
                echo '<div id="layout" style="display:flex; height:100vh; width:100%; overflow:hidden;">';

                // <!-- SIDEBAR -->
                // <!-- <div style="width:250px; flex-shrink:0;"> changed to this for collapse thingy v 51726 -->
                echo '<div id="sidebar-container" style="width:250px; flex-shrink:0; transition:0.3s">';
                include "modules/sidebar.php";
                echo '</div>';

                // <!-- MAIN -->
                echo '<div style="flex:1; display:flex; flex-direction:column; min-width:0">';

                // <!-- NAVBAR -->
                // <!-- <div style="height:60px; flex-shrink:0;"> changed to this for collapse thingy v 51726 -->
                echo '<div id="navbar-container" style="height:60px; flex-shrink:0; width:100%; transition:0.3s">';
                include "modules/navbar.php";
                echo '</div>';

                // <!-- CONTENT -->
                echo '<div style="flex:1; overflow:auto; padding:20px">';

                $route = isset($_GET["route"]) ? basename($_GET["route"]) : 'sample';

                if (isset($_GET["route"])) {
                    $raw = $_GET["route"];
                    // Allow only alphanumeric, hyphens, and ONE slash
                    if (preg_match('/^[a-zA-Z0-9-]+(\/[a-zA-Z0-9-]+)?$/', $raw)) {
                        $route = $raw;
                    } else {
                        $route = '404';
                    }
                }

                if (in_array($route, $allowedRoutes) && isset($modulePaths[$route])) {
                    include $modulePaths[$route];
                } else {
                    // Distinguish "not found" from "forbidden" for better UX
                    $status = isset($modulePaths[$route]) ? '403' : '404';
                    include "modules/{$status}.php";
                }
                /*   
                   $route = $_GET["route"] ?? "home";
                   include "modules/" . $route . ".php";
                 */

                echo '</div>';

                echo '</div>';

                echo '</div>';

            } else {
                $route = "clientlogin";

                include "modules/start.php";
            }
            ?>
        </main>

    </main>



    <!-- LTR & RTL Mode -->
    <!-- <div class="fixed top-[40%] -end-3 z-50">

    <a href="" id="switchRtl">

        <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold rtl:block ltr:hidden">
            LTR
        </span>

        <span class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold ltr:block rtl:hidden">
            RTL
        </span>

    </a>

</div> -->
    <!-- LTR & RTL Mode -->

    <!-- JAVASCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<!-- Flatpickr JS added 52326-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <!-- SlimSelect JS from dashboard 51826-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/slim-select@2.9.0/dist/slimselect.min.js"></script> moved 52126 -->

    <!-- Leaflet JS from dashboard 51826-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/habitrack/views/js/map.js"></script>


    <?php
    if ($route === 'add-property') {
        echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
    }
?>

<?php
    if ($route === 'edit-property') {
        echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
    }
?>




    <!-- ROUTE SCRIPTS -->
    <?php

    if (isset($route)) {

        $routeScripts = [

            "clientsignup" => [
                "clientsignup.js"
            ],

            "clientlogin" => [
                "clientlogin.js"
            ],

            "agentlogin" => [
                "agentlogin.js"
            ],

            "adminlogin" => [
                "adminlogin.js"
            ],

        "add-property" => [
            "add-property.js"
        ],
          "edit-property" => [
            "edit-property.js"
        ],
         "agentregister" => [
            "agentregister.js"
        ],
        "edit-agent" => [
            "edit-agentprofile.js"
        ],

            "dashboard" => [
                "map.js"
            ],
            "pre-qual" => [
                "pre-qual.js"
            ],

        "clientInfoSheet" => [
            "clientInfoSheet.js"
        ],

        "spouseInfoSheet" => [
            "spouseInfoSheet.js"
        ],

        "clientprofile" => [
            "clientprofile.js"
        ],

        "reservations" => [
            "reservations.js"
        ],

        "edit-clientprofile" => [
            "edit-clientprofile.js"
        ],



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
    <!-- added this for the collapse thingyy 51726 -->
    <!-- <script>
    document.getElementById("toggle-sidebar").addEventListener("click", function () {

        const sidebar = document.getElementById("sidebar-container");
        const main  = document.getElementById("main-area");
        const navbar = document.getElementById("navbar");
        const isCollapsed = sidebar.style.width === "80px";

        if (isCollapsed) {
            sidebar.style.width = "250px";
            layout.style.gridTemplateColumns = "";
            navbar.style.left = "300px";
            main.style.left = "300px";
        } else {
            sidebar.style.width = "80px";
            navbar.style.left = "80px";
            main.style.left = "80px";
        }


    });
    
</script> -->
    <script>
        //new for collapse thingyy
        document.getElementById("toggle-sidebar").addEventListener("click", function () {

            const sidebar = document.getElementById("sidebar");
            const main = document.getElementById("main-area");
            const navbar = document.getElementById("navbar");

            const isCollapsed = sidebar.classList.toggle("w-[80px]");

            if (isCollapsed) {
                sidebar.style.width = "80px";
                main.style.left = "0px";
                navbar.style.left = "0px";
            } else {
                sidebar.style.width = "300px";
                main.style.left = "300px";
                navbar.style.left = "300px";
            }

        });
    </script>
</body>

</html>
