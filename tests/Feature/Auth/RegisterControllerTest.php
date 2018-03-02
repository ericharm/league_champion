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
        $regAttempt = [
          'name' => $this->faker->name,
          'email' => $this->faker->unique()->safeEmail,
          'password' => $this->faker->password
        ];

        $response = $this->post('/api/register', $regAttempt);
        error_log(strip_tags($response->getContent()));
        $response->assertStatus(201);
    }
}
