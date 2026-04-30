<?php if (isset($component)) { $__componentOriginal1a6cca1fb3b05e19b47840b98800a235 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6cca1fb3b05e19b47840b98800a235 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.dashboard','data' => ['title' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
                    <p class="mt-2 text-sm text-slate-600">Overview of your investment plans and portfolio status.</p>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a href="<?php echo e(route('investment-plans')); ?>" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                        Browse Plans
                    </a>
                    <a href="<?php echo e(route('profile')); ?>" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50">
                        Account Settings
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Active Plans Card -->
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-emerald-50 to-white px-6 py-8 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600">Active Plans</p>
                        <p class="mt-3 text-4xl font-bold text-emerald-700"><?php echo e($userPackages->where('status','active')->count()); ?></p>
                        <p class="mt-2 text-xs text-slate-600">Currently active</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100">
                        <svg class="h-6 w-6 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Plans Card -->
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-amber-50 to-white px-6 py-8 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600">Pending Plans</p>
                        <p class="mt-3 text-4xl font-bold text-amber-700"><?php echo e($userPackages->where('status','pending')->count()); ?></p>
                        <p class="mt-2 text-xs text-slate-600">Awaiting activation</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                        <svg class="h-6 w-6 text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Plans Card -->
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-cyan-50 to-white px-6 py-8 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600">Total Plans</p>
                        <p class="mt-3 text-4xl font-bold text-cyan-700"><?php echo e($userPackages->count()); ?></p>
                        <p class="mt-2 text-xs text-slate-600">All-time portfolio</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-cyan-100">
                        <svg class="h-6 w-6 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Resolved Plans Card -->
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-rose-50 to-white px-6 py-8 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600">Resolved Plans</p>
                        <p class="mt-3 text-4xl font-bold text-rose-700"><?php echo e($userPackages->where('status','resolved')->count()); ?></p>
                        <p class="mt-2 text-xs text-slate-600">Completed</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-100">
                        <svg class="h-6 w-6 text-rose-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userPackages->isEmpty()): ?>
            <!-- Onboarding Section -->
            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-10 shadow-sm md:px-8">
                <div class="mb-8 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-cyan-100">
                        <svg class="h-8 w-8 text-cyan-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900">Get Started in 4 Simple Steps</h2>
                    <p class="mt-2 text-sm text-slate-600">Follow these quick steps to begin investing with TradersCap.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    <?php
                        $steps = [
                            ['title'=>'Open Trading Account','desc'=>'Open trading account with your preferred broker or choose from our reputed broker lists','icon_class'=>'fa-solid fa-briefcase'],
                            ['title'=>'Fund Your Account','desc'=>'After creating your account, fund your account to start trading.','icon_class'=>'fa-solid fa-wallet'],
                            ['title'=>'Send MT4 Details','desc'=>'When funding is completed, send us your MT4 details to trade on your behalf','icon_class'=>'fa-solid fa-circle-info'],
                            ['title'=>'Watch & Earn','desc'=>'You may watch and enjoy our profitable trading from anywhere','icon_class'=>'fa-solid fa-eye'],
                        ];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-6">
                            <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100">
                                <span class="text-sm font-bold text-cyan-600"><?php echo e($i + 1); ?></span>
                            </div>
                            <h3 class="font-semibold text-slate-900"><?php echo e($s['title']); ?></h3>
                            <p class="mt-2 text-sm text-slate-600"><?php echo e($s['desc']); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="<?php echo e(route('investment-plans')); ?>" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-8 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                        Start Your Journey
                    </a>
                    <a href="#" class="inline-flex items-center justify-center rounded-full border border-slate-300 px-8 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50">
                        Open Trading Account
                    </a>
                </div>
            </section>
        <?php else: ?>
            <!-- Your Packages Section -->
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-slate-900">Your Packages</h2>
                        <a href="<?php echo e(route('investment-plans')); ?>" class="text-sm font-semibold text-cyan-600 hover:text-cyan-700">Buy more plans</a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Package</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Starts</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Ends</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-right font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $userPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $up): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="border-b border-slate-200 transition-colors hover:bg-slate-50">
                                    <td class="px-6 py-4 font-medium text-slate-900"><?php echo e($up->package->name ?? '—'); ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?php echo e($up->starts_at ? $up->starts_at->format('M d, Y') : '—'); ?></td>
                                    <td class="px-6 py-4 text-slate-600"><?php echo e($up->ends_at ? $up->ends_at->format('M d, Y') : '—'); ?></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.08em] <?php echo e($up->status === 'active' ? 'bg-emerald-100 text-emerald-800' : ($up->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700')); ?>">
                                            <?php echo e(ucfirst($up->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="<?php echo e(route('my-plans')); ?>" class="text-sm font-semibold text-cyan-600 hover:text-cyan-700">Manage</a>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($up->status === 'active'): ?>
                                                <form method="POST" action="<?php echo e(route('my-plans.cancel', $up)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to cancel this package?');">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-700">Cancel</button>
                                                </form>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Quick Actions Section -->
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-lg font-semibold text-slate-900">Quick Access</h2>
                </div>
                <div class="grid grid-cols-1 gap-6 px-6 py-8 sm:grid-cols-2 lg:grid-cols-4 md:px-8">
                    <!-- Support & Complaints -->
                    <a href="<?php echo e(route('complaints')); ?>" class="group rounded-xl border border-slate-200 bg-gradient-to-br from-blue-50 to-white p-6 transition-all hover:border-blue-300 hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 transition-colors group-hover:bg-blue-200">
                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-slate-900 transition-colors group-hover:text-blue-700">Support Tickets</h3>
                        <p class="mt-2 text-sm text-slate-600">Create and manage support tickets for assistance</p>
                    </a>

                    <!-- Partners Corner -->
                    <a href="<?php echo e(route('partners')); ?>" class="group rounded-xl border border-slate-200 bg-gradient-to-br from-purple-50 to-white p-6 transition-all hover:border-purple-300 hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 transition-colors group-hover:bg-purple-200">
                            <svg class="h-6 w-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-slate-900 transition-colors group-hover:text-purple-700">Partners Corner</h3>
                        <p class="mt-2 text-sm text-slate-600">Explore partnership opportunities and affiliations</p>
                    </a>

                    <!-- My Plans -->
                    <a href="<?php echo e(route('my-plans')); ?>" class="group rounded-xl border border-slate-200 bg-gradient-to-br from-green-50 to-white p-6 transition-all hover:border-green-300 hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 transition-colors group-hover:bg-green-200">
                            <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-slate-900 transition-colors group-hover:text-green-700">My Plans</h3>
                        <p class="mt-2 text-sm text-slate-600">View and manage all your investment packages</p>
                    </a>

                    <!-- Browse Plans -->
                    <a href="<?php echo e(route('investment-plans')); ?>" class="group rounded-xl border border-slate-200 bg-gradient-to-br from-orange-50 to-white p-6 transition-all hover:border-orange-300 hover:shadow-md">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 transition-colors group-hover:bg-orange-200">
                            <svg class="h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-slate-900 transition-colors group-hover:text-orange-700">Browse Plans</h3>
                        <p class="mt-2 text-sm text-slate-600">Explore more investment plans and packages</p>
                    </a>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <script>
        // small helper to stop accidental form double submits
        document.addEventListener('submit', function(e){
            const form = e.target;
            if(form.getAttribute('data-prevent-double')){
                const btn = form.querySelector('button[type=submit]');
                if(btn) btn.disabled = true;
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a6cca1fb3b05e19b47840b98800a235)): ?>
<?php $attributes = $__attributesOriginal1a6cca1fb3b05e19b47840b98800a235; ?>
<?php unset($__attributesOriginal1a6cca1fb3b05e19b47840b98800a235); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a6cca1fb3b05e19b47840b98800a235)): ?>
<?php $component = $__componentOriginal1a6cca1fb3b05e19b47840b98800a235; ?>
<?php unset($__componentOriginal1a6cca1fb3b05e19b47840b98800a235); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>