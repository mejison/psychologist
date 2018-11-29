<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $table = "course_teachers";

    function user()
    {
    	return $this->belongsTo("App\Models\ApplicationModels\User", "user_id");
    }
}
