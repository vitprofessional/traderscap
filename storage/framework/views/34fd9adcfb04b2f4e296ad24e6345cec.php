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
    <div class="max-w-6xl w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Welcome back, <?php echo e($user->name ?? 'Customer'); ?></h1>
                <p class="text-sm text-gray-600">Overview of your account and active plans.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('investment-plans')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700">Browse Plans</a>
                <a href="<?php echo e(route('profile')); ?>" class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm">Account</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Active Plans</div>
                <div class="mt-2 text-2xl font-semibold"><?php echo e($userPackages->where('status','active')->count()); ?></div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Next Expiry</div>
                <?php
                    $next = $userPackages->where('status','active')->filter(fn($u)=> $u->ends_at)->sortBy('ends_at')->first();
                ?>
                <div class="mt-2 text-lg"><?php echo e($next && $next->ends_at ? $next->ends_at->toFormattedDateString() : '-'); ?></div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Email</div>
                <div class="mt-2 text-lg"><?php echo e($user->email ?? '-'); ?></div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userPackages->isEmpty()): ?>
            <section class="bg-white p-6 rounded shadow">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="w-12 h-12 flex items-center justify-center bg-indigo-50 rounded-full text-indigo-600">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7v6a4 4 0 004 4h10a4 4 0 004-4V7" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                        </svg>
                    </div>
                    <h2 class="text-center text-2xl font-semibold">Get started in 4 simple steps</h2>
                </div>
                <p class="text-center text-sm text-gray-600 mb-6">Follow these quick steps to begin investing with TradersCap.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <?php
                        $steps = [
                            ['title'=>'Open Trading Account','desc'=>'Open trading account with your preferred broker or choose from our reputed broker lists','icon_class'=>'fa-solid fa-briefcase'],
                            ['title'=>'Fund Your Account','desc'=>'After creating your account, fund your account to start trading.','icon_class'=>'fa-solid fa-wallet'],
                            ['title'=>'Send MT4 Details','desc'=>'When funding is completed, send us your MT4 details to trade on your behalf','icon_class'=>'fa-solid fa-circle-info'],
                            ['title'=>'Watch & Earn','desc'=>'You may watch and enjoy our profitable trading from anywhere','icon_class'=>'fa-solid fa-eye'],
                        ];
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 rounded border bg-white">
                            <div class="flex items-center gap-6">
                                <div class="w-28 h-16 rounded-full border-2 border-indigo-900 flex items-center justify-center bg-white">
                                    <i class="<?php echo e($s['icon_class']); ?> text-indigo-900 text-2xl" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <div class="font-semibold"><?php echo e($s['title']); ?></div>
                                    <div class="text-sm text-gray-600"><?php echo e($s['desc']); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="flex items-center justify-center gap-3">
                    <a href="<?php echo e(route('investment-plans')); ?>" class="px-5 py-3 bg-indigo-600 text-white rounded-md">Start Your Journey</a>
                    <a href="#" class="px-4 py-2 border rounded-md text-sm">Open Trading Account</a>
                </div>
            </section>
        <?php else: ?>
            <div class="bg-white p-4 rounded shadow">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-medium">Your Packages</h2>
                    <a href="<?php echo e(route('investment-plans')); ?>" class="text-sm text-indigo-600 hover:underline">Buy more plans</a>
                </div>

                <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b text-gray-600">
                            <th class="py-3 px-2">Package</th>
                            <th class="py-3 px-2">Starts</th>
                            <th class="py-3 px-2">Ends</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $userPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $up): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-2"><?php echo e($up->package->name ?? '—'); ?></td>
                                <td class="py-3 px-2"><?php echo e($up->starts_at ? $up->starts_at->toFormattedDateString() : '—'); ?></td>
                                <td class="py-3 px-2"><?php echo e($up->ends_at ? $up->ends_at->toFormattedDateString() : '—'); ?></td>
                                <td class="py-3 px-2"><?php echo e(ucfirst($up->status)); ?></td>
                                <td class="py-3 px-2 text-right">
                                    <a href="<?php echo e(route('my-plans')); ?>" class="text-sm text-indigo-600 hover:underline mr-3">Manage</a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($up->status === 'active'): ?>
                                        <form method="POST" action="<?php echo e(route('my-plans.cancel', $up)); ?>" class="inline" onsubmit="return confirm('Cancel this package?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-sm text-red-600">Cancel</button>
                                        </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
                </div>
            </div>
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