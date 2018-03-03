<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\User;
use MailThief\Testing\InteractsWithMail;

class ResetPasswordControllerTest extends TestCase {
    use InteractsWithMail;

    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
        $this->password = $this->faker->password;

        $this->user = factory(User::class)->create([
            'password' => Hash::make($this->password)
        ]);
    }

    private function getResetToken() {
        $response = $this->post('/api/password/email', [
            'email' => $this->user->email,
        ]);

        $url = $this->lastMessage()->data['actionUrl'];
        return parse_url($url, PHP_URL_QUERY);
    }

    public function testResetPassword() {
        $user = User::find($this->user->id);
        $oldPassword = $user->password;
        $newPassword = str_random(10);
        $token = $this->getResetToken();
        $response = $this->post('/api/password/reset', [
            'email' => $this->user->email,
            'token' => $token,
            'password' => $newPassword,
            'password_confirmation' => $newPassword
        ]);
        $updatedPassword = User::find($this->user->id)->password;

        $response->assertStatus(200);
        $this->assertNotEquals($oldPassword, $updatedPassword);
    }
}
