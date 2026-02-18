<?php if (isset($component)) { $__componentOriginald2aa9f7b74553621bdcc3c69267ff328 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald2aa9f7b74553621bdcc3c69267ff328 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\PageComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\PageComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="text-2xl font-semibold">Reply Ticket</h2>
     <?php $__env->endSlot(); ?>

    <?php
        $ticket = \App\Models\Ticket::find(request()->query('ticket') ?? $ticket_id ?? null);
    ?>

    <div class="max-w-5xl mx-auto p-6">
        <h3 class="text-lg font-medium mb-4">Ticket #<?php echo e($ticket?->id ?? ''); ?></h3>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket): ?>
            <div class="bg-white shadow-sm rounded-lg p-6">
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
            </div>
        <?php else: ?>
            <div class="text-sm text-gray-600">Ticket not found.</div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald2aa9f7b74553621bdcc3c69267ff328)): ?>
<?php $attributes = $__attributesOriginald2aa9f7b74553621bdcc3c69267ff328; ?>
<?php unset($__attributesOriginald2aa9f7b74553621bdcc3c69267ff328); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald2aa9f7b74553621bdcc3c69267ff328)): ?>
<?php $component = $__componentOriginald2aa9f7b74553621bdcc3c69267ff328; ?>
<?php unset($__componentOriginald2aa9f7b74553621bdcc3c69267ff328); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/filament/pages/tickets/reply.blade.php ENDPATH**/ ?>