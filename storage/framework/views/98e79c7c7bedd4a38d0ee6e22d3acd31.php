<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $ticket = \App\Models\Ticket::with(['user', 'messages.user'])->find(request()->query('ticket') ?? $ticket_id ?? null);
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket): ?>
        
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap">
            <a href="<?php echo e(url(config('filament.path', 'admin') . '/complaints')); ?>"
               style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.82rem;color:#64748b;text-decoration:none;padding:0.35rem 0.7rem;border:1px solid #e2e8f0;border-radius:6px;background:#f8fafc;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                All tickets
            </a>
            <span style="font-size:0.82rem;color:#94a3b8">/</span>
            <span style="font-size:0.82rem;color:#334155;font-weight:600">Ticket #<?php echo e($ticket->id); ?></span>

            <?php
                $statusColor = match($ticket->status) {
                    'open' => ['bg'=>'#fef3c7','text'=>'#92400e','dot'=>'#f59e0b'],
                    'resolved' => ['bg'=>'#dcfce7','text'=>'#14532d','dot'=>'#22c55e'],
                    default => ['bg'=>'#f1f5f9','text'=>'#475569','dot'=>'#94a3b8'],
                };
            ?>
            <span style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.78rem;font-weight:600;padding:0.3rem 0.75rem;border-radius:999px;background:<?php echo e($statusColor['bg']); ?>;color:<?php echo e($statusColor['text']); ?>">
                <span style="width:6px;height:6px;border-radius:50%;background:<?php echo e($statusColor['dot']); ?>"></span>
                <?php echo e(ucfirst($ticket->status)); ?>

            </span>
        </div>

        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin-ticket-chat', ['ticket' => $ticket]);

$key = 'admin-ticket-chat-'.e($ticket->id).'';

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2613935857-0', 'admin-ticket-chat-'.e($ticket->id).'');

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 2rem;text-align:center">
            <div style="width:64px;height:64px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            </div>
            <p style="font-size:1rem;font-weight:600;color:#334155;margin:0 0 0.35rem">Ticket not found</p>
            <p style="font-size:0.875rem;color:#94a3b8;margin:0">The ticket you're looking for doesn't exist or has been deleted.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/filament/pages/tickets/reply.blade.php ENDPATH**/ ?>