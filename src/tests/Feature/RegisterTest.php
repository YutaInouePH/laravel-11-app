<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Spectator\Spectator;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private array $register_data;

    protected function setUp(): void
    {
        parent::setUp();

        Spectator::using('openapi.v1.yaml');

        $this->register_data = [
            'name' => 'John Doe',
            'email' => 'john_doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
    }

    /**
     * Check for response status 201 and json response structure.
     * Assert database has a new user record.
     */
    public function test_register_success(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;

        $this->postJson($route, $register_data)
            ->assertValidRequest()
            ->assertValidResponse(201);
        $this->assertDatabaseHas('users', [
            'name' => $register_data['name'],
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - email: The email has already been taken.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_duplicate_email(): void
    {
        // Create a user record with the same email.
        User::factory()->create([
            'email' => $this->register_data['email'],
        ]);

        $route = route('api.register');
        $register_data = $this->register_data;

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.email.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'name' => $register_data['name'],
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - email: The email must be a valid email address.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_email_format(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['email'] = 'invalid-email.com'; // [email: invalid format]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.email.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - email: The email must be a string with a maximum length of 255 characters.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_email_text_length(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['email'] = str_repeat('a', 256) . '@test.com'; // [email: 256 characters]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.email.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - password: The password must be a string with a maximum length of 255 characters.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_password_length_max(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['password'] = str_repeat('a', 256); // [password: 256 characters]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.password.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - password: The password must be at least 8 characters.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_password_length_min(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['password'] = 'pass'; // [password: 4 characters]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.password.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - password: The password confirmation does not match.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_password_confirmation(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['password_confirmation'] = 'password123'; // [password_confirmation: different value]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.password_confirmation.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

    /**
     * Check for response status 422 and json response structure.
     * Expected error details:
     * - name: The name must be a string with a maximum length of 255 characters.
     * Assert database doesn't have a new user record.
     */
    public function test_register_fail_name_length(): void
    {
        $route = route('api.register');
        $register_data = $this->register_data;
        $register_data['name'] = str_repeat('a', 256); // [name: 256 characters]

        $this->postJson($route, $register_data)
            ->assertJson(fn(AssertableJson $json) => $json->has('errors.name.0'))
            ->assertStatus(422);
        $this->assertDatabaseMissing('users', [
            'email' => $register_data['email'],
        ]);
    }

}
