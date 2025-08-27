<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_middleware_blocks_non_admin_users()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Try to access admin route
        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Should be forbidden
        $response->assertStatus(403);
    }

    /** @test */
    public function admin_middleware_allows_admin_users()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Try to access admin route
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        // Should be successful (would redirect to login page if view doesn't exist)
        // We're testing that it doesn't return 403
        $this->assertNotEquals(403, $response->getStatusCode());
    }

    /** @test */
    public function user_middleware_allows_admin_users()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Try to access user route
        $response = $this->actingAs($admin)->get('/laporan');

        // Should be successful (would redirect to login page if view doesn't exist)
        // We're testing that it doesn't return 403
        $this->assertNotEquals(403, $response->getStatusCode());
    }

    /** @test */
    public function user_middleware_allows_user_users()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Try to access user route
        $response = $this->actingAs($user)->get('/laporan');

        // Should be successful (would redirect to login page if view doesn't exist)
        // We're testing that it doesn't return 403
        $this->assertNotEquals(403, $response->getStatusCode());
    }
}