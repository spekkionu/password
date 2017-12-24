<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->enableAuth();
        $this->enableRegistration();
    }

    public function test_user_cannot_access_registration_when_auth_is_disabled()
    {
        $this->disableAuth();

        $response = $this->get('/register');
        $response->assertRedirect('/');
    }

    public function test_user_cannot_access_registration_when_disabled()
    {
        $this->disableRegistration();

        $response = $this->get('/register');
        $response->assertRedirect('/login');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $password = 'password';
        $user = factory(User::class)->make(['password' => $password]);

        $this->post('/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    public function test_that_a_user_cannot_register_with_a_used_email()
    {
        $password = 'password';
        $existing = factory(User::class)->create(['password' => $password]);
        $user = factory(User::class)->make(['password' => $password]);

        $response = $this->post('/register', [
            'name' => $user->name,
            'email' => $existing->email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseHas('users', [
            'email' => $existing->email,
            'name' => $existing->name,
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }

    public function test_that_a_user_must_enter_required_fields()
    {
        $response = $this->post('/register', [
            'name' => null,
            'email' => null,
            'password' => null,
            'password_confirmation' => null,
        ]);

        $response->assertSessionHasErrors(['email', 'name', 'password']);
    }
}
