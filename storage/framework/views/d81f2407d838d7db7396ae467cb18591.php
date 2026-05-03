<?php if (isset($component)) { $__componentOriginal1a6cca1fb3b05e19b47840b98800a235 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6cca1fb3b05e19b47840b98800a235 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.dashboard','data' => ['title' => 'Support Tickets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Support Tickets']); ?>
    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Support Tickets</h1>
                    <p class="mt-2 text-sm text-slate-600">Track and manage your support requests with our team.</p>
                </div>
                <a href="<?php echo e(route('complaints.create')); ?>" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    New Ticket
                </a>
            </div>
        </section>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tickets->isEmpty()): ?>
            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-12 shadow-sm text-center md:px-8">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                    <svg class="h-8 w-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p class="text-sm text-slate-600 mb-4">You have no support tickets yet.</p>
                <p class="text-xs text-slate-500 mb-6">Create a ticket to report an issue or contact our support team.</p>
                <a href="<?php echo e(route('complaints.create')); ?>" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                    Create Ticket
                </a>
            </section>
        <?php else: ?>
            <!-- Tickets List -->
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('complaints.show', $t)); ?>" class="group block rounded-2xl border border-slate-200 bg-white px-6 py-6 shadow-sm transition-all hover:border-cyan-300 hover:shadow-md md:px-8">
                        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                            <!-- Left: Ticket Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 uppercase tracking-[0.06em]">
                                        #<?php echo e($t->id); ?>

                                    </span>
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.06em]
                                        <?php if($t->status === 'open'): ?> bg-emerald-100 text-emerald-800
                                        <?php elseif($t->status === 'pending'): ?> bg-amber-100 text-amber-800
                                        <?php else: ?> bg-slate-100 text-slate-800 <?php endif; ?>">
                                        <?php echo e(ucfirst($t->status)); ?>

                                    </span>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 group-hover:text-cyan-700 transition-colors mb-2 line-clamp-2">
                                    <?php echo e($t->subject); ?>

                                </h3>
                                <p class="text-xs text-slate-500"><?php echo e($t->created_at->diffForHumans()); ?></p>
                            </div>

                            <!-- Right: Priority & Arrow -->
                            <div class="flex items-center gap-4 md:flex-col md:items-end">
                                <!-- Priority Badge -->
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.06em]
                                    <?php if($t->priority === 'high'): ?> bg-rose-100 text-rose-800
                                    <?php elseif($t->priority === 'normal'): ?> bg-cyan-100 text-cyan-800
                                    <?php else: ?> bg-slate-100 text-slate-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($t->priority)); ?> Priority
                                </span>
                                <!-- Arrow Icon -->
                                <svg class="h-5 w-5 text-slate-400 group-hover:text-cyan-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/complaints/index.blade.php ENDPATH**/ ?>