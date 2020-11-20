<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class SubscribersController extends Controller
{
    public function delete(Subscriber $subscriber)
    {
        if (!auth()->user()->can('delete', $subscriber)) {
            return response('You are not allowed to delete this subscriber!', 403);
        }

        Subscriber::where('referrer_id', $subscriber->id)
            ->update(['referrer_id' => null]);

        $waitlistId = $subscriber->waitlist->id;

        $subscriber->delete();

        return response()
            ->redirectToRoute('lists.show', [
                'waitlist' => $waitlistId,
            ])
            ->with('successMessage', 'Successfully deleted subscriber!');
    }
}
