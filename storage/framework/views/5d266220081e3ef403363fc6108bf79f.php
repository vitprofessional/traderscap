<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $title ?? config('app.name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? config('app.name'))]); ?>

<div class="min-h-screen bg-slate-100">
    <!-- Mobile Backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0f172a] text-slate-50 shadow-xl flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0">
        <!-- Logo Section -->
        <div class="px-5 py-5 flex items-center justify-between border-b border-slate-700/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-400 to-cyan-600 flex items-center justify-center shadow-lg flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-white leading-tight"><?php echo e(config('app.name')); ?></h2>
                    <p class="text-[10px] font-semibold tracking-widest text-cyan-400 uppercase">Managed Accounts</p>
                </div>
            </div>
            <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white transition-colors p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700">
            <?php
                $navSections = [
                    'GET STARTED' => [
                        ['route'=>'dashboard','label'=>'Dashboard','icon'=>'home'],
                        ['route'=>'investment-plans','label'=>'Start Here','icon'=>'rocket'],
                        ['route'=>'investment-plans.submit-details','label'=>'Submit MT4/MT5 Details','icon'=>'monitor'],
                        ['route'=>'find-broker','label'=>'Brokers','icon'=>'building'],
                    ],
                    'MANAGE' => [
                        ['route'=>'my-plans','label'=>'My Plan','icon'=>'plan'],
                        ['route'=>'investment-plans','label'=>'Performance','icon'=>'chart','locked'=>false],
                        ['route'=>'my-plans','label'=>'Transactions','icon'=>'transfer'],
                    ],
                    'SUPPORT' => [
                        ['route'=>'complaints','label'=>'Support / Tickets','icon'=>'ticket'],
                        ['route'=>'partners','label'=>'Partners Corner','icon'=>'users'],
                    ],
                    'ACCOUNT' => [
                        ['route'=>'profile','label'=>'Profile & Settings','icon'=>'user'],
                    ],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="mt-5 mb-1.5 px-3 text-[10px] font-bold tracking-widest text-slate-500 uppercase"><?php echo e($section); ?></p>
                <ul class="space-y-0.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isActive = request()->routeIs($it['route'].'*') && !($it['label'] === 'Start Here' && request()->routeIs('dashboard')) && !($it['label'] === 'Submit MT4/MT5 Details');
                            // Refine active check for dashboard specifically
                            if ($it['label'] === 'Dashboard') $isActive = request()->routeIs('dashboard');
                            if ($it['label'] === 'Start Here') $isActive = false;
                            if ($it['label'] === 'Submit MT4/MT5 Details') $isActive = false;
                            $routeUrl = route($it['route']);
                            $locked = $it['locked'] ?? false;
                        ?>
                        <li>
                            <a href="<?php echo e($locked ? '#' : $routeUrl); ?>" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 <?php echo e($isActive ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-100'); ?> <?php echo e($locked ? 'opacity-60 cursor-not-allowed' : ''); ?>">
                                <span class="flex-shrink-0 w-4 h-4 flex items-center justify-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($it['icon'] === 'home'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    <?php elseif($it['icon'] === 'rocket'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    <?php elseif($it['icon'] === 'monitor'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    <?php elseif($it['icon'] === 'building'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M9 8h1m-1 4h1m4-4h1m-1 4h1M3 21V7a2 2 0 012-2h4v16M13 21V11a2 2 0 012-2h4a2 2 0 012 2v10"/></svg>
                                    <?php elseif($it['icon'] === 'plan'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                    <?php elseif($it['icon'] === 'chart'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                    <?php elseif($it['icon'] === 'transfer'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/></svg>
                                    <?php elseif($it['icon'] === 'ticket'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    <?php elseif($it['icon'] === 'users'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    <?php elseif($it['icon'] === 'user'): ?>
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                                <span class="text-sm font-medium flex-1 leading-none"><?php echo e($it['label']); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($locked): ?>
                                    <svg class="w-3.5 h-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                <?php elseif($isActive): ?>
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-200 flex-shrink-0"></span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>

        <!-- Invite & Earn Card -->
        <div class="mx-3 mb-4 mt-2 rounded-xl bg-gradient-to-br from-cyan-600 to-cyan-800 p-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-white">Invite & Earn</p>
                    <p class="text-[10px] text-cyan-100">Earn up to 20% commission by referring new clients.</p>
                </div>
            </div>
            <a href="<?php echo e(route('partners')); ?>" class="mt-1 flex items-center justify-center gap-2 w-full rounded-lg bg-white/20 hover:bg-white/30 transition-colors px-3 py-2 text-xs font-semibold text-white">
                Learn More
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex flex-col min-h-screen md:pl-64">
        <!-- Header/Topbar -->
        <?php
            $topUser = auth()->user();
            $topAvatarSrc = null;
            if ($topUser && !empty($topUser->avatar)) {
                $topAvatarPath = preg_replace('#^(storage/app/public|public)/#', '', $topUser->avatar);

                if (str_starts_with($topUser->avatar, 'http')) {
                    $topAvatarSrc = $topUser->avatar;
                } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($topAvatarPath)) {
                    $topAvatarSrc = \Illuminate\Support\Facades\Storage::disk('public')->url($topAvatarPath);
                }
            }
            $topAvatarFallback = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($topUser->email ?? ''))) . '?s=80&d=identicon';
            $currentPage = $title ?? 'Dashboard';
        ?>
        <header class="sticky top-0 z-20 bg-white border-b border-slate-200/80" style="box-shadow: 0 1px 3px 0 rgba(0,0,0,.06), 0 1px 2px -1px rgba(0,0,0,.06);">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6">

                
                <div class="flex items-center gap-3 min-w-0">
                    <button id="sidebar-toggle" class="flex-shrink-0 w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                    </button>

                    
                    <div class="hidden sm:block w-px h-5 bg-slate-200 flex-shrink-0"></div>

                    
                    <div class="hidden sm:flex items-center gap-2 min-w-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-md bg-cyan-600 flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm">
                            <span class="text-slate-400 font-medium"><?php echo e(config('app.name')); ?></span>
                            <svg class="w-3.5 h-3.5 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                            <span class="font-semibold text-slate-800 truncate"><?php echo e($currentPage); ?></span>
                        </div>
                    </div>
                    
                    <span class="sm:hidden text-sm font-bold text-slate-900 truncate"><?php echo e($currentPage); ?></span>
                </div>

                
                <div class="flex items-center gap-1 sm:gap-2">

                    
                    <button class="hidden md:flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 hover:bg-white text-slate-400 hover:text-slate-600 px-3 py-2 text-sm transition-colors mr-1" style="min-width:160px;">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <span class="text-xs font-medium">Search...</span>
                        <kbd class="ml-auto text-[10px] font-mono bg-white border border-slate-200 rounded px-1.5 py-0.5 text-slate-400">⌘K</kbd>
                    </button>

                    
                    <div class="relative">
                        <button id="notifications-btn" class="relative w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                        </button>
                        
                        <div id="notifications-menu" class="absolute right-0 mt-2 w-80 bg-white rounded-2xl border border-slate-200 shadow-2xl opacity-0 invisible transition-all duration-200 z-50" style="pointer-events: none;">
                            <div class="flex items-center justify-between px-4 py-3.5 border-b border-slate-100">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Notifications</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">You have 3 unread messages</p>
                                </div>
                                <span class="text-[11px] font-bold text-cyan-700 bg-cyan-50 border border-cyan-100 px-2 py-0.5 rounded-full">3 new</span>
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                                    ['color'=>'cyan','icon'=>'dollar','title'=>'Plan activated successfully','time'=>'2 hours ago'],
                                    ['color'=>'emerald','icon'=>'check','title'=>'Support ticket #1024 resolved','time'=>'5 hours ago'],
                                    ['color'=>'amber','icon'=>'warn','title'=>'Plan expiring in 7 days','time'=>'1 day ago'],
                                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="flex items-start gap-3 px-4 py-3.5 hover:bg-slate-50 transition-colors group">
                                    <div class="w-9 h-9 rounded-full bg-<?php echo e($notif['color']); ?>-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notif['icon']==='dollar'): ?>
                                            <svg class="w-4 h-4 text-<?php echo e($notif['color']); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <?php elseif($notif['icon']==='check'): ?>
                                            <svg class="w-4 h-4 text-<?php echo e($notif['color']); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <?php else: ?>
                                            <svg class="w-4 h-4 text-<?php echo e($notif['color']); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-800 group-hover:text-slate-900 leading-snug"><?php echo e($notif['title']); ?></p>
                                        <p class="text-xs text-slate-400 mt-0.5"><?php echo e($notif['time']); ?></p>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-cyan-500 flex-shrink-0 mt-1.5"></div>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="border-t border-slate-100 px-4 py-3 flex items-center justify-between">
                                <a href="<?php echo e(route('complaints')); ?>" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 transition-colors">View all notifications →</a>
                                <button class="text-xs text-slate-400 hover:text-slate-600 transition-colors">Mark all read</button>
                            </div>
                        </div>
                    </div>

                    
                    <a href="<?php echo e(route('complaints')); ?>" class="w-9 h-9 flex items-center justify-center rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors" title="Support">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </a>

                    
                    <div class="w-px h-6 bg-slate-200 mx-1 hidden sm:block flex-shrink-0"></div>

                    
                    <div class="relative">
                        <button id="user-avatar-btn" class="flex items-center gap-2.5 rounded-xl pl-1 pr-2.5 py-1 hover:bg-slate-100 transition-colors cursor-pointer group">
                            
                            <div class="relative flex-shrink-0">
                                <div class="w-8 h-8 rounded-full overflow-hidden ring-2 ring-slate-200 group-hover:ring-cyan-400 transition-all">
                                    <img src="<?php echo e($topAvatarSrc ?? $topAvatarFallback); ?>" alt="avatar" class="w-full h-full object-cover">
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                            </div>
                            
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-slate-900 leading-tight"><?php echo e($topUser->name ?? 'Guest'); ?></p>
                                <p class="text-[11px] text-slate-500 leading-tight">Client</p>
                            </div>
                            <svg class="hidden sm:block w-3.5 h-3.5 text-slate-400 group-hover:text-slate-600 transition-colors flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
                        </button>

                        
                        <div id="user-menu" class="absolute right-0 mt-2 w-60 bg-white rounded-2xl border border-slate-200 shadow-2xl opacity-0 invisible transition-all duration-200 z-50" style="pointer-events: none;">
                            
                            <div class="px-4 py-4 border-b border-slate-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full overflow-hidden ring-2 ring-cyan-100 flex-shrink-0">
                                        <img src="<?php echo e($topAvatarSrc ?? $topAvatarFallback); ?>" alt="avatar" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-slate-900 truncate"><?php echo e($topUser->name ?? 'Guest'); ?></p>
                                        <p class="text-xs text-slate-500 truncate"><?php echo e($topUser->email ?? ''); ?></p>
                                        <span class="inline-block mt-0.5 text-[10px] font-bold text-cyan-700 bg-cyan-50 border border-cyan-100 px-1.5 py-0.5 rounded-full">Client</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="py-2 px-1.5">
                                <a href="<?php echo e(route('profile')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </span>
                                    <span class="font-medium">My Profile</span>
                                </a>
                                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    </span>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="<?php echo e(route('complaints')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                    </span>
                                    <span class="font-medium">Support</span>
                                </a>
                            </div>
                            
                            <div class="border-t border-slate-100 py-2 px-1.5">
                                <form method="POST" action="<?php echo e(route('customerLogout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-rose-600 hover:bg-rose-50 transition-colors">
                                        <span class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        </span>
                                        <span class="font-medium">Sign out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-4 sm:p-6 bg-slate-100 flex-1 overflow-auto">
            <?php echo e($slot); ?>

        </main>
    </div>

    <script>
        (function(){
            // Sidebar toggle (works on all screens)
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.getElementById('sidebar');
            var backdrop = document.getElementById('sidebar-backdrop');
            var closeBtn = document.getElementById('sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                if (backdrop) backdrop.classList.remove('hidden');
            }
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                if (backdrop) backdrop.classList.add('hidden');
            }

            if(toggle && sidebar){
                toggle.addEventListener('click', function(){
                    if (sidebar.classList.contains('-translate-x-full')) {
                        openSidebar();
                    } else {
                        // On desktop, keep open; on mobile, close
                        if (window.innerWidth < 768) closeSidebar();
                    }
                });
            }
            if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if(backdrop) backdrop.addEventListener('click', closeSidebar);

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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/components/layouts/dashboard.blade.php ENDPATH**/ ?>