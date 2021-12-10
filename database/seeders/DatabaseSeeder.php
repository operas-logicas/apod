<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
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
        // if(App::environment() === 'production') {
        //     exit("Don't seed! In production.");
        // }

        // Disable mass-assignment protection
        Model::unguard();

        // Truncate tables and re-seed
        DB::table('users')->truncate();
        DB::table('posts')->truncate();

        // Create some fake users before seeding posts
        User::factory(10)->create();

        // Seed posts table
        $this->call(PostTableSeeder::class);
    }
}
