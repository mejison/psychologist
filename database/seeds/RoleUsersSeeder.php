<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\Role;

class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $psychologist = new Role;
        $psychologist->name = "psychologist";
        $psychologist->pos = 1;
        $psychologist->display_name = "Psychologist";
        $psychologist->save();


        $courseOrganizer = new Role;
        $courseOrganizer->name = "courseOrganizer";
        $courseOrganizer->pos = 3;
        $courseOrganizer->display_name = "CourseOrganizer";
        $courseOrganizer->save();

        $supervisor = new Role;
        $supervisor->name = "supervisor";
        $supervisor->pos = 2;
        $supervisor->display_name = "Susupervisor";
        $supervisor->save();

        $admin = new Role;
        $admin->name = "admin";
        $admin->pos = 4;
        $admin->display_name = "Admin";
        $admin->save();


    }
}
