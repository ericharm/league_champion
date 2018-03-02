<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

class RegistrationsControllerTest extends TestCase {
    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
    }

    public function testCreateRegistration() {
        $name = $this->faker->name;
        $password = $this->faker->password;
        $regAttempt = [
          'name' => $name,
          'email' => $this->faker->unique()->safeEmail,
          'password' => $password,
          'password_confirmation' => $password
        ];

        $response = $this->post('/api/register', $regAttempt);
        $reg = \App\User::orderBy('id', 'desc')->first();
        
        $response->assertStatus(201);
        $this->assertEquals($name, $reg->name);
        $this->assertContains($name, $response->getContent());
    }

    public function testMissingPassword() {
        $name = $this->faker->name;
        $regAttempt = [
          'name' => $name,
          'email' => $this->faker->unique()->safeEmail
        ];

        $response = $this->post('/api/register', $regAttempt);
        $response->assertStatus(400);
        $this->assertContains('The password field is required.',
          $response->getContent());
    }
}
