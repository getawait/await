<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\Waitlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $email = 'test@email.com';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_join_waitlist()
    {
        $waitlist = Waitlist::factory()->create();

        $response = $this->post('/api/v1/subscribers', [
            'waitlist' => $waitlist->id,
            'email' => $this->email,
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'position' => true,
            ]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $this->email,
        ]);
    }

    public function test_that_you_cannot_use_the_same_email_twice()
    {
        $this->postJson('/api/v1/subscribers', [
            'email' => $this->email,
        ]);

        $response = $this->postJson('/api/v1/subscribers', [
            'email' => $this->email,
        ]);

        $response->assertStatus(422);
    }

    public function test_that_you_can_see_all_subscriber_data()
    {
        $response = $this->getJson('/api/v1/subscribers');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'total',
            ]);
    }

    public function test_that_you_can_see_your_position()
    {
        $this->postJson('/api/v1/subscribers', [
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
}
