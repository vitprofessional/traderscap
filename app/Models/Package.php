<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public const DURATION_TYPES = [
        'daily' => 1,
        'weekly' => 7,
        'monthly' => 30,
        'yearly' => 365,
    ];

    protected $fillable = [
        'name',
        'description',
        'facilities',
        'price',
        'duration_type',
        'duration_value',
        'duration_days',
        'is_active',
        'is_recommended',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_recommended' => 'boolean',
    ];

    protected function facilities(): Attribute
    {
        return Attribute::make(
            get: function ($value): array {
                if (is_array($value)) {
                    return array_values(array_filter(array_map('trim', $value), fn ($item) => $item !== ''));
                }

                if ($value === null || $value === '') {
                    return [];
                }

                $decoded = json_decode((string) $value, true);

                if (is_array($decoded)) {
                    return array_values(array_filter(array_map('trim', $decoded), fn ($item) => $item !== ''));
                }

                if (is_string($decoded)) {
                    $value = $decoded;
                }

                $items = preg_split('/\r\n|\r|\n|\/|,/', (string) $value) ?: [];

                return array_values(array_filter(array_map('trim', $items), fn ($item) => $item !== ''));
            },
            set: function ($value): ?string {
                if ($value === null || $value === '') {
                    return null;
                }

                $items = is_array($value) ? $value : [$value];

                $normalizedItems = [];

                foreach ($items as $item) {
                    $raw = is_array($item)
                        ? ($item['value'] ?? $item['facility'] ?? '')
                        : $item;

                    if (! is_string($raw) && ! is_numeric($raw)) {
                        continue;
                    }

                    $parts = preg_split('/\r\n|\r|\n|\/|,/', (string) $raw) ?: [];

                    foreach ($parts as $part) {
                        $part = trim($part);

                        if ($part !== '') {
                            $normalizedItems[] = $part;
                        }
                    }
                }

                $normalized = array_values(array_unique($normalizedItems));

                return json_encode($normalized);
            },
        );
    }

    protected function durationLabel(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $type = $this->duration_type ?: 'daily';
                $value = max(1, (int) ($this->duration_value ?: 1));

                $labels = [
                    'daily' => ['singular' => 'Day', 'plural' => 'Days'],
                    'weekly' => ['singular' => 'Week', 'plural' => 'Weeks'],
                    'monthly' => ['singular' => 'Month', 'plural' => 'Months'],
                    'yearly' => ['singular' => 'Year', 'plural' => 'Years'],
                ];

                $labelSet = $labels[$type] ?? $labels['daily'];

                return $value . ' ' . ($value === 1 ? $labelSet['singular'] : $labelSet['plural']);
            }
        );
    }
}
