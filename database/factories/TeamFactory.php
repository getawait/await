<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        $user = User::factory()->create();

        return [
            'name' => $user->name . '\'s Team',
            'user_id' => $user->id,
            'personal_team' => true,
        ];
    }

    public function withTeamMembers()
    {
        return $this->state(function (array $attributes) {
            return [
                'personal_team' => false,
            ];
        });
    }
}
