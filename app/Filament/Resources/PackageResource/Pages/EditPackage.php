<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use App\Models\Package;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected ?string $subheading = 'Update the package name, min deposit, or listed facilities.';

    protected ?string $replacedRecommendedPackageName = null;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Package';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete package')
                ->requiresConfirmation(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = $this->normalizePackageData($data);

        if (! empty($data['is_recommended'])) {
            $this->replacedRecommendedPackageName = Package::query()
                ->where('is_recommended', true)
                ->whereKeyNot($this->record->getKey())
                ->value('name');

            Package::query()
                ->whereKeyNot($this->record->getKey())
                ->update(['is_recommended' => false]);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->record->is_recommended) {
            return;
        }

        if (! $this->replacedRecommendedPackageName) {
            return;
        }

        Notification::make()
            ->title("Recommended package updated. {$this->replacedRecommendedPackageName} was replaced by {$this->record->name}.")
            ->success()
            ->send();
    }

    private function normalizePackageData(array $data): array
    {
        $durationMultipliers = [
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            'yearly' => 365,
        ];

        $rawType = isset($data['duration_type']) ? trim((string) $data['duration_type']) : '';
        $rawValue = $data['duration_value'] ?? null;

        $durationType = array_key_exists($rawType, $durationMultipliers) ? $rawType : null;
        $durationValue = is_numeric($rawValue) ? max(1, (int) $rawValue) : null;

        // If admin leaves duration fields blank while editing, keep existing stored values.
        if (! $durationType && ! $durationValue) {
            $durationType = $this->record->duration_type ?: 'daily';
            $durationValue = (int) ($this->record->duration_value ?: 30);
        } else {
            $durationType ??= ($this->record->duration_type ?: 'daily');
            $durationValue ??= (int) ($this->record->duration_value ?: 30);
        }

        $multiplier = $durationMultipliers[$durationType] ?? 1;

        $data['duration_type'] = $durationType;
        $data['duration_value'] = max(1, (int) $durationValue);
        $data['duration_days'] = $durationValue * $multiplier;

        $raw = $data['facilities'] ?? [];
        if (is_string($raw)) {
            $raw = array_filter(array_map('trim', explode('/', $raw)), fn ($v) => $v !== '');
        }
        $data['facilities'] = Package::normalizeFacilities(is_array($raw) ? $raw : []);

        return $data;
    }
}
