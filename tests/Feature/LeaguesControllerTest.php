<?php

namespace Tests\Feature;

use Tests\ResourceTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;
use App\League;

class LeaguesControllerTest extends ResourceTestCase
{
    public function setUp() {
        parent::setUp();
        $this->faker = Faker::create();
        $this->league = factory(League::class)->create();
    }

    public function testGetLeagues()
    {
        $response = $this->get('/api/leagues');
        $response->assertStatus(200);
        $this->assertContains($this->league->name,
            $response->getContent());
    }

    public function testGetLeague()
    {
        $response = $this->get('/api/leagues/' . $this->league->id);
        $response->assertStatus(200);
        $this->assertContains($this->league->name,
            $response->getContent());
    }

    public function testGetLeagueWrongId()
    {
        $id = League::orderBy('id', 'desc')->first()->id + 1;
        $response = $this->get('/api/leagues/' . $id);
        $response->assertStatus(404);
        $this->assertContains('No league found with id ' . $id,
            $response->getContent());
    }

    public function testUpdateLeague()
    {
        $originalName = $this->league->name;
        $newName = str_random(10);
        $data = ['name' => $newName];

        $response = $this->put('/api/leagues/' . $this->league->id, $data);
        $response->assertStatus(202);
        $this->assertContains($newName, $response->getContent());
        $this->assertNotContains($originalName, $response->getContent());

        $league = League::find($this->league->id);
        $this->assertEquals($newName, $league->name);
    }

    public function testStoreLeague()
    {
        $originalLeagueCount = League::count();
        $leagueName = $this->faker->company;
        $league = [
            'name' => $leagueName,
            'sport' => $this->faker->word
        ];
        $response = $this->post('/api/leagues', $league);
        $afterStoreCount = League::count();

        $response->assertStatus(201);
        $this->assertContains($leagueName, $response->getContent());
        $this->assertEquals(1, $afterStoreCount - $originalLeagueCount);
    }

    public function testDestroyLeague()
    {
        $originalLeagueCount = League::count();
        $response = $this->delete('/api/leagues/' . $this->league->id);
        $afterStoreCount = League::count();

        $response->assertStatus(202);
        $this->assertContains('successfully deleted', $response->getContent());
        $this->assertContains($this->league->name, $response->getContent());
        $this->assertEquals(1, $originalLeagueCount - $afterStoreCount);
    }
}
