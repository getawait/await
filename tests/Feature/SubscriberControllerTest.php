<?php

namespace Tests\Feature;

use App\Models\Waitlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'test@email.com';

    public function test_join_waitlist()
    {
        $waitlist = Waitlist::factory()->create();

        $response = $this->post('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'position' => 1, // todo
            ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $this->email,
        ]);
    }

    public function test_that_when_multiple_waitlists_exist_correct_position()
    {
        $waitlist = Waitlist::factory()->create();
        $anotherWaitlist = Waitlist::factory()->create();

        $this->post('/api/v1/subscribers', [
            'waitlist' => $anotherWaitlist->id,
            'email' => 'another@email.com',
        ]);

        $response = $this->post('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'position' => 1, // todo
            ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $this->email,
        ]);
    }

    public function test_that_you_can_only_provide_current_waitlist_referrer()
    {
        $waitlist = Waitlist::factory()->create();
        $anotherWaitlist = Waitlist::factory()->create();

        $this->post('/api/v1/subscribers', [
            'waitlist' => $anotherWaitlist->id,
            'email' => 'another@email.com',
        ]);

        $response = $this->postJson('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
            'referrer' => 1,
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('subscribers', [
            'email' => $this->email,
        ]);
    }

    public function test_that_you_cannot_use_the_same_email_twice()
    {
        $waitlist = Waitlist::factory()->create();

        $this->postJson('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response = $this->postJson('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response->assertStatus(422);
    }

    public function test_that_you_can_see_your_position_with_one_waitlist()
    {
        $waitlist = Waitlist::factory()->create();

        $this->postJson('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response = $this->getJson('/api/v1/subscribers/' . $this->email);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'position',
                'total',
            ]);
    }

    public function test_that_you_can_see_your_position_with_two_waitlists()
    {
        $waitlist = Waitlist::factory()->create();
        $anotherWaitlist = Waitlist::factory()->create();

        $this->post('/api/v1/subscribers', [
            'waitlist' => $anotherWaitlist->id,
            'email' => 'another@email.com',
        ]);

        $this->postJson('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $anotherResponse = $this->getJson('/api/v1/subscribers/another@email.com');
        $response = $this->getJson('/api/v1/subscribers/' . $this->email);

        $anotherResponse
            ->assertStatus(200)
            ->assertJsonFragment([
                'position' => 1,
            ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'position' => 1,
            ]);
    }

    // todo: Test for referral position modifier
}
