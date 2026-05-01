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
        $summaryCards = $this->getDashboardSummary();
        $highlights = $this->getMonthlyHighlights();
        $recentTickets = $this->getRecentTickets();
        $quickActions = $this->getQuickActions();
        $openTickets = \App\Models\Ticket::query()->where('status', 'open')->count();
        $activeCustomers = \App\Models\User::query()->where('status', 'active')->count();

        $cardStyles = [
            'amber' => ['surface' => 'rgba(251, 191, 36, 0.12)', 'color' => '#b45309'],
            'emerald' => ['surface' => 'rgba(16, 185, 129, 0.12)', 'color' => '#047857'],
            'rose' => ['surface' => 'rgba(244, 63, 94, 0.12)', 'color' => '#be123c'],
            'sky' => ['surface' => 'rgba(14, 165, 233, 0.12)', 'color' => '#0369a1'],
        ];
    ?>

    <style>
        .admin-dashboard {
            display: grid;
            gap: 1.5rem;
        }

        .admin-dashboard[x-cloak] {
            display: none !important;
        }

        .dashboard-hero {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.75rem;
            background:
                radial-gradient(circle at top left, rgba(251, 191, 36, 0.22), transparent 26%),
                radial-gradient(circle at right center, rgba(59, 130, 246, 0.12), transparent 22%),
                linear-gradient(135deg, #0f172a 0%, #111827 52%, #0b1220 100%);
            color: #f8fafc;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
        }

        .dashboard-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.03), transparent 36%),
                radial-gradient(circle at 76% 18%, rgba(255, 255, 255, 0.06), transparent 18%);
            pointer-events: none;
        }

        .dashboard-hero__inner {
            position: relative;
            z-index: 1;
            display: grid;
            gap: 1.5rem;
            padding: 1.75rem;
        }

        .dashboard-hero__content {
            display: grid;
            gap: 1rem;
        }

        .dashboard-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            padding: 0.5rem 0.9rem;
            font-size: 0.875rem;
            color: rgba(248, 250, 252, 0.9);
        }

        .dashboard-kicker__dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 999px;
            background: #fbbf24;
            box-shadow: 0 0 0 6px rgba(251, 191, 36, 0.16);
        }

        .dashboard-hero__meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
        }

        .dashboard-hero__meta {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            padding: 0.45rem 0.8rem;
            font-size: 0.78rem;
            color: rgba(226, 232, 240, 0.82);
        }

        .dashboard-hero__meta strong {
            color: #fff;
            font-weight: 700;
        }

        .dashboard-title {
            margin: 0;
            max-width: 14ch;
            font-size: clamp(2.1rem, 4vw, 3.35rem);
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.02;
        }

        .dashboard-subtitle {
            max-width: 46rem;
            margin: 0;
            font-size: 1.02rem;
            line-height: 1.7;
            color: rgba(226, 232, 240, 0.78);
        }

        .dashboard-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .dashboard-tab {
            appearance: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 150ms ease, background-color 150ms ease, border-color 150ms ease, color 150ms ease, box-shadow 150ms ease;
        }

        .dashboard-tab:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(251, 191, 36, 0.24);
        }

        .dashboard-tab.is-active {
            background: #fbbf24;
            color: #0f172a;
            border-color: #fbbf24;
            box-shadow: 0 10px 24px rgba(251, 191, 36, 0.22);
        }

        .dashboard-hero__footnote {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .dashboard-hero__footnote-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem 0.85rem;
            font-size: 0.8rem;
            color: rgba(226, 232, 240, 0.82);
        }

        .dashboard-hero__footnote-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 999px;
            background: #fbbf24;
            box-shadow: 0 0 0 5px rgba(251, 191, 36, 0.12);
        }

        .dashboard-hero__stats {
            display: grid;
            gap: 0.9rem;
            align-content: start;
        }

        .dashboard-hero__mini {
            border-radius: 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
        }

        .dashboard-hero__mini-label {
            margin: 0;
            font-size: 0.9rem;
            color: rgba(226, 232, 240, 0.75);
        }

        .dashboard-hero__mini-value {
            margin: 0.4rem 0 0;
            font-size: 2.1rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }

        .dashboard-hero__mini-note {
            margin: 0.25rem 0 0;
            font-size: 0.8rem;
            color: rgba(203, 213, 225, 0.72);
        }

        .dashboard-hero__summary {
            border-radius: 1.35rem;
            border: 1px solid rgba(251, 191, 36, 0.18);
            background: rgba(251, 191, 36, 0.1);
            padding: 1.1rem;
        }

        .dashboard-hero__summary-title {
            margin: 0;
            font-size: 0.95rem;
            color: #fef3c7;
        }

        .dashboard-hero__summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
            margin-top: 0.95rem;
        }

        .dashboard-hero__summary-item p {
            margin: 0;
        }

        .dashboard-hero__summary-value {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
        }

        .dashboard-hero__summary-label {
            margin-top: 0.25rem !important;
            font-size: 0.78rem;
            line-height: 1.45;
            color: rgba(255, 247, 237, 0.78);
        }

        .dashboard-section {
            display: grid;
            gap: 1.5rem;
        }

        .dashboard-section[hidden] {
            display: none !important;
        }

        .dashboard-cards {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .dashboard-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.35rem;
            background: #fff;
            padding: 1.2rem;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
            transition: transform 150ms ease, box-shadow 150ms ease, border-color 150ms ease;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
            border-color: rgba(251, 191, 36, 0.18);
        }

        .dashboard-card__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .dashboard-card__label {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #64748b;
        }

        .dashboard-card__value {
            margin: 0.7rem 0 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .dashboard-card__detail {
            margin: 0.3rem 0 0;
            font-size: 0.9rem;
            color: #64748b;
        }

        .dashboard-card__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            flex-shrink: 0;
        }

        .dashboard-panel {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.5rem;
            background: #fff;
            padding: 1.4rem;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
        }

        .dashboard-panel__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .dashboard-panel__title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dashboard-panel__subtitle {
            margin: 0.35rem 0 0;
            font-size: 0.9rem;
            line-height: 1.6;
            color: #64748b;
        }

        .dashboard-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            border: 1px solid rgba(148, 163, 184, 0.28);
            border-radius: 999px;
            background: #fff;
            padding: 0.7rem 1rem;
            color: #0f172a;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background-color 150ms ease, border-color 150ms ease, transform 150ms ease;
        }

        .dashboard-button:hover {
            transform: translateY(-1px);
            border-color: rgba(251, 191, 36, 0.32);
            background: rgba(255, 251, 235, 0.9);
        }

        .dashboard-metrics {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        .dashboard-metric {
            border-radius: 1.15rem;
            background: #f8fafc;
            padding: 1rem;
        }

        .dashboard-metric__label {
            margin: 0;
            font-size: 0.9rem;
            color: #64748b;
        }

        .dashboard-metric__value {
            margin: 0.35rem 0 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
        }

        .dashboard-list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .dashboard-list__item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 1rem;
            background: #f8fafc;
            padding: 0.9rem 1rem;
            text-decoration: none;
            color: inherit;
            transition: border-color 150ms ease, background-color 150ms ease, transform 150ms ease;
        }

        .dashboard-list__item:hover {
            transform: translateY(-1px);
            border-color: rgba(251, 191, 36, 0.28);
            background: rgba(255, 251, 235, 0.95);
        }

        .dashboard-list__title {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
        }

        .dashboard-list__meta {
            margin: 0.25rem 0 0;
            font-size: 0.85rem;
            color: #64748b;
        }

        .dashboard-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 0.35rem 0.7rem;
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .dashboard-pill--neutral {
            background: #e2e8f0;
            color: #475569;
        }

        .dashboard-pill--open {
            background: rgba(244, 63, 94, 0.12);
            color: #be123c;
        }

        .dashboard-pill--resolved {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .dashboard-quick-grid {
            display: grid;
            gap: 0.8rem;
        }

        .dashboard-quick-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.16);
            border-radius: 1.1rem;
            background: #f8fafc;
            padding: 1rem;
            text-decoration: none;
            color: inherit;
            transition: border-color 150ms ease, background-color 150ms ease, transform 150ms ease;
        }

        .dashboard-quick-link:hover {
            transform: translateY(-1px);
            border-color: rgba(251, 191, 36, 0.28);
            background: rgba(255, 251, 235, 0.95);
        }

        .dashboard-quick-link__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.95rem;
            background: #fff;
            color: #475569;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        }

        .dashboard-quick-link__title {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
        }

        .dashboard-quick-link__description {
            margin: 0.25rem 0 0;
            font-size: 0.85rem;
            color: #64748b;
        }

        .dashboard-support {
            display: grid;
            gap: 1rem;
        }

        .dashboard-support__focus {
            border-radius: 1.2rem;
            background: #0f172a;
            padding: 1rem;
            color: #fff;
        }

        .dashboard-support__focus p {
            margin: 0;
        }

        .dashboard-support__focus-label {
            font-size: 0.85rem;
            color: rgba(226, 232, 240, 0.8);
        }

        .dashboard-support__focus-value {
            margin-top: 0.35rem !important;
            font-size: 1.9rem;
            font-weight: 700;
        }

        @media (min-width: 768px) {
            .dashboard-hero__inner {
                grid-template-columns: minmax(0, 1.3fr) minmax(0, 0.9fr);
                align-items: stretch;
            }

            .dashboard-cards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .dashboard-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .dashboard-cards {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .dashboard-support {
                grid-template-columns: minmax(0, 1fr) minmax(0, 0.8fr);
            }
        }
    </style>

    <div x-data="{ tab: 'overview' }" class="admin-dashboard" x-cloak>
        <section class="dashboard-hero">
            <div class="dashboard-hero__inner">
                <div class="dashboard-hero__content">
                    <div class="dashboard-kicker">
                        <span class="dashboard-kicker__dot"></span>
                        Admin overview
                    </div>

                    <div class="dashboard-hero__meta-row">
                        <span class="dashboard-hero__meta">Panel <strong>Traderscap</strong></span>
                        <span class="dashboard-hero__meta">Updated <strong><?php echo e(\Illuminate\Support\Carbon::now()->format('M d, Y')); ?></strong></span>
                    </div>

                    <div>
                        <h1 class="dashboard-title">Dashboard</h1>
                        <p class="dashboard-subtitle">
                            Track customers, packages, support, and operations from a single professional command center.
                        </p>
                    </div>

                    <div class="dashboard-tabs">
                        <button type="button" class="dashboard-tab" x-bind:class="tab === 'overview' ? 'is-active' : ''" x-on:click="tab = 'overview'">Overview</button>
                        <button type="button" class="dashboard-tab" x-bind:class="tab === 'operations' ? 'is-active' : ''" x-on:click="tab = 'operations'">Operations</button>
                        <button type="button" class="dashboard-tab" x-bind:class="tab === 'support' ? 'is-active' : ''" x-on:click="tab = 'support'">Support</button>
                    </div>

                    <div class="dashboard-hero__footnote">
                        <span class="dashboard-hero__footnote-item"><span class="dashboard-hero__footnote-dot"></span>Clean reporting</span>
                        <span class="dashboard-hero__footnote-item"><span class="dashboard-hero__footnote-dot"></span>Fast actions</span>
                        <span class="dashboard-hero__footnote-item"><span class="dashboard-hero__footnote-dot"></span>Support visibility</span>
                    </div>
                </div>

                <div class="dashboard-hero__stats">
                    <div class="dashboard-hero__mini">
                        <p class="dashboard-hero__mini-label">Open tickets</p>
                        <p class="dashboard-hero__mini-value"><?php echo e($openTickets); ?></p>
                        <p class="dashboard-hero__mini-note">Needs attention from the support team</p>
                    </div>
                    <div class="dashboard-hero__mini">
                        <p class="dashboard-hero__mini-label">Active customers</p>
                        <p class="dashboard-hero__mini-value"><?php echo e($activeCustomers); ?></p>
                        <p class="dashboard-hero__mini-note">Users currently on an active status</p>
                    </div>
                    <div class="dashboard-hero__summary">
                        <p class="dashboard-hero__summary-title">This month</p>
                        <div class="dashboard-hero__summary-grid">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="dashboard-hero__summary-item">
                                    <p class="dashboard-hero__summary-value"><?php echo e($highlight['value']); ?></p>
                                    <p class="dashboard-hero__summary-label"><?php echo e($highlight['label']); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="dashboard-section" x-show="tab === 'overview'" x-transition.opacity>
            <div class="dashboard-cards">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $summaryCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="dashboard-card">
                        <div class="dashboard-card__top">
                            <div>
                                <p class="dashboard-card__label"><?php echo e($card['label']); ?></p>
                                <p class="dashboard-card__value"><?php echo e($card['value']); ?></p>
                                <p class="dashboard-card__detail"><?php echo e($card['detail']); ?></p>
                            </div>
                            <div class="dashboard-card__icon" style="background: <?php echo e($cardStyles[$card['color']]['surface']); ?>; color: <?php echo e($cardStyles[$card['color']]['color']); ?>;">
                                <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $card['icon'],'class' => 'size-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($card['icon']),'class' => 'size-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div style="display:grid;gap:1.5rem;grid-template-columns:repeat(1,minmax(0,1fr));">
                <section class="dashboard-panel">
                    <div class="dashboard-panel__header">
                        <div>
                            <h2 class="dashboard-panel__title">Recent complaints</h2>
                            <p class="dashboard-panel__subtitle">Latest support items that need review or follow-up.</p>
                        </div>
                        <a href="<?php echo e(\App\Filament\Resources\TicketResource::getUrl('index')); ?>" class="dashboard-button">View all</a>
                    </div>

                    <div class="dashboard-list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="dashboard-list__item">
                                <div>
                                    <p class="dashboard-list__title">#<?php echo e($ticket['id']); ?> <?php echo e($ticket['subject']); ?></p>
                                    <p class="dashboard-list__meta"><?php echo e($ticket['created_at'] ?? 'Just now'); ?></p>
                                </div>
                                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;justify-content:flex-end;">
                                    <span class="dashboard-pill dashboard-pill--neutral"><?php echo e(ucfirst($ticket['priority'] ?? 'normal')); ?></span>
                                    <span class="dashboard-pill <?php echo e($ticket['status'] === 'open' ? 'dashboard-pill--open' : 'dashboard-pill--resolved'); ?>"><?php echo e(ucfirst($ticket['status'] ?? 'open')); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="dashboard-list__item">
                                <div>
                                    <p class="dashboard-list__title">No tickets yet</p>
                                    <p class="dashboard-list__meta">Support activity will appear here once customers start submitting requests.</p>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>

                <section class="dashboard-panel">
                    <h2 class="dashboard-panel__title">Quick actions</h2>
                    <p class="dashboard-panel__subtitle">Shortcuts to the most common admin areas.</p>

                    <div class="dashboard-quick-grid">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($action['url']); ?>" class="dashboard-quick-link">
                                <div class="dashboard-quick-link__icon">
                                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $action['icon'],'class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action['icon']),'class' => 'size-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                                </div>
                                <div style="min-width:0;flex:1;">
                                    <p class="dashboard-quick-link__title"><?php echo e($action['label']); ?></p>
                                    <p class="dashboard-quick-link__description"><?php echo e($action['description']); ?></p>
                                </div>
                                <div style="color:#94a3b8;flex-shrink:0;">
                                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => 'heroicon-o-arrow-right','class' => 'size-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'heroicon-o-arrow-right','class' => 'size-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>
            </div>
        </section>

        <section class="dashboard-section" x-show="tab === 'operations'" x-transition.opacity style="display:none;">
            <div class="dashboard-cards">
                <article class="dashboard-card">
                    <div class="dashboard-card__top">
                        <div>
                            <p class="dashboard-card__label">Customers</p>
                            <p class="dashboard-card__value"><?php echo e($summaryCards[0]['value']); ?></p>
                            <p class="dashboard-card__detail">Use this to track overall account growth.</p>
                        </div>
                    </div>
                </article>
                <article class="dashboard-card">
                    <div class="dashboard-card__top">
                        <div>
                            <p class="dashboard-card__label">Packages</p>
                            <p class="dashboard-card__value"><?php echo e($summaryCards[3]['value']); ?></p>
                            <p class="dashboard-card__detail">Active catalog items ready for customers.</p>
                        </div>
                    </div>
                </article>
                <article class="dashboard-card">
                    <div class="dashboard-card__top">
                        <div>
                            <p class="dashboard-card__label">Plans</p>
                            <p class="dashboard-card__value"><?php echo e($summaryCards[1]['value']); ?></p>
                            <p class="dashboard-card__detail">Currently active customer packages.</p>
                        </div>
                    </div>
                </article>
                <article class="dashboard-card">
                    <div class="dashboard-card__top">
                        <div>
                            <p class="dashboard-card__label">Countries</p>
                            <p class="dashboard-card__value"><?php echo e($highlights[3]['value']); ?></p>
                            <p class="dashboard-card__detail">Regions available in the platform.</p>
                        </div>
                    </div>
                </article>
            </div>

            <div style="display:grid;gap:1.5rem;grid-template-columns:repeat(1,minmax(0,1fr));">
                <section class="dashboard-panel">
                    <div class="dashboard-panel__header">
                        <div>
                            <h2 class="dashboard-panel__title">Operations shortcuts</h2>
                            <p class="dashboard-panel__subtitle">High-frequency links for daily admin work.</p>
                        </div>
                        <span class="dashboard-pill dashboard-pill--neutral">5 quick links</span>
                    </div>

                    <div class="dashboard-quick-grid" style="margin-top:1rem;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $quickActions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($action['url']); ?>" class="dashboard-quick-link">
                                <div class="dashboard-quick-link__icon">
                                    <?php if (isset($component)) { $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.icon','data' => ['icon' => $action['icon'],'class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($action['icon']),'class' => 'size-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $attributes = $__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__attributesOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950)): ?>
<?php $component = $__componentOriginalbfc641e0710ce04e5fe02876ffc6f950; ?>
<?php unset($__componentOriginalbfc641e0710ce04e5fe02876ffc6f950); ?>
<?php endif; ?>
                                </div>
                                <div style="min-width:0;flex:1;">
                                    <p class="dashboard-quick-link__title"><?php echo e($action['label']); ?></p>
                                    <p class="dashboard-quick-link__description"><?php echo e($action['description']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>

                <section class="dashboard-panel">
                    <h2 class="dashboard-panel__title">Monthly summary</h2>
                    <div class="dashboard-metrics" style="margin-top:1rem;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="dashboard-metric">
                                <p class="dashboard-metric__label"><?php echo e($highlight['label']); ?></p>
                                <p class="dashboard-metric__value"><?php echo e($highlight['value']); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </section>
            </div>
        </section>

        <section class="dashboard-section dashboard-support" x-show="tab === 'support'" x-transition.opacity style="display:none;">
            <section class="dashboard-panel">
                <div class="dashboard-panel__header">
                    <div>
                        <h2 class="dashboard-panel__title">Support pipeline</h2>
                        <p class="dashboard-panel__subtitle">Keep unresolved requests visible and easy to prioritise.</p>
                    </div>
                    <a href="<?php echo e(\App\Filament\Resources\TicketResource::getUrl('index')); ?>" class="dashboard-button">Open support</a>
                </div>

                <div class="dashboard-metrics" style="margin-top:1rem;">
                    <div class="dashboard-metric" style="background:rgba(244,63,94,0.06);">
                        <p class="dashboard-metric__label">Open tickets</p>
                        <p class="dashboard-metric__value" style="color:#be123c;"><?php echo e($openTickets); ?></p>
                    </div>
                    <div class="dashboard-metric" style="background:rgba(16,185,129,0.06);">
                        <p class="dashboard-metric__label">Active customers</p>
                        <p class="dashboard-metric__value" style="color:#047857;"><?php echo e($activeCustomers); ?></p>
                    </div>
                </div>

                <div class="dashboard-list" style="margin-top:1rem;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="dashboard-list__item">
                            <div>
                                <p class="dashboard-list__title"><?php echo e($ticket['subject']); ?></p>
                                <p class="dashboard-list__meta">Ticket #<?php echo e($ticket['id']); ?> · <?php echo e($ticket['created_at'] ?? 'Recently'); ?></p>
                            </div>
                            <span class="dashboard-pill <?php echo e($ticket['status'] === 'open' ? 'dashboard-pill--open' : 'dashboard-pill--resolved'); ?>"><?php echo e(ucfirst($ticket['status'] ?? 'open')); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="dashboard-list__item">
                            <div>
                                <p class="dashboard-list__title">No tickets available yet</p>
                                <p class="dashboard-list__meta">Once support requests arrive, they will appear here.</p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>

            <section class="dashboard-support__focus">
                <p class="dashboard-support__focus-label">Support focus</p>
                <p class="dashboard-support__focus-value">Same day</p>
                <p style="margin-top:0.5rem;color:rgba(226,232,240,0.78);line-height:1.6;">
                    The dashboard keeps service work visible without overwhelming the layout.
                </p>
            </section>
        </section>
    </div>
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
<?php /**PATH C:\xampp\htdocs\traderscap\resources\views/filament/pages/dashboard.blade.php ENDPATH**/ ?>