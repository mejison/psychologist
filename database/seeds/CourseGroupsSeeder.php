<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\CourseGroups;
use Illuminate\Support\Facades\DB;

class CourseGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseGroups::truncate();
        DB::statement("
            insert  into `course_groups`(`id`,`name`,`hours`,`dashboard`, `show_sub`, `created_at`,`updated_at`) values 
            
            (1,'Forsknings- og formidlingsmodulet', 60, 1, 0, NULL,NULL),
            
            (2,'Fællesmodulet', 90, 1, 0, NULL, NULL),
            
            (3,'Det tværgående modul', 60, 1, 0, NULL,NULL),
            
            (4,'Specialiseringsmodulet for psykoterapi, voksne',150, 1, 1,NULL,'2017-10-16 17:18:10'),
            
            (5,'Specialiseringsmodulet for psykoterapi, børn', 150, 1, 0, NULL,'2017-10-17 14:05:26'),
            
            (6,'Specialiseringsmodulet for psykopatologi',150, 1, 0, NULL,'2017-10-17 14:06:15'),
            
            (7,'Specialiseringsmodulet for klinisk børnepsykologi', 150, 0, 0, NULL,'2017-10-17 14:06:23'),
            
            (8,'Specialiseringsmodulet for gerontopsykologi', 150, 0, 0,NULL,'2017-10-17 14:06:29'),
            
            (9,'Specialiseringsmodulet for klinisk neuropsykologi', 150, 0, 0, NULL,'2017-10-17 14:06:37'),
            
            (10,'Specialiseringsmodulet for psykotraumatologi', 150, 0, 0,NULL,'2017-10-17 14:06:43'),
            
            (11,'Specialiseringsmodulet for arbejds- og organisationspsykolog', 230, 0, 0,NULL,'2017-10-17 14:06:53'),
            
            (12,'Specialiseringsmodulet for pædagogisk psykologi', 150, 0, 0, NULL,'2017-10-17 14:06:59'),
            
            (20,'Specialiseringsmodulet for klinisk børneneuropsykologi', 150, 0, 0, NULL,'2017-10-16 17:48:55'),
            
            (21,'Specialiseringsmodulet for sundhedspsykologi', 150, 0, 0, NULL,'2017-10-16 17:49:20');
        ");
    }
}
