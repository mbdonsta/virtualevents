<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_user_can_see_login_page()
    {
        $response = $this->get(route('auth.get_login'));
        $response->assertViewIs('auth.login');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_see_login_page()
    {
        $password = 'sample-password';
        $user = User::factory()->createOne([
            'password' => bcrypt($password)
        ]);

        $response = $this->post(route('auth.post_login'), [
            'email' => $user->email,
            'password' => $password
        ]);
        $response->assertRedirect(route('homepage'));
    }

    public function test_user_can_login_with_correct_fields()
    {
        $password = fake()->password(8) . fake()->randomDigit();
        $response = $this->followingRedirects()
            ->post(route('auth.post_register'), [
                'firstname' => fake()->firstName,
                'lastname' => fake()->lastName,
                'email' => fake()->email,
                'password' => $password,
                'password_confirmation' => $password,
                'terms' => 1
            ]);
        $response->assertViewIs('auth.register-success');
        $response->assertStatus(200);
    }
}
