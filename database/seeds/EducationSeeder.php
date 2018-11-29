<?php

use Illuminate\Database\Seeder;
use App\Models\ApplicationModels\Educations;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Educations::truncate();
        $educations = [
            "Sundhedspsykologi med børn",
            "Psykoterapi med børn",
            "Klinisk børnepsykologi",
            "Klinisk børneneuropsykologi",
            "Pædagogisk psykologi",
            "Sundhedspsykologi med voksne",
            "Psykoterapi med voksne",
            "Psykopatologi",
            "Klinisk Neuropsykologi",
            "Gerontopsykolog",
            "Psykotraumatologi", 
            "Arbejds- og Organisationspsykologi"
        ];

        foreach($educations as $row) {
            Educations::insert([
                "name" =>  $row,
                "desc" => "",
                "praksis" => "",
                "spv_education" => "",
                "options_sv" => "",
                "check_options" => ""
            ]);
        }
    }
}
