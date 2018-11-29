<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class CourseSubGroups extends Model
{
    public function groups()
    {
        return $this->hasOne("App\Models\ApplicationModels\CourseGroups", "id", "groups_id");
    }

    public function courses()
    {
        return $this->hasMany("App\Models\ApplicationModels\CourseNumber", "groups_id", "id");
    }
}
