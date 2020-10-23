<?php

namespace Tests\Feature;

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

    public function test_that_you_can_see_your_position()
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
}
