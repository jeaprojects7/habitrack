<?php
$base_dir = __DIR__ ;
$static_url = '/habitrack/views/Adminassets'; // Ensure this is the correct path

// Include the common navlink content
ob_start();
$navlink_content = ob_get_clean(); // Capture the navlink content

// Optionally define the Hero block content
ob_start();
?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<body>
     <?php include $base_dir . '/navbar.php'; ?>
     <div class="pt-20"> <!-- space under navbar -->
        <!-- <div id="map" style="height: 500px;"></div> -->
        <div id="map" class="h-screen w-full bg-white"></div>
    </div>
    

<script>
    var map = L.map('map').setView([9.7392, 118.7353], 13); // Puerto Princesa coords

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
</script>
        
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Start Content -->
            <div class="flex justify-between items-center">
                <div>
                    <h5 class="text-xl font-semibold">Hello, Calvin</h5>
                    <h6 class="text-slate-400">Welcome back!</h6>
                </div>
            </div>

          
            </div>
            <!-- End Content -->
        </div>
    </div><!--end container-->


<?php
$hero_content = ob_get_clean(); // Capture the hero content

// Include the base template
include "$base_dir/base.php";
?> 