<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure that a subscriber's email address is unique within a given waitlist
 */
class UniqueSubscriberEmailForWaitlist implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
