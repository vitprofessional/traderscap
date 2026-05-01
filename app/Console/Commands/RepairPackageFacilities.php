<?php

namespace App\Console\Commands;

use App\Models\Package;
use Illuminate\Console\Command;

class RepairPackageFacilities extends Command
{
    protected $signature = 'packages:repair-facilities {--overwrite : Replace facilities even when a package already has values}';

    protected $description = 'Backfill missing package facilities so existing packages work with the new package system.';

    public function handle(): int
    {
        $updatedCount = 0;
        $skippedCount = 0;
        $overwrite = (bool) $this->option('overwrite');

        Package::query()->get()->each(function (Package $package) use (&$updatedCount, &$skippedCount, $overwrite): void {
            $existingFacilities = Package::normalizeFacilities($package->facilities ?? []);

            if (! $overwrite && $existingFacilities !== []) {
                $skippedCount++;

                return;
            }

            $facilities = $this->defaultFacilitiesFor($package);

            $package->forceFill([
                'facilities' => $facilities,
            ])->save();

            $updatedCount++;

            $this->line("Updated package {$package->name}: " . implode(' | ', $facilities));
        });

        $this->info("Facilities repaired for {$updatedCount} package(s); skipped {$skippedCount} package(s).");

        return self::SUCCESS;
    }

    private function defaultFacilitiesFor(Package $package): array
    {
        $packageName = strtolower(trim($package->name));

        $namedDefaults = [
            'basic' => [
                'Beginner-friendly account setup guidance',
                'Managed forex market exposure',
                'Weekly performance updates',
                'Email support',
            ],
            'premium' => [
                'Advanced portfolio management',
                'Enhanced risk control strategy',
                'Priority support access',
                'Detailed performance reporting',
                'Dedicated account oversight',
            ],
            'pro' => [
                'Advanced trade management',
                'Risk-adjusted portfolio strategy',
                'Priority account review',
                'Performance reporting',
            ],
        ];

        if (array_key_exists($packageName, $namedDefaults)) {
            return $namedDefaults[$packageName];
        }

        if ((float) $package->price >= 10000) {
            return [
                'Advanced portfolio management',
                'Priority support access',
                'Detailed performance reporting',
                'Enhanced risk control strategy',
            ];
        }

        if ((float) $package->price > 0) {
            return [
                'Managed market participation',
                'Structured risk control',
                'Periodic performance reporting',
                'Support assistance',
            ];
        }

        return [
            'Beginner-friendly account setup guidance',
            'Managed forex market exposure',
            'Weekly performance updates',
            'Email support',
        ];
    }
}