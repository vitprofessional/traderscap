<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use App\Models\Package;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

    protected ?string $subheading = 'Define a new service package with min deposit and included facilities.';

    protected ?string $replacedRecommendedPackageName = null;

    public function getTitle(): string|Htmlable
    {
        return 'Create Package';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data = $this->normalizePackageData($data);

        if (! empty($data['is_recommended'])) {
            $this->replacedRecommendedPackageName = Package::query()
                ->where('is_recommended', true)
                ->value('name');

            Package::query()->update(['is_recommended' => false]);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        if (! $this->record->is_recommended) {
            return;
        }

        $title = $this->replacedRecommendedPackageName
            ? "Recommended package updated. {$this->replacedRecommendedPackageName} was replaced by {$this->record->name}."
            : "Recommended package set to {$this->record->name}.";

        Notification::make()
            ->title($title)
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

        // Keep duration optional in the form; fallback to schema defaults when omitted.
        if (! $durationType && ! $durationValue) {
            $durationType = 'daily';
            $durationValue = 30;
        } else {
            $durationType ??= 'daily';
            $durationValue ??= 30;
        }

        $multiplier = $durationMultipliers[$durationType] ?? 1;

        $data['duration_type'] = $durationType;
        $data['duration_value'] = $durationValue;
        $data['duration_days'] = $durationValue * $multiplier;

        $raw = $data['facilities'] ?? [];
        if (is_string($raw)) {
            $raw = array_filter(array_map('trim', explode('/', $raw)), fn ($v) => $v !== '');
        }
        $data['facilities'] = Package::normalizeFacilities(is_array($raw) ? $raw : []);

        return $data;
    }
}
