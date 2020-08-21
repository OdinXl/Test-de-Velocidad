<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);		
    
		factory(App\User::class, 12345)->create();
		factory(App\User::class, 7655)->states('eliminado')->create();
	}
}
