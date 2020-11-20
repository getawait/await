<?php

namespace App\Policies;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriberPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Subscriber $subscriber)
    {
        $team = $subscriber->waitlist->team;

        return $user->belongsToTeam($team) && $user->hasTeamPermission($team, 'update');
    }

    public function delete(User $user, Subscriber $subscriber)
    {
        $team = $subscriber->waitlist->team;

        return $user->belongsToTeam($team) && $user->hasTeamPermission($team, 'delete');
    }
}
