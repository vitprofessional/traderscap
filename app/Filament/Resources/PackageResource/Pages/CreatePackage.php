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

    protected ?string $subheading = 'Define a new service package with min deposit, duration, and included facilities.';

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
        $durationType = (string) ($data['duration_type'] ?? 'monthly');
        $durationValue = max(1, (int) ($data['duration_value'] ?? 1));

        $durationMultipliers = [
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            'yearly' => 365,
        ];

        $multiplier = $durationMultipliers[$durationType] ?? 30;

        $data['duration_type'] = array_key_exists($durationType, $durationMultipliers) ? $durationType : 'monthly';
        $data['duration_value'] = $durationValue;
        $data['duration_days'] = $durationValue * $multiplier;

        $facilityRows = is_array($data['facilities'] ?? null) ? $data['facilities'] : [];
        $facilities = [];

        foreach ($facilityRows as $facilityRow) {
            $parts = preg_split('/\r\n|\r|\n|\/|,/', (string) $facilityRow) ?: [];

            foreach ($parts as $part) {
                $part = trim($part);

                if ($part !== '') {
                    $facilities[] = $part;
                }
            }
        }

        $data['facilities'] = array_values(array_unique($facilities));

        return $data;
    }
}
