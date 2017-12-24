<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->enableAuth();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_guests_cannot_access_home()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_that_logged_in_users_can_access_home()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_that_guests_can_access_home_when_auth_is_disabled()
    {
        $this->disableAuth();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
