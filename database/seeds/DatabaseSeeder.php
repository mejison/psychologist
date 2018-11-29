<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $this->call(RoleUsersSeeder::class);
       $this->call(AdminAccessSeeder::class);
       $this->call(CourseGroupsSeeder::class);
       $this->call(CourseSubGroupsSeeder::class);
       $this->call(CoursesNumbersSeeder::class);
    }
}