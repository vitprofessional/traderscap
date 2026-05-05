<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected ?string $subheading = 'View and manage all registered customer accounts and their subscription status.';

    public function getTitle(): string|Htmlable
    {
        return 'Customers';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New customer')
                ->icon('heroicon-m-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge((string) User::query()->count()),

            'registered' => Tab::make('Registered')
                ->badge((string) $this->applyTabScope(User::query(), 'registered')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'registered')),

            'banned' => Tab::make('Banned')
                ->badge((string) $this->applyTabScope(User::query(), 'banned')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'banned')),

            'pending' => Tab::make('Pending Verify')
                ->badge((string) $this->applyTabScope(User::query(), 'pending')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'pending')),

            'active_waiting' => Tab::make('Active Waiting')
                ->badge((string) $this->applyTabScope(User::query(), 'active_waiting')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'active_waiting')),

            'active' => Tab::make('Active')
                ->badge((string) $this->applyTabScope(User::query(), 'active')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'active')),

            'expired' => Tab::make('Expired')
                ->badge((string) $this->applyTabScope(User::query(), 'expired')->count())
                ->modifyQueryUsing(fn (Builder $q): Builder => $this->applyTabScope($q, 'expired')),
        ];
    }

    protected function applyTabScope(Builder $query, string $tab): Builder
    {
        // Register / Banned: purely from account_status
        if (in_array($tab, ['registered', 'banned'], true)) {
            return $query->where('account_status', $tab);
        }

        // Package-derived tabs only apply to account_status = active users
        $query->where('account_status', 'active');

        if ($tab === 'active') {
            return $query->whereHas(
                'userPackages',
                fn (Builder $q): Builder => $q->where('status', 'active')
            );
        }

        if ($tab === 'active_waiting') {
            return $query
                ->whereHas('userPackages', fn (Builder $q): Builder => $q->where('status', 'active_waiting'))
                ->whereDoesntHave('userPackages', fn (Builder $q): Builder => $q->where('status', 'active'));
        }

        if ($tab === 'pending') {
            return $query
                ->whereHas('userPackages', fn (Builder $q): Builder => $q->where('status', 'pending'))
                ->whereDoesntHave('userPackages', fn (Builder $q): Builder => $q->whereIn('status', ['active', 'active_waiting']));
        }

        if ($tab === 'expired') {
            return $query
                ->whereHas('userPackages', fn (Builder $q): Builder => $q->where('status', 'expired'))
                ->whereDoesntHave('userPackages', fn (Builder $q): Builder => $q->whereIn('status', ['active', 'active_waiting', 'pending']));
        }

        return $query;
    }
}
