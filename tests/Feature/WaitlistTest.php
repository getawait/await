<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Waitlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WaitlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_waitlist_can_be_deleted_by_owner()
    {
        $waitlist = Waitlist::factory()->create();
        $owner = $waitlist->team->owner;

        $response = $this
            ->actingAs($owner)
            ->delete('/lists/' . $waitlist->id);

        $response->assertStatus(200);
        $this->assertDeleted($waitlist);
    }

    public function test_waitlist_cannot_be_deleted_by_team_member()
    {
        $waitlist = Waitlist::factory()->create();
        $team = $waitlist->team;
        $teamMember = User::factory()->create();
        $team->users()->attach(
            $teamMember,
            ['role' => null]
        );
        $team->save();

        $response = $this
            ->actingAs($teamMember)
            ->delete('/lists/' . $waitlist->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('waitlists', [
            'id' => $waitlist->id,
        ]);
    }

    public function test_waitlist_cannot_be_deleted_by_random_user()
    {
        $waitlist = Waitlist::factory()->create();
        $randomUser = User::factory()->create();

        $response = $this
            ->actingAs($randomUser)
            ->delete('/lists/' . $waitlist->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('waitlists', [
            'id' => $waitlist->id,
        ]);
    }

    public function test_waitlist_cannot_be_deleted_by_unauthenticated_user()
    {
        $waitlist = Waitlist::factory()->create();

        $response = $this->delete('/lists/' . $waitlist->id);

        $response->assertStatus(302);
        $this->assertDatabaseHas('waitlists', [
            'id' => $waitlist->id,
        ]);
    }
}