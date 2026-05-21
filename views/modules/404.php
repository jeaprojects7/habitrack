<?php
$base_dir = __DIR__ . '/modules';
$static_url = '/habitrack/views/Adminassets'; // Ensure this is the correct path
$logo_url = '/habitrack/views/assets'; // added 52126



?>

    <section class="relative bg-green-600/5">
        <div class="container-fluid relative">
            <div class="grid grid-cols-1">
                <div class="flex flex-col min-h-screen justify-center md:px-10 py-10 px-4">
                    <div class="text-center">
                        <a href="home"><img src="<?php echo $logo_url; ?>/images/jeaLogo.png" class="mx-auto w-24 h-auto"  alt=""></a>
                    </div>
                    <div class="title-heading text-center my-auto">
                        <img src="<?php echo $static_url; ?>/images/error.png" class="mx-auto" alt="">
                        <h1 class="mt-3 mb-6 md:text-4xl text-3xl font-bold">Page Not Found?</h1>
                        <p class="text-slate-400">Whoops, this is embarassing. <br> Looks like the page you were looking for wasn't found.</p>
                        
                        <div class="mt-4">
                            <a href="home" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md">Back to Home</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="mb-0 text-slate-400">© <script>document.write(new Date().getFullYear())</script> Hously. Design & Develop with <i class="mdi mdi-heart text-red-600"></i> by <a href="https://shreethemes.in/" target="_blank" class="text-reset">Jea</a>.</p>
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->

<?php

?>