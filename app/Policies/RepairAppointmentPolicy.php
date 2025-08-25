<?php

namespace App\Policies;

use App\Models\RepairAppointment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepairAppointmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RepairAppointment $repair)
    {
        return $user->id === $repair->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, RepairAppointment $repair)
    {
        return $user->id === $repair->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RepairAppointment $repair)
    {
        return $user->id === $repair->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RepairAppointment $repair)
    {
        return $user->id === $repair->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RepairAppointment  $repair
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RepairAppointment $repair)
    {
        return $user->id === $repair->user_id;
    }
}
