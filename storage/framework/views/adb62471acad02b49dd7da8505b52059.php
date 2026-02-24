<div class="max-w-3xl w-full">

    <div class="bg-white p-4 rounded shadow mb-4 h-96 overflow-y-auto" wire:poll.3s id="chat-messages">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-3 p-3 rounded <?php echo e($m->is_admin ? 'bg-indigo-50 text-indigo-900' : 'bg-gray-50'); ?>">
                <div class="text-sm text-gray-700"><?php echo nl2br(e($m->message)); ?></div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->attachment): ?>
                    <div class="mt-2">
                        <a href="<?php echo e(asset('storage/app/public/'.$m->attachment)); ?>" target="_blank" class="text-sm text-indigo-600 hover:underline">View attachment</a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="text-xs text-gray-500 mt-2"><?php echo e($m->created_at->diffForHumans()); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->user): ?> • <?php echo e($m->user->name); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <form wire:submit.prevent="sendMessage">
        <div class="mb-3">
            <textarea wire:model.defer="message" rows="3" class="w-full border rounded p-2" placeholder="Write a message..."></textarea>
        </div>
        <div class="mb-3">
            <input type="file" wire:model="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" />
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-sm text-red-600"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Send</button>
            <a href="<?php echo e(route('complaints')); ?>" class="px-4 py-2 border rounded">Back</a>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:load', function () {
            const container = document.getElementById('chat-messages');
            function scrollBottom() { container.scrollTop = container.scrollHeight; }
            scrollBottom();
            Livewire.hook('message.processed', (component) => {
                scrollBottom();
            });
            Livewire.on('ticketMessageSent', scrollBottom);
        });
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/ticket-chat.blade.php ENDPATH**/ ?>