<?php
session_start();

$static_url = '/habitrack/views/Adminassets';
$logo_url = '/habitrack/views/assets'; // // added 52126

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

    <link href="<?php echo $static_url; ?>/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/tailwind.css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/output.css">

    <!-- Leaflet CSS from dashboard 51826-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- SlimSelect CSS from dashboard 51826-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slim-select@2.9.0/dist/slimselect.css" />
  
<!-- SlimSelect JS from dashboard 51826-->  <!-- moved here 52126-->
    <script src="https://cdn.jsdelivr.net/npm/slim-select@2.9.0/dist/slimselect.min.js"></script>

    <!-- Map Module CSS from dashboard 51826-->
    <link rel="stylesheet" href="/habitrack/views/Adminassets/css/map.css" />

    <!-- Bootstrap from dashboard 51826-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->


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

if(!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok") && isset($_GET["route"])){
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
        if($route == "clientsignup"){
            include "modules/client/clientsignup.php";
        }else if($route == "dashboard"){
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
            
        }else{
            include "modules/" . $route . ".php";
        }
    } else {
        include "modules/404.php";
    }
}else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok"){
    $role = $_SESSION["role"] ?? '';
    $routeMap   = include "configs/routes.php";
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

        "dashboard" => [
            "map.js"
        ]

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
    const main    = document.getElementById("main-area");
    const navbar  = document.getElementById("navbar");

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