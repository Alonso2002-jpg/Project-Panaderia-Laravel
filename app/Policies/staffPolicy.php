<?php

namespace App\Policies;

use App\Models\staff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class staffPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, staff $staff): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, staff $staff): bool
    {
    }

    public function delete(User $user, staff $staff): bool
    {
    }

    public function restore(User $user, staff $staff): bool
    {
    }

    public function forceDelete(User $user, staff $staff): bool
    {
    }
}
