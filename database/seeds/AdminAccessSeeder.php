<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\User;
use App\Models\ApplicationModels\Role;

class AdminAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->name = "Admin";
        $admin->surname = "Admin";
        $admin->info = "";
        $admin->email = "admin@admin.com";
        $admin->password = bcrypt('12345678');
        $admin->save();

        $admin->attachRole(Role::where('name', '=', 'admin')->first());
    }
    
}