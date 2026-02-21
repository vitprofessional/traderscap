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
    <div class="max-w-6xl w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('profile_success')): ?>
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <?php echo e(session('profile_success')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="name" class="block text-sm font-medium text-indigo-800 mb-1">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="<?php echo e(old('name', $user->name ?? '')); ?>"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-indigo-800 mb-1">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="<?php echo e(old('email', $user->email ?? '')); ?>"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-6 py-3 text-base font-semibold text-white hover:bg-indigo-700">
                        Save profile
                    </button>
                </form>

                <div class="my-8 border-t border-gray-300"></div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('password_success')): ?>
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <?php echo e(session('password_success')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('profile.password.update')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-indigo-800 mb-1">Current password</label>
                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->passwordUpdate->has('current_password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($errors->passwordUpdate->first('current_password')); ?></p>
                        <?php elseif($errors->has('current_password')): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($errors->first('current_password')); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-indigo-800 mb-1">New password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-indigo-800 mb-1">Confirm</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="w-full rounded-md border border-indigo-100 bg-white px-4 py-3 text-base text-gray-900 focus:border-indigo-500 focus:outline-none"
                            required
                        >
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-indigo-300 px-6 py-3 text-base font-semibold text-white hover:bg-indigo-400">
                        Change password
                    </button>
                </form>
            </div>

            <div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('avatar_success')): ?>
                    <div class="mb-4 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        <?php echo e(session('avatar_success')); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <h3 class="text-4xl font-semibold text-indigo-950 mb-4">Avatar</h3>

                <div class="w-[180px] h-[180px] rounded-md border border-gray-300 overflow-hidden bg-white mb-8">
                    <?php
                        $avatarSrc = null;
                        if (!empty($user?->avatar)) {
                            $avatarSrc = str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/app/public/' . $user->avatar);
                        }
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($avatarSrc): ?>
                        <img src="<?php echo e($avatarSrc); ?>" alt="Avatar" class="w-full h-full object-cover">
                    <?php else: ?>
                        <img src="https://www.gravatar.com/avatar/<?php echo e(md5(strtolower(trim($user->email ?? '')) )); ?>?s=240&d=identicon" alt="Avatar" class="w-full h-full object-cover">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <form method="POST" action="<?php echo e(route('profile.avatar.update')); ?>" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <div>
                        <input type="file" name="avatar" accept="image/*" class="w-full rounded-md border border-gray-300 bg-white px-4 py-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-md bg-cyan-500 px-6 py-3 text-base font-semibold text-white hover:bg-cyan-600">
                        Upload avatar
                    </button>
                </form>
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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/customer/profile.blade.php ENDPATH**/ ?>