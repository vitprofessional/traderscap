<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserPackage;
use App\Models\User;
use Carbon\Carbon;

class ExpireUserPackages extends Command
{
    protected $signature = 'userpackages:expire';

    protected $description = 'Expire user packages whose end date has passed and update user status.';

    public function handle()
    {
        $today = Carbon::today();

        $this->info('Starting expiration check: ' . $today->toDateString());

        $expired = UserPackage::whereNotNull('ends_at')
            ->where('ends_at', '<', $today)
            ->where('status', '!=', 'expired')
            ->get();

        $this->info('Found ' . $expired->count() . ' packages to expire.');

        $affectedUserIds = [];

        foreach ($expired as $up) {
            $up->status = 'expired';
            $up->save(); // fires UserPackage::saved → User::syncStatus() automatically

            $affectedUserIds[] = $up->user_id;

            $this->info("Expired package id={$up->id} for user_id={$up->user_id}");

            // Notify the user
            try {
                $user = User::find($up->user_id);
                if ($user) {
                    $user->notify(new \App\Notifications\PackageExpiredNotification($up));
                }
            } catch (\Throwable $e) {
                report($e);
                $this->error('Failed to send notification for user_package id=' . $up->id);
            }
        }

        // Log the resulting user statuses for any affected users
        foreach (array_unique($affectedUserIds) as $uid) {
            $u = User::find($uid);
            if ($u) {
                $this->info("User id={$u->id} status is now: {$u->status}");
            }
        }

        $this->info('Expiration check completed.');

        return 0;
    }
}
