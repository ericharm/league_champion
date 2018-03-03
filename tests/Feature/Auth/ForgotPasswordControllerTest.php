<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\User;
use MailThief\Testing\InteractsWithMail;

class ForgotPasswordControllerTest extends TestCase {
    use InteractsWithMail;

    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
        $this->password = $this->faker->password;

        $this->user = factory(User::class)->create([
            'password' => Hash::make($this->password)
        ]);
    }

    public function testForgotPassword() {
        $response = $this->post('/api/password/email', [
            'email' => $this->user->email,
        ]);

        $this->seeMessageFor($this->user->email);
        $this->assertContains('We have e-mailed your password reset link!',
            $response->getContent());
        $response->assertStatus(200);
    }
}
