<?php $static_url = '/habitrack/views/Adminassets';
      $logo_url = '/habitrack/views/assets'; 

$role = $_SESSION['role'] ?? 'Guest';

$sidebarMenus = [

    'Admin' => [
        ['title' => 'Dashboard',          'route' => 'dashboard',       'icon' => 'grid'],
        ['title' => 'Explore Properties', 'route' => 'exploreproperty', 'icon' => 'home'],
        ['title' => 'Add Properties',     'route' => 'add-property',    'icon' => 'plus-square'],
        ['title' => 'Add Agent',          'route' => 'agentregister',   'icon' => 'plus-square'],
        ['title' => 'Agent List',         'route' => 'agentdisplay',    'icon' => 'user'],
    ],

    'Agent' => [
        ['title' => 'Dashboard',          'route' => 'dashboard',       'icon' => 'grid'],
        ['title' => 'Explore Properties', 'route' => 'exploreproperty', 'icon' => 'grid'],
        ['title' => 'Site Visit',         'route' => 'siteVisit',       'icon' => 'calendar'],
    ],

    'Client' => [
        ['title' => 'Dashboard',    'route' => 'dashboard',    'icon' => 'grid'],
        ['title' => 'Reservations', 'route' => 'reservations', 'icon' => 'heart'],
    ],

];

$currentMenu = $sidebarMenus[$role] ?? [];
?>

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
.sidebar-link:hover { color: #ffffff; }
.sidebar-link.active { color: #ffffff; font-weight: 600; }

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
.sidebar-btn:hover { color: #ffffff; }
.sidebar-btn.open  { color: #ffffff; }

.submenu-arrow {
    margin-left: auto;
    transition: transform 0.2s ease;
    width: 16px;
    height: 16px;
}
.submenu-arrow.rotated { transform: rotate(90deg); }

.sidebar-submenu { display: none; margin-top: 4px; margin-left: 32px; }
.sidebar-submenu.open { display: block; }
.sidebar-submenu a {
    display: block;
    padding: 8px 12px;
    font-size: 13px;
    color: #64748b;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
}
.sidebar-submenu a:hover { color: #ffffff; }
</style>

<aside id="sidebar" style="width:300px;background-color:#0f172a;height:100vh;overflow-y:auto;position:fixed;top:0;left:0;z-index:40;transition:0.3s;">

    <!-- Logo -->
    <div style="padding: 8px 10px; border-bottom: 1px solid rgba(255,255,255,0.08);">
        <a href="dashboard" style="display:flex;align-items:center;gap:12px;text-decoration:none;">
            <img src="<?php echo $logo_url; ?>/images/jeaLogo.png" alt="" style="height:50px;width:auto;">
            <span style="color:white;font-size:30px;font-weight:450;margin-top:6px;">Habitrack</span>
        </a>
    </div>

    <!-- Nav Items -->
    <ul style="flex:1;padding:20px 12px;list-style:none;margin:0;display:flex;flex-direction:column;gap:4px;">

        <?php foreach ($currentMenu as $menu): ?>
        <li>
            <a href="<?php echo $menu['route']; ?>"
               class="sidebar-link <?php echo (isset($_GET['route']) && $_GET['route'] === $menu['route']) ? 'active' : ''; ?>">
                <i data-feather="<?php echo $menu['icon']; ?>" style="width:18px;height:18px;flex-shrink:0;"></i>
                <span><?php echo $menu['title']; ?></span>
            </a>
        </li>
        <?php endforeach; ?>

        <?php if ($role === 'Agent'): ?>
        <li>
            <button class="sidebar-btn" onclick="toggleSubmenu('prequal-submenu', this)">
                <i data-feather="user" style="width:18px;height:18px;flex-shrink:0;"></i>
                <span>Client Pre-Qualification</span>
                <i data-feather="chevron-right" class="submenu-arrow"></i>
            </button>
            <ul id="prequal-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                <li><a href="index.php?route=clientPreQual&status=Pending">Pending</a></li>
                <li><a href="index.php?route=clientPreQual&status=Approved">Approved</a></li>
                <li><a href="index.php?route=clientPreQual&status=Rejected">Rejected</a></li>
            </ul>
        </li>
        <?php endif; ?>

        <?php if ($role === 'Admin'): ?>
        <li>
            <button class="sidebar-btn" onclick="toggleSubmenu('reservation-submenu', this)">
                <i data-feather="user" style="width:18px;height:18px;flex-shrink:0;"></i>
                <span>Client Reservations</span>
                <i data-feather="chevron-right" class="submenu-arrow"></i>
            </button>
            <ul id="reservation-submenu" class="sidebar-submenu" style="list-style:none;padding:0;">
                <li><a href="index.php?route=clientReservation">All</a></li>
                <li><a href="index.php?route=clientReservation&status=Pending">Pending</a></li>
                <li><a href="index.php?route=clientReservation&status=Approved">Approved</a></li>
                <li><a href="index.php?route=clientReservation&status=Rejected">Rejected</a></li>
            </ul>
        </li>
        <?php endif; ?>

    </ul>

</aside>

<div id="sidebar-spacer" style="width:300px;flex-shrink:0;transition:width 0.3s ease;"></div>

<script>
function toggleSubmenu(id, btn) {
    const submenu = document.getElementById(id);
    const arrow   = btn.querySelector('.submenu-arrow');

    document.querySelectorAll('.sidebar-submenu').forEach(function(el) {
        if (el.id !== id) el.classList.remove('open');
    });
    document.querySelectorAll('.sidebar-btn').forEach(function(el) {
        if (el !== btn) {
            el.classList.remove('open');
            const a = el.querySelector('.submenu-arrow');
            if (a) a.classList.remove('rotated');
        }
    });

    const isOpen = submenu.classList.toggle('open');
    btn.classList.toggle('open', isOpen);
    arrow.classList.toggle('rotated', isOpen);
}
</script>