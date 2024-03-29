<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Success authentication.
     * Check for response status 204 and is user authenticated.
     */
    public function test_login_successful_credentials(): void
    {
        $route = route('login', [], false);
        $response = $this->postJson($route, [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated('sanctum');
        $response->assertStatus(204);
    }

    /**
     * Failed authentication.
     * Check for response status 422 (validation error) and is user not authenticated.
     */
    public function test_login_failed_credentials(): void
    {
        $route = route('login', [], false);
        $response = $this->postJson($route, [
            'email' => 'test_failed@example.com',
            'password' => 'password',
        ]);

        $this->assertGuest('sanctum');
        $response->assertStatus(422);
    }

    public function test_logout_success(): void
    {
        $user = User::factory()->create();
        $route = route('logout', [], false);
        $response = $this->actingAs($user)
            ->postJson($route);

        $this->assertGuest('sanctum');
        $response->assertStatus(204);
    }

    public function test_logout_failed(): void
    {
        $route = route('logout', [], false);
        $response = $this->postJson($route);

        $this->assertGuest('sanctum');
        $response->assertStatus(200);
    }
}
