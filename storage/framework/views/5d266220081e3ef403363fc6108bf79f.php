<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $title ?? 'TradersCap']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? 'TradersCap')]); ?>

<div class="min-h-screen flex bg-gray-50">
    <aside id="sidebar" class="w-64 bg-indigo-600 text-white shadow-sm hidden md:block">
        <div class="p-4 border-b border-indigo-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold">TradersCap</h2>
            <button id="sidebar-close" class="md:hidden text-white">✕</button>
        </div>

        <nav class="p-4">
            <ul class="space-y-1">
                <?php
                    $items = [
                        ['route'=>'dashboard','label'=>'Dashboard','icon'=>'home'],
                        ['route'=>'my-plans','label'=>'My Plans','icon'=>'collection'],
                        ['route'=>'investment-plans','label'=>'Investment Plans','icon'=>'credit-card'],
                        ['route'=>'complaints','label'=>'Complaints','icon'=>'chat'],
                        ['route'=>'partners','label'=>'Partners Corner','icon'=>'users'],
                        ['route'=>'profile','label'=>'Profile','icon'=>'user'],
                    ];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isActive = request()->routeIs($it['route'].'*');
                        $routeUrl = route($it['route']);
                    ?>

                    <li>
                        <a href="<?php echo e($routeUrl); ?>" class="group flex items-center gap-3 p-2 rounded-md transition-colors duration-150 <?php echo e($isActive ? 'bg-white/10 text-white' : 'text-white/90 hover:bg-white/5'); ?>">
                            <span class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center <?php echo e($isActive ? 'bg-white text-indigo-600' : 'bg-white/5 text-white'); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($it['icon'] === 'home'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.5z"/></svg>
                                <?php elseif($it['icon'] === 'collection'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 7a2 2 0 012-2h14v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                                <?php elseif($it['icon'] === 'credit-card'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="5" width="18" height="12" rx="2"/></svg>
                                <?php elseif($it['icon'] === 'chat'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21 12c0 4.418-4.03 8-9 8-1.224 0-2.387-.2-3.44-.58L3 20l1.58-4.56C3.97 14.39 3 13.25 3 12V7a2 2 0 012-2h14a2 2 0 012 2v5z"/></svg>
                                <?php elseif($it['icon'] === 'users'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM6 11c1.657 0 3-1.343 3-3S7.657 5 6 5 3 6.343 3 8s1.343 3 3 3zM6 13c-2.33 0-7 1.17-7 3.5V20h14v-3.5C13 14.17 8.33 13 6 13z"/></svg>
                                <?php elseif($it['icon'] === 'user'): ?>
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-9 9a9 9 0 0118 0v1H3v-1z"/></svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>

                            <span class="font-medium"><?php echo e($it['label']); ?></span>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="flex items-center justify-between p-4 bg-white border-b">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="md:hidden px-2 py-1 border rounded">☰</button>
                <h3 class="text-lg font-medium"><?php echo e($title ?? 'Dashboard'); ?></h3>
            </div>

            <div class="flex items-center gap-4">
                <?php $u = auth()->user(); ?>
                <div class="flex items-center gap-3">
                    <?php
                        $avatarSrc = null;
                        if ($u && !empty($u->avatar)) {
                            $avatarSrc = str_starts_with($u->avatar, 'http') ? $u->avatar : asset('storage/app/public/' . $u->avatar);
                        }
                    ?>
                    <div class="w-10 h-10 bg-white rounded-full overflow-hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avatarSrc): ?>
                            <img src="<?php echo e($avatarSrc); ?>" alt="avatar" class="w-full h-full object-cover">
                        <?php else: ?>
                            <img src="https://www.gravatar.com/avatar/<?php echo e(md5(strtolower(trim($u->email ?? '')) )); ?>?s=80&d=identicon" alt="avatar" class="w-full h-full object-cover">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="text-sm text-indigo-900">
                        <div class="font-medium"><?php echo e($u->name ?? 'Guest'); ?></div>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="text-xs text-indigo-700 hover:underline">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6 bg-gray-50 flex-1 overflow-auto">
            <?php echo e($slot); ?>

        </main>
    </div>

    <script>
        (function(){
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