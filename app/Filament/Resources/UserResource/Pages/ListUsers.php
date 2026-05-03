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

    /**
     * Package statuses that should be treated as active for customer categorization.
     */
    protected array $activePackageStatuses = ['active', 'active_waiting'];

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
                ->badge((string) $this->countForEffectiveStatus('registered'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $this->applyEffectiveStatusScope($query, 'registered')),
            'pending' => Tab::make('Pending Verify')
                ->badge((string) $this->countForEffectiveStatus('pending'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $this->applyEffectiveStatusScope($query, 'pending')),
            'active' => Tab::make('Active')
                ->badge((string) $this->countForEffectiveStatus('active'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $this->applyEffectiveStatusScope($query, 'active')),
            'expired' => Tab::make('Expired')
                ->badge((string) $this->countForEffectiveStatus('expired'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $this->applyEffectiveStatusScope($query, 'expired')),
        ];
    }

    protected function countForEffectiveStatus(string $status): int
    {
        return $this->applyEffectiveStatusScope(User::query(), $status)->count();
    }

    protected function applyEffectiveStatusScope(Builder $query, string $status): Builder
    {
        if ($status === 'active') {
            return $query->where(function (Builder $statusQuery): void {
                $statusQuery
                    ->where('status', 'active')
                    ->orWhereHas('userPackages', fn (Builder $packageQuery): Builder => $packageQuery->whereIn('status', $this->activePackageStatuses));
            });
        }

        return $query
            ->where('status', $status)
            ->whereDoesntHave('userPackages', fn (Builder $packageQuery): Builder => $packageQuery->whereIn('status', $this->activePackageStatuses));
    }
}
