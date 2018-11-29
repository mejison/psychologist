<?php

namespace App\Models\ApplicationModels;


use Illuminate\Database\Eloquent\Model;

class UserSubInformation extends Model
{
    protected $table = 'user_information';
    protected $appends = ['educations'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable  = ['address','post','city','phone','special_preparation','age','trained_leader','website','pathWebsiteScreen','avatar_path','visitors_count','website_link_count'];
    /**
     * Get the user that has base user info.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEducationsAttribute($value)
    {
        return isset($this->attributes['special_preparation']) ? $this->attributes['special_preparation'] : [];
    }
}
