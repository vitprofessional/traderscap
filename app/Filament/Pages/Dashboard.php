<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CountryResource;
use App\Filament\Resources\PackageResource;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Package;
use App\Models\QuizAnswer;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserPackage;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    public function getTitle(): string | Htmlable
    {
        return 'Dashboard';
    }

    // ─── Stats cards ──────────────────────────────────────────────────────────

    public function getStatsCards(): array
    {
        $d7  = now()->subDays(7);
        $d14 = now()->subDays(14);

        $totalNow   = User::count();
        $totalNew7  = User::where('created_at', '>=', $d7)->count();
        $totalNew14 = User::whereBetween('created_at', [$d14, $d7])->count();

        // Use users.status (kept in sync by UserPackage model events + syncStatus())
        $activeNow   = User::where('status', 'active')->count();
        $activeNew7  = User::where('status', 'active')->where('updated_at', '>=', $d7)->count();
        $activeNew14 = User::where('status', 'active')->whereBetween('updated_at', [$d14, $d7])->count();

        $pendingNow  = User::where('status', 'pending')->count();
        $pendingNew7 = User::where('status', 'pending')->where('updated_at', '>=', $d7)->count();
        $pendingPrev = User::where('status', 'pending')->whereBetween('updated_at', [$d14, $d7])->count();

        $packagesNow = UserPackage::whereIn('status', ['active', 'active_waiting'])->count();
        $pkgNew7     = UserPackage::whereIn('status', ['active', 'active_waiting'])->where('created_at', '>=', $d7)->count();
        $pkgPrev     = UserPackage::whereIn('status', ['active', 'active_waiting'])->whereBetween('created_at', [$d14, $d7])->count();

        $ticketsNow  = Ticket::where('status', 'open')->count();
        $ticketsNew7 = Ticket::where('status', 'open')->where('created_at', '>=', $d7)->count();
        $ticketsPrev = Ticket::where('status', 'open')->whereBetween('created_at', [$d14, $d7])->count();

        $quizNow  = QuizAnswer::count();
        $quizNew7 = QuizAnswer::where('created_at', '>=', $d7)->count();
        $quizPrev = QuizAnswer::whereBetween('created_at', [$d14, $d7])->count();

        return [
            [
                'key'   => 'total_users',
                'label' => 'Total Users',
                'value' => $totalNow,
                'trend' => $this->calcTrend($totalNew7, $totalNew14),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-users',
                'color' => 'blue',
                'url'   => UserResource::getUrl('index'),
            ],
            [
                'key'   => 'active_users',
                'label' => 'Active Users',
                'value' => $activeNow,
                'trend' => $this->calcTrend($activeNew7, $activeNew14),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-user-circle',
                'color' => 'green',
                'url'   => UserResource::getUrl('index'),
            ],
            [
                'key'   => 'pending_users',
                'label' => 'Pending Users',
                'value' => $pendingNow,
                'trend' => $this->calcTrend($pendingNew7, $pendingPrev),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-clock',
                'color' => 'amber',
                'url'   => UserResource::getUrl('index'),
            ],
            [
                'key'   => 'packages',
                'label' => 'Active Plans',
                'value' => $packagesNow,
                'trend' => $this->calcTrend($pkgNew7, $pkgPrev),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-rectangle-stack',
                'color' => 'violet',
                'url'   => UserResource::getUrl('index'),
            ],
            [
                'key'   => 'tickets',
                'label' => 'Open Tickets',
                'value' => $ticketsNow,
                'trend' => $this->calcTrend($ticketsNew7, $ticketsPrev),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-chat-bubble-left-right',
                'color' => 'rose',
                'url'   => TicketResource::getUrl('index'),
            ],
            [
                'key'   => 'quiz',
                'label' => 'Quiz Submissions',
                'value' => $quizNow,
                'trend' => $this->calcTrend($quizNew7, $quizPrev),
                'note'  => 'vs last 7 days',
                'icon'  => 'heroicon-o-academic-cap',
                'color' => 'cyan',
                'url'   => null,
            ],
        ];
    }

    private function calcTrend(int $current, int $previous): array
    {
        if ($previous === 0) {
            $pct = $current > 0 ? 100 : 0;
            return ['pct' => $pct, 'up' => true, 'neutral' => $current === 0];
        }
        $pct = round((($current - $previous) / $previous) * 100, 1);
        return ['pct' => abs($pct), 'up' => $pct >= 0, 'neutral' => $pct === 0.0];
    }

    // ─── User overview (donut) ────────────────────────────────────────────────

    public function getUserOverview(): array
    {
        $active     = User::where('status', 'active')->count();
        $pending    = User::where('status', 'pending')->count();
        $registered = User::where('status', 'registered')->count();
        $inactive   = User::where('status', 'expired')->count();
        $others     = max(0, User::count() - $active - $pending - $registered - $inactive);

        return [
            ['label' => 'Active',     'count' => $active,     'color' => '#22c55e'],
            ['label' => 'Pending',    'count' => $pending,    'color' => '#f59e0b'],
            ['label' => 'Registered', 'count' => $registered, 'color' => '#6366f1'],
            ['label' => 'Expired',    'count' => $inactive,   'color' => '#f43f5e'],
        ];
    }

    // ─── User growth (line chart) ─────────────────────────────────────────────

    public function getUserGrowth(): array
    {
        $labels = [];
        $data   = [];

        for ($i = 6; $i >= 0; $i--) {
            $day      = now()->subDays($i);
            $labels[] = $day->format('M j');
            $data[]   = User::whereDate('created_at', $day->toDateString())->count();
        }

        return compact('labels', 'data');
    }

    // ─── Recent users ─────────────────────────────────────────────────────────

    public function getRecentUsers(): array
    {
        return User::query()
            ->latest()
            ->limit(5)
            ->get(['id', 'name', 'email', 'status', 'created_at'])
            ->map(fn(User $u) => [
                'id'       => $u->id,
                'name'     => $u->name,
                'email'    => $u->email,
                'status'   => $u->status,
                'joined'   => optional($u->created_at)->format('M j, Y'),
                'url'      => UserResource::getUrl('edit', ['record' => $u->id]),
                'initials' => mb_strtoupper(mb_substr($u->name, 0, 1))
                              . (str_contains($u->name, ' ')
                                  ? mb_strtoupper(mb_substr(strrchr($u->name, ' '), 1, 1))
                                  : ''),
            ])
            ->all();
    }

    // ─── Pending actions ──────────────────────────────────────────────────────

    public function getPendingActions(): array
    {
        $actions = [];

        UserPackage::with(['user', 'package'])
            ->whereIn('status', ['registered', 'pending'])
            ->latest()
            ->limit(5)
            ->each(function (UserPackage $up) use (&$actions) {
                $actions[] = [
                    'type'   => 'Package ' . ucfirst($up->status),
                    'detail' => optional($up->package)->name ?? 'Package #' . $up->package_id,
                    'user'   => optional($up->user)->name ?? '—',
                    'date'   => optional($up->created_at)->format('M j, Y'),
                    'action' => 'Review',
                    'url'    => $up->user_id ? UserResource::getUrl('edit', ['record' => $up->user_id]) : UserResource::getUrl('index'),
                    'color'  => 'amber',
                ];
            });

        Ticket::where('status', 'open')
            ->latest()
            ->limit(5)
            ->each(function (Ticket $t) use (&$actions) {
                $actions[] = [
                    'type'   => 'Open Ticket',
                    'detail' => $t->subject,
                    'user'   => '—',
                    'date'   => optional($t->created_at)->format('M j, Y'),
                    'action' => 'View',
                    'url'    => TicketResource::getUrl('index'),
                    'color'  => 'rose',
                ];
            });

        usort($actions, fn($a, $b) => strcmp($b['date'], $a['date']));

        return array_slice($actions, 0, 8);
    }

    // ─── Recent activity feed ─────────────────────────────────────────────────

    public function getRecentActivity(): array
    {
        $feed = [];

        User::latest()->limit(3)->each(fn(User $u) => $feed[] = [
            'icon'  => 'user',
            'color' => 'blue',
            'text'  => 'New user registered — ' . $u->name,
            'time'  => optional($u->created_at)->diffForHumans(),
        ]);

        UserPackage::with('package')
            ->whereIn('status', ['active', 'active_waiting'])
            ->latest()->limit(3)
            ->each(fn(UserPackage $up) => $feed[] = [
                'icon'  => 'package',
                'color' => 'green',
                'text'  => 'Package "' . (optional($up->package)->name ?? 'Plan') . '" activated',
                'time'  => optional($up->created_at)->diffForHumans(),
            ]);

        Ticket::latest()->limit(3)->each(fn(Ticket $t) => $feed[] = [
            'icon'  => 'ticket',
            'color' => 'rose',
            'text'  => 'Support ticket — ' . \Illuminate\Support\Str::limit($t->subject, 40),
            'time'  => optional($t->created_at)->diffForHumans(),
        ]);

        usort($feed, fn($a, $b) => strcmp($a['time'], $b['time']));

        return array_slice($feed, 0, 8);
    }

    // ─── Onboarding progress ─────────────────────────────────────────────────

    public function getOnboardingProgress(): array
    {
        $total = max(1, User::count());

        // Step 1: User registered (chose path)
        $step1 = User::count();
        // Step 2: Has any package assigned
        $step2 = User::whereHas('userPackages')->count();
        // Step 3: MT4/MT5 credentials submitted in any package
        $step3 = UserPackage::whereNotNull('trading_id')
                    ->whereNotNull('trading_password')
                    ->distinct()
                    ->count('user_id');
        // Step 4: Account is active
        $step4 = User::where('status', 'active')->count();

        return [
            'total' => $total,
            'steps' => [
                ['num' => 1, 'label' => 'Choose Path',            'count' => $step1, 'pct' => round($step1 / $total * 100)],
                ['num' => 2, 'label' => 'Open/Fund Account',      'count' => $step2, 'pct' => round($step2 / $total * 100)],
                ['num' => 3, 'label' => 'Submit MT4/MT5 Details', 'count' => $step3, 'pct' => round($step3 / $total * 100)],
                ['num' => 4, 'label' => 'Account Activated',      'count' => $step4, 'pct' => round($step4 / $total * 100)],
            ],
        ];
    }

    // ─── Account status breakdown ─────────────────────────────────────────────

    public function getAccountStatus(): array
    {
        $total   = User::count();
        $withPkg = User::whereHas('userPackages')->count();
        $withMt4 = UserPackage::whereNotNull('trading_id')
                    ->whereNotNull('trading_password')
                    ->distinct()
                    ->count('user_id');
        $active  = User::where('status', 'active')->count();
        $pending = User::whereIn('status', ['pending', 'registered'])->count();

        // Overall badge reflects the dominant platform state
        if ($active > 0 && $active >= $pending) {
            $badge = 'ACTIVE';
            $badgeStyle = 'background:#dcfce7;color:#166534;';
        } elseif ($pending > 0) {
            $badge = 'PENDING';
            $badgeStyle = 'background:#fef3c7;color:#92400e;';
        } else {
            $badge = 'REGISTERED';
            $badgeStyle = 'background:#ede9fe;color:#5b21b6;';
        }

        return [
            'badge'      => $badge,
            'badgeStyle' => $badgeStyle,
            'items'      => [
                [
                    'label'  => 'Registration Completed',
                    'status' => $total > 0 ? 'done' : 'pending',
                    'note'   => $total > 0 ? number_format($total) . ' users' : 'No users',
                ],
                [
                    'label'  => 'MT4/MT5 Details',
                    'status' => $withMt4 === 0 ? 'none' : ($withMt4 < $withPkg ? 'partial' : 'done'),
                    'note'   => $withMt4 === 0 ? 'Not Submitted' : number_format($withMt4) . ' submitted',
                ],
                [
                    'label'  => 'Activation',
                    'status' => $active === 0 ? 'pending' : ($active < $total ? 'partial' : 'done'),
                    'note'   => $active === 0 ? 'Pending' : number_format($active) . ' active',
                ],
            ],
        ];
    }

    // ─── Quick actions ────────────────────────────────────────────────────────

    public function getQuickActions(): array
    {
        return [
            ['label' => 'All Users',    'url' => UserResource::getUrl('index'),        'icon' => 'heroicon-o-users'],
            ['label' => 'Add New User', 'url' => UserResource::getUrl('create'),       'icon' => 'heroicon-o-user-plus'],
            ['label' => 'Packages',     'url' => PackageResource::getUrl('index'),     'icon' => 'heroicon-o-rectangle-stack'],
            ['label' => 'Manage Customers', 'url' => UserResource::getUrl('index'),    'icon' => 'heroicon-o-credit-card'],
            ['label' => 'Tickets',      'url' => TicketResource::getUrl('index'),      'icon' => 'heroicon-o-chat-bubble-left-right'],
            ['label' => 'Countries',    'url' => CountryResource::getUrl('index'),     'icon' => 'heroicon-o-globe-alt'],
        ];
    }
}