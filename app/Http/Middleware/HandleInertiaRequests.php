<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HandleInertiaRequests
{
    public function handle(Request $request, \Closure $next)
    {
        $user = auth()->user();

        if ($user->current_team_id) {
            Inertia::share([
                'user' => array_merge(
                    [
                        'permissions' => $user->teamRole($user->currentTeam)->permissions,
                    ],
                    collect(Inertia::getShared('user')())->toArray()
                ),
            ]);
        }

        return $next($request);
    }
}