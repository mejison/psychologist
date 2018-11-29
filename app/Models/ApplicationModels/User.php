<?php

namespace App\Models\ApplicationModels;


use App\Helpers\Enum_Roles;
use App\Helpers\FindFilter;
use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Helpers\MailSender;
use App\Models\ApplicationModels\CourseTeacher;
use App\Models\ApplicationModels\CourseGroups;
use App\Models\ApplicationModels\CourseSubGroups;
use App\Models\ApplicationModels\CourseNumber;
use App\Models\ApplicationModels\CourseMainInfo;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *sss
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'email_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Set the verified status to true and make the email token null
    public function verified()
    {
        $this->verified = 1;
        $this->email_token = null;
        $this->save();
    }

    /**
     * return full name User
     */
    public function getFullName()
    {
        return $this->name . " " . $this->surname;
    }

    /**
     * Get the full info about user record associated with the user.
     */
    public function fullInfoAboutUser()
    {
        return $this->hasOne(UserSubInformation::class);
    }

    /**
     * Get all supervisor belongs to user
     */
    public function userSupervisors()
    {
        return $this->hasOne(PsychologySupervisor::class);
    }

    /**
     * Get all supervision_type from table supervision_types
     */
    public function getSupervisionTypes($user_id)
    {
        return DB::table('supervision_types')
            ->where('user_id', '=',$user_id)
            ->get()->first();
    }
    /**
     * Get main Information about course from table course_main_info
     */
    public function getCourseInfo($user_id)
    {
        $data = DB::table('course_main_info')
            ->where('user_id', '=',$user_id)
            ->get()->first();

        if ( ! empty($data))
        {
            $data->sub_module = 0;
            if ($sub = CourseNumber::find($data->course_id))
            {
                $data->sub_module = $sub->groups_id;
            }
    
            $data->module = 0;
    
            if ($data->sub_module)
            {
                if ($group = CourseSubGroups::find($data->sub_module))
                {
                    $data->module = $group->groups_id;
                }
            }
        }
        
        if ( ! empty($data))
        {
            $data->course_date = json_decode($data->course_date);
        }
        
        return $data;
    }
    /**
     * Get course modules  from table course_modules
     */
    public function getCourseModules($user_id)
    {
        return CourseMainInfo::with('groups.groups.groups')->where('user_id', $user_id)->first();
    }

    /**
     * Get all supervisor educations from table supervision_educations
     */
    public function getUserEducations($user_id)
    {
        return DB::table('users_educations')
            ->where('user_id', '=',$user_id)
            ->get()->first();
    }
    /**
     * Get all supervision_type from table supervision_types
     */
    public function getUserAddress($user_id)
    {
        return DB::table('users_address')
            ->where('user_id', '=',$user_id)
            ->get()->first();
    }
    /**
     * Get all supervision speciality from table supervision_speciality
     */
    public function getSupervisionSpeciality($user_id)
    {
        return DB::table('supervision_speciality')
            ->where('user_id', '=',$user_id)
            ->get()->first();
    }
    /**
     * Get all supervision pictures  from table supervision_pictures
     */
    public function getUserPictures($user_id)
    {
        return DB::table('user_pictures')
            ->where('user_id', '=',$user_id)
            ->get();
    }
    /**
     * Get all supervision videos  from table supervision_videos
     */
    public function getUserVideos($user_id)
    {
        return DB::table('user_videos')
            ->where('user_id', '=',$user_id)
            ->get();
    }
    /**
     * Get all supervision_specialisation from table supervision_file_specialisation
     */
    public function getSupervisionSpecialisation($user_id)
    {
        return DB::table('supervision_file_specialisation')
            ->where('user_id', '=',$user_id)
            ->get();
    }
    /**
     * Get all course teacher from table course_teachers
     */
    public function getCourseTeachers($user_id)
    {
        return CourseTeacher::where('user_id', '=', $user_id)->get();
    }
    /**
     * Get all course program from table course_programs
     */
    public function getCourseProgram($user_id)
    {
        return DB::table('course_programs')
            ->where('user_id', '=',$user_id)
            ->get();
    }

    /**
     * update User profile
     */
    public function updateProfile($request)
    {
        $user = \App\Models\ApplicationModels\User::find(\Auth::user()->id);
        MailSender::sendMailWhenChangeProfile($request);
        $user->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => ($request->password != null) ? bcrypt($request->password) : $user->password]);
        if ($user->fullInfoAboutUser != null) {
            $user->fullInfoAboutUser()->update([
                'address' => $request->address,
                'post' => $request->post,
                'city' => $request->city,
                'phone' => $request->phone,
                'special_preparation' => $request->special_preparation]);
        } else {
            $user->fullInfoAboutUser()->create([
                'address' => $request->address,
                'post' => $request->post,
                'city' => $request->city,
                'phone' => $request->phone,
                'special_preparation' => $request->special_preparation]);
        }
        $user->save();
    }

    /**
     * find supervisor profile
     */
    public function findProfiles($request, $role)
    {
        $searchResult = [];
        if ( ! empty($request->userName))
        {
            $userName = explode(" ", $request->userName);
            if (count($userName) > 1) {
                $searchResult = $this->where('name', 'LIKE', '%' . $userName[0] . '%')->where('surname', 'LIKE', '%' . $userName[1] . '%')->with('fullInfoAboutUser')->get();
            } else {
                $searchResult = $this->where('name', 'LIKE', '%' . $userName[0] . '%')->with('fullInfoAboutUser')->get();
                if (count(!$searchResult)) {

                    $searchResult = $this->where('surname', 'LIKE', '%' . $userName[0] . '%')->with('fullInfoAboutUser')->get();
                }
            }
        } else {
            $searchResult = $this->with('fullInfoAboutUser')->get();
        }

        $listProfiles = $this->filterProfiles($request, $searchResult, $role);
        return $listProfiles;
    }

    public function findProfilesByTeachers($request, $teacher, $role)
    {
        $result = [];
        $users_ids = [];
        foreach (CourseTeacher::where('teacher_name', 'like', '%' . $teacher . '%')->get() as $teacher)
        {
            $users_ids[] = $teacher->user_id;
        }

        if ($users_ids)
        {
            $result = $this->whereIn("id", $users_ids)->with('fullInfoAboutUser')->get();
        }

        return $result;
    }

    /**
     * filters
     * @param $request
     * @param $profiles
     * @param $role
     * @return array|mixed
     * @throws Exception
     */
    private function filterProfiles($request, $profiles, $role)
    {

        $listUsers = [];
        foreach ($profiles as $user) {
            if ($user->roles->first()->name == $role) {

                $user['speciality'] = $this->getSupervisionSpeciality($user->id);
                $user['address'] = $this->getUserAddress($user->id);
                $user['education'] = $this->getUserEducations($user->id);
                array_push($listUsers, $user);

            }
        }
        
        return FindFilter::filter($request, $listUsers, $role);
    }

    /**
     * Get main Information about course from table course_main_info
     */
    public function getThisCourseInfo()
    {
        $data = DB::table('course_main_info')
            ->where('user_id', '=', $this->id)
            ->get()->first();
        if ( ! empty($data))
        {
            $data->course_date = json_decode($data->course_date);
            return $data;
        }
        return FALSE;
    }

    public function role()
    {
        return $this->belongsToMany("App\Models\ApplicationModels\Role", "role_user", "user_id", "role_id");
    }

}