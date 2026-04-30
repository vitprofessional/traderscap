<?php if (isset($component)) { $__componentOriginal1a6cca1fb3b05e19b47840b98800a235 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6cca1fb3b05e19b47840b98800a235 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.dashboard','data' => ['title' => 'Investment Plans']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Investment Plans')]); ?>
    <div class="mx-auto w-full max-w-7xl space-y-8 px-2 py-2 sm:px-4 lg:px-6 lg:py-4">
        <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-r from-slate-900 via-slate-800 to-cyan-900 px-5 py-7 shadow-sm md:px-8 md:py-8">
            <div class="absolute -top-14 -right-10 h-36 w-36 rounded-full bg-cyan-300/20 blur-2xl"></div>
            <div class="absolute -bottom-16 -left-8 h-36 w-36 rounded-full bg-sky-300/20 blur-2xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-cyan-200/90">Plan Marketplace</p>
                    <h2 class="mt-1.5 text-2xl font-semibold text-white md:text-3xl">Browse Investment Plans</h2>
                    <p class="mt-2 max-w-xl text-sm text-slate-200/90">Compare packages, explore included facilities, and request activation from one streamlined view.</p>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs sm:text-sm md:min-w-[240px]">
                    <div class="rounded-xl border border-white/15 bg-white/10 px-3 py-3 text-white backdrop-blur">
                        <p class="text-slate-200/90">Available Plans</p>
                        <p class="mt-1 text-base font-semibold"><?php echo e($plans->count()); ?></p>
                    </div>
                    <div class="rounded-xl border border-white/15 bg-white/10 px-3 py-3 text-white backdrop-blur">
                        <p class="text-slate-200">Current Status</p>
                        <p class="mt-1 text-xs font-semibold"><?php echo e(!empty($hasAnyPackage) ? 'Plan selected' : 'No active plan'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plans->isEmpty()): ?>
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-sm text-slate-600">No plans are available right now. Please check back later.</p>
            </div>
        <?php else: ?>
            <?php
                $planCount = $plans->count();
                $featuredPlanId = $planCount ? $plans->values()->get(intdiv(max($planCount - 1, 0), 2))->id : null;
            ?>

            <section class="rounded-3xl border border-slate-200 bg-white px-5 py-6 shadow-sm md:px-8 md:py-8">
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-semibold text-slate-900">Pricing Plans</h3>
                    <p class="mt-2 text-sm text-slate-600">Transparent pricing with clearly defined facilities and duration.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 lg:gap-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isFeatured = $featuredPlanId === $plan->id;
                            $isCurrentPlan = isset($currentPackageId) && (int) $currentPackageId === (int) $plan->id;
                            $facilities = is_array($plan->facilities) ? $plan->facilities : [];
                            $buttonLabel = 'GET STARTED';

                            if (!empty($hasAnyPackage)) {
                                $buttonLabel = (isset($currentPackagePrice) && (float) $plan->price < (float) $currentPackagePrice)
                                    ? 'DOWNGRADE'
                                    : 'UPGRADE';
                            }

                            // Format price: show normal number if < 1000, else show k format (e.g., 1k, 1.5k)
                            if ($plan->price < 1000) {
                                $formattedPrice = number_format($plan->price, 0);
                            } else {
                                $priceInK = $plan->price / 1000;
                                // Remove trailing zeros and decimal point if not needed
                                $formattedPrice = rtrim(rtrim(number_format($priceInK, 1), '0'), '.') . 'k';
                            }
                        ?>

                        <article class="flex h-full flex-col overflow-hidden rounded-[22px] border border-slate-100 bg-white shadow-[0_14px_35px_rgba(15,23,42,0.08)] transition-transform duration-200 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(15,23,42,0.12)] <?php echo e($isFeatured ? 'ring-2 ring-cyan-500/20' : ''); ?>">
                            <div class="bg-white px-5 pt-8 pb-6 text-center md:px-7">
                                <div class="mb-3 flex flex-wrap items-center justify-center gap-2">
                                    <h4 class="text-2xl font-bold tracking-tight text-slate-900"><?php echo e($plan->name); ?></h4>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isFeatured): ?>
                                        <span class="inline-flex items-center rounded-full bg-orange-500 px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-[0.2em] text-white shadow-sm">Recommended</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCurrentPlan): ?>
                                    <div class="mx-auto mb-3 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.2em] text-emerald-700 ring-1 ring-emerald-200">Current Plan</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 px-5 py-8 text-center text-white md:px-7">
                                <div class="leading-none">
                                    <span class="text-4xl font-black tracking-tighter">$</span><span class="text-5xl font-black tracking-tighter"><?php echo e($formattedPrice); ?></span>
                                </div>
                                <div class="mt-1 text-sm font-semibold text-white/95">Min</div>
                                <div class="mt-2 text-xs font-medium text-white/85">/ <?php echo e((int) $plan->duration_days); ?> days</div>
                            </div>

                            <div class="border-b border-slate-100 px-5 py-5 text-center md:px-7">
                                <p class="text-sm leading-6 text-slate-500">
                                    <?php echo e($plan->description ?: 'A flexible plan designed to help you grow with confidence.'); ?>

                                </p>
                            </div>

                            <div class="flex flex-1 flex-col px-5 py-6 md:px-7">
                                <ul class="space-y-2.5 text-sm leading-5 text-slate-600">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li class="flex items-start gap-2">
                                            <span class="mt-0.5 flex-shrink-0 text-sm leading-none text-slate-400">-</span>
                                            <span class="text-slate-700"><?php echo e($facility); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li class="text-sm text-slate-500">No facilities listed</li>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>

                                <div class="mt-auto pt-7">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCurrentPlan): ?>
                                        <div class="w-full rounded-full bg-slate-100 px-5 py-3 text-center text-[11px] font-bold uppercase tracking-[0.12em] text-slate-600">
                                            Active Package
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('investment-plans.request', $plan)); ?>" class="inline-flex w-full items-center justify-center rounded-full bg-rose-600 px-5 py-3 text-[11px] font-extrabold uppercase tracking-[0.12em] text-white shadow-lg shadow-rose-600/30 transition-all duration-200 hover:bg-rose-700 hover:shadow-lg hover:shadow-rose-600/40 active:scale-95">
                                            <?php echo e($buttonLabel); ?>

                                        </a>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>

            <?php
                $steps = [
                    ['number' => '01', 'title' => 'Discover', 'points' => ['Determine your financial goals', 'Identify your risk profile']],
                    ['number' => '02', 'title' => 'Propose', 'points' => ['Pick the right package level', 'Match facilities with your objectives']],
                    ['number' => '03', 'title' => 'Implement', 'points' => ['Submit your trading details', 'Your plan moves to pending verification']],
                    ['number' => '04', 'title' => 'Guide', 'points' => ['Receive regular plan updates', 'Renew or adjust as needed']],
                ];
            ?>

            <section class="rounded-3xl border border-slate-200 bg-white px-5 py-6 shadow-sm md:px-8 md:py-8">
                <div class="mb-8 text-center">
                    <h3 class="text-3xl font-semibold text-slate-800">Four Step Investment Planning Process</h3>
                    <p class="mt-2 text-sm text-slate-600">A clear framework to select, activate, and manage your investment package.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4 xl:gap-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-200 px-5 py-3 text-2xl font-semibold text-slate-900"><?php echo e($step['number']); ?></div>
                            <div class="bg-cyan-700 px-5 py-4 text-3xl font-semibold leading-none text-white"><?php echo e($step['title']); ?></div>
                            <div class="p-5">
                                <ul class="space-y-2 text-sm text-slate-700">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $step['points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="flex items-start gap-2">
                                            <span class="mt-1 h-1.5 w-1.5 rounded-full bg-cyan-700"></span>
                                            <span><?php echo e($point); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
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




<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/investment-plans.blade.php ENDPATH**/ ?>