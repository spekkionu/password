<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->enableAuth();
    }

    public function test_user_cannot_access_login_when_auth_is_disabled()
    {
        $this->disableAuth();

        $response = $this->get('/login');
        $response->assertRedirect('/');
    }

    public function test_user_can_log_in()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
    }

    public function test_user_cannot_login_with_incorrect_email()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $response = $this->post('/login', [
            'email' => 'incorrect' . $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create(['password' => 'password']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'incorrect',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_must_fill_in_required_fields()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password', 'email']);
    }
}
