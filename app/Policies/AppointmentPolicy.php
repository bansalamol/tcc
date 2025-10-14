<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->can('manage appointments');
    }

    public function viewAny(User $user)
    {
        return $this->manage($user);
    }

    public function view(User $user, Appointment $appointment)
    {
        return $this->manage($user);
    }

    public function create(User $user)
    {
        return $this->manage($user);
    }

    public function update(User $user, Appointment $appointment)
    {
        return $this->manage($user);
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $this->manage($user);
    }
}
