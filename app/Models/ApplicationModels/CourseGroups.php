<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class CourseGroups extends Model
{
    public function sub()
    {
        return $this->hasMany("App\Models\ApplicationModels\CourseSubGroups", "groups_id", "id");
    }
}
