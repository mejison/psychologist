<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class CourseNumber extends Model
{
    public function groups()
    {
        return $this->hasOne("App\Models\ApplicationModels\CourseSubGroups", "id", "groups_id");
    }

    public function main_info()
    {
        return $this->hasMany("App\Models\ApplicationModels\CourseMainInfo", "course_id", "id");
    }

}