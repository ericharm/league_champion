<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\FoundationTesting\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\User;

class UserTest extends TestCase
{
    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
        $this->password = $this->faker->password;

        $this->user = factory(User::class)->create([
            'password' => Hash::make($this->password)
        ]);
    }

    public function testIsSoCool()
    {
        $this->assertTrue($this->user->isSoCool());
    }
}
