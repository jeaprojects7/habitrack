    <div
        class="fixed top-18 right-0 h-[64px]  flex items-center justify-between px-6"
        style="left:300px; z-index:30; transition:0.3s;" id="main-area">
        <div class="layout-specing">
            <!-- Start Content -->
            <div class="flex justify-between items-center">
                <div>
                    <h5 class="text-xl font-semibold">
                        Hello, 
                        <?php echo isset($_SESSION['fname']) 
                            ? htmlspecialchars($_SESSION['fname']) 
                            : 'Guest'; ?>
                    </h5>
                </div>
            </div>

          
            </div>
            <!-- End Content -->
        </div>
    </div><!--end container-->

