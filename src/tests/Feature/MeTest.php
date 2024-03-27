<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spectator\Spectator;
use Tests\TestCase;

class MeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up the test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Spectator::using('openapi.v1.yaml');
    }

    /**
     * Check for response status 200 and json response structure.
     */
    public function test_me_index(): void
    {
        $route = route('api.me.index', [], false);
        $this->actingAs(User::factory()->create())
            ->getJson($route)
            ->assertValidRequest()
            ->assertValidResponse(200);
    }
}
