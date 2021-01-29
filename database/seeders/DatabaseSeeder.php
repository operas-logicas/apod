<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Don't seed if in production!
        if(App::environment() === 'production') {
            exit("Don't seed! In production.");
        }

        // Disable mass-assignment protection
        Model::unguard();

        // Truncate tables to re-seed
        DB::table('posts')->truncate();

        // Not using a factory to get fake seed
        // \App\Models\User::factory(10)->create();

        // Seed tables
        $this->call(PostTableSeeder::class);
    }
}
