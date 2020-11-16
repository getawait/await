<?php

namespace App\Http\Controllers;

use App\Http\Resources\WaitlistResource;
use App\Models\Subscriber;
use Inertia\Inertia;

class SubscribersController extends Controller
{
    public function delete(Subscriber $subscriber)
    {
        if (!auth()->user()->can('delete', $subscriber)) {
            return response('You are not allowed to delete this subscriber!', 403);
        }

        Subscriber::where('referrer_id', $subscriber->id)
            ->update(['referrer_id' => null]);

        $subscriber->delete();

        Inertia::share('flash', function () {
            return [
                'successMessage' => 'Successfully deleted subscriber!',
            ];
        });

        return Inertia::render('Lists/Show', [
            'list' => new WaitlistResource($subscriber->waitlist),
        ]);
    }
}
