<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class CourseMainInfo extends Model
{
    protected $table = "course_main_info";

    function user()
    {
    	return $this->hasOne("App\Models\ApplicationModels\User", "id", "user_id");
    }

    function modules()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CourseModules", "user_id", "user_id");
    }

    function programs()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CoursePrograms", "user_id", "user_id");
    }

    function teachers()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CourseTeachers", "user_id", "user_id");
    }

    function teachers_all()
    {
    	return $this->hasMany("App\Models\ApplicationModels\CourseTeachers", "user_id", "user_id");
    }


    function groups()
    {
        return $this->hasOne("App\Models\ApplicationModels\CourseNumber", "id", "course_id");
    }

}
