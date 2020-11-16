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
        $team = $waitlist->team;

        return $user->belongsToTeam($team) && $user->hasTeamPermission($team, 'view');
    }

    public function create(User $user)
    {
       return $user->hasTeamPermission($user->currentTeam, 'create');
    }

    public function update(User $user, Waitlist $waitlist)
    {
        $team = $waitlist->team;

        return $user->belongsToTeam($team) && $user->hasTeamPermission($team, 'update');
    }

    public function delete(User $user, Waitlist $waitlist)
    {
        $team = $waitlist->team;

        return $user->belongsToTeam($team) && $user->hasTeamPermission($team, 'delete');
    }
}
