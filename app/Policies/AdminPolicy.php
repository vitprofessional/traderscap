<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if (! $user instanceof Admin) {
            return false;
        }

        // Super admins bypass all checks
        if ($user->role === 'super') {
            return true;
        }
    }

    public function viewAny($user): bool
    {
        if (! $user instanceof Admin) {
            return false;
        }

        return in_array($user->role, ['super', 'general', 'moderator'], true);
    }

    public function view($user, Admin $model): bool
    {
        if (! $user instanceof Admin) {
            return false;
        }

        return in_array($user->role, ['super', 'general', 'moderator'], true);
    }

    public function create($user): bool
    {
        if (! $user instanceof Admin) {
            return false;
        }

        // General and super can create
        return in_array($user->role, ['super', 'general'], true);
    }

    public function update($user, Admin $model): bool
    {
        if (! $user instanceof Admin) {
            return false;
        }

        // Prevent non-super from updating a super admin
        if ($model->role === 'super') {
            return false;
        }

        // General can update others; moderator can update only themselves
        if ($user->role === 'general') {
            return true;
        }

        if ($user->role === 'moderator') {
            return $user->id === $model->id;
        }

        return false;
    }

    public function delete($user, Admin $model): bool
    {
        // Only super can delete (handled in before), so deny here
        return false;
    }
}
