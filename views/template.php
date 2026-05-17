<?php
session_start();

$static_url = '/habitrack/views/Adminassets';
?>

<!DOCTYPE html>
<html lang="en" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="UTF-8">

    <title>Habitrack</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Tailwind CSS Saas & Software Landing Page Template">

    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo $static_url; ?>/images/favicon.ico">

    <!-- Css -->
    <link href="<?php echo $static_url; ?>/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet">
    <link href="<?php echo $static_url; ?>/libs/tobii/css/tobii.min.css" rel="stylesheet">

    <!-- Main Css -->
    <link href="<?php echo $static_url; ?>/libs/simplebar/simplebar.min.css" rel="stylesheet">

    <link href="<?php echo $static_url; ?>/libs/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/tailwind.css">

    <link rel="stylesheet" href="<?php echo $static_url; ?>/css/output.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body class="font-body text-base text-black dark:text-white dark:bg-slate-900">

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
        'clientlogin',
        'agentlogin',
        'adminlogin',
        'clientsignup',
        'home',
        'agentDashboard',
        'adminDashboard',
        'home',
        'logout'
    ];
    if (in_array($route, $allowedRoutes)) {
        if($route == "clientsignup"){
            include "modules/clientsignup.php";
        }else{
            include "modules/" . $route . ".php";
        }
    } else {
        include "modules/404.php";
    }
}else if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == "ok"){


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

           
            $route = $_GET["route"] ?? "home";
            include "modules/" . $route . ".php";
         

        echo '</div>';

    echo '</div>';

echo '</div>';

} else {
    include "modules/clientlogin.php";
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

<!-- LTR & RTL Mode -->
<div class="fixed top-[40%] -end-3 z-50">

    <a href="" id="switchRtl">

        <span class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold rtl:block ltr:hidden">
            LTR
        </span>

        <span class="py-1 px-3 relative inline-block rounded-t-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-700 font-bold ltr:block rtl:hidden">
            RTL
        </span>

    </a>

</div>
<!-- LTR & RTL Mode -->

<!-- JAVASCRIPTS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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