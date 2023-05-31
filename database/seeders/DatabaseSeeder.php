<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            CountriesTableSeeder::class,
            LanguagesTableSeeder::class,
            VideoSourcesTableSeeder::class,
            PlansTableSeeder::class,
//            EventsTableSeeder::class
        ]);
    }
}
