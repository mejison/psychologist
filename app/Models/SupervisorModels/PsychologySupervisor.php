<?php

namespace App\Models\SupervisorModels;


use Illuminate\Database\Eloquent\Model;
use App\Models\ApplicationModels\User;

class PsychologySupervisor extends Model
{
    protected $table = 'psychologist_supervision';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'surname', 'email', 'address', 'post', 'city', 'phone', 'special_preparation', 'special_evidence', 'special_trained',
        'supervisor_selected', 'presentation_description', 'form_type'];

    /**
     * Get the user that has base user info.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * adding Supervisor selection
     */
    public function selectSupervisor($supervisorFullName)
    {
        $name = explode(" ", $supervisorFullName);
        $exist = $this->where('user_id', '=', \Auth::user()->id)->where('name', '=', $name[0])->count();
        
        if ( ! $exist) {
            
            $user = User::where('name', $name[0])->with('fullInfoAboutUser')->first();
            
            $supervisor = new PsychologySupervisor;
            $supervisor->user_id = \Auth::user()->id;
            $supervisor->name =  $name[0];
            $supervisor->surname = $user->surname;
            $supervisor->email = $user->email;
            $supervisor->supervisor_selected = true;
            $supervisor->special_preparation = '';

            $supervisor->save();
            return $supervisor;
        }
        return false;
    }
}
