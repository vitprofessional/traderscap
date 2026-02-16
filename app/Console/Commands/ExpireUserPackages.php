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

        foreach ($expired as $up) {
            $up->status = 'expired';
            $up->save();

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

            // Update user status to expired if they have no active packages
            $user = User::find($up->user_id);
            if ($user) {
                $hasActive = $user->userPackages()->where('status', 'active')->exists();
                if (! $hasActive) {
                    $user->status = 'expired';
                    $user->save();
                    $this->info("User id={$user->id} marked as expired");
                }
            }
        }

        // Ensure users with active packages are marked 'active'
        $this->info('Ensuring users with active packages are marked active...');
        $usersWithActive = User::whereHas('userPackages', function ($q) {
            $q->where('status', 'active')->where(function ($q2) {
                $q2->whereNull('ends_at')->orWhere('ends_at', '>=', Carbon::today());
            });
        })->get();

        foreach ($usersWithActive as $u) {
            if ($u->status !== 'active') {
                $u->status = 'active';
                $u->save();
                $this->info("User id={$u->id} marked as active");
            }
        }

        $this->info('Expiration check completed.');

        return 0;
    }
}
