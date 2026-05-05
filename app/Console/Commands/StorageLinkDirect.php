<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StorageLinkDirect extends Command
{
    protected $signature = 'storage:link-direct';

    protected $description = 'Create the storage symlink using PHP symlink() directly (for shared hosting)';

    public function handle(): int
    {
        $target = realpath(storage_path('app/public'));
        $link   = public_path('storage');

        if (is_link($link)) {
            $this->info('Symlink already exists at public/storage.');
            return self::SUCCESS;
        }

        if (file_exists($link)) {
            $this->error('A file or directory already exists at public/storage — please remove it first.');
            return self::FAILURE;
        }

        if (! function_exists('symlink')) {
            $this->error('PHP symlink() function is disabled on this server. Create the link manually via SSH: ln -s ' . $target . ' ' . $link);
            return self::FAILURE;
        }

        if (symlink($target, $link)) {
            $this->info('The [public/storage] directory has been linked.');
            return self::SUCCESS;
        }

        $this->error('Failed to create symlink. Try via SSH: ln -s ' . $target . ' ' . $link);
        return self::FAILURE;
    }
}
