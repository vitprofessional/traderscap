<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'facilities',
        'price',
        'duration_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

                $items = preg_split('/\r\n|\r|\n|,/', (string) $value) ?: [];

                return array_values(array_filter(array_map('trim', $items), fn ($item) => $item !== ''));
            },
            set: function ($value): ?string {
                if ($value === null || $value === '') {
                    return null;
                }

                $items = is_array($value)
                    ? $value
                    : (preg_split('/\r\n|\r|\n|,/', (string) $value) ?: []);

                $normalized = array_values(array_filter(array_map('trim', $items), fn ($item) => $item !== ''));

                return json_encode($normalized);
            },
        );
    }
}
