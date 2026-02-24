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

    <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:28px 30px;">
        <h1 style="margin:0; font-size:42px; line-height:1.1; font-weight:700; color:#111827;">My Profile</h1>

        <div style="display:flex; gap:36px; align-items:flex-start; margin-top:24px;">
            <div style="flex:0 0 320px; width:320px;">
                <div style="width:320px; height:320px; overflow:hidden; border-radius:14px; background:#f3f4f6;">
                    <img src="<?php echo e($avatarSrc); ?>" alt="Profile photo" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
            </div>

            <div style="flex:1; min-width:0;">
                <div style="display:flex; flex-direction:column;">
                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Full Name</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;"><?php echo e($fullName !== '' ? $fullName : 'N/A'); ?></p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Surname</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;"><?php echo e($sureName !== '' ? $sureName : 'N/A'); ?></p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0; border-bottom:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Email Address</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70; word-break:break-word;"><?php echo e($user->email ?? 'N/A'); ?></p>
                    </div>

                    <div style="display:grid; grid-template-columns:140px 1fr; align-items:center; gap:22px; padding:18px 0;">
                        <p style="margin:0; font-size:14px; font-weight:700; color:#0b1b70;">Contact Number</p>
                        <p style="margin:0; font-size:22px; line-height:1.3; color:#0b1b70;"><?php echo e($contact !== '-' ? $contact : 'N/A'); ?></p>
                    </div>
                </div>

                <div style="display:flex; gap:16px; align-items:center; margin-top:26px; flex-wrap:wrap;">
                    <a href="<?php echo e(route('profile', ['tab' => 'edit'])); ?>" style="display:inline-flex; align-items:center; padding:11px 18px; border-radius:14px; background:#3b82f6; color:#fff; text-decoration:none; font-size:16px; line-height:1; font-weight:600;">
                        Edit Profile
                    </a>

                    <a href="<?php echo e(route('profile', ['tab' => 'password'])); ?>" style="display:inline-flex; align-items:center; padding:11px 18px; border-radius:14px; background:#6b7280; color:#fff; text-decoration:none; font-size:16px; line-height:1; font-weight:600;">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'edit'): ?>
        <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px 30px; margin-top:20px;">
            <h2 style="margin:0 0 16px 0; font-size:24px; font-weight:700; color:#111827;">Edit Profile</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('profile_success')): ?>
                <div style="margin-bottom:14px; padding:10px 12px; border-radius:8px; border:1px solid #a7f3d0; background:#ecfdf5; color:#065f46; font-size:14px;">
                    <?php echo e(session('profile_success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('profile.update')); ?>" style="display:grid; gap:14px; max-width:620px;">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="name" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="<?php echo e(old('name', $user->name ?? '')); ?>"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label for="email" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?php echo e(old('email', $user->email ?? '')); ?>"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div style="padding-top:4px;">
                    <button type="submit" style="display:inline-flex; align-items:center; padding:11px 18px; border:0; border-radius:10px; background:#2563eb; color:#fff; font-size:15px; font-weight:600; cursor:pointer;">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($activeTab === 'password'): ?>
        <div style="width:100%; background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px 30px; margin-top:20px;">
            <h2 style="margin:0 0 16px 0; font-size:24px; font-weight:700; color:#111827;">Change Password</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('password_success')): ?>
                <div style="margin-bottom:14px; padding:10px 12px; border-radius:8px; border:1px solid #a7f3d0; background:#ecfdf5; color:#065f46; font-size:14px;">
                    <?php echo e(session('password_success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('profile.password.update')); ?>" style="display:grid; gap:14px; max-width:620px;">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="current_password" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Current Password</label>
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->passwordUpdate->has('current_password')): ?>
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;"><?php echo e($errors->passwordUpdate->first('current_password')); ?></p>
                    <?php elseif($errors->has('current_password')): ?>
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;"><?php echo e($errors->first('current_password')); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label for="password" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">New Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="margin:6px 0 0 0; font-size:13px; color:#dc2626;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div>
                    <label for="password_confirmation" style="display:block; margin-bottom:6px; font-size:13px; font-weight:600; color:#374151;">Confirm New Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        style="width:100%; padding:11px 12px; border:1px solid #d1d5db; border-radius:8px; font-size:15px; color:#111827;"
                    >
                </div>

                <div style="padding-top:4px;">
                    <button type="submit" style="display:inline-flex; align-items:center; padding:11px 18px; border:0; border-radius:10px; background:#4b5563; color:#fff; font-size:15px; font-weight:600; cursor:pointer;">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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