<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->can('manage patients');
    }

    public function viewAny(User $user)
    {
        return $this->manage($user);
    }

    public function view(User $user, Patient $patient)
    {
        return $this->manage($user);
    }

    public function create(User $user)
    {
        return $this->manage($user);
    }

    public function update(User $user, Patient $patient)
    {
        return $this->manage($user);
    }

    public function delete(User $user, Patient $patient)
    {
        return $this->manage($user);
    }
}
