<?php if (isset($component)) { $__componentOriginal1a6cca1fb3b05e19b47840b98800a235 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6cca1fb3b05e19b47840b98800a235 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.dashboard','data' => ['title' => 'Profile']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Profile']); ?>
    <?php
        $avatarSrc = null;
        if (!empty($user?->avatar)) {
            $avatarPath = preg_replace('#^(storage/app/public|public)/#', '', $user->avatar);

            if (str_starts_with($user->avatar, 'http')) {
                $avatarSrc = $user->avatar;
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($avatarPath)) {
                $avatarSrc = \Illuminate\Support\Facades\Storage::disk('public')->url($avatarPath);
            }
        }

        if (! $avatarSrc) {
            $avatarSrc = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email ?? ''))) . '?s=600&d=identicon';
        }

        $fullName  = trim((string) ($user->name ?? ''));
        $nameParts = preg_split('/\s+/', $fullName) ?: [];
        $firstName = $nameParts[0] ?? '';
        $lastName  = count($nameParts) > 1 ? trim(implode(' ', array_slice($nameParts, 1))) : '';

        $status = ($hasActivePlan ?? false) ? 'active' : (string) ($user->status ?? 'registered');
        $statusLabel = ucfirst(str_replace('_', ' ', $status));
        $statusBadgeClass = match ($status) {
            'active'        => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'active_waiting'=> 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'pending'       => 'bg-amber-100  text-amber-700  border-amber-200',
            'expired'       => 'bg-rose-100   text-rose-700   border-rose-200',
            default         => 'bg-slate-100  text-slate-700  border-slate-200',
        };

        $emailVerified = ! empty($user?->email_verified_at);
        $memberSince   = optional($user?->created_at)->format('M d, Y') ?? 'N/A';
        $phoneDisplay  = $user->phone ?? null;
        $countryName   = $user->country?->name ?? null;

        $activeTab = request('tab');
        if (! in_array($activeTab, ['edit', 'password'], true)) {
            if (session('profile_success') || session('avatar_success')
                || $errors->hasAny(['first_name', 'last_name', 'email', 'phone', 'country_id', 'avatar'])) {
                $activeTab = 'edit';
            } elseif (session('password_success') || $errors->passwordUpdate->any() || $errors->has('password') || $errors->has('current_password')) {
                $activeTab = 'password';
            } else {
                $activeTab = null;
            }
        }
    ?>

    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->pending_email): ?>
            <div class="flex flex-wrap items-start gap-4 rounded-2xl border border-sky-300 bg-sky-50 px-6 py-5 shadow-sm">
                <div class="flex-shrink-0 rounded-full bg-sky-100 p-2">
                    <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-sky-900">Email change pending verification</p>
                    <p class="mt-0.5 text-xs text-sky-700">
                        A confirmation link was sent to <span class="font-semibold"><?php echo e($user->pending_email); ?></span>.
                        Your email will only be updated after you click the link.
                    </p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('resend_success')): ?>
                        <p class="mt-1.5 text-xs font-semibold text-emerald-700">✓ <?php echo e(session('resend_success')); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex flex-shrink-0 flex-wrap gap-2">
                    <form method="POST" action="<?php echo e(route('verification.email-change.resend')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-sky-400 bg-sky-100 px-4 py-2 text-xs font-semibold text-sky-900 transition hover:bg-sky-200 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-1">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Resend
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('verification.email-change.cancel')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50 hover:border-slate-400 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-1">
                            Cancel Change
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $emailVerified): ?>
            <div class="flex flex-wrap items-start gap-4 rounded-2xl border border-amber-300 bg-amber-50 px-6 py-5 shadow-sm">
                <div class="flex-shrink-0 rounded-full bg-amber-100 p-2">
                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-amber-900">Please verify your email address</p>
                    <p class="mt-0.5 text-xs text-amber-700">A verification link was sent to <span class="font-semibold"><?php echo e($user->email); ?></span>. Check your inbox (and spam folder).</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('resend_success')): ?>
                        <p class="mt-1.5 text-xs font-semibold text-emerald-700">✓ <?php echo e(session('resend_success')); ?></p>
                    <?php elseif(session('resend_info')): ?>
                        <p class="mt-1.5 text-xs font-semibold text-sky-700"><?php echo e(session('resend_info')); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <form method="POST" action="<?php echo e(route('verification.send')); ?>" class="flex-shrink-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-amber-400 bg-amber-100 px-4 py-2 text-xs font-semibold text-amber-900 transition hover:bg-amber-200 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-1">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Resend Email
                    </button>
                </form>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Profile Header -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <h1 class="text-3xl font-bold text-slate-900">My Profile</h1>
            <p class="mt-2 text-sm text-slate-600">Manage your account information and security settings.</p>
        </section>

        <!-- Profile Information Card -->
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="px-6 py-6 md:px-8">
                <h2 class="text-lg font-semibold text-slate-900 mb-8">Profile Information</h2>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <!-- Avatar Column -->
                    <div class="flex flex-col items-center lg:items-start">
                        <div class="h-48 w-48 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm">
                            <img src="<?php echo e($avatarSrc); ?>" alt="Profile photo" class="h-full w-full object-cover">
                        </div>

                        <form method="POST" action="<?php echo e(route('profile.avatar.update')); ?>" enctype="multipart/form-data" class="mt-4 w-full max-w-xs space-y-3">
                            <?php echo csrf_field(); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('avatar_success')): ?>
                                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2">
                                    <p class="text-xs font-semibold text-emerald-800"><?php echo e(session('avatar_success')); ?></p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <div>
                                <label for="avatar" class="mb-2 block text-xs font-semibold uppercase tracking-[0.08em] text-slate-600">Profile Picture</label>
                                <input
                                    id="avatar"
                                    name="avatar"
                                    type="file"
                                    accept="image/png,image/jpeg,image/webp"
                                    required
                                    class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 file:mr-3 file:cursor-pointer file:rounded-md file:border-0 file:bg-cyan-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:uppercase file:tracking-[0.08em] file:text-white hover:file:bg-cyan-700"
                                >
                                <p class="mt-2 text-xs text-slate-500">JPG, PNG, or WEBP. Min 200x200, max 2MB.</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-rose-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-5 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                                Update Picture
                            </button>
                        </form>
                    </div>

                    <!-- Info Column -->
                    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="sm:col-span-2 border-b border-slate-200 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Full Name</p>
                            <p class="text-xl font-bold text-slate-900"><?php echo e($fullName !== '' ? $fullName : 'N/A'); ?></p>
                        </div>

                        <div class="border-b border-slate-200 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Email Address</p>
                            <p class="text-base font-semibold text-slate-900 break-all"><?php echo e($user->email ?? 'N/A'); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emailVerified): ?>
                                <span class="mt-1.5 inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Verified
                                </span>
                            <?php else: ?>
                                <span class="mt-1.5 inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                    Not Verified
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->pending_email): ?>
                                <p class="mt-2 text-xs text-sky-700">
                                    <span class="font-semibold">Pending:</span> <?php echo e($user->pending_email); ?> — awaiting confirmation
                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="border-b border-slate-200 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Phone Number</p>
                            <p class="text-base font-semibold text-slate-900"><?php echo e($phoneDisplay ?? 'Not set'); ?></p>
                        </div>

                        <div class="border-b border-slate-200 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Country</p>
                            <p class="text-base font-semibold text-slate-900"><?php echo e($countryName ?? 'Not set'); ?></p>
                        </div>

                        <div class="border-b border-slate-200 pb-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Account Status</p>
                            <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm font-semibold <?php echo e($statusBadgeClass); ?>"><?php echo e($statusLabel); ?></span>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500 mb-1">Member Since</p>
                            <p class="text-base font-semibold text-slate-900"><?php echo e($memberSince); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-wrap gap-3 pt-8 border-t border-slate-200">
                    <a href="<?php echo e(route('profile', ['tab' => 'edit'])); ?>"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm ring-1 ring-cyan-600 transition-all hover:bg-cyan-700 hover:ring-cyan-700 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Profile
                    </a>

                    <a href="<?php echo e(route('profile', ['tab' => 'password'])); ?>"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-400 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Change Password
                    </a>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $emailVerified): ?>
                        <a href="<?php echo e(route('verification.notice')); ?>"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-amber-300 bg-amber-50 px-6 py-2.5 text-sm font-semibold text-amber-800 shadow-sm transition-all hover:bg-amber-100 hover:border-amber-400 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-amber-300 focus:ring-offset-2">
                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Verify Email
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Edit Profile Form -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'edit'): ?>
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-lg font-semibold text-slate-900">Edit Profile</h2>
                </div>

                <div class="px-6 py-8 md:px-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('profile_success')): ?>
                        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-semibold text-emerald-800"><?php echo e(session('profile_success')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="max-w-3xl space-y-8">
                        <?php echo csrf_field(); ?>

                        
                        <div class="flex flex-wrap items-center gap-4 rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 font-medium">Status:</span>
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold <?php echo e($statusBadgeClass); ?>"><?php echo e($statusLabel); ?></span>
                            </div>
                            <div class="w-px h-4 bg-slate-300 hidden sm:block"></div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 font-medium">Email:</span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emailVerified): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Verified
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                                        Not Verified
                                    </span>
                                    <a href="<?php echo e(route('verification.notice')); ?>" class="text-xs font-medium text-cyan-600 underline underline-offset-2 hover:text-cyan-700">Verify now</a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="w-px h-4 bg-slate-300 hidden sm:block"></div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-500 font-medium">Member since:</span>
                                <span class="font-semibold text-slate-800"><?php echo e($memberSince); ?></span>
                            </div>
                        </div>

                        
                        <fieldset>
                            <legend class="mb-4 text-xs font-bold uppercase tracking-[0.1em] text-slate-500">Personal Information</legend>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="first_name" class="mb-1.5 block text-sm font-semibold text-slate-800">
                                        First Name <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        id="first_name" name="first_name" type="text"
                                        value="<?php echo e(old('first_name', $firstName)); ?>"
                                        required maxlength="100" autocomplete="given-name"
                                        placeholder="e.g. John"
                                        class="w-full rounded-lg border px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:outline-none focus:ring-2 <?php echo e($errors->has('first_name') ? 'border-rose-400 bg-rose-50 focus:ring-rose-300' : 'border-slate-300 bg-white focus:border-cyan-500 focus:ring-cyan-200'); ?>"
                                    >
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs font-medium text-rose-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label for="last_name" class="mb-1.5 block text-sm font-semibold text-slate-800">Last Name</label>
                                    <input
                                        id="last_name" name="last_name" type="text"
                                        value="<?php echo e(old('last_name', $lastName)); ?>"
                                        maxlength="100" autocomplete="family-name"
                                        placeholder="e.g. Smith"
                                        class="w-full rounded-lg border px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:outline-none focus:ring-2 <?php echo e($errors->has('last_name') ? 'border-rose-400 bg-rose-50 focus:ring-rose-300' : 'border-slate-300 bg-white focus:border-cyan-500 focus:ring-cyan-200'); ?>"
                                    >
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs font-medium text-rose-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </fieldset>

                        
                        <fieldset>
                            <legend class="mb-4 text-xs font-bold uppercase tracking-[0.1em] text-slate-500">Contact Details</legend>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-800">
                                        Email Address <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        id="email" name="email" type="email"
                                        value="<?php echo e(old('email', $user->email ?? '')); ?>"
                                        required maxlength="255" autocomplete="email"
                                        placeholder="you@example.com"
                                        class="w-full rounded-lg border px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:outline-none focus:ring-2 <?php echo e($errors->has('email') ? 'border-rose-400 bg-rose-50 focus:ring-rose-300' : 'border-slate-300 bg-white focus:border-cyan-500 focus:ring-cyan-200'); ?>"
                                    >
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs font-medium text-rose-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->pending_email): ?>
                                        <p class="mt-2 flex items-center gap-1.5 text-xs text-sky-700">
                                            <svg class="h-3.5 w-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z"/></svg>
                                            A change to <span class="font-semibold"><?php echo e($user->pending_email); ?></span> is awaiting email confirmation. Your current email remains active until confirmed.
                                        </p>
                                    <?php else: ?>
                                        <p class="mt-1.5 text-xs text-slate-500">Changing your email will send a verification link to the new address. It will only take effect after confirmation.</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-800">Phone Number</label>
                                    <input
                                        id="phone" name="phone" type="tel"
                                        value="<?php echo e(old('phone', $user->phone ?? '')); ?>"
                                        maxlength="30" autocomplete="tel"
                                        placeholder="+44 7700 900000"
                                        class="w-full rounded-lg border px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:outline-none focus:ring-2 <?php echo e($errors->has('phone') ? 'border-rose-400 bg-rose-50 focus:ring-rose-300' : 'border-slate-300 bg-white focus:border-cyan-500 focus:ring-cyan-200'); ?>"
                                    >
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs font-medium text-rose-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <div>
                                    <label for="country_id" class="mb-1.5 block text-sm font-semibold text-slate-800">Country</label>
                                    <select
                                        id="country_id" name="country_id"
                                        autocomplete="country"
                                        class="w-full rounded-lg border px-4 py-3 text-slate-900 transition focus:outline-none focus:ring-2 <?php echo e($errors->has('country_id') ? 'border-rose-400 bg-rose-50 focus:ring-rose-300' : 'border-slate-300 bg-white focus:border-cyan-500 focus:ring-cyan-200'); ?>"
                                    >
                                        <option value="">— Select country —</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>" <?php echo e(old('country_id', $user->country_id) == $c->id ? 'selected' : ''); ?>>
                                                <?php echo e($c->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1.5 text-xs font-medium text-rose-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </fieldset>

                        <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 pt-6 mt-2">
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-600 px-8 py-2.5 text-sm font-semibold text-white shadow-sm ring-1 ring-cyan-600 transition-all hover:bg-cyan-700 hover:ring-cyan-700 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2">
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Save Changes
                            </button>
                            <a href="<?php echo e(route('profile')); ?>"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-8 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-400 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Change Password Form -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'password'): ?>
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <h2 class="text-lg font-semibold text-slate-900">Change Password</h2>
                </div>

                <div class="px-6 py-8 md:px-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('password_success')): ?>
                        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-semibold text-emerald-800"><?php echo e(session('password_success')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form method="POST" action="<?php echo e(route('profile.password.update')); ?>" class="max-w-2xl space-y-6">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-slate-900 mb-2">Current Password</label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-500 transition-all focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                            >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->passwordUpdate->has('current_password')): ?>
                                <p class="mt-2 text-sm text-rose-600"><?php echo e($errors->passwordUpdate->first('current_password')); ?></p>
                            <?php elseif($errors->has('current_password')): ?>
                                <p class="mt-2 text-sm text-rose-600"><?php echo e($errors->first('current_password')); ?></p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-900 mb-2">New Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-500 transition-all focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                            >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-rose-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-900 mb-2">Confirm New Password</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-500 transition-all focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                            >
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-slate-700 active:scale-95">
                                Update Password
                            </button>
                        </div>
                    </form>
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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/profile.blade.php ENDPATH**/ ?>