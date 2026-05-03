<x-filament-panels::page>
@php
    $stats        = $this->getStatsCards();
    $overview     = $this->getUserOverview();
    $growth       = $this->getUserGrowth();
    $recentUsers  = $this->getRecentUsers();
    $pending      = $this->getPendingActions();
    $activity     = $this->getRecentActivity();
    $quickActions = $this->getQuickActions();
    $onboarding   = $this->getOnboardingProgress();
    $accountStatus = $this->getAccountStatus();

    $admin      = auth('admin')->user();
    $adminName  = $admin?->name ?? 'Admin';
    $today      = \Illuminate\Support\Carbon::now()->format('M j, Y');
    $weekEnd    = \Illuminate\Support\Carbon::now()->addDays(6)->format('M j, Y');

    $totalUsers = collect($overview)->sum('count');

    $statusColorMap = [
        'active'         => ['bg' => '#dcfce7', 'text' => '#166534'],
        'active_waiting' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
        'pending'        => ['bg' => '#fef9c3', 'text' => '#854d0e'],
        'registered'     => ['bg' => '#ede9fe', 'text' => '#5b21b6'],
        'expired'        => ['bg' => '#fee2e2', 'text' => '#991b1b'],
    ];

    $iconColorMap = [
        'blue'   => ['bg' => '#eff6ff', 'icon' => '#2563eb'],
        'green'  => ['bg' => '#f0fdf4', 'icon' => '#16a34a'],
        'amber'  => ['bg' => '#fffbeb', 'icon' => '#d97706'],
        'violet' => ['bg' => '#f5f3ff', 'icon' => '#7c3aed'],
        'rose'   => ['bg' => '#fff1f2', 'icon' => '#e11d48'],
        'cyan'   => ['bg' => '#ecfeff', 'icon' => '#0891b2'],
    ];

    $trendUpColor   = '#16a34a';
    $trendDownColor = '#dc2626';
@endphp

<style>
/* ── Base ─────────────────────────────────────────── */
.tc-dash { font-family: inherit; color: #0f172a; }
.tc-dash *, .tc-dash *::before, .tc-dash *::after { box-sizing: border-box; }

/* ── Top Bar ─────────────────────────────────────── */
.tc-topbar {
    display: flex; flex-wrap: wrap; align-items: center;
    justify-content: space-between; gap: 1rem;
    margin-bottom: 1.75rem;
}
.tc-topbar__greeting { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin: 0; }
.tc-topbar__sub { font-size: 0.875rem; color: #64748b; margin: 0.2rem 0 0; }
.tc-topbar__right { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.tc-date-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    border: 1px solid #e2e8f0; border-radius: 0.5rem;
    background: #fff; padding: 0.5rem 0.875rem;
    font-size: 0.8125rem; font-weight: 500; color: #334155;
}
.tc-export-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: #0f172a; color: #fff; border: none; border-radius: 0.5rem;
    padding: 0.55rem 1rem; font-size: 0.8125rem; font-weight: 600; cursor: pointer;
    text-decoration: none; transition: background 150ms;
}
.tc-export-btn:hover { background: #1e293b; }

/* ── Stats Grid ──────────────────────────────────── */
.tc-stats { display: grid; gap: 1rem; grid-template-columns: repeat(2, 1fr); margin-bottom: 1.5rem; }
@media(min-width:768px)  { .tc-stats { grid-template-columns: repeat(3, 1fr); } }
@media(min-width:1280px) { .tc-stats { grid-template-columns: repeat(6, 1fr); } }

.tc-stat {
    background: #fff; border: 1px solid #f1f5f9; border-radius: 0.875rem;
    padding: 1.1rem 1.1rem 0.9rem; box-shadow: 0 1px 4px rgba(15,23,42,.04);
    transition: box-shadow 150ms, transform 150ms;
    display: flex; flex-direction: column; gap: 0.6rem;
    text-decoration: none; color: inherit;
}
.tc-stat:hover { box-shadow: 0 4px 16px rgba(15,23,42,.09); transform: translateY(-2px); }
.tc-stat__top { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.5rem; }
.tc-stat__label { font-size: 0.78rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: .04em; margin: 0; }
.tc-stat__icon { width: 2.25rem; height: 2.25rem; border-radius: 0.6rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.tc-stat__value { font-size: 1.75rem; font-weight: 700; letter-spacing: -.03em; color: #0f172a; margin: 0; line-height: 1; }
.tc-stat__trend { display: flex; align-items: center; gap: 0.3rem; font-size: 0.75rem; font-weight: 600; }
.tc-stat__trend-note { font-size: 0.7rem; color: #94a3b8; }

/* ── Mid row ─────────────────────────────────────── */
.tc-mid { display: grid; gap: 1rem; grid-template-columns: 1fr; margin-bottom: 1.5rem; }
@media(min-width:768px)  { .tc-mid { grid-template-columns: 1fr 1.3fr; } }
@media(min-width:1280px) { .tc-mid { grid-template-columns: 1fr 1.3fr .85fr; } }

/* ── Cards ───────────────────────────────────────── */
.tc-card {
    background: #fff; border: 1px solid #f1f5f9; border-radius: 0.875rem;
    box-shadow: 0 1px 4px rgba(15,23,42,.04); overflow: hidden;
}
.tc-card__header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.1rem 0.6rem; gap: 0.5rem;
}
.tc-card__title { font-size: 0.9rem; font-weight: 700; color: #0f172a; margin: 0; }
.tc-card__badge {
    font-size: 0.7rem; font-weight: 600; color: #64748b;
    background: #f1f5f9; border-radius: 999px; padding: .2rem .55rem;
}
.tc-card__link {
    font-size: 0.75rem; font-weight: 600; color: #2563eb;
    text-decoration: none; white-space: nowrap;
}
.tc-card__link:hover { text-decoration: underline; }
.tc-card__body { padding: 0 1.1rem 1.1rem; }

/* ── Donut ───────────────────────────────────────── */
.tc-donut-wrap { display: flex; flex-direction: column; align-items: center; gap: 0.9rem; }
.tc-donut-canvas-wrap { position: relative; width: 150px; height: 150px; margin: 0 auto; }
.tc-donut-total {
    position: absolute; inset: 0; display: flex; flex-direction: column;
    align-items: center; justify-content: center; pointer-events: none;
}
.tc-donut-total__value { font-size: 1.4rem; font-weight: 700; color: #0f172a; line-height: 1; }
.tc-donut-total__label { font-size: 0.65rem; color: #94a3b8; margin-top: 0.1rem; }
.tc-donut-legend { display: grid; grid-template-columns: 1fr 1fr; gap: .4rem .9rem; width: 100%; }
.tc-donut-legend__item { display: flex; align-items: center; gap: .4rem; font-size: .75rem; color: #475569; }
.tc-donut-legend__dot { width: .55rem; height: .55rem; border-radius: 50%; flex-shrink: 0; }
.tc-donut-legend__count { font-weight: 700; color: #0f172a; margin-left: auto; }

/* ── Line chart ──────────────────────────────────── */
.tc-line-canvas { width: 100%; height: 140px; display: block; }

/* ── Quick Actions ───────────────────────────────── */
.tc-qa-list { display: grid; gap: .45rem; }
.tc-qa-item {
    display: flex; align-items: center; gap: .65rem;
    padding: .6rem .8rem; border-radius: .6rem; border: 1px solid #f1f5f9;
    text-decoration: none; color: #0f172a; font-size: .82rem; font-weight: 600;
    transition: background 120ms, border-color 120ms;
}
.tc-qa-item:hover { background: #f8fafc; border-color: #e2e8f0; }
.tc-qa-item__icon {
    width: 1.9rem; height: 1.9rem; border-radius: .45rem; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #475569;
}
.tc-qa-arrow { margin-left: auto; color: #cbd5e1; }

/* ── Table ───────────────────────────────────────── */
.tc-table-wrap { overflow-x: auto; }
.tc-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
.tc-table th {
    padding: .55rem .9rem; text-align: left; font-size: .7rem; font-weight: 700;
    color: #94a3b8; text-transform: uppercase; letter-spacing: .05em;
    border-bottom: 1px solid #f1f5f9; white-space: nowrap; background: #fafafa;
}
.tc-table td {
    padding: .7rem .9rem; border-bottom: 1px solid #f8fafc; color: #334155;
    vertical-align: middle; white-space: nowrap;
}
.tc-table tr:last-child td { border-bottom: none; }
.tc-table tr:hover td { background: #fafafa; }

/* ── Badge / Avatar ──────────────────────────────── */
.tc-badge {
    display: inline-flex; align-items: center; padding: .2rem .55rem;
    border-radius: 999px; font-size: .7rem; font-weight: 700; line-height: 1.2;
}
.tc-avatar {
    width: 1.9rem; height: 1.9rem; border-radius: 50%; background: #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 700; color: #475569; flex-shrink: 0;
}

/* ── Bottom row ──────────────────────────────────── */
.tc-bottom { display: grid; gap: 1rem; grid-template-columns: 1fr; }
@media(min-width:1024px) { .tc-bottom { grid-template-columns: 1.4fr 1fr; } }

/* ── Activity feed ───────────────────────────────── */
.tc-feed { display: grid; gap: .6rem; }
.tc-feed__item { display: flex; align-items: flex-start; gap: .7rem; }
.tc-feed__dot {
    width: 1.9rem; height: 1.9rem; border-radius: 50%; display: flex;
    align-items: center; justify-content: center; flex-shrink: 0; margin-top: .05rem;
}
.tc-feed__text { font-size: .82rem; color: #334155; line-height: 1.4; flex: 1; }
.tc-feed__time { font-size: .72rem; color: #94a3b8; white-space: nowrap; }

/* ── Onboarding Stepper ──────────────────────────── */
.tc-onboarding-row { display: grid; gap: 1rem; grid-template-columns: 1fr; margin-bottom: 1rem; }
@media(min-width: 768px) { .tc-onboarding-row { grid-template-columns: 1fr 1fr; } }

.tc-stepper { display: flex; align-items: flex-start; padding: .5rem 0 .1rem; gap: 0; }
.tc-step { display: flex; flex-direction: column; align-items: center; flex: 1; }
.tc-step__connector {
    flex: 1; height: 2px; background: #e2e8f0; margin-top: .95rem; min-width: .5rem;
    transition: background 150ms;
}
.tc-step__connector--done { background: #0ea5e9; }
.tc-step__circle {
    width: 1.9rem; height: 1.9rem; border-radius: 50%; display: flex; align-items: center;
    justify-content: center; font-size: .72rem; font-weight: 700;
    border: 2px solid #e2e8f0; background: #f8fafc; color: #94a3b8;
    position: relative; z-index: 1; transition: all 150ms; flex-shrink: 0;
}
.tc-step__circle--done { background: #0ea5e9; border-color: #0ea5e9; color: #fff; }
.tc-step__circle--active { background: #fff; border-color: #0ea5e9; color: #0ea5e9; }
.tc-step__label {
    font-size: .67rem; color: #94a3b8; text-align: center;
    margin-top: .4rem; max-width: 5.5rem; line-height: 1.3;
}
.tc-step__label--done { color: #0f172a; font-weight: 600; }
.tc-step__count { font-size: .62rem; color: #94a3b8; margin-top: .1rem; text-align: center; }
.tc-step__count--done { color: #0ea5e9; font-weight: 600; }

/* ── Account Status list ─────────────────────────── */
.tc-status-list { display: grid; gap: .9rem; }
.tc-status-item { display: flex; align-items: center; gap: .7rem; }
.tc-status-dot { width: .85rem; height: .85rem; border-radius: 50%; flex-shrink: 0; }
.tc-status-label { flex: 1; font-size: .84rem; color: #334155; font-weight: 500; }
.tc-status-note { font-size: .78rem; color: #94a3b8; white-space: nowrap; }
.tc-status-note--done { color: #16a34a; font-weight: 600; }
.tc-status-note--partial { color: #d97706; font-weight: 600; }
</style>

<div class="tc-dash">

    {{-- ── Top bar ── --}}
    <div class="tc-topbar">
        <div>
            <p class="tc-topbar__greeting">Welcome back, {{ $adminName }}! 👋</p>
            <p class="tc-topbar__sub">Here's what's happening with your platform today.</p>
        </div>
        <div class="tc-topbar__right">
            <span class="tc-date-pill">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                {{ $today }}
            </span>
            <a href="{{ \App\Filament\Resources\UserResource::getUrl('index') }}" class="tc-export-btn">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 16V4m0 12-4-4m4 4 4-4M3 20h18"/></svg>
                Export Report
            </a>
        </div>
    </div>

    {{-- ── Stats row ── --}}
    <div class="tc-stats">
        @foreach ($stats as $s)
            @php
                $ic = $iconColorMap[$s['color']] ?? ['bg'=>'#f1f5f9','icon'=>'#64748b'];
                $tr = $s['trend'];
                $trColor = $tr['neutral'] ? '#94a3b8' : ($tr['up'] ? $trendUpColor : $trendDownColor);
            @endphp
            @if($s['url'])
            <a href="{{ $s['url'] }}" class="tc-stat">
            @else
            <div class="tc-stat">
            @endif
                <div class="tc-stat__top">
                    <p class="tc-stat__label">{{ $s['label'] }}</p>
                    <div class="tc-stat__icon" style="background:{{ $ic['bg'] }};color:{{ $ic['icon'] }};">
                        <x-filament::icon :icon="$s['icon']" class="w-4 h-4" />
                    </div>
                </div>
                <p class="tc-stat__value">{{ number_format($s['value']) }}</p>
                <div>
                    <div class="tc-stat__trend" style="color:{{ $trColor }};">
                        @if(!$tr['neutral'])
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                @if($tr['up'])<path d="M18 15l-6-6-6 6"/>@else<path d="M6 9l6 6 6-6"/>@endif
                            </svg>
                        @endif
                        {{ $tr['pct'] }}%
                    </div>
                    <div class="tc-stat__trend-note">{{ $s['note'] }}</div>
                </div>
            @if($s['url'])</a>@else</div>@endif
        @endforeach
    </div>

    {{-- ── Charts + Quick Actions ── --}}
    <div class="tc-mid">

        {{-- User Overview Donut --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">User Overview</h3>
                <span class="tc-card__badge">All Time</span>
            </div>
            <div class="tc-card__body">
                <div class="tc-donut-wrap">
                    <div class="tc-donut-canvas-wrap">
                        <canvas id="donutChart" width="150" height="150"></canvas>
                        <div class="tc-donut-total">
                            <span class="tc-donut-total__value">{{ number_format($totalUsers) }}</span>
                            <span class="tc-donut-total__label">Total</span>
                        </div>
                    </div>
                    <div class="tc-donut-legend">
                        @foreach ($overview as $seg)
                            <div class="tc-donut-legend__item">
                                <span class="tc-donut-legend__dot" style="background:{{ $seg['color'] }};"></span>
                                <span>{{ $seg['label'] }}</span>
                                <span class="tc-donut-legend__count">{{ number_format($seg['count']) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Growth Line --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Users Growth <span style="font-size:.75rem;font-weight:500;color:#64748b;">(Last 7 Days)</span></h3>
            </div>
            <div class="tc-card__body">
                <canvas id="lineChart" class="tc-line-canvas"></canvas>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Quick Actions</h3>
            </div>
            <div class="tc-card__body">
                <div class="tc-qa-list">
                    @foreach ($quickActions as $qa)
                        <a href="{{ $qa['url'] }}" class="tc-qa-item">
                            <span class="tc-qa-item__icon">
                                <x-filament::icon :icon="$qa['icon']" class="w-4 h-4" />
                            </span>
                            {{ $qa['label'] }}
                            <svg class="tc-qa-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ── Onboarding Progress + Account Status ── --}}
    <div class="tc-onboarding-row">

        {{-- Onboarding Progress --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Onboarding Progress</h3>
                <a href="{{ \App\Filament\Resources\UserResource::getUrl('index') }}" class="tc-card__link">View Guide →</a>
            </div>
            <div class="tc-card__body" style="padding-top:.3rem;">
                <div class="tc-stepper">
                    @foreach ($onboarding['steps'] as $i => $step)
                        @php $done = $step['count'] > 0; @endphp
                        {{-- Connector before step (not before first) --}}
                        @if ($i > 0)
                            <div class="tc-step__connector {{ $done ? 'tc-step__connector--done' : '' }}"></div>
                        @endif
                        <div class="tc-step">
                            <div class="tc-step__circle {{ $done ? 'tc-step__circle--done' : '' }}">
                                @if ($done)
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 12l5 5 9-9"/></svg>
                                @else
                                    {{ $step['num'] }}
                                @endif
                            </div>
                            <div class="tc-step__label {{ $done ? 'tc-step__label--done' : '' }}">{{ $step['label'] }}</div>
                            <div class="tc-step__count {{ $done ? 'tc-step__count--done' : '' }}">{{ number_format($step['count']) }} users</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Account Status --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Account Status</h3>
                <span style="{{ $accountStatus['badgeStyle'] }}font-size:.68rem;font-weight:700;padding:.22rem .65rem;border-radius:999px;letter-spacing:.04em;">
                    {{ $accountStatus['badge'] }}
                </span>
            </div>
            <div class="tc-card__body">
                <div class="tc-status-list">
                    @foreach ($accountStatus['items'] as $item)
                        @php
                            $dotColor = match($item['status']) {
                                'done'    => '#22c55e',
                                'partial' => '#f59e0b',
                                'none'    => '#f43f5e',
                                default   => '#cbd5e1',  // pending
                            };
                            $noteClass = match($item['status']) {
                                'done'    => 'tc-status-note--done',
                                'partial' => 'tc-status-note--partial',
                                default   => '',
                            };
                        @endphp
                        <div class="tc-status-item">
                            <div class="tc-status-dot" style="background:{{ $dotColor }};"></div>
                            <span class="tc-status-label">{{ $item['label'] }}</span>
                            <span class="tc-status-note {{ $noteClass }}">{{ $item['note'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- ── Recent Users table ── --}}
    <div class="tc-card" style="margin-bottom:1rem;">
        <div class="tc-card__header">
            <h3 class="tc-card__title">Recent Users</h3>
            <a href="{{ \App\Filament\Resources\UserResource::getUrl('index') }}" class="tc-card__link">View All →</a>
        </div>
        <div class="tc-table-wrap">
            <table class="tc-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentUsers as $u)
                        @php $sc = $statusColorMap[$u['status']] ?? ['bg'=>'#f1f5f9','text'=>'#475569']; @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <div class="tc-avatar">{{ $u['initials'] }}</div>
                                    <span style="font-weight:600;">{{ $u['name'] }}</span>
                                </div>
                            </td>
                            <td style="color:#64748b;">{{ $u['email'] }}</td>
                            <td>
                                <span class="tc-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                    {{ ucfirst(str_replace('_',' ',$u['status'])) }}
                                </span>
                            </td>
                            <td style="color:#64748b;">{{ $u['joined'] }}</td>
                            <td><a href="{{ $u['url'] }}" style="font-size:.75rem;font-weight:600;color:#2563eb;text-decoration:none;">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:#94a3b8;">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Pending Actions + Activity ── --}}
    <div class="tc-bottom">

        {{-- Pending Actions --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Pending Actions</h3>
                <span class="tc-card__badge">{{ count($pending) }} items</span>
            </div>
            <div class="tc-table-wrap">
                <table class="tc-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Details</th>
                            <th>User</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pending as $pa)
                            @php
                                $pColor = $pa['color'] === 'amber'
                                    ? ['bg'=>'#fffbeb','text'=>'#92400e']
                                    : ['bg'=>'#fff1f2','text'=>'#9f1239'];
                            @endphp
                            <tr>
                                <td><span class="tc-badge" style="background:{{ $pColor['bg'] }};color:{{ $pColor['text'] }};">{{ $pa['type'] }}</span></td>
                                <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;">{{ $pa['detail'] }}</td>
                                <td>{{ $pa['user'] }}</td>
                                <td style="color:#64748b;">{{ $pa['date'] }}</td>
                                <td><a href="{{ $pa['url'] }}" style="font-size:.75rem;font-weight:600;color:#2563eb;text-decoration:none;">{{ $pa['action'] }}</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:#94a3b8;">No pending actions 🎉</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="tc-card">
            <div class="tc-card__header">
                <h3 class="tc-card__title">Recent Activity</h3>
                <span class="tc-card__badge">Latest</span>
            </div>
            <div class="tc-card__body" style="padding-top:.3rem;">
                <div class="tc-feed">
                    @forelse ($activity as $item)
                        @php
                            $dotMap = ['blue'=>['bg'=>'#eff6ff','ic'=>'#3b82f6'],'green'=>['bg'=>'#f0fdf4','ic'=>'#22c55e'],'rose'=>['bg'=>'#fff1f2','ic'=>'#f43f5e'],'amber'=>['bg'=>'#fffbeb','ic'=>'#f59e0b']];
                            $dc = $dotMap[$item['color']] ?? ['bg'=>'#f1f5f9','ic'=>'#94a3b8'];
                        @endphp
                        <div class="tc-feed__item">
                            <div class="tc-feed__dot" style="background:{{ $dc['bg'] }};color:{{ $dc['ic'] }};">
                                @if($item['icon'] === 'user')
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                @elseif($item['icon'] === 'package')
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                @elseif($item['icon'] === 'ticket')
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/></svg>
                                @endif
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p class="tc-feed__text">{{ $item['text'] }}</p>
                            </div>
                            <span class="tc-feed__time">{{ $item['time'] }}</span>
                        </div>
                    @empty
                        <p style="font-size:.82rem;color:#94a3b8;text-align:center;padding:.5rem 0;">No recent activity.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ── Chart.js ── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(function () {
    const donutData = @json(array_values($overview));
    const donutCtx  = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutData.map(d => d.label),
                datasets: [{
                    data: donutData.map(d => d.count),
                    backgroundColor: donutData.map(d => d.color),
                    borderWidth: 2, borderColor: '#fff', hoverOffset: 4
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString() } }
                },
                responsive: true, maintainAspectRatio: true
            }
        });
    }

    const growthData = @json($growth);
    const lineCtx    = document.getElementById('lineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: growthData.labels,
                datasets: [{
                    label: 'New Users',
                    data: growthData.data,
                    fill: true,
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34,197,94,.1)',
                    borderWidth: 2, tension: 0.4,
                    pointRadius: 4, pointBackgroundColor: '#22c55e',
                    pointBorderColor: '#fff', pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 }, color: '#94a3b8', stepSize: 1 }, beginAtZero: true }
                }
            }
        });
    }
})();
</script>
</x-filament-panels::page>