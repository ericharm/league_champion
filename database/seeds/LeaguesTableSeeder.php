<?php

use Illuminate\Database\Seeder;

class LeaguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\League::class)->create([
        'name' => 'Modern Jai alai',
        'sport' => 'Jai alai'
      ]);

      factory(App\League::class)->create([
        'name' => 'City Disc League',
        'sport' => 'Disc Golf'
      ]);


    }
}
