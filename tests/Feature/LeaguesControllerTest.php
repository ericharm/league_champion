<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeaguesControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetLeagues()
    {
        $response = $this->get('/api/leagues');
        $response->assertStatus(200);
    }
}
