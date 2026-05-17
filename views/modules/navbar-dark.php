<!-- Start Navbar -->
<nav id="topnav" class="defaultscroll is-sticky">
            <div class="container relative">
                <!-- Logo container-->
                <a class="logo" href="index.php">
                    <img src="<?php echo $static_url; ?>/images/logo-dark.png" class="inline-block dark:hidden" alt="">
                    <img src="<?php echo $static_url; ?>/images/logo-light.png" class="hidden dark:inline-block" alt="">
                </a>
                <!-- End Logo container-->

                <!-- Start Mobile Toggle -->
                <div class="menu-extras">
                    <div class="menu-item">
                        <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Mobile Toggle -->

                <!--Login button Start-->
                <ul class="buy-button list-none mb-0">
                    <li class="inline mb-0">
                        <a href="auth-login.php" class="btn btn-icon bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full"><i data-feather="user" class="size-4 stroke-[3]"></i></a>
                    </li>
                    <li class="sm:inline ps-1 mb-0 hidden">
                        <a href="auth-signup.php" class="btn bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full">Signup</a>
                    </li>
                </ul>
                <!--Login button End-->

                <div id="navigation">
                    <!-- Navigation Menu-->   
                    <ul class="navigation-menu justify-end">
                        <li class="has-submenu parent-parent-menu-item">
                            <a href="javascript:void(0)">Home</a><span class="menu-arrow"></span>

                            <ul class="submenu megamenu">
                                <li>
                                    <ul>
                                        <li>
                                            <a href="index.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-one.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero One</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index-two.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-two.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Two</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <ul>
                                        <li>
                                            <a href="index-three.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-three.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Three</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index-four.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-four.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Four</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <ul>
                                        <li>
                                            <a href="index-five.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-five.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Five</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index-six.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-six.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Six</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                
                                <li>
                                    <ul>
                                        <li>
                                            <a href="index-seven.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-seven.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Seven</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="index-eight.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-eight.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Eight</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                
                                <li>
                                    <ul>
                                        <li>
                                            <a href="index-nine.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-nine.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Nine</span>
                                                </div>
                                            </a>
                                        </li>
                                
                                        <li>
                                            <a href="index-ten.php" class="sub-menu-item">
                                                <div class="lg:text-center">
                                                    <span class="hidden lg:block"><img src="<?php echo $static_url; ?>/images/demos/hero-ten.png" class="img-fluid rounded shadow-md" alt=""></span>
                                                    <span class="lg:mt-2 block">Hero Ten</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                
                        <li><a href="buy.php" class="sub-menu-item">Buy</a></li>
                
                        <li><a href="sell.php" class="sub-menu-item">Sell</a></li>

                        <li class="has-submenu parent-parent-menu-item">
                            <a href="javascript:void(0)">Listing</a><span class="menu-arrow"></span>
                            <ul class="submenu">
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Grid View </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="grid.php" class="sub-menu-item">Grid Listing</a></li>
                                        <li><a href="grid-sidebar.php" class="sub-menu-item">Grid Sidebar </a></li>
                                        <li><a href="grid-map.php" class="sub-menu-item">Grid With Map</a></li>
                                    </ul> 
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> List View </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="list.php" class="sub-menu-item">List Listing</a></li>
                                        <li><a href="list-sidebar.php" class="sub-menu-item">List Sidebar </a></li>
                                        <li><a href="list-map.php" class="sub-menu-item">List With Map</a></li>
                                    </ul>  
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Property Detail</a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="property-detail.php" class="sub-menu-item">Property Detail</a></li>
                                        <li><a href="property-detail-two.php" class="sub-menu-item">Property Detail Two</a></li>
                                    </ul>  
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu parent-parent-menu-item">
                            <a href="javascript:void(0)">Pages</a><span class="menu-arrow"></span>
                            <ul class="submenu">
                                <li><a href="aboutus.php" class="sub-menu-item">About Us</a></li>
                                <li><a href="features.php" class="sub-menu-item">Featues</a></li>
                                <li><a href="pricing.php" class="sub-menu-item">Pricing</a></li>
                                <li><a href="faqs.php" class="sub-menu-item">Faqs</a></li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Agents</a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="agents.php" class="sub-menu-item">Agents</a></li>
                                        <li><a href="agent-profile.php" class="sub-menu-item">Agent Profile</a></li>
                                    </ul>  
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Agencies</a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="agencies.php" class="sub-menu-item">Agencies</a></li>
                                        <li><a href="agency-profile.php" class="sub-menu-item">Agency Profile</a></li>
                                    </ul>  
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Auth Pages </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="auth-login.php" class="sub-menu-item">Login</a></li>
                                        <li><a href="auth-signup.php" class="sub-menu-item">Signup</a></li>
                                        <li><a href="auth-re-password.php" class="sub-menu-item">Reset Password</a></li>
                                    </ul>  
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Utility </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="terms.php" class="sub-menu-item">Terms of Services</a></li>
                                        <li><a href="privacy.php" class="sub-menu-item">Privacy Policy</a></li>
                                    </ul>  
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Blog </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="blogs.php" class="sub-menu-item"> Blogs</a></li>
                                        <li><a href="blog-sidebar.php" class="sub-menu-item"> Blog Sidebar</a></li>
                                        <li><a href="blog-detail.php" class="sub-menu-item"> Blog Detail</a></li>
                                    </ul> 
                                </li>
                                <li class="has-submenu parent-menu-item"><a href="javascript:void(0)"> Special </a><span class="submenu-arrow"></span>
                                    <ul class="submenu">
                                        <li><a href="comingsoon.php" class="sub-menu-item">Comingsoon</a></li>
                                        <li><a href="maintenance.php" class="sub-menu-item">Maintenance</a></li>
                                        <li><a href="404.php" class="sub-menu-item">404! Error</a></li>
                                    </ul>  
                                </li>
                            </ul>
                        </li>
                
                        <li><a href="contact.php" class="sub-menu-item">Contact</a></li>
                    </ul><!--end navigation menu-->
                </div><!--end navigation-->
            </div><!--end container-->
        </nav><!--end header-->
        <!-- End Navbar -->

<!-- JavaScript to handle the active class -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navItems = document.querySelectorAll('#navbar-navlist .nav-link');

        navItems.forEach(item => {
            item.addEventListener('click', function () {
                // Remove active class from all nav-links
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to the clicked nav-link
                this.classList.add('active');
            });
        });
    });
</script>