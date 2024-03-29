<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spectator\Spectator;
use Tests\TestCase;

class FriendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Spectator::using('openapi.v1.yaml');
    }

    /**
     * Retrieve logged-in user's friends.
     * Validate the response body structure
     */
    public function test_spec_friends_index(): void
    {
        $user = User::first();
        $route = route('api.friends.index', [], false);

        $this->actingAs($user)
            ->getJson($route)
            ->assertValidRequest()
            ->assertValidResponse(200);
    }
}
