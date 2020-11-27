<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Rules\ReferrerInWaitlist;
use App\Rules\UniqueSubscriberEmailForWaitlist;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'waitlist' => 'required|exists:waitlists,id',
            'email' => [
                'required',
                'email',
                new UniqueSubscriberEmailForWaitlist($request->get('waitlist')),
            ],
            'referrer' => [
                'string',
                'exists:subscribers,id',
                new ReferrerInWaitlist($request->get('waitlist')),
            ],
        ]);

        $subscriber = new Subscriber();
        $subscriber->waitlist_id = $data['waitlist'];
        $subscriber->email = $data['email'];

        if (isset($data['referrer'])) {
            $subscriber->referrer_id = $data['referrer'];
            $subscriber->was_referred = true;
        }

        $subscriber->save();

        return response()->json([
            'id' => $subscriber->id,
            'position' => $subscriber->getPosition(),
        ], Response::HTTP_CREATED);
    }

    public function show(Subscriber $subscriber)
    {
        return response()->json([
            'position' => $subscriber->getPosition(),
            'total' => Subscriber::where('waitlist_id', $subscriber->waitlist_id)->count(),
        ]);
    }
}
