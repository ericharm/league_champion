<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\League;

class LeaguesControllerTest extends TestCase
{
    public function setUp() {
        parent::setUp();
        $this->league = factory(League::class)->create();
    }

    public function testGetLeagues()
    {
        $response = $this->get('/api/leagues');
        $response->assertStatus(200);
        $this->assertContains($this->league->name,
            $response->getContent());
    }
}
