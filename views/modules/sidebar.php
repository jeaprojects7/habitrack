<?php $static_url = '/habitrack/views/Adminassets';
      $logo_url = '/habitrack/views/assets'; ?>

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
        <div style="padding: 8px 10px; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <a href="home" style="
       display:flex;
       align-items:center;
       gap:12px;
       text-decoration:none;
       ">
                <img src="<?php echo $logo_url; ?>/images/jeaLogo.png" alt="" style="height: 50px;  width:auto;">

                <span style="
            color:white;
            font-size:30px;
            font-weight:450;
            margin-top:6px;
           
        ">
            Habitrack
        </span>
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
                <a href="exploreproperty"
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
                <a href="add-property"
                   class="sidebar-link <?php echo (isset($_GET['route']) && $_GET['route'] === 'addProperties') ? 'active' : ''; ?>">
                    <i data-feather="plus-square" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>Add Properties</span>
                </a>
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

           
    <!-- </nav> -->

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