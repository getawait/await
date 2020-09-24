<?php

namespace App\Http\Controllers;

use App\Http\Resources\WaitlistResource;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ListsController extends Controller
{
    public function index()
    {
        return Inertia::render('Lists/Index', [
            'list' => auth()->user()->currentLists,
        ]);
    }

    public function show(Waitlist $waitlist)
    {
        return Inertia::render('Lists/Show', [
            'list' => new WaitlistResource($waitlist),
        ]);
    }

    public function create()
    {
        return Inertia::render('Lists/Create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        Gate::forUser($user)->authorize('create', new Waitlist());

        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        Waitlist::create(array_merge(
            $validatedData,
            [
                'team_id' => $user->currentTeam->id,
            ]
        ));

        return response()
            ->redirectToRoute('lists.index')
            ->with('message', 'Profile updated!');
    }
}
