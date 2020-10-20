<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'waitlist' => 'required|exists:waitlists,id',
            'email' => 'required|email',
            'referrer' => 'string|exists:subscribers,id',
        ]);

        $subscriber = new Subscriber();
        $subscriber->waitlist_id = $data['waitlist'];
        $subscriber->email = $data['email'];
        $subscriber->save();

        if (isset($data['referrer'])) {
            $subscriber->referrer = $data['referrer'];
        }

        return response()->json([
            'position' => $subscriber->getPosition(),
        ], Response::HTTP_CREATED);
    }

    public function show(Subscriber $subscriber)
    {
        return response()->json([
            'position' => $subscriber->getPosition(),
            'total' => Subscriber::count(),
        ]);
    }
}
