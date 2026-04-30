<?php

namespace App\Filament\Pages;

use App\Filament\Resources\AdminResource;
use App\Filament\Resources\CountryResource;
use App\Filament\Resources\PackageResource;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\UserResource;
use App\Models\Country;
use App\Models\Package;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserPackage;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    public function getTitle(): string | Htmlable
    {
        return 'Dashboard';
    }

    public function getDashboardSummary(): array
    {
        $activeUsers = User::query()->where('status', 'active')->count();
        $activePlans = UserPackage::query()->where('status', 'active')->count();
        $openTickets = Ticket::query()->where('status', 'open')->count();
        $activePackages = Package::query()->where('is_active', true)->count();
        $countries = Country::query()->where('is_active', true)->count();

        return [
            [
                'label' => 'Customers',
                'value' => User::query()->count(),
                'detail' => $activeUsers . ' active accounts',
                'icon' => 'heroicon-o-users',
                'color' => 'amber',
            ],
            [
                'label' => 'Live plans',
                'value' => $activePlans,
                'detail' => 'Active user packages',
                'icon' => 'heroicon-o-rectangle-stack',
                'color' => 'emerald',
            ],
            [
                'label' => 'Open tickets',
                'value' => $openTickets,
                'detail' => 'Needs attention',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'color' => 'rose',
            ],
            [
                'label' => 'Catalog',
                'value' => $activePackages,
                'detail' => $countries . ' active countries',
                'icon' => 'heroicon-o-building-library',
                'color' => 'sky',
            ],
        ];
    }

    public function getMonthlyHighlights(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        return [
            [
                'label' => 'New customers this month',
                'value' => User::query()->where('created_at', '>=', $startOfMonth)->count(),
            ],
            [
                'label' => 'Packages created this month',
                'value' => Package::query()->where('created_at', '>=', $startOfMonth)->count(),
            ],
            [
                'label' => 'Tickets opened this month',
                'value' => Ticket::query()->where('created_at', '>=', $startOfMonth)->count(),
            ],
            [
                'label' => 'Countries available',
                'value' => Country::query()->where('is_active', true)->count(),
            ],
        ];
    }

    public function getRecentTickets(): array
    {
        return Ticket::query()
            ->latest()
            ->limit(5)
            ->get(['id', 'subject', 'status', 'priority', 'created_at'])
            ->map(fn (Ticket $ticket): array => [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'created_at' => optional($ticket->created_at)->diffForHumans(),
            ])
            ->all();
    }

    public function getQuickActions(): array
    {
        return [
            [
                'label' => 'Customers',
                'description' => 'Review accounts and statuses.',
                'url' => UserResource::getUrl('index'),
                'icon' => 'heroicon-o-users',
            ],
            [
                'label' => 'Packages',
                'description' => 'Manage plans and min deposits.',
                'url' => PackageResource::getUrl('index'),
                'icon' => 'heroicon-o-credit-card',
            ],
            [
                'label' => 'Tickets',
                'description' => 'Handle support requests.',
                'url' => TicketResource::getUrl('index'),
                'icon' => 'heroicon-o-chat-bubble-left-right',
            ],
            [
                'label' => 'Countries',
                'description' => 'Update availability and regions.',
                'url' => CountryResource::getUrl('index'),
                'icon' => 'heroicon-o-globe-alt',
            ],
            [
                'label' => 'Admins',
                'description' => 'Keep admin access tidy.',
                'url' => AdminResource::getUrl('index'),
                'icon' => 'heroicon-o-shield-check',
            ],
        ];
    }
}
