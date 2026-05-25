<?php 
$static_url = '/habitrack/views/Adminassets';

$role = $_SESSION['role'] ?? 'Guest';
$isGuest = ($role === 'Guest');

/* NAVBAR PRIVILEGE SYSTEM (same pattern as sidebar) */
$navbarMenus = [

    'Admin' => [
        [
            'title' => 'My Profile',
            'route' => 'userProfile',
            'icon'  => 'user'
        ],
        [
            'title' => 'Settings',
            'route' => 'settings',
            'icon'  => 'settings'
        ],
        [
            'title' => 'Logout',
            'route' => 'logout',
            'icon'  => 'log-out',
            'danger' => true
        ]
    ],

    'Agent' => [
        [
            'title' => 'My Profile',
            'route' => 'agentProfile',
            'icon'  => 'user'
        ],
        [
            'title' => 'Settings',
            'route' => 'settings',
            'icon'  => 'settings'
        ],
        [
            'title' => 'Logout',
            'route' => 'logout',
            'icon'  => 'log-out',
            'danger' => true
        ]
    ],

    'Client' => [
        [
            'title' => 'My Profile',
            'route' => 'clientprofile',
            'icon'  => 'user'
        ],
        [
            'title' => 'Settings',
            'route' => 'edit-clientprofile',
            'icon'  => 'settings'
        ],
        [
            'title' => 'Logout',
            'route' => 'logout',
            'icon'  => 'log-out',
            'danger' => true
        ]
    ],

    'Guest' => [
        [
            'title' => 'Login',
            'route' => 'clientlogin',
            'icon'  => 'log-in'
        ],
        [
            'title' => 'Sign Up',
            'route' => 'clientsignup',
            'icon'  => 'user-plus'
        ]
    ]
];

$currentNavbarMenu = $navbarMenus[$role] ?? $navbarMenus['Guest'];
?>

<div id="navbar"
    class="fixed top-0 right-0 h-[67px] bg-white dark:bg-slate-900 flex items-center justify-between px-6 border-b border-gray-200 dark:border-gray-800 shadow-sm"
    style="left:300px; z-index:30; transition:0.3s;">

    <!-- LEFT -->
    <div class="flex items-center gap-4">

        <button id="toggle-sidebar" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
            <i data-feather="menu" class="w-5 h-5"></i>
        </button>

        <div class="relative">
            <i data-feather="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" placeholder="Search..."
                class="border border-gray-200 dark:border-gray-700 rounded-lg pl-9 pr-4 py-2 w-56 bg-transparent text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

        <!-- Dark mode switcher -->
        <div class="relative flex items-center">
            <span class="relative inline-block rotate-0">
                <input type="checkbox" class="checkbox opacity-0 absolute" id="chk" />
                <label class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8" for="chk">
                    <i data-feather="moon" class="size-[18px] text-yellow-500"></i>
                    <i data-feather="sun" class="size-[18px] text-yellow-500"></i>
                    <span class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] size-7"></span>
                </label>
            </span>
        </div>

        <?php if (!$isGuest): ?>
        <!-- NOTIFICATION BELL — logged in only -->
        <div class="relative" id="notif-wrapper">
            <button id="notif-btn" class="relative p-1 hover:bg-gray-100 dark:hover:bg-slate-700 rounded transition-colors">
                <i data-feather="bell" class="w-5 h-5"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <div id="notif-dropdown"
                class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 z-50">

                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                    <h6 class="font-semibold text-sm text-gray-700 dark:text-white">Notifications</h6>
                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">3 New</span>
                </div>

                <ul class="divide-y divide-gray-100 dark:divide-slate-700 max-h-64 overflow-y-auto">
                    <li class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i data-feather="home" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-white font-medium">New property listed</p>
                            <p class="text-xs text-gray-400">2 minutes ago</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i data-feather="user" class="w-4 h-4 text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-white font-medium">New user registered</p>
                            <p class="text-xs text-gray-400">10 minutes ago</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700 cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <i data-feather="message-circle" class="w-4 h-4 text-yellow-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700 dark:text-white font-medium">New message received</p>
                            <p class="text-xs text-gray-400">1 hour ago</p>
                        </div>
                    </li>
                </ul>

                <div class="px-4 py-3 border-t border-gray-100 dark:border-slate-700 text-center">
                    <a href="#" class="text-sm text-blue-500 hover:underline">View all notifications</a>
                </div>

            </div>
        </div>
        <?php endif; ?>

        <!-- PROFILE -->
        <div class="relative" id="profile-wrapper">
            <button id="profile-btn" class="flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg px-2 py-1 transition-colors">
                <img src="<?php echo $static_url; ?>/images/client/07.jpg"
                     class="w-9 h-9 rounded-full object-cover border-2 border-gray-200">
                <i data-feather="chevron-down" class="w-4 h-4 text-gray-500"></i>
            </button>

            <div id="profile-dropdown"
                class="hidden absolute right-0 mt-2 w-52 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 z-50">

                <?php if (!$isGuest): ?>
                <!-- Logged in -->
                <div class="px-4 py-3 border-b border-gray-100 dark:border-slate-700">
                    <p class="text-sm font-semibold text-gray-700 dark:text-white">
                        <?php echo htmlspecialchars($_SESSION['fname']); ?>
                    </p>
                    <p class="text-xs text-gray-400">
                        <?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>
                    </p>
                </div>

                <ul class="py-1">

                <?php foreach ($currentNavbarMenu as $item): ?>

                    <li>
                        <a href="<?= $item['route']; ?>"
                        class="flex items-center gap-3 px-4 py-2 text-sm
                        <?= !empty($item['danger']) ? 'text-red-500 hover:bg-red-50 dark:hover:bg-slate-700'
                                                    : 'text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700' ?>">

                            <i data-feather="<?= $item['icon']; ?>" class="w-4 h-4"></i>

                            <?= $item['title']; ?>

                        </a>
                    </li>

                <?php endforeach; ?>

            </ul>

                <?php else: ?>
                <!-- Guest -->
                <ul class="py-1">
                    <li>
                        <a href="clientlogin" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700">
                            <i data-feather="log-in" class="w-4 h-4"></i> Login
                        </a>
                    </li>
                    <li>
                        <a href="clientsignup" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-slate-700">
                            <i data-feather="user-plus" class="w-4 h-4"></i> Sign Up
                        </a>
                    </li>
                </ul>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

// ── SIDEBAR TOGGLE ──────────────────────────────────────────
    const toggleBtn = document.getElementById('toggle-sidebar');
    const sidebar   = document.getElementById('sidebar');
    const spacer    = document.getElementById('sidebar-spacer');
    const layoutPage = document.querySelector('.layout-page');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = sidebar.classList.toggle('-translate-x-full');

            // shrink/expand spacer so content fills the gap
            if (spacer) {
            // In navbar.php toggle JS - update this line:
            spacer.style.width = isHidden ? '0px' : '280px';
            }
        });
    }

    // ── NOTIFICATION DROPDOWN ───────────────────────────────────
    const notifBtn      = document.getElementById('notif-btn');
    const notifDropdown = document.getElementById('notif-dropdown');
    const profileBtn      = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('hidden');
            if (profileDropdown) profileDropdown.classList.add('hidden');
        });
    }

    // ── PROFILE DROPDOWN ────────────────────────────────────────
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            if (notifDropdown) notifDropdown.classList.add('hidden');
        });
    }

    // ── CLOSE DROPDOWNS ON OUTSIDE CLICK ────────────────────────
    document.addEventListener('click', function () {
        if (notifDropdown)   notifDropdown.classList.add('hidden');
        if (profileDropdown) profileDropdown.classList.add('hidden');
    });

});
</script>