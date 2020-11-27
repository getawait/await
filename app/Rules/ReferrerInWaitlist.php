<?php

namespace App\Rules;

use App\Models\Subscriber;
use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure that a referrer belongs to a waitlist
 */
class ReferrerInWaitlist implements Rule
{
    private string $waitlistId;

    public function __construct($waitlistId)
    {
        $this->waitlistId = $waitlistId;
    }

    public function passes($attribute, $value)
    {
        return Subscriber::where('waitlist_id', $this->waitlistId)
            ->where('email', $value)
            ->exists();
    }

    public function message()
    {
        return 'This referrer is not subscribed to the waitlist you have provided.';
    }
}
