<section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <!-- Messages Container -->
    <div class="border-b border-slate-200 px-6 py-4 md:px-8">
        <h2 class="text-sm font-semibold uppercase tracking-[0.08em] text-slate-600">Conversation</h2>
    </div>
    
    <div class="h-96 space-y-3 overflow-y-auto px-6 py-5 md:px-8" wire:poll.3s id="chat-messages">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex gap-3 <?php echo e($m->is_admin ? 'flex-row' : 'flex-row-reverse'); ?>">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full <?php echo e($m->is_admin ? 'bg-cyan-100' : 'bg-slate-200'); ?>">
                        <span class="text-xs font-semibold <?php echo e($m->is_admin ? 'text-cyan-700' : 'text-slate-700'); ?>">
                            <?php echo e(substr($m->user?->name ?? 'U', 0, 1)); ?>

                        </span>
                    </div>
                </div>
                
                <!-- Message Bubble -->
                <div class="flex-1">
                    <div class="flex items-baseline gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->user): ?>
                            <span class="text-xs font-semibold text-slate-900"><?php echo e($m->user->name); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="text-xs text-slate-500"><?php echo e($m->created_at->diffForHumans()); ?></span>
                    </div>
                    <div class="mt-1 rounded-lg px-4 py-3 <?php echo e($m->is_admin ? 'bg-cyan-50' : 'bg-slate-100'); ?>">
                        <p class="text-sm leading-relaxed text-slate-900"><?php echo nl2br(e($m->message)); ?></p>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->attachment): ?>
                            <div class="mt-3 flex items-center text-xs font-semibold text-cyan-600 hover:text-cyan-700">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <a href="<?php echo e(asset('storage/app/public/'.$m->attachment)); ?>" target="_blank" class="ml-1 hover:underline">View attachment</a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    
    <!-- Reply Form -->
    <form wire:submit.prevent="sendMessage" class="border-t border-slate-200 px-6 py-6 md:px-8">
        <div class="mb-4">
            <label for="message" class="block text-sm font-semibold text-slate-900">Your Reply</label>
            <textarea 
                wire:model.defer="message" 
                id="message"
                rows="4" 
                placeholder="Type your message here..."
                class="mt-3 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:outline-none"
            ></textarea>
        </div>
        
        <div class="mb-4">
            <label for="attachment" class="block text-sm font-semibold text-slate-900">Attachment (Optional)</label>
            <input 
                type="file" 
                wire:model="attachment" 
                id="attachment"
                accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx"
                class="mt-3 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border file:border-slate-300 file:bg-white file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-50"
            />
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <p class="mt-2 text-xs text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <div class="flex gap-3">
            <button 
                type="submit" 
                class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95"
            >
                Send Reply
            </button>
            <a 
                href="<?php echo e(route('complaints')); ?>" 
                class="inline-flex items-center justify-center rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50"
            >
                ← Back
            </a>
        </div>
    </form>
</section>

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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/ticket-chat.blade.php ENDPATH**/ ?>