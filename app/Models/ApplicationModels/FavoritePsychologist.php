<?php

namespace App\Models\ApplicationModels;

use Illuminate\Database\Eloquent\Model;

class FavoritePsychologist extends Model
{
    protected $table = "favorite_psychologist_list";

    public function course()
    {
    	return $this->hasOne("App\Models\ApplicationModels\CourseMainInfo", "id", "courseId");
    }
}
