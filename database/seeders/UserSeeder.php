<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(2)->create();
        // ->has(Course::factory(3)->create());
        User::factory()
        ->count(3)
        ->hasCourses(4)
        ->create();
    }
    
}
