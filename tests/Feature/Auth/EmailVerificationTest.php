<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;
    public function test_registration_redirects_to_laporan_page()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/laporan');
    }

    public function test_user_can_access_laporan_page_immediately_after_registration()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Follow the redirect to laporan page
        $response = $this->followingRedirects()->get('/laporan');

        // Should be able to access laporan page immediately
        $response->assertStatus(200);
    }

    public function test_user_cannot_access_dashboard_without_verification()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(403);
    }

    public function test_user_can_access_dashboard_after_verification()
    {
        // Create an admin user since only admins can access the dashboard
        $user = User::factory()->create([
            'email_verified_at' => null,
            'role' => 'admin',
        ]);

        $user->markEmailAsVerified();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSuccessful();
    }
}
