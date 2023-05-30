<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PegawaiAbsen;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        PegawaiAbsen::factory()->count(10)->create();
    }
}
