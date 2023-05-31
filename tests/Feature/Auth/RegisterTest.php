<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_user_can_see_register_page()
    {
        $response = $this->get(route('auth.get_register'));
        $response->assertViewIs('auth.register');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_cannot_see_register_page()
    {
        $user = User::factory()->makeOne();
        $response = $this->actingAs($user)
            ->get(route('auth.get_register'));
        $response->assertRedirect(route('homepage'));
    }

    public function test_user_can_register_with_correct_fields()
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
