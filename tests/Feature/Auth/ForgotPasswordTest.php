<?php

namespace Tests\Feature\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->enableAuth();
    }

    public function test_user_cannot_access_password_reset_when_auth_is_disabled()
    {
        $this->disableAuth();

        $response = $this->get('/password/reset');
        $response->assertRedirect('/');
    }

    public function test_a_user_can_request_a_password_reset()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $response = $this->post('/password/email', ['email' => $user->email]);
        $this->assertDatabaseHas('password_resets', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_user_must_enter_email_for_password_reset()
    {
        Notification::fake();
        $user = factory(User::class)->create();
        $response = $this->post('/password/email', ['email' => '']);
        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
        $response->assertSessionHasErrors('email');
    }

    public function test_a_user_can_complete_a_password_reset()
    {
        $old = bcrypt('oldpassword');
        $user = factory(User::class)->create(['password' => $old]);

        /** @var PasswordBroker $broker */
        $broker = app('auth.password.broker');
        $token = $broker->createToken($user);

        $this->assertDatabaseHas('users', ['email' => $user->email, 'password' => $old]);
        $this->assertDatabaseHas('password_resets', ['email' => $user->email]);

        $response = $this->post('/password/reset', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
        $this->assertDatabaseMissing('users', ['email' => $user->email, 'password' => $old]);
    }
}
