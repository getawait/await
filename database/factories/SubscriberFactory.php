<?php

namespace Database\Factories;

use App\Models\Subscriber;
use App\Models\Waitlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition()
    {
        $waitlist = Waitlist::factory()->create();

        return [
            'email' => $this->faker->email,
            'waitlist_id' => $waitlist->id,
        ];
    }

    public function wasReferred()
    {
        return [
          'was_referred' => true,
        ];
    }

    public function withReferrer()
    {
        $referrer = Subscriber::factory()->create();

        return [
            'referrer_id' => $referrer->id,
        ];
    }
}
