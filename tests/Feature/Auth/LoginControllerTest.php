<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\User;

class LoginControllerTest extends TestCase {
    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
        $this->password = $this->faker->password;

        $this->user = factory(User::class)->create([
          'password' => Hash::make($this->password)
        ]);
    }

    public function testLoginWithValidPassword()
    {
        $password = $this->password;
        $loginAttempt = [
          'email' => $this->user->email,
          'password' => $this->password
        ];
        $response = $this->post('/api/login', $loginAttempt);
        $user = json_decode($response->getContent())->user;

        $response->assertStatus(200);
        $this->assertNotNull($user->api_token);
    }

    public function testLoginWithIncorrectPassword()
    {
        $password = $this->password;
        $loginAttempt = [
          'email' => $this->user->email,
          'password' => 'abcdefg'
        ];

        $response = $this->post('/api/login', $loginAttempt);
        $response->assertStatus(400);
        $this->assertContains('Login failed.', $response->getContent());
    }

    public function testLoginWithNoPassword()
    {
        $password = $this->password;
        $loginAttempt = [
          'email' => $this->user->email
        ];

        $response = $this->post('/api/login', $loginAttempt);
        $response->assertStatus(400);
        $this->assertContains('Login failed.', $response->getContent());
    }

    public function testLoginWithIncorrectField()
    {
        $password = $this->password;
        $loginAttempt = [
          'email' => $this->user->email,
          'drowssap' => $this->password
        ];

        $response = $this->post('/api/login', $loginAttempt);
        $response->assertStatus(400);
        $this->assertContains('Login failed.', $response->getContent());
    }
}
