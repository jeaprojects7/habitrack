<?php $static_url = '/habitrack/views/Adminassets'; ?>

<style>
.sidebar-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    border-radius: 8px;
    color: #94a3b8;
    font-size: 17px;
    font-weight: 500;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
    width: 100%;
}

.sidebar-link:hover {
    color: #ffffff;
}

.sidebar-link.active {
    color: #ffffff;
    font-weight: 600;
}

.sidebar-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 16px;
    border-radius: 8px;
    color: #94a3b8;
    font-size: 17px;
    font-weight: 500;
    background: transparent;
    border: none;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
    text-align: left;
}

.sidebar-btn:hover {

    color: #ffffff;
}

.sidebar-btn.open {

    color: #ffffff;
}

.submenu-arrow {
    margin-left: auto;
    transition: transform 0.2s ease;
    width: 16px;
    height: 16px;
}

.submenu-arrow.rotated {
    transform: rotate(90deg);
}

.sidebar-submenu {
    display: none;
    margin-top: 4px;
    margin-left: 32px;
}

.sidebar-submenu.open {
    display: block;
}

.sidebar-submenu a {
    display: block;
    padding: 8px 12px;
    font-size: 13px;
    color: #64748b;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.sidebar-submenu a:hover {
    color: #ffffff;
}
</style>

<!-- <aside id="sidebar" style="width: 300px; background-color: #0f172a; height: 100vh; overflow-y: auto; position: fixed; top: 0; left: 0; z-index: 50; transition: width 0.3s ease; flex-shrink: 0;"> -->
<!-- change this ^ to this v -->
 <aside id="sidebar"
style="width:300px;
background-color:#0f172a;
height:100vh;
overflow-y:auto;
position:fixed;
top:0;
left:0;
z-index:40;
transition:0.3s;"> <!-- ga work na ni pero wala ang sa hamburger -->
<!-- <aside id="sidebar"
class="sidebar fixed top-0 left-0 h-screen w-[300px] bg-slate-900 overflow-y-auto transition-all duration-300">
    <nav style="height: 100%; display: flex; flex-direction: column;"> -->

        <!-- Logo -->
        <div style="padding: 16px 26px; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <a href="home">
                <img src="<?php echo $static_url; ?>/images/logo-light.png" alt="Habitrack" style="height: 30px;">
            </a>
        </div>

        <!-- Nav Items -->
        <ul style="flex: 1; padding: 20px 12px; list-style: none; margin: 0; display: flex; flex-direction: column; gap: 4px;">

            <!-- Dashboard -->
            <li>
                <a href="home"
                   class="sidebar-link <?php echo (!isset($_GET['route']) || $_GET['route'] === 'home') ? 'active' : ''; ?> ">
                    <i data-feather="grid" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Explore Properties -->
            <li>
                <a href="exploreProperties"
                   class="sidebar-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'exploreProperties') ? 'active' : ''; ?>">
                    <i data-feather="home" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Explore Properties</span>
                </a>
            </li>

            <!-- Favorite Properties -->
            <li>
                <a href="favoriteProperties"
                   class="sidebar-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'favoriteProperties') ? 'active' : ''; ?>">
                    <i data-feather="heart" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Favorite Properties</span>
                </a>
            </li>

            <!-- Add Properties -->
            <li>
                <a href="addProperties"
                   class="sidebar-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'addProperties') ? 'active' : ''; ?>">
                    <i data-feather="plus-square" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Add Properties</span>
                </a>
            </li>

            <!-- Apps -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('apps-submenu', this)">
                    <i data-feather="cpu" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Apps</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="apps-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="#">Chat</a></li>
                    <li><a href="#">Calendar</a></li>
                </ul>
            </li>

            <!-- User Profile -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('profile-submenu', this)">
                    <i data-feather="user" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>User Profile</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="profile-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="userProfile">My Profile</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </li>

            <!-- Blog -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('blog-submenu', this)">
                    <i data-feather="file-text" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Blog</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="blog-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="#">All Posts</a></li>
                    <li><a href="#">Add Post</a></li>
                </ul>
            </li>

            <!-- Invoice -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('invoice-submenu', this)">
                    <i data-feather="file" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Invoice</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="invoice-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="#">Invoice List</a></li>
                    <li><a href="#">Invoice Detail</a></li>
                </ul>
            </li>

            <!-- Pages -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('pages-submenu', this)">
                    <i data-feather="copy" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Pages</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="pages-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="#">Starter</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Term & Condition</a></li>
                </ul>
            </li>

            <!-- Authentication -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('auth-submenu', this)">
                    <i data-feather="lock" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Authentication</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="auth-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="clientlogin">Login</a></li>
                    <li><a href="clientsignup">Register</a></li>
                    <li><a href="logout">Logout</a></li>
                </ul>
            </li>

            <!-- Miscellaneous -->
            <li>
                <button class="sidebar-btn" onclick="toggleSubmenu('misc-submenu', this)">
                    <i data-feather="layers" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Miscellaneous</span>
                    <i data-feather="chevron-right" class="submenu-arrow"></i>
                </button>
                <ul id="misc-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                    <li><a href="#">Coming Soon</a></li>
                    <li><a href="#">Maintenance</a></li>
                    <li><a href="404">404 Page</a></li>
                </ul>
            </li>

        </ul>

    </nav>

</aside>

<!-- Spacer — must match sidebar width -->
<div id="sidebar-spacer" style="width: 300px; flex-shrink: 0; transition: width 0.3s ease;"></div>

<script>
function toggleSubmenu(id, btn) {
    const submenu = document.getElementById(id);
    const arrow   = btn.querySelector('.submenu-arrow');

    // Close all others
    document.querySelectorAll('.sidebar-submenu').forEach(function(el) {
        if (el.id !== id) {
            el.classList.remove('open');
        }
    });
    document.querySelectorAll('.sidebar-btn').forEach(function(el) {
        if (el !== btn) {
            el.classList.remove('open');
            const a = el.querySelector('.submenu-arrow');
            if (a) a.classList.remove('rotated');
        }
    });

    // Toggle this one
    const isOpen = submenu.classList.toggle('open');
    btn.classList.toggle('open', isOpen);
    arrow.classList.toggle('rotated', isOpen);
}
</script>