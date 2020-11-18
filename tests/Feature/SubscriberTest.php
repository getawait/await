<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscriber_can_be_deleted_by_owner()
    {
        $subscriber = Subscriber::factory()->create();
        $owner = $subscriber->waitlist->team->owner;

        $response = $this
            ->actingAs($owner)
            ->delete('/subscribers/' . $subscriber->id);

        $response->assertStatus(302);
        $this->assertDeleted($subscriber);
    }

    public function test_subscriber_can_be_deleted_by_admin()
    {
        $subscriber = Subscriber::factory()->create();
        $team = $subscriber->waitlist->team;
        $teamMember = User::factory()->create();
        $team->users()->attach(
            $teamMember,
            ['role' => 'admin']
        );
        $team->save();

        $this
            ->actingAs($teamMember)
            ->delete('/subscribers/' . $subscriber->id);

        $this->assertDeleted($subscriber);
    }

    public function test_subscriber_cannot_be_deleted_by_editor()
    {
        $subscriber = Subscriber::factory()->create();
        $team = $subscriber->waitlist->team;
        $teamMember = User::factory()->create();
        $team->users()->attach(
            $teamMember,
            ['role' => 'editor']
        );
        $team->save();

        $response = $this
            ->actingAs($teamMember)
            ->delete('/subscribers/' . $subscriber->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
        ]);
    }

    public function test_waitlist_cannot_be_deleted_by_viewer()
    {
        $subscriber = Subscriber::factory()->create();
        $team = $subscriber->waitlist->team;
        $teamMember = User::factory()->create();
        $team->users()->attach(
            $teamMember,
            ['role' => 'readonly']
        );
        $team->save();

        $response = $this
            ->actingAs($teamMember)
            ->delete('/subscribers/' . $subscriber->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
        ]);
    }

    public function test_waitlist_cannot_be_deleted_by_random_user()
    {
        $subscriber = Subscriber::factory()->create();
        $randomUser = User::factory()->create();

        $response = $this
            ->actingAs($randomUser)
            ->delete('/subscribers/' . $subscriber->id);

        $response->assertStatus(403);
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
        ]);
    }

    public function test_waitlist_cannot_be_deleted_by_unauthenticated_user()
    {
        $subscriber = Subscriber::factory()->create();

        $response = $this->delete('/subscribers/' . $subscriber->id);

        $response->assertStatus(302);
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
        ]);
    }
}