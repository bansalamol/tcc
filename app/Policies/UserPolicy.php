<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->hasAnyRole(['Administrator', 'Manager']);
    }

    public function viewAny(User $user)
    {
        return $this->manage($user);
    }

    public function view(User $user, User $model)
    {
        return $this->manage($user);
    }

    public function create(User $user)
    {
        return $this->manage($user);
    }

    public function update(User $user, User $model)
    {
        return $this->manage($user);
    }

    public function delete(User $user, User $model)
    {
        return $this->manage($user);
    }
}
