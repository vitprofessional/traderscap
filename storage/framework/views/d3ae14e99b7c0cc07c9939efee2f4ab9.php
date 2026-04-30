<div id="act-root" style="max-width:860px;margin:0 auto;font-family:inherit">
<style>
/* ── Chat shell ─────────────────────────────────────── */
#act-root *{box-sizing:border-box;}
.act-card{
    background:#fff;
    border-radius:16px;
    border:1px solid #e2e8f0;
    box-shadow:0 4px 24px rgba(15,23,42,0.07);
    overflow:hidden;
    display:flex;
    flex-direction:column;
}
/* ── Header ─────────────────────────────────────────── */
.act-head{
    padding:1.1rem 1.4rem;
    border-bottom:1px solid #f1f5f9;
    background:#f8fafc;
    display:flex;
    align-items:center;
    gap:1rem;
    flex-wrap:wrap;
}
.act-head__icon{
    width:40px;height:40px;border-radius:10px;
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}
.act-head__meta{flex:1;min-width:0}
.act-head__ticket{font-size:0.78rem;color:#94a3b8;font-weight:500;margin-bottom:2px}
.act-head__subject{font-size:0.975rem;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.act-head__customer{display:inline-flex;align-items:center;gap:0.4rem;font-size:0.78rem;color:#64748b;margin-top:3px}
.act-badge{
    display:inline-flex;align-items:center;gap:0.35rem;
    font-size:0.75rem;font-weight:600;
    padding:0.3rem 0.7rem;border-radius:999px;
    white-space:nowrap;
}
.act-badge--open{background:#fef3c7;color:#92400e}
.act-badge--open span{background:#f59e0b}
.act-badge--resolved{background:#dcfce7;color:#14532d}
.act-badge--resolved span{background:#22c55e}
.act-badge--closed,.act-badge--default{background:#f1f5f9;color:#475569}
.act-badge--closed span,.act-badge--default span{background:#94a3b8}
.act-badge__dot{width:6px;height:6px;border-radius:50%;display:inline-block}
/* ── Message body ───────────────────────────────────── */
.act-body{
    flex:1;
    padding:1.25rem 1.4rem;
    overflow-y:auto;
    min-height:320px;
    max-height:calc(100vh - 360px);
    background:#fff;
    display:flex;
    flex-direction:column;
    gap:1rem;
}
.act-date-divider{
    display:flex;align-items:center;gap:0.75rem;
    font-size:0.72rem;color:#94a3b8;font-weight:500;margin:0.5rem 0;
}
.act-date-divider::before,.act-date-divider::after{
    content:'';flex:1;height:1px;background:#f1f5f9;
}
/* ── Message rows ───────────────────────────────────── */
.act-row{display:flex;gap:0.6rem;align-items:flex-end}
.act-row--admin{flex-direction:row-reverse}
.act-avatar{
    width:32px;height:32px;border-radius:50%;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    font-size:0.75rem;font-weight:700;
    background:#eef2f6;color:#334155;
}
.act-avatar--admin{
    background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;
}
.act-msg{max-width:70%}
.act-bubble{
    padding:0.7rem 1rem;
    border-radius:16px;
    font-size:0.9rem;
    line-height:1.55;
    word-break:break-word;
}
.act-bubble--user{
    background:#f1f5f9;color:#0f172a;
    border-bottom-left-radius:4px;
}
.act-bubble--admin{
    background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;
    border-bottom-right-radius:4px;
}
.act-bubble__attach{
    display:inline-flex;align-items:center;gap:0.4rem;
    margin-top:0.5rem;font-size:0.78rem;
    padding:0.3rem 0.6rem;border-radius:6px;
    background:rgba(255,255,255,0.18);color:inherit;
    text-decoration:none;border:1px solid rgba(255,255,255,0.22);
}
.act-bubble--user .act-bubble__attach{
    background:#e2e8f0;color:#334155;border-color:#cbd5e1;
}
.act-meta{
    font-size:0.72rem;color:#94a3b8;
    margin-top:0.3rem;
    padding:0 0.2rem;
}
.act-row--admin .act-meta{text-align:right}
/* ── Input bar ──────────────────────────────────────── */
.act-input-bar{
    padding:1rem 1.4rem;
    border-top:1px solid #f1f5f9;
    background:#f8fafc;
}
.act-input-inner{
    display:flex;gap:0.75rem;align-items:flex-end;
}
.act-textarea{
    flex:1;
    resize:none;
    border:1px solid #e2e8f0;
    border-radius:12px;
    padding:0.75rem 1rem;
    font-size:0.9rem;
    line-height:1.5;
    min-height:60px;
    max-height:160px;
    outline:none;
    transition:border-color 0.15s,box-shadow 0.15s;
    background:#fff;
    font-family:inherit;
    color:#0f172a;
}
.act-textarea:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,0.12)}
.act-textarea::placeholder{color:#94a3b8}
.act-actions{display:flex;flex-direction:column;gap:0.5rem;align-items:flex-end}
.act-tool-row{display:flex;gap:0.5rem;align-items:center}
.act-tool-btn{
    display:inline-flex;align-items:center;gap:0.4rem;
    font-size:0.78rem;color:#64748b;
    padding:0.45rem 0.75rem;border-radius:8px;
    border:1px solid #e2e8f0;background:#fff;
    cursor:pointer;white-space:nowrap;text-decoration:none;
    transition:background 0.12s,border-color 0.12s;
}
.act-tool-btn:hover{background:#f1f5f9;border-color:#cbd5e1}
.act-send-btn{
    display:inline-flex;align-items:center;gap:0.5rem;
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:#fff;border:none;
    padding:0.6rem 1.25rem;border-radius:10px;
    font-size:0.875rem;font-weight:600;
    cursor:pointer;white-space:nowrap;
    transition:opacity 0.15s,transform 0.1s;
    box-shadow:0 2px 8px rgba(79,70,229,0.28);
}
.act-send-btn:hover{opacity:0.92}
.act-send-btn:active{transform:scale(0.97)}
.act-attach-preview{
    display:flex;align-items:center;gap:0.5rem;
    font-size:0.78rem;color:#475569;
    padding:0.3rem 0.6rem;border-radius:6px;background:#ede9fe;
    margin-top:0.4rem;
}
.act-error{font-size:0.75rem;color:#ef4444;margin-top:0.25rem}
/* ── Empty state ────────────────────────────────────── */
.act-empty{
    flex:1;display:flex;flex-direction:column;
    align-items:center;justify-content:center;gap:0.75rem;
    padding:3rem 2rem;text-align:center;color:#94a3b8;
}
.act-empty__icon{width:56px;height:56px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center}
@media(max-width:600px){
    .act-body{max-height:52vh;min-height:220px}
    .act-msg{max-width:88%}
}
</style>

<?php
    $statusClass = match($ticket->status ?? 'open') {
        'open' => 'act-badge--open',
        'resolved' => 'act-badge--resolved',
        'closed' => 'act-badge--closed',
        default => 'act-badge--default',
    };
    $customerName = $ticket->user?->name ?? 'Customer';
    $customerInitial = strtoupper(substr($customerName, 0, 1));
?>

<div class="act-card">

    
    <div class="act-head">
        <div class="act-head__icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <div class="act-head__meta">
            <div class="act-head__ticket">Ticket #<?php echo e($ticket->id); ?></div>
            <div class="act-head__subject"><?php echo e($ticket->subject); ?></div>
            <div class="act-head__customer">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?php echo e($customerName); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket->user?->email): ?>
                    &nbsp;·&nbsp; <?php echo e($ticket->user->email); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <span class="act-badge <?php echo e($statusClass); ?>">
            <span class="act-badge__dot"></span>
            <?php echo e(ucfirst($ticket->status ?? 'open')); ?>

        </span>
    </div>

    
    <div id="act-messages" wire:poll.5s class="act-body">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isAdmin = $m->is_admin ?? false;
                $name = $isAdmin ? 'Admin' : ($m->user?->name ?? 'Customer');
                $initial = strtoupper(substr($name, 0, 1));
                $attachUrl = $m->attachment
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($m->attachment)
                    : null;
            ?>
            <div class="act-row <?php echo e($isAdmin ? 'act-row--admin' : ''); ?>">
                <div class="act-avatar <?php echo e($isAdmin ? 'act-avatar--admin' : ''); ?>"><?php echo e($initial); ?></div>
                <div class="act-msg">
                    <div class="act-bubble <?php echo e($isAdmin ? 'act-bubble--admin' : 'act-bubble--user'); ?>">
                        <?php echo nl2br(e($m->message)); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attachUrl): ?>
                            <div>
                                <a href="<?php echo e($attachUrl); ?>" target="_blank" class="act-bubble__attach">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.6 19.9a4.5 4.5 0 01-6.36-6.36l8.84-8.84a3.5 3.5 0 014.95 4.95L11.2 18.3a2 2 0 01-2.83-2.83l8.49-8.49"/></svg>
                                    View attachment
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="act-meta">
                        <?php echo e($m->created_at->diffForHumans()); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isAdmin): ?> &nbsp;·&nbsp; <?php echo e($name); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="act-empty">
                <div class="act-empty__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                </div>
                <p style="font-size:0.9rem;font-weight:600;color:#475569;margin:0">No messages yet</p>
                <p style="font-size:0.8rem;margin:0">Send the first reply to the customer below.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="act-input-bar">
        <form wire:submit.prevent="sendMessage">
            <div class="act-input-inner">
                <textarea
                    wire:model.defer="message"
                    required
                    placeholder="Write a reply to the customer…"
                    class="act-textarea"
                    rows="2"
                    onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.closest('form').requestSubmit();}"
                ></textarea>
                <div class="act-actions">
                    <div class="act-tool-row">
                        <label class="act-tool-btn" title="Attach file">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.6 19.9a4.5 4.5 0 01-6.36-6.36l8.84-8.84a3.5 3.5 0 014.95 4.95L11.2 18.3a2 2 0 01-2.83-2.83l8.49-8.49"/></svg>
                            Attach
                            <input type="file" wire:model="attachment" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" style="display:none" />
                        </label>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="act-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <button type="submit" class="act-send-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Send reply
                    </button>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attachment): ?>
                <div class="act-attach-preview">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05L12.6 19.9a4.5 4.5 0 01-6.36-6.36l8.84-8.84a3.5 3.5 0 014.95 4.95L11.2 18.3a2 2 0 01-2.83-2.83l8.49-8.49"/></svg>
                    File attached — ready to send
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </form>
    </div>

</div>

<script>
(function(){
    function scrollBottom(){
        var el = document.getElementById('act-messages');
        if(el) el.scrollTop = el.scrollHeight;
    }
    document.addEventListener('livewire:load', function(){
        scrollBottom();
        Livewire.hook('message.processed', scrollBottom);
        Livewire.on('ticketMessageSent', scrollBottom);
    });
    // Also scroll on initial load if livewire:load already fired
    document.addEventListener('DOMContentLoaded', scrollBottom);
})();
</script>
</div>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/livewire/admin-ticket-chat.blade.php ENDPATH**/ ?>