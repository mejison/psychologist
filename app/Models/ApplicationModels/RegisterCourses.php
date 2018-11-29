<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class RegisterCourses extends Model
{

    function course()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CourseMainInfo", "id", "courseId");
    }

    function files()
    {
    	return $this->hasMany("App\Models\ApplicationModels\RegisterCoursesAttaches", "registerId");
    }

    function group()
    {
        $course = $this->hasOne("App\Models\ApplicationModels\CourseMainInfo", "id", "courseId");
        $number = $course->getResults()->hasOne("App\Models\ApplicationModels\CourseNumber", "id", "course_id");
        $sub = $number->getResults()->hasOne("App\Models\ApplicationModels\CourseSubGroups", "id", "groups_id");
        return $sub->getResults()->hasOne("App\Models\ApplicationModels\CourseGroups", "id", "groups_id");
    }

    function sub()
    {
        $course = $this->hasOne("App\Models\ApplicationModels\CourseMainInfo", "id", "courseId");
        $number = $course->getResults()->hasOne("App\Models\ApplicationModels\CourseNumber", "id", "course_id");
        return $number->getResults()->hasOne("App\Models\ApplicationModels\CourseSubGroups", "id", "groups_id");
    }
}
