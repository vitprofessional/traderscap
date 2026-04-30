<x-layouts.app :title="$title ?? 'TradersCap'">

<div class="min-h-screen flex bg-slate-50">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-slate-50 shadow-lg hidden md:flex md:flex-col">
        <!-- Logo Section -->
        <div class="border-b border-slate-700 px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white">TradersCap</h2>
                    <p class="text-xs text-slate-400">Trading Platform</p>
                </div>
            </div>
            <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <ul class="space-y-1.5">
                @php
                    $items = [
                        ['route'=>'dashboard','label'=>'Dashboard','icon'=>'home'],
                        ['route'=>'my-plans','label'=>'My Plans','icon'=>'collection'],
                        ['route'=>'investment-plans','label'=>'Investment Plans','icon'=>'credit-card'],
                        ['route'=>'find-broker','label'=>'Find Best Broker','icon'=>'search'],
                        ['route'=>'complaints','label'=>'Complaints','icon'=>'chat'],
                        ['route'=>'partners','label'=>'Partners Corner','icon'=>'users'],
                        ['route'=>'profile','label'=>'Profile','icon'=>'user'],
                    ];
                @endphp

                @foreach($items as $it)
                    @php
                        $isActive = request()->routeIs($it['route'].'*');
                        $routeUrl = route($it['route']);
                    @endphp

                    <li>
                        <a href="{{ $routeUrl }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-150 {{ $isActive ? 'bg-cyan-600 text-white shadow-md' : 'text-slate-300 hover:bg-slate-700/50 hover:text-slate-50' }}">
                            <!-- Icon -->
                            <span class="flex-shrink-0 w-5 h-5 flex items-center justify-center {{ $isActive ? 'text-cyan-100' : 'text-slate-400 group-hover:text-slate-300' }}">
                                @if($it['icon'] === 'home')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                @elseif($it['icon'] === 'collection')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                @elseif($it['icon'] === 'credit-card')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                @elseif($it['icon'] === 'search')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                @elseif($it['icon'] === 'chat')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                @elseif($it['icon'] === 'users')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                @elseif($it['icon'] === 'user')
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                @endif
                            </span>

                            <!-- Label -->
                            <span class="text-sm font-medium flex-1">{{ $it['label'] }}</span>

                            <!-- Active Indicator -->
                            @if($isActive)
                                <span class="w-2 h-2 rounded-full bg-cyan-200"></span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <!-- Footer -->
        <div class="border-t border-slate-700 px-6 py-4">
            <p class="text-xs text-slate-400 text-center">© 2026 TradersCap</p>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header/Topbar -->
        <header class="flex items-center justify-between px-6 py-5 bg-white border-b border-slate-200 shadow-sm">
            <!-- Left Section: Toggle & Title -->
            <div class="flex items-center gap-5">
                <!-- Mobile Sidebar Toggle -->
                <button id="sidebar-toggle" class="md:hidden p-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 transition-all duration-150 text-slate-600 hover:text-slate-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Page Title -->
                <div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $title ?? 'Dashboard' }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Welcome to TradersCap</p>
                </div>
            </div>

            <!-- Right Section: Controls & User Menu -->
            <div class="flex items-center gap-4">
                <!-- Status Indicator -->
                <div class="hidden lg:flex items-center gap-2 px-3 py-2 rounded-full bg-slate-50">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-600">Online</span>
                </div>

                <!-- Notifications Button -->
                <div class="relative">
                    <button id="notifications-btn" class="p-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-150 relative" title="Notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-rose-600 rounded-full w-5 h-5">3</span>
                    </button>
                    <!-- Notifications Dropdown -->
                    <div id="notifications-menu" class="absolute right-0 mt-2 w-80 bg-white rounded-xl border border-slate-200 shadow-lg opacity-0 invisible transition-all duration-200 z-50" style="pointer-events: none;">
                        <div class="border-b border-slate-200 px-4 py-3">
                            <h4 class="text-sm font-semibold text-slate-900">Notifications</h4>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Notification Item 1 -->
                            <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-100">
                                <div class="w-10 h-10 rounded-lg bg-cyan-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900">Plan activated successfully</p>
                                    <p class="text-xs text-slate-500 mt-1">Your new investment plan is now active</p>
                                    <p class="text-xs text-slate-400 mt-2">2 hours ago</p>
                                </div>
                            </a>
                            <!-- Notification Item 2 -->
                            <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-100">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900">Ticket resolved</p>
                                    <p class="text-xs text-slate-500 mt-1">Your support ticket #1024 has been resolved</p>
                                    <p class="text-xs text-slate-400 mt-2">5 hours ago</p>
                                </div>
                            </a>
                            <!-- Notification Item 3 -->
                            <a href="#" class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900">Plan expiring soon</p>
                                    <p class="text-xs text-slate-500 mt-1">Your current plan will expire in 7 days</p>
                                    <p class="text-xs text-slate-400 mt-2">1 day ago</p>
                                </div>
                            </a>
                        </div>
                        <div class="border-t border-slate-200 px-4 py-3">
                            <a href="{{ route('complaints') }}" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all notifications →</a>
                        </div>
                    </div>
                </div>

                <!-- Help Button -->
                <button id="help-btn" class="p-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-150" title="Help & Support">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>

                <!-- Settings Button -->
                <button id="settings-btn" class="p-2.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all duration-150" title="Settings">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                <!-- Divider -->
                <div class="w-px h-6 bg-slate-200"></div>

                <!-- User Profile Section -->
                @php $u = auth()->user(); @endphp
                <div class="flex items-center gap-3">
                    <!-- Avatar -->
                    @php
                        $avatarSrc = null;
                        if ($u && !empty($u->avatar)) {
                            $avatarSrc = str_starts_with($u->avatar, 'http') ? $u->avatar : asset('storage/app/public/' . $u->avatar);
                        }
                    @endphp
                    <div class="relative">
                        <div id="user-avatar-btn" class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-slate-100 hover:ring-cyan-300 transition-all cursor-pointer">
                            @if($avatarSrc)
                                <img src="{{ $avatarSrc }}" alt="avatar" class="w-full h-full object-cover">
                            @else
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($u->email ?? '')) ) }}?s=80&d=identicon" alt="avatar" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white"></span>

                        <!-- User Dropdown Menu -->
                        <div id="user-menu" class="absolute right-0 mt-2 w-56 bg-white rounded-xl border border-slate-200 shadow-lg opacity-0 invisible transition-all duration-200 z-50" style="pointer-events: none;">
                            <div class="px-4 py-3 border-b border-slate-200">
                                <p class="text-sm font-semibold text-slate-900">{{ $u->name ?? 'Guest' }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $u->email ?? 'guest@example.com' }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l-7-4m0 0V5m7 4l7-4" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            </div>
                            <div class="border-t border-slate-200 py-2">
                                <form method="POST" action="{{ route('customerLogout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- User Info (Desktop) -->
                    <div class="hidden sm:block">
                        <div class="text-sm font-semibold text-slate-900">{{ $u->name ?? 'Guest' }}</div>
                        <p class="text-xs text-slate-500">Premium Member</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6 bg-slate-50 flex-1 overflow-auto">
            {{ $slot }}
        </main>
    </div>

    <script>
        (function(){
            // Sidebar toggle
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.getElementById('sidebar');
            var closeBtn = document.getElementById('sidebar-close');
            if(toggle && sidebar){
                toggle.addEventListener('click', function(){
                    sidebar.classList.toggle('hidden');
                });
            }
            if(closeBtn && sidebar){
                closeBtn.addEventListener('click', function(){
                    sidebar.classList.add('hidden');
                });
            }

            // Dropdown Menu Management
            function closeAllMenus() {
                ['notifications-menu', 'user-menu'].forEach(function(menuId) {
                    var menu = document.getElementById(menuId);
                    if (menu) {
                        menu.classList.add('opacity-0', 'invisible');
                        menu.style.pointerEvents = 'none';
                    }
                });
            }

            // Notifications Menu Toggle
            var notificationsBtn = document.getElementById('notifications-btn');
            var notificationsMenu = document.getElementById('notifications-menu');
            if (notificationsBtn && notificationsMenu) {
                notificationsBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var isOpen = !notificationsMenu.classList.contains('opacity-0');
                    closeAllMenus();
                    if (!isOpen) {
                        notificationsMenu.classList.remove('opacity-0', 'invisible');
                        notificationsMenu.style.pointerEvents = 'auto';
                    }
                });
            }

            // User Menu Toggle
            var userAvatarBtn = document.getElementById('user-avatar-btn');
            var userMenu = document.getElementById('user-menu');
            if (userAvatarBtn && userMenu) {
                userAvatarBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var isOpen = !userMenu.classList.contains('opacity-0');
                    closeAllMenus();
                    if (!isOpen) {
                        userMenu.classList.remove('opacity-0', 'invisible');
                        userMenu.style.pointerEvents = 'auto';
                    }
                });
            }

            // Help Button
            var helpBtn = document.getElementById('help-btn');
            if (helpBtn) {
                helpBtn.addEventListener('click', function() {
                    closeAllMenus();
                    alert('Help & Support feature coming soon! Contact our team for assistance.');
                });
            }

            // Settings Button
            var settingsBtn = document.getElementById('settings-btn');
            if (settingsBtn) {
                settingsBtn.addEventListener('click', function() {
                    closeAllMenus();
                    alert('Settings feature coming soon! Manage your preferences here.');
                });
            }

            // Close menus when clicking outside
            document.addEventListener('click', function(e) {
                var isMenuClick = e.target.closest('#notifications-menu') || 
                                 e.target.closest('#notifications-btn') ||
                                 e.target.closest('#user-menu') ||
                                 e.target.closest('#user-avatar-btn');
                if (!isMenuClick) {
                    closeAllMenus();
                }
            });

            // Close menus with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllMenus();
                }
            });
        })();
    </script>
    </div>

</x-layouts.app>
