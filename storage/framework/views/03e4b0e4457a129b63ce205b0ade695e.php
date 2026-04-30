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
            $avatarSrc = str_starts_with($user->avatar, 'http')
                ? $user->avatar
                : \Illuminate\Support\Facades\Storage::disk('public')->url($avatarPath);
        }

        if (! $avatarSrc) {
            $avatarSrc = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email ?? ''))) . '?s=600&d=identicon';
        }

        $fullName = trim((string) ($user->name ?? ''));
        $nameParts = preg_split('/\s+/', $fullName) ?: [];
        $sureName = count($nameParts) > 1 ? end($nameParts) : ($fullName !== '' ? $fullName : '-');
        $contact = $user->phone ?? $user->contact ?? '-';

        $activeTab = request('tab');
        if (! in_array($activeTab, ['edit', 'password'], true)) {
            if (session('profile_success') || $errors->has('name') || $errors->has('email')) {
                $activeTab = 'edit';
            } elseif (session('password_success') || $errors->passwordUpdate->any() || $errors->has('password') || $errors->has('current_password')) {
                $activeTab = 'password';
            } else {
                $activeTab = null;
            }
        }
    ?>

    <div class="mx-auto w-full max-w-6xl space-y-8 px-2 sm:px-4 lg:px-6">
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
                    </div>

                    <!-- Info Column -->
                    <div class="space-y-6 lg:col-span-2">
                        <!-- Full Name -->
                        <div class="border-b border-slate-200 pb-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Full Name</p>
                            <p class="text-xl font-semibold text-slate-900"><?php echo e($fullName !== '' ? $fullName : 'N/A'); ?></p>
                        </div>

                        <!-- Surname -->
                        <div class="border-b border-slate-200 pb-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Surname</p>
                            <p class="text-xl font-semibold text-slate-900"><?php echo e($sureName !== '' ? $sureName : 'N/A'); ?></p>
                        </div>

                        <!-- Email Address -->
                        <div class="border-b border-slate-200 pb-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Email Address</p>
                            <p class="text-xl font-semibold text-slate-900 break-words"><?php echo e($user->email ?? 'N/A'); ?></p>
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-600 mb-2">Contact Number</p>
                            <p class="text-xl font-semibold text-slate-900"><?php echo e($contact !== '-' ? $contact : 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-wrap gap-3 pt-8 border-t border-slate-200">
                    <a href="<?php echo e(route('profile', ['tab' => 'edit'])); ?>" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                        Edit Profile
                    </a>

                    <a href="<?php echo e(route('profile', ['tab' => 'password'])); ?>" class="inline-flex items-center justify-center rounded-full bg-slate-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-slate-700 active:scale-95">
                        Change Password
                    </a>
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

                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="max-w-2xl space-y-6">
                        <?php echo csrf_field(); ?>

                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-900 mb-2">Full Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="<?php echo e(old('name', $user->name ?? '')); ?>"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-500 transition-all focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                            >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
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
                            <label for="email" class="block text-sm font-semibold text-slate-900 mb-2">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="<?php echo e(old('email', $user->email ?? '')); ?>"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-500 transition-all focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500"
                            >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
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

                        <div class="pt-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95">
                                Save Changes
                            </button>
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