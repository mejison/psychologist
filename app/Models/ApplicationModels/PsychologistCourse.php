<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class PsychologistCourse extends Model
{
    protected $table = "mine_psychologist_course";

    function course()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CourseMainInfo", "id", "courseId");
    }
}
