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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $hasStatus = static fn (string $status) => function ($subQuery) use ($status): void {
            $subQuery
                ->select(DB::raw(1))
                ->from('user_packages')
                ->whereColumn('user_packages.user_id', 'users.id')
                ->where('user_packages.status', $status);
        };

        $hasAnyStatus = static fn (array $statuses) => function ($subQuery) use ($statuses): void {
            $subQuery
                ->select(DB::raw(1))
                ->from('user_packages')
                ->whereColumn('user_packages.user_id', 'users.id')
                ->whereIn('user_packages.status', $statuses);
        };

        // Register / Banned: purely from account_status
        if (in_array($tab, ['registered', 'banned'], true)) {
            return $query->where('account_status', $tab);
        }

        // Package-derived tabs only apply to account_status = active users
        $query->where('account_status', 'active');

        if ($tab === 'active') {
            return $query->whereExists($hasStatus('active'));
        }

        if ($tab === 'active_waiting') {
            return $query
                ->whereExists($hasStatus('active_waiting'))
                ->whereNotExists($hasStatus('active'));
        }

        if ($tab === 'pending') {
            return $query
                ->whereExists($hasStatus('pending'))
                ->whereNotExists($hasAnyStatus(['active', 'active_waiting']));
        }

        if ($tab === 'expired') {
            return $query
                ->whereExists($hasStatus('expired'))
                ->whereNotExists($hasAnyStatus(['active', 'active_waiting', 'pending']));
        }

        return $query;
    }

    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        $table = $this->getTable();

        if ($table->hasDeferredFilters()) {
            $this->getTableFiltersForm()->statePath('tableFilters')->flushCachedAbsoluteStatePaths();
        }

        try {
            foreach ($table->getFilters() as $filter) {
                $state = $this->getTableFilterState($filter->getName()) ?? [];

                $filter->applyToBaseQuery($query, $state);
                $filter->apply($query, $state);
            }

            return $query;
        } finally {
            if ($table->hasDeferredFilters()) {
                $this->getTableFiltersForm()->statePath('tableDeferredFilters')->flushCachedAbsoluteStatePaths();
            }
        }
    }

    public function filterTableQuery(Builder $query): Builder
    {
        $this->applyFiltersToTableQuery($query);
        $this->ensureQueryHasModel($query);

        $this->applySearchToTableQuery($query);
        $this->ensureQueryHasModel($query);

        foreach ($this->getTable()->getVisibleColumns() as $column) {
            $column->applyRelationshipAggregates($query);

            if ($this->getTable()->isGroupsOnly()) {
                continue;
            }

            $column->applyEagerLoading($query);
        }

        return $query;
    }

    public function getFilteredTableQuery(): ?Builder
    {
        $query = $this->getTable()->getQuery();

        if (! $query) {
            return null;
        }

        $this->ensureQueryHasModel($query);

        return $this->filterTableQuery($query);
    }

    public function getFilteredSortedTableQuery(): ?Builder
    {
        $query = $this->getFilteredTableQuery();

        if (! $query) {
            return null;
        }

        $this->ensureQueryHasModel($query);

        $this->applyGroupingToTableQuery($query);
        $this->ensureQueryHasModel($query);

        $this->applySortingToTableQuery($query);

        return $query;
    }

    protected function ensureQueryHasModel(Builder $query): void
    {
        if ($query->getModel() instanceof Model) {
            return;
        }

        $query->setModel(new User());
    }
}
