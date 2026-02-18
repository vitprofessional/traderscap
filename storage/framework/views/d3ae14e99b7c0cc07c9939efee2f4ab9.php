<div id="admin-chat-wrapper" class="w-full admin-chat-wrapper">

    <style>
    /* Fallback styles so chat looks correct even if Tailwind isn't available */
    .admin-chat-wrapper{max-width:920px;margin:0 auto;padding:1.5rem}
    .admin-chat-card{background:#fff;border-radius:10px;box-shadow:0 8px 22px rgba(15,23,42,0.07);overflow:hidden}
    .admin-chat-header{padding:16px 20px;border-bottom:1px solid #eef2f6;background:#fbfbfd;display:flex;justify-content:space-between;align-items:center}
    .admin-chat-body{padding:20px;height:60vh;overflow:auto;background:#ffffff}
    .admin-msg-row{display:flex;margin-bottom:10px}
    .admin-msg-row.end{justify-content:flex-end}
    .admin-msg-bubble{padding:14px 16px;border-radius:14px;display:inline-block;max-width:100%}
    .admin-msg-bubble.user{background:#f8fafc;color:#0f172a}
    .admin-msg-bubble.admin{background:#4f46e5;color:#fff}
    .admin-chat-input{padding:16px 20px;border-top:1px solid #eef2f6;background:#fbfbfd;display:flex;gap:14px;align-items:flex-end}
    .admin-chat-input textarea{flex:1;padding:12px;border:1px solid #e6e9ef;border-radius:10px;min-height:72px}
    .admin-chat-input .btn{background:#4f46e5;color:#fff;padding:10px 16px;border-radius:10px;border:none;cursor:pointer}
    .admin-chat-attach{font-size:13px;color:#374151}
    @media(max-width:640px){.admin-chat-wrapper{padding:10px}.admin-chat-body{height:48vh}}
    </style>

    <div class="admin-chat-card bg-white shadow rounded-lg">
        <div class="admin-chat-header p-4 bg-gray-100">
            <div>
                <div class="text-sm font-medium">Ticket ID #<?php echo e($ticket->id ?? ''); ?></div>
                <div class="text-lg text-gray-500">Subject: <?php echo e($ticket->subject ?? 'No subject'); ?></div>
            </div>
            <div class="text-sm text-gray-600">Status: <span class="font-medium"><?php echo e(ucfirst($ticket->status ?? 'open')); ?></span></div>
        </div>

        <div id="admin-chat-messages" wire:poll.3s class="admin-chat-body p-4 bg-white">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $isAdmin = $m->is_admin ?? ($m->admin_id ? true : false); ?>
                <div class="admin-msg-row <?php echo e($isAdmin ? 'end' : ''); ?>">
                    <div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isAdmin): ?>
                            <div style="width:36px;height:36px;border-radius:9999px;background:#eef2f6;display:inline-flex;align-items:center;justify-content:center;margin-right:8px;font-weight:600;color:#0f172a"><?php echo e(strtoupper(substr($m->user?->name ?? 'C',0,1))); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="admin-msg-bubble <?php echo e($isAdmin ? 'admin' : 'user'); ?>"><?php echo nl2br(e($m->message)); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($m->attachment): ?>
                                <div style="margin-top:8px;margin-bottom:0;font-size:13px;"><a href="<?php echo e(asset('storage/app/public/' . $m->attachment)); ?>" target="_blank" style="color:#ffff00;text-decoration:underline">View attachment</a></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div style="font-size:12px;color:#6b7280;margin-top:6px;<?php echo e($isAdmin ? 'text-align:right' : ''); ?>"><?php echo e($m->created_at->diffForHumans()); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isAdmin && $m->user): ?> • <?php echo e($m->user->name); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="admin-chat-input">
            <form wire:submit.prevent="sendMessage" style="display:flex;flex:1;gap:12px;align-items:flex-end;width:100%">
                <textarea wire:model.defer="message" required placeholder="Write a message..." style="flex:1;border-radius:8px;border:1px solid #e6e9ef;padding:10px;min-height:60px"></textarea>
                <div style="display:flex;flex-direction:column;gap:8px;align-items:flex-end">
                    <div style="display:flex;gap:8px;align-items:center">
                        <label class="admin-chat-attach" title="Attach file" style="cursor:pointer;padding:8px 10px;border-radius:8px;background:#fff;border:1px solid #e6e9ef;display:inline-flex;align-items:center;gap:8px">
                            <span class="icon attach-icon" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.6 19.9a4.5 4.5 0 01-6.36-6.36l8.84-8.84a3.5 3.5 0 014.95 4.95L11.2 18.3a2 2 0 01-2.83-2.83l8.49-8.49"/></svg>
                            </span>
                            <span class="text-sm" style="font-size:13px;color:#374151">Attach</span>
                            <input type="file" wire:model="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" style="display:none" />
                        </label>

                        <button id="icon-style-toggle" title="Toggle icon style" type="button" style="background:#fff;border:1px solid #e6e9ef;padding:8px;border-radius:8px;display:inline-flex;align-items:center">
                            <span class="icon-toggle" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                            </span>
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-sm text-red-600"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <button type="submit" class="btn send-with-icon" style="display:inline-flex;align-items:center;gap:8px">
                        <span class="icon send-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"/><path d="M22 2l-7 20 1-7 7-7z"/></svg>
                        </span>
                        <span>Send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            const container = document.getElementById('admin-chat-messages');
            function scrollBottom() { container.scrollTop = container.scrollHeight; }
            scrollBottom();
            Livewire.hook('message.processed', (component) => { scrollBottom(); });
            Livewire.on('ticketMessageSent', scrollBottom);
        });
        // Icon style toggle (outline / filled)
        (function(){
            const wrapper = document.getElementById('admin-chat-wrapper');
            const toggle = document.getElementById('icon-style-toggle');
            function setFilled(state){
                if(state){ wrapper.classList.add('icon-style-filled'); localStorage.setItem('chatIconFilled','1'); }
                else { wrapper.classList.remove('icon-style-filled'); localStorage.removeItem('chatIconFilled'); }
            }
            if(toggle && wrapper){
                const saved = localStorage.getItem('chatIconFilled');
                setFilled(!!saved);
                toggle.addEventListener('click', function(){ setFilled(!wrapper.classList.contains('icon-style-filled')); });
            }
        })();
    </script>

</div>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/admin-ticket-chat.blade.php ENDPATH**/ ?>