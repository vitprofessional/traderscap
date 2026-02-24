<?php

namespace App\Console\Commands;

use App\Models\Broker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SyncBrokerLogos extends Command
{
    protected $signature = 'brokers:sync-logos {--force : Overwrite existing files}';

    protected $description = 'Create missing broker logo files in storage/app/public/brokers using the default logo.';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $fallbackPath = 'brokers/logos/logo.png';

        if (! $disk->exists($fallbackPath)) {
            $this->error("Fallback logo not found: {$fallbackPath}");

            return self::FAILURE;
        }

        $fallbackContent = $disk->get($fallbackPath);
        $force = (bool) $this->option('force');

        $brokers = Broker::query()
            ->whereNotNull('logo')
            ->where('logo', '!=', '')
            ->get(['id', 'name', 'logo']);

        $created = 0;
        $skipped = 0;

        foreach ($brokers as $broker) {
            $rawPath = (string) $broker->logo;
            $path = preg_replace('#^(storage/app/public|public)/#', '', $rawPath);

            if (! is_string($path) || trim($path) === '') {
                $this->warn("Skipped broker #{$broker->id} ({$broker->name}) due to invalid logo path.");
                $skipped++;
                continue;
            }

            if ($disk->exists($path) && ! $force) {
                $this->line("Exists: {$path}");
                $skipped++;
                continue;
            }

            $dir = dirname($path);
            if ($dir !== '.' && ! $disk->exists($dir)) {
                $disk->makeDirectory($dir);
            }

            $disk->put($path, $fallbackContent, 'public');
            $this->info("Created: {$path}");
            $created++;
        }

        $this->newLine();
        $this->info("Done. Created {$created}, skipped {$skipped}.");

        return self::SUCCESS;
    }
}
