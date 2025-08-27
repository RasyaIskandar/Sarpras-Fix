<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_dashboard()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Try to access dashboard
        $response = $this->actingAs($admin)->get('/dashboard');

        // Should be successful
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_access_laporan_page()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Try to access laporan page
        $response = $this->actingAs($admin)->get('/laporan');

        // Should be successful
        $response->assertStatus(200);
    }

    /** @test */
    public function user_cannot_access_dashboard()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Try to access dashboard
        $response = $this->actingAs($user)->get('/dashboard');

        // Debug: Check what status we actually get
        // Should be forbidden (403)
        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_access_laporan_page()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Try to access laporan page
        $response = $this->actingAs($user)->get('/laporan');

        // Should be successful
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_is_redirected_to_dashboard_after_login()
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('password123'), // Use a known password
        ]);

        // Try to login
        $response = $this->from('/login')->post('/login', [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        // Should be redirected to dashboard
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_is_redirected_to_laporan_after_login()
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user',
            'password' => bcrypt('password123'), // Use a known password
        ]);

        // Try to login
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        // Should be redirected to laporan
        $response->assertRedirect('/laporan');
    }
}