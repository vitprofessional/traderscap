<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    private const FACILITY_SEPARATOR_PATTERN = '/\r\n|\r|\n|,|\s\/\s/';

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
                    return self::normalizeFacilities($value);
                }

                if ($value === null || $value === '') {
                    return [];
                }

                $decoded = json_decode((string) $value, true);

                if (is_array($decoded)) {
                    return self::normalizeFacilities($decoded);
                }

                if (is_string($decoded)) {
                    $value = $decoded;
                }

                return self::normalizeFacilities([(string) $value]);
            },
            set: function ($value): ?string {
                if ($value === null || $value === '') {
                    return null;
                }

                $normalized = self::normalizeFacilities(is_array($value) ? $value : [$value]);

                return json_encode($normalized);
            },
        );
    }

    public static function normalizeFacilities(array $items): array
    {
        $normalizedItems = [];

        foreach ($items as $item) {
            $raw = is_array($item)
                ? ($item['value'] ?? $item['facility'] ?? '')
                : $item;

            if (! is_string($raw) && ! is_numeric($raw)) {
                continue;
            }

            $parts = preg_split(self::FACILITY_SEPARATOR_PATTERN, (string) $raw) ?: [];

            foreach ($parts as $part) {
                $part = trim($part);

                if ($part !== '') {
                    $normalizedItems[] = $part;
                }
            }
        }

        return array_values(array_unique($normalizedItems));
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
