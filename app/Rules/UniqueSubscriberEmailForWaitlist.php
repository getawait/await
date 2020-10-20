<?php

namespace App\Rules;

use App\Models\Subscriber;
use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure that a subscriber's email address is unique within a given waitlist
 */
class UniqueSubscriberEmailForWaitlist implements Rule
{
    private string $waitlistId;

    public function __construct($waitlistId)
    {
        $this->waitlistId = $waitlistId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !Subscriber::where('waitlist_id', $this->waitlistId)
            ->where('email', $value)
            ->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email is already on the waitlist.';
    }
}
