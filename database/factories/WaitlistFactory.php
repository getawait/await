<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Waitlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaitlistFactory extends Factory
{
    protected $model = Waitlist::class;

    public function definition()
    {
        $team = Team::factory()->create();

        return [
            'name' => $this->faker->company,
            'team_id' => $team->id,
        ];
    }

    public function inActive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }
}
