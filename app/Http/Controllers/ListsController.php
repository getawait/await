<?php

namespace App\Http\Controllers;

use App\Http\Resources\WaitlistResource;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ListsController extends Controller
{
    public function index()
    {
        Inertia::share('flash', function () {
            return [
                'successMessage' => Session::get('successMessage'),
            ];
        });


        return Inertia::render('Lists/Index', [
            'lists' => WaitlistResource::collection(auth()->user()->currentLists),
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

        Validator::make([
            'name' => $request->name
        ], [
            'name' => 'required|string',
        ])->validateWithBag('createList');

        Waitlist::create([
            'name' => $request->name,
            'team_id' => $user->currentTeam->id,
        ]);

        return response()
            ->redirectToRoute('lists.index')
            ->with('successMessage', 'You have successfully created new waitlist!');
    }
}
