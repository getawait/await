<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Waitlist;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Waitlist $waitlist)
    {
        return $user->belongsToTeam($waitlist->team);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Waitlist $waitlist)
    {
        return $user->belongsToTeam($waitlist->team);
    }

    /**
     * Only the user that owns the team that the waitlist is associated with, can delete the waitlist
     *
     * @param User     $user
     * @param Waitlist $waitlist
     *
     * @return bool
     */
    public function delete(User $user, Waitlist $waitlist)
    {
        return $user->ownsTeam($waitlist->team);
    }
}
