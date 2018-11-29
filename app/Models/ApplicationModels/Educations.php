<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class Educations extends Model
{
    public function groups() {
        return $this->belongsToMany("App\Models\ApplicationModels\CourseGroups", "educations_groups", "education_id", "groups_id");
    }

    public function requires() {
        return $this->hasMany("App\Models\ApplicationModels\EducationRuquire", "education_id");
    }
}
