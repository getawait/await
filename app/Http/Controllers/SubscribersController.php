<?php

namespace App\Http\Controllers;

use App\Http\Resources\WaitlistResource;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class SubscribersController extends Controller
{
    public function delete(Subscriber $subscriber)
    {
        // todo: permissions

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
