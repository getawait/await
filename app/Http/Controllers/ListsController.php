<?php

namespace App\Http\Controllers;

use App\Exports\SubscribersExport;
use App\Http\Resources\WaitlistResource;
use App\Models\Waitlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        if (!auth()->user()->can('view', $waitlist)) {
            return response('You are not allowed to view this waitlist!', 403);
        }

        Inertia::share('flash', function () {
            return [
                'successMessage' => Session::get('successMessage'),
            ];
        });

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
        if (!auth()->user()->can('create', Waitlist::class)) {
            return response('You are not allowed to create a waitlist!', 403);
        }

        $user = auth()->user();

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

    public function export(Waitlist $waitlist)
    {
        if (!auth()->user()->can('view', $waitlist)) {
            return response('You are not allowed to view this waitlist!', 403);
        }

        $fileName = $waitlist->name . '-' . Carbon::now()->toString() . '.csv';

        return (new SubscribersExport($waitlist))->download($fileName);
    }

    public function delete(Waitlist $waitlist)
    {
        if (!auth()->user()->can('delete', $waitlist)) {
            return response('You are not allowed to delete this waitlist!', 403);
        }

        $waitlist->delete();

        Inertia::share('flash', function () {
            return [
                'successMessage' => 'Successfully deleted waitlist!',
            ];
        });

        return Inertia::render('Lists/Index');
    }
}
