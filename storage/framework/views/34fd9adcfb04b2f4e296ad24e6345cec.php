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
<div class="space-y-6">

    
    <div class="relative rounded-2xl overflow-hidden text-white shadow-xl" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(6,182,212,.06) 1px, transparent 1px), linear-gradient(90deg, rgba(6,182,212,.06) 1px, transparent 1px); background-size: 48px 48px;"></div>
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full opacity-10" style="background: radial-gradient(circle, #22d3ee 0%, transparent 70%);"></div>

        <div class="relative px-8 py-10 lg:px-14 lg:py-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">

                
                <div class="flex-1 min-w-0">
                    <div class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 bg-cyan-500/10 px-3 py-1 mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                        <span class="text-[11px] font-semibold text-cyan-300 uppercase tracking-widest">Managed Forex Accounts</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-extrabold leading-tight tracking-tight text-white">
                        Professional Forex Management
                    </h1>
                    <p class="mt-3 text-base text-slate-300 font-normal max-w-lg leading-relaxed">
                        No upfront payment. We only get paid when you profit.
                    </p>

                    <div class="mt-7 mb-6 h-px w-16 bg-cyan-500/40"></div>

                    <div class="flex flex-wrap gap-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                            ['icon'=>'dollar','label'=>'No Upfront Payment'],
                            ['icon'=>'lock',  'label'=>'Zero Lock-In Periods'],
                            ['icon'=>'trend', 'label'=>'Returns Over 100%'],
                            ['icon'=>'broker','label'=>'Your Preferred Broker'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-2 rounded-full border border-white/10 bg-white/[.07] px-3.5 py-2">
                            <span class="w-6 h-6 rounded-full bg-cyan-500/20 flex items-center justify-center flex-shrink-0">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($feat['icon']==='dollar'): ?>
                                    <svg class="w-3 h-3 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v12M9 9h4.5a1.5 1.5 0 010 3H10a1.5 1.5 0 000 3H15"/></svg>
                                <?php elseif($feat['icon']==='lock'): ?>
                                    <svg class="w-3 h-3 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                                <?php elseif($feat['icon']==='trend'): ?>
                                    <svg class="w-3 h-3 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                                <?php else: ?>
                                    <svg class="w-3 h-3 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M9 8h1m-1 4h1m4-4h1m-1 4h1M3 21V7a2 2 0 012-2h4v16M13 21V11a2 2 0 012-2h4a2 2 0 012 2v10"/></svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                            <span class="text-xs font-medium text-slate-200 whitespace-nowrap"><?php echo e($feat['label']); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="hidden lg:flex flex-col items-center justify-center flex-shrink-0">
                    <div class="relative w-44 h-44">
                        <div class="absolute inset-0 rounded-full border border-cyan-500/20"></div>
                        <div class="absolute inset-4 rounded-full bg-white/5 border border-white/10 flex flex-col items-center justify-center gap-2 px-3">
                            <div class="w-12 h-12 rounded-full bg-cyan-500/15 border border-cyan-500/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                            <p class="text-[10px] font-bold text-slate-300 text-center uppercase tracking-wide leading-snug">Your Funds<br>Stay In Your<br>Broker Account</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <div class="flex items-center gap-3 rounded-xl border border-emerald-200/70 bg-emerald-50 px-5 py-3.5">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <p class="text-sm text-emerald-800 font-medium">We trade on your account with investor (read-only) access. You stay in control. Your funds are safe.</p>
    </div>

    <?php
        $activeStatuses = ['active', 'active_waiting'];
        $hasActivePlan = $userPackages->contains(
            fn ($userPackage) => in_array(strtolower((string) $userPackage->status), $activeStatuses, true)
        );
    ?>


    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        
        <div class="xl:col-span-2 space-y-6">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActivePlan): ?>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                    ['label'=>'Active Plans','value'=>$userPackages->where('status','active')->count(),'color'=>'emerald','icon'=>'check'],
                    ['label'=>'Pending Plans','value'=>$userPackages->where('status','pending')->count(),'color'=>'amber','icon'=>'clock'],
                    ['label'=>'Total Plans','value'=>$userPackages->count(),'color'=>'cyan','icon'=>'bar'],
                    ['label'=>'Completed','value'=>$userPackages->where('status','resolved')->count(),'color'=>'violet','icon'=>'tick'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-xl bg-white border border-slate-200 px-4 py-4 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide"><?php echo e($stat['label']); ?></p>
                        <div class="w-7 h-7 rounded-lg bg-<?php echo e($stat['color']); ?>-50 flex items-center justify-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stat['icon']==='check'): ?>
                                <svg class="w-3.5 h-3.5 text-<?php echo e($stat['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            <?php elseif($stat['icon']==='clock'): ?>
                                <svg class="w-3.5 h-3.5 text-<?php echo e($stat['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <?php elseif($stat['icon']==='bar'): ?>
                                <svg class="w-3.5 h-3.5 text-<?php echo e($stat['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="18" y="3" width="4" height="18"/><rect x="10" y="8" width="4" height="13"/><rect x="2" y="13" width="4" height="8"/></svg>
                            <?php else: ?>
                                <svg class="w-3.5 h-3.5 text-<?php echo e($stat['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?php echo e($stat['value']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $hasActivePlan): ?>
            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900">Choose Your Path</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Select the option that best describes your current situation.</p>
                </div>
                <div class="grid sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                    
                    <div class="p-6 flex flex-col gap-4">
                        <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-cyan-600 bg-cyan-50 border border-cyan-100 rounded-full px-3 py-1 w-fit">I Have a Trading Account</span>
                        <h3 class="text-lg font-bold text-slate-900">Submit MT4/MT5 Details</h3>
                        <p class="text-sm text-slate-500 flex-1">Already have a trading account? Submit your MT4/MT5 details to activate managed trading.</p>
                        <div class="flex items-center justify-center rounded-xl bg-slate-50 h-28">
                            <svg class="w-16 h-16 text-cyan-200" viewBox="0 0 80 60" fill="none"><rect x="4" y="4" width="72" height="52" rx="6" fill="#e0f2fe" stroke="#7dd3fc" stroke-width="2"/><rect x="14" y="14" width="52" height="32" rx="3" fill="white" stroke="#bae6fd" stroke-width="1.5"/><rect x="20" y="20" width="8" height="6" rx="1" fill="#0ea5e9"/><rect x="32" y="20" width="8" height="6" rx="1" fill="#7dd3fc"/><rect x="44" y="20" width="8" height="6" rx="1" fill="#bae6fd"/><circle cx="58" cy="38" r="8" fill="#0ea5e9"/><path d="M54 38l3 3 5-5" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                        </div>
                        <a href="<?php echo e(route('investment-plans.submit-details')); ?>" class="flex items-center justify-center gap-2 w-full rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold px-4 py-3 transition-colors">
                            Submit MT4/MT5 Details
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="flex items-center gap-2 text-xs text-slate-500 hover:text-cyan-600 transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            How to get MT4/MT5 details?
                        </a>
                    </div>

                    
                    <div class="p-6 flex flex-col gap-4">
                        <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-slate-600 bg-slate-50 border border-slate-200 rounded-full px-3 py-1 w-fit">I Don't Have a Trading Account</span>
                        <h3 class="text-lg font-bold text-slate-900">Open Account with Preferred Broker</h3>
                        <p class="text-sm text-slate-500 flex-1">Open a real trading account with our recommended brokers and then submit your MT4/MT5 details.</p>
                        <div class="flex items-center justify-center rounded-xl bg-slate-50 h-28">
                            <svg class="w-16 h-16 text-slate-200" viewBox="0 0 80 60" fill="none"><rect x="4" y="4" width="72" height="52" rx="6" fill="#f1f5f9" stroke="#cbd5e1" stroke-width="2"/><path d="M16 46 L16 14 L40 8 L64 14 L64 46 Z" fill="#e2e8f0" stroke="#94a3b8" stroke-width="1.5"/><rect x="28" y="28" width="24" height="18" rx="2" fill="#cbd5e1"/><path d="M34 28 L34 22 Q40 18 46 22 L46 28" stroke="#94a3b8" stroke-width="1.5" fill="none"/></svg>
                        </div>
                        <a href="<?php echo e(route('find-broker')); ?>" class="flex items-center justify-center gap-2 w-full rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-3 transition-colors">
                            View Recommended Brokers
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="flex items-center gap-2 text-xs text-slate-500 hover:text-cyan-600 transition-colors">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            How to open an account?
                        </a>
                    </div>
                </div>
            </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $hasActivePlan && $packages->isNotEmpty()): ?>
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Our Investment Plans</h2>
                    <a href="<?php echo e(route('investment-plans')); ?>" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">View All Plans <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
                <div class="grid sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-5 flex flex-col gap-2 <?php echo e($pkg->is_recommended ? 'bg-cyan-50' : ''); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pkg->is_recommended): ?>
                            <span class="text-[10px] font-bold text-cyan-700 bg-cyan-100 border border-cyan-200 rounded-full px-2 py-0.5 w-fit">Recommended</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <h3 class="font-bold text-slate-900"><?php echo e($pkg->name); ?></h3>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-extrabold text-slate-900">$<?php echo e(number_format((float) $pkg->price)); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pkg->description): ?>
                        <p class="text-xs text-slate-500 leading-relaxed"><?php echo e(Str::limit($pkg->description, 80)); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(route('investment-plans.request', $pkg)); ?>" class="mt-2 flex items-center justify-center gap-2 rounded-lg <?php echo e($pkg->is_recommended ? 'bg-cyan-600 hover:bg-cyan-700 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800'); ?> text-xs font-semibold px-3 py-2 transition-colors">
                            Get Started
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasActivePlan && $userPackages->isNotEmpty()): ?>
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Your Packages</h2>
                    <a href="<?php echo e(route('investment-plans')); ?>" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">+ Buy more</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50 text-xs text-slate-500 uppercase tracking-wide">
                                <th class="px-5 py-3 text-left font-semibold">Package</th>
                                <th class="px-5 py-3 text-left font-semibold">Status</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $userPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $up): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-5 py-3.5 font-medium text-slate-900"><?php echo e($up->package->name ?? '-'); ?></td>
                                <td class="px-5 py-3.5">
                                    <?php $sc = match($up->status) { 'active'=>'emerald', 'pending'=>'amber', default=>'slate' }; ?>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-<?php echo e($sc); ?>-100 text-<?php echo e($sc); ?>-800"><?php echo e(ucfirst($up->status)); ?></span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="<?php echo e(route('my-plans')); ?>" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">Manage</a>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($up->status === 'active'): ?>
                                        <form method="POST" action="<?php echo e(route('my-plans.cancel', $up)); ?>" class="inline" onsubmit="return confirm('Cancel this package?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700">Cancel</button>
                                        </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Top Recommended Brokers</h2>
                    <a href="<?php echo e(route('find-broker')); ?>" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 flex items-center gap-1">View All <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($topBrokers->isNotEmpty()): ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y divide-slate-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topBrokers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $broker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $brokerLogoUrl = null;

                        if (filled($broker->logo)) {
                            if (filter_var($broker->logo, FILTER_VALIDATE_URL)) {
                                $brokerLogoUrl = $broker->logo;
                            } else {
                                $logoPath = preg_replace('#^(storage/app/public|public/storage|public|storage)/#', '', $broker->logo);
                                $brokerLogoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url(ltrim($logoPath, '/'));
                            }
                        }
                    ?>
                    <div class="p-4 flex flex-col gap-3">
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brokerLogoUrl): ?>
                                <img src="<?php echo e($brokerLogoUrl); ?>" alt="<?php echo e($broker->name); ?>" class="w-8 h-8 rounded-lg object-contain bg-slate-50 border border-slate-100">
                            <?php else: ?>
                                <div class="w-8 h-8 rounded-lg bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-sm"><?php echo e(substr($broker->name,0,1)); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 leading-tight"><?php echo e($broker->name); ?></p>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">Recommended</span>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->min_deposit): ?>
                        <p class="text-xs text-slate-500">Min. Deposit <span class="font-semibold text-slate-800">$<?php echo e(number_format((float) $broker->min_deposit)); ?></span></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($broker->website): ?>
                        <a href="<?php echo e($broker->website); ?>" target="_blank" rel="noopener" class="mt-auto text-center text-xs font-semibold text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg px-3 py-2 transition-colors">Open Account</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php else: ?>
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-slate-500">No brokers available yet.</p>
                    <a href="<?php echo e(route('find-broker')); ?>" class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-cyan-600 hover:text-cyan-700">Find Best Broker <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>


            
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                    ['icon'=>'users','label'=>'Total Investors','value'=>'1,240+'],
                    ['icon'=>'funds','label'=>'Total Funds Managed','value'=>'$2.4M+'],
                    ['icon'=>'roi','label'=>'Avg Monthly ROI','value'=>'7.2%'],
                    ['icon'=>'payout','label'=>'Last Payout','value'=>'Today'],
                    ['icon'=>'support','label'=>'Support Response','value'=>'< 15 min'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-xl bg-white border border-slate-200 px-4 py-4 text-center shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-cyan-50 mx-auto mb-2 flex items-center justify-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($stat['icon']==='users'): ?>
                            <svg class="w-4 h-4 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        <?php elseif($stat['icon']==='funds'): ?>
                            <svg class="w-4 h-4 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                        <?php elseif($stat['icon']==='roi'): ?>
                            <svg class="w-4 h-4 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                        <?php elseif($stat['icon']==='payout'): ?>
                            <svg class="w-4 h-4 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <?php else: ?>
                            <svg class="w-4 h-4 text-cyan-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <p class="text-base font-extrabold text-slate-900"><?php echo e($stat['value']); ?></p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-tight"><?php echo e($stat['label']); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>

        
        <div class="space-y-5">

            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Onboarding Progress</h3>
                    <a href="#" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View Guide</a>
                </div>
                <?php
                    $hasPkgAssigned  = $userPackages->isNotEmpty();
                    $hasMt4Submitted = $userPackages->contains(
                        fn($p) => !empty($p->trading_id) && !empty($p->trading_password)
                    );
                    $isActivated = $hasActivePlan; // already computed above

                    $steps = [
                        ['num'=>1,'label'=>'Choose Path',            'done'=>true],
                        ['num'=>2,'label'=>'Open/Fund Account',      'done'=>$hasPkgAssigned],
                        ['num'=>3,'label'=>'Submit MT4/MT5 Details', 'done'=>$hasMt4Submitted],
                        ['num'=>4,'label'=>'Account Activated',      'done'=>$isActivated],
                    ];
                ?>
                <div class="flex items-start justify-between gap-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col items-center gap-1.5 flex-1 relative">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?>
                        <div class="absolute top-4 left-1/2 w-full h-0.5 <?php echo e($step['done'] ? 'bg-cyan-400' : 'bg-slate-200'); ?>"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold z-10 <?php echo e($step['done'] ? 'bg-cyan-600 text-white' : 'bg-slate-100 text-slate-500 border border-slate-200'); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($step['done']): ?>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            <?php else: ?>
                                <?php echo e($step['num']); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <p class="text-[10px] text-center text-slate-500 leading-tight font-medium"><?php echo e($step['label']); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Account Status</h3>
                    <?php
                        if ($isActivated) {
                            $statusBadgeClass = 'text-emerald-700 bg-emerald-100 border-emerald-200';
                            $statusBadgeText  = 'Active';
                        } elseif ($hasPkgAssigned) {
                            $statusBadgeClass = 'text-amber-700 bg-amber-100 border-amber-200';
                            $statusBadgeText  = 'Pending';
                        } else {
                            $statusBadgeClass = 'text-slate-600 bg-slate-100 border-slate-200';
                            $statusBadgeText  = 'Registered';
                        }
                    ?>
                    <span class="text-[10px] font-bold <?php echo e($statusBadgeClass); ?> border rounded-full px-2.5 py-0.5 uppercase tracking-wide">
                        <?php echo e($statusBadgeText); ?>

                    </span>
                </div>
                <ul class="space-y-3">
                    
                    <li class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            <span class="text-sm text-slate-700">Registration Completed</span>
                        </div>
                    </li>
                    
                    <li class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasMt4Submitted): ?>
                                <span class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                                </span>
                            <?php else: ?>
                                <span class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-sm text-slate-700">MT4/MT5 Details</span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasMt4Submitted): ?>
                            <span class="text-xs font-semibold text-emerald-600">Submitted</span>
                        <?php else: ?>
                            <span class="text-xs text-slate-400">Not Submitted</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                    
                    <li class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActivated): ?>
                                <span class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
                                </span>
                            <?php else: ?>
                                <span class="w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-sm text-slate-700">Activation</span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isActivated): ?>
                            <span class="text-xs font-semibold text-emerald-600">Active</span>
                        <?php else: ?>
                            <span class="text-xs text-slate-400">Pending</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </li>
                </ul>
            </div>

            
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Why Choose Us?</h3>
                <ul class="space-y-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                        ['icon'=>'trophy','color'=>'cyan','title'=>'Performance Driven','desc'=>'We share in the profits we make in your account.'],
                        ['icon'=>'dollar','color'=>'emerald','title'=>'No Upfront Payment','desc'=>'You pay nothing in advance.'],
                        ['icon'=>'lock','color'=>'blue','title'=>'Zero Lock-In Periods','desc'=>'Opt out at any time. You\'re always in control.'],
                        ['icon'=>'trend','color'=>'violet','title'=>'High Growth Potential','desc'=>'Annual returns of over 100%*.'],
                        ['icon'=>'building','color'=>'orange','title'=>'Trade with Your Broker','desc'=>'You can trade with your preferred broker.'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $why): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-<?php echo e($why['color']); ?>-50 border border-<?php echo e($why['color']); ?>-100 flex items-center justify-center flex-shrink-0">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($why['icon']==='trophy'): ?>
                                <svg class="w-4 h-4 text-<?php echo e($why['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9H4.5a2.5 2.5 0 010-5H6"/><path d="M18 9h1.5a2.5 2.5 0 000-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0012 0V2z"/></svg>
                            <?php elseif($why['icon']==='dollar'): ?>
                                <svg class="w-4 h-4 text-<?php echo e($why['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v12M9 9h4.5a1.5 1.5 0 010 3H10a1.5 1.5 0 000 3H15"/></svg>
                            <?php elseif($why['icon']==='lock'): ?>
                                <svg class="w-4 h-4 text-<?php echo e($why['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <?php elseif($why['icon']==='trend'): ?>
                                <svg class="w-4 h-4 text-<?php echo e($why['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                            <?php else: ?>
                                <svg class="w-4 h-4 text-<?php echo e($why['color']); ?>-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M9 8h1m-1 4h1m4-4h1m-1 4h1M3 21V7a2 2 0 012-2h4v16M13 21V11a2 2 0 012-2h4a2 2 0 012 2v10"/></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800"><?php echo e($why['title']); ?></p>
                            <p class="text-xs text-slate-500"><?php echo e($why['desc']); ?></p>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>

            
            <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 text-white p-5">
                <h3 class="text-sm font-bold mb-1">Need Help?</h3>
                <p class="text-xs text-slate-300 mb-4">Our support team is available 24/7 to assist you.</p>
                <a href="<?php echo e(route('complaints.create')); ?>" class="flex items-center justify-center gap-2 w-full rounded-xl bg-white text-slate-900 text-sm font-semibold px-4 py-2.5 hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Open a Ticket
                </a>
            </div>

        </div>
    </div>
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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>