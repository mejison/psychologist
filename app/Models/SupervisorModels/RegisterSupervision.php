<?php

namespace App\Models\SupervisorModels;
use App\Models\ApplicationModels\Educations;


use App\Models\ApplicationModels\User;
use Illuminate\Database\Eloquent\Model;

class RegisterSupervision extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'supervision_id', 'role', 'registration_date', 'supervision_type', 'number_of_hours', 'type_classes', 'group_composition', 'comment',
        'udredning_intervention', 'type_work', 'long_course', 'percentPsychology'];
    /**
     *This attributes for boolean mark in data
     */
    private static $mark = true;

    /**
     * Get the user that has base user info.
     */
    public function supervision()
    {
        return $this->belongsTo(PsychologySupervisor::class);
    }

    /**
     * Get the user that has base user info.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     *get status for supervision  page(SUPERVISION/OVERSIGT SUPERVISION)
     */
    public function getAllSupervisionStatus()
    {
//        need add select from user becouse we have supervisor session with user
        $supervisionStatus = $this->where('user_id', '=', \Auth::user()->id)->get();

        $informationAboutUser = \App\Models\ApplicationModels\User::with('fullInfoAboutUser', 'roles')->find(\Auth::user()->id);
        $responseData = [];
        
        $edc = false;
        if (is_int($informationAboutUser->fullInfoAboutUser->special_preparation)) {
            $edc = Educations::find($informationAboutUser->fullInfoAboutUser->special_preparation);
        }

        $informationAboutUser->fullInfoAboutUser->special_preparation = $edc ? $edc->praksis : "";
        
        array_push($responseData, $supervisionStatus, $informationAboutUser);
//        array_push($responseData, $supervisorList, $informationAboutUser);
        return $responseData;
    }

    /*
     * calculating total hours supervision statuses
     */

    public function calculateTotalHoursSupervision()
    {
        $totalHours = 0;
        $supervisionStatus = $this->where('user_id', '=', \Auth::user()->id)->get();
        foreach ($supervisionStatus as $item) {
            if ($item->type_classes == 'individuel') {
                $totalHours += $item->number_of_hours;
            } elseif ($item->group_composition == '0-8') {
                $totalHours += $item->number_of_hours;
            } elseif ($item->group_composition == '9-12') {
                $totalHours += ($item->number_of_hours / 2);
            }else{
//                if we have group composition over 12 users we don't count hours
            }

        }
        return $totalHours;
    }

    /**
     *get info about supervision page(SUPERVISION/OPDATERING SUPERVISION)
     */
    public function getInfoAboutSupervision($request)
    {
        if ($request->registerSupervisionsRole != 'supervisor') {
            return $this->where('id', '=', $request->registerSupervisionsId)->where('role', '=', 'selfCreated')->with('supervision')->first();
        }
        return $this->where('id', '=', $request->registerSupervisionsId)->where('role', '=', 'supervisor')->with('user')->first();

    }

    /**
     *get supervision  sessions page(SUPERVISION/TEORIKURSER ALLE REGISTRERINGER)
     */
    public function getSupervisionSession()
    {
        $supervisionStatusWithRoleSelfCreated = $this->where('user_id', '=', \Auth::user()->id)->where('role', '=', 'selfCreated')->with('supervision')->get();
        $supervisionStatusWithRoleSupervisor = $this->where('user_id', '=', \Auth::user()->id)->where('role', '=', 'supervisor')->with('user')->get();
        return $supervisionStatusWithRoleSelfCreated->merge($supervisionStatusWithRoleSupervisor);
    }

    /**
     *update supervision  sessions page(SUPERVISION/OPDATERING SUPERVISION)
     */
    public function updateSupervisionStatus($request)
    {
        $sessionStatus = $this->find($request->supervisionSessionId);
        $sessionStatus->supervision_type = $request->supervision_type;
        $sessionStatus->number_of_hours = $request->number_of_hours;
        $sessionStatus->type_classes = $request->type_classes;
        $sessionStatus->udredning_intervention = $request->udredning_intervention;
        $sessionStatus->type_work = $request->type_work;
        $sessionStatus->type_classes = $request->type_classes;
        $sessionStatus->group_composition = $request->group_composition;
        $sessionStatus->comment = $request->comment;
        $sessionStatus->long_course = $request->long_course;
        $sessionStatus->percentPsychology = $request->percentPsychology;
        $sessionStatus->save();
    }


}
