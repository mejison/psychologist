<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class EducationRuquire extends Model
{
    public function course() {
        return $this->hasOne("App\Models\ApplicationModels\CourseNumber", "id", "course_id");
    }
}
