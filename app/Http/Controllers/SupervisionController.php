<?php

namespace App\Http\Controllers;

use App\Http\Requests\PsychologiRegSupervisor;
use App\Http\Requests\RegisterSupervisionRequest;
use App\Models\ApplicationModels\ImageModel;
use App\Models\ApplicationModels\Role;
use App\Models\ApplicationModels\Educations;
use App\Models\ApplicationModels\Permission;
use App\Models\ApplicationModels\UserSubInformation;
use App\Models\SupervisorModels\PsychologySupervisor;
use App\Models\SupervisorModels\RegisterSupervision;
use App\Models\ApplicationModels\User;
use App\Models\SupervisorModels\UpdateSupervision;
use App\Models\SupervisorModels\UpdateSupervisionModel;

use Auth;
use DB;
use Illuminate\Http\Request;
use App\Helpers\Enum_Roles;

class SupervisionController extends Controller
{
    private $imageModel;
    private $userModel;
    private $psychologySupervisorModel;
    private $registerSupervisionModel;
    private $updateSupervisionModel;

    public function __construct()
    {
//        TODO need change to dependency injection
        $this->imageModel = new ImageModel();
        $this->userModel = new User();
        $this->psychologySupervisorModel = new PsychologySupervisor();
        $this->registerSupervisionModel = new RegisterSupervision();
        $this->updateSupervisionModel = new UpdateSupervisionModel();
    }

    /**
     * register supervisor to psychology
     */
    public function registrationSupervisor(PsychologiRegSupervisor $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['supervisor_selected'] = true;
        $psychology = $this->psychologySupervisorModel->create($data);
//        add property to $request because addToMineSupervisor model need  supervisionsId
        $request->supervisionsId = $psychology->id;
        $this->addToMineSupervisionPsychologyList($request);
        return $psychology;
    }

    /**
     *find supervisor for psychology
     */
    public function searchSupervisor(Request $request)
    {
        $find = $request->get("find");
        $users = [];
        foreach(User::whereHas('role', function($q){ $q->where("name", "=", "supervisor"); })->get() as $user)
		{
			$users[] = $user;
        }
        
        $users = array_filter($users, function ($u) use ($find) {
            return (strpos($u->name, $find)) || (strpos($u->surname, $find));
        });
        return $users;
    }

    /**
     *attach Supervisor  for psychology
     */
    public function attachSupervisor(Request $request)
    {
        $part = explode(" ", $request->supervisorName);
        $supervisor = User::query();
        if ( ! empty($part[0])) {
            $supervisor->where("name", $part[0]);
        }
        if ( ! empty($part[1])) {
            $supervisor->where("surname", $part[1]);
        }
        $supervisor = $supervisor->first();
        
        if ($supervisor) {

            $exist = DB::table('psychologist_supervision')->where('email', $supervisor->email)->count();

            if ( ! $exist) {
                DB::table('psychologist_supervision')->insert([
                    "user_id" => \Auth::user()->id,
                    "name" => $supervisor->name,
                    "surname" => $supervisor->surname,
                    "email" => $supervisor->email,
                    "special_preparation" => ""
                ]);
                
                DB::table('mine_supervision_list_psychologist')->insert([
                    "userId" => \Auth::user()->id,
                    "supervision_id" => DB::getPdo()->lastInsertId()
                ]);
                return (new \Illuminate\Http\Response)->setStatusCode(200, 'Success');
            }
        }
        
        return (new \Illuminate\Http\Response)->setStatusCode(409, 'Fail attaching  supervisor');
    }

    /**
     *get all Supervisors  for psychology
     */
    public function getAllSupervisors()
    {
        return $this->getMineListSupervisors();
    }

    /**
     *get all Supervisors  for psychology
     */
    public function getAllBilagFiles(Request $request)
    {
        return DB::table('register_supervisions_bilag')->where('user_id', '=', \Auth::user()->id)->where('session_id', '=', $request->registerSupervisionsId)->get();
    }

    /**
     *set data to Supervision Register
     */
    public function registerSupervision(RegisterSupervisionRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        $idSupervisorSession = $this->registerSupervisionModel->create($data)->id;
        $request->supervisionsId = $request->supervision_id;
        if ($request->role != 'supervisor') {
            //  if user selfCreated by psychology
            $this->addToMineSupervisionPsychologyList($request);
        } else {
            $this->addToMineList($request);
        }
        return $idSupervisorSession;
    }

    /*
     * add supervisor  to mine supervisor_psychology_list
     */
    public function addToMineSupervisionPsychologyList(Request $request)
    {
        $result = DB::table('mine_supervision_list_psychologist')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisionsId)->get();
        if ($result->isEmpty()) {
            DB::table('mine_supervision_list_psychologist')->insert(['userId' => \Auth::user()->id, 'supervision_id' => $request->supervisionsId, 'created_at' => \Carbon\Carbon::now()]);
            return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervison successfuly added.');
        }
        return (new \Illuminate\Http\Response)->setStatusCode(409, 'Supervison already in list.');
    }

    /**
     *upload bilag files
     */
    public function uploadBilagFile(Request $request)
    {
//        Excel || MP4 validation
        $mimeType = \File::mimeType($request->file);
        if ($mimeType != 'application/octet-stream' && $mimeType != 'video/mp4') {
            $this->validate($request, ['file' => 'file|mimes:jpeg,png,jpg,svg,pdf,doc,docx,mpga']);
        }
        return $this->imageModel->uploadFile($request);
    }

    /**
     *delete bilag files
     */
    public function deleteBilagFile(Request $request)
    {
        return $this->imageModel->deleteFile($request);
    }

    /**
     *get status for supervision  page(SUPERVISION/OVERSIGT SUPERVISION)
     */
    public function getSupervisionStatus()
    {
        return  $this->registerSupervisionModel->getAllSupervisionStatus();
    }

    /**
     *get info about supervision page(SUPERVISION/OPDATERING SUPERVISION)
     */
    public function getInfoSupervision(Request $request)
    {
        return $this->registerSupervisionModel->getInfoAboutSupervision($request);
    }

    /**
     *get info about supervision page(SUPERVISION/TEORIKURSER ALLE REGISTRERINGER)
     */
    public function getSupervisionsSession(Request $request)
    {
        return $this->registerSupervisionModel->getSupervisionSession($request);
    }

    /**
     *update supervision session status  page(SUPERVISION/OPDATERING SUPERVISION)
     */
    public function updateSupervisionStatus(Request $request)
    {
        return $this->registerSupervisionModel->updateSupervisionStatus($request);
    }

    /**
     *find supervisor global supervisors
     */
    public function searchGlobalSupervisor(Request $request)
    {
        $this->validate($request, ['find' => 'required']);
        $query = $request->find;
        $supervisor = [];
//       TODO   Need refactor with =>  Role::where('name','=','Enum_Roles::SUPERVISOR')->users->where(like...) and testing
        $search = User::where('name', 'LIKE', '%' . $query . '%')->orWhere('surname', 'LIKE', '%' . $query . '%')->get();
        foreach ($search as $user) {
            if ($user->roles->first()->name == Enum_Roles::SUPERVISOR) {
                array_push($supervisor, $user);
            }
        }
        return $supervisor;
    }

    /**
     *find supervisor profile
     */
    public function findSupervisionProfile(Request $request)
    {
        return $this->userModel->findProfiles($request, Enum_Roles::SUPERVISOR);
    }

    /**
     * return full information about supervisor
     */
    public function getSupervisionInformation(Request $request)
    {
        return User::where("id", "=", $request->supervisionsId)->with('fullInfoAboutUser', 'roles')->first();
    }

    /**
     * add supervision to "Mine List"
     * @param Request $request
     */
    public function addToMineList(Request $request)
    {
        //TODO if we add supervisor created  by psychology need add check in mine_supervision_list_psychology !
        $result = DB::table('mine_supervision_list')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisionsId)->get();
        if ($result->isEmpty()) {
            DB::table('mine_supervision_list')->insert(['userId' => \Auth::user()->id, 'supervision_id' => $request->supervisionsId, 'created_at' => \Carbon\Carbon::now()]);
            return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervison successfuly added.');
        }
        return (new \Illuminate\Http\Response)->setStatusCode(409, 'Supervison already in list.');
    }

    /*
     * get all mine supervision from table(mine_supervision_list)
     */
//   TODO NEED REFACTORING THIS METHOD  (so much quick fix from customer)
    public function getMineListSupervisors()
    {
        $users = DB::table('mine_supervision_list')
            ->where('userId', '=', \Auth::user()->id)
            ->join('users', 'mine_supervision_list.supervision_id', '=', 'users.id')
            ->join('user_information', 'mine_supervision_list.supervision_id', '=', 'user_information.user_id')
            ->join('users_address', 'mine_supervision_list.supervision_id', '=', 'users_address.user_id')
            ->join('supervision_speciality', 'mine_supervision_list.supervision_id', '=', 'supervision_speciality.user_id')
            ->join('users_educations', 'mine_supervision_list.supervision_id', '=', 'users_educations.user_id')
            ->select('users.name', 'users.surname', 'user_information.special_preparation', 'user_information.city', 'user_information.trained_leader',
                'user_information.avatar_path','user_information.age', 'user_information.version', 'mine_supervision_list.created_at',
                'user_information.user_id', 'supervision_speciality.Eksistentiel_humanistisk', 'supervision_speciality.Kognitiv_adfærdsterapeutisk',
                'users_educations.primary_education', 'users_educations.secondary_education', 'users_educations.third_education',
                'supervision_speciality.Psykodynamisk_psykoanalytisk', 'supervision_speciality.Systemisk_strukturel', 'users_address.address_name', 'users_address.road_name', 'users_address.post_number')
            ->get();
        $registerPsychology = DB::table('mine_supervision_list_psychologist')
            ->where('userId', '=', \Auth::user()->id)
            ->join('psychologist_supervision', 'mine_supervision_list_psychologist.supervision_id', '=', 'psychologist_supervision.id')
            ->select('psychologist_supervision.name', 'psychologist_supervision.surname', 'psychologist_supervision.city', 'psychologist_supervision.special_preparation', 'psychologist_supervision.id', 'mine_supervision_list_psychologist.created_at', 'psychologist_supervision.supervisor_selected')
            ->get();
        // TODO change user_id in register_psychology  on id  because customer need hot fix
        $registerPsychology->each(function ($item) {
            $item->user_id = $item->id;
        });
//        TODO NEED REFACTORING THIS DATA TO PUSH IN SOME METHODS :D
        $responseData = [];
        $users = $users->merge($registerPsychology);
        $totalSupervisionHours = $this->registerSupervisionModel->calculateTotalHoursSupervision();
        $responseData['supervisors'] = $users;
        $responseData['totalHoursSession'] = $totalSupervisionHours;

        return $responseData;
    }

    /*
     * add supervision to "Favorite  List"
     * @param Request $request
     */
    public function addToFavoriteList(Request $request)
    {
        $result = DB::table('favorite_supervision_list')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisionsId)->get();
        if ($result->isEmpty()) {
            DB::table('favorite_supervision_list')->insert(['userId' => \Auth::user()->id, 'supervision_id' => $request->supervisionsId, 'created_at' => \Carbon\Carbon::now()]);
            return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervison successfuly added.');
        }
        return (new \Illuminate\Http\Response)->setStatusCode(409, 'Supervison already in list.');
    }

    /*
    * get all favorite supervision from table(favorite_supervision_list)
    */
    public function getFavoriteListSupervisors()
    {
        return DB::table('favorite_supervision_list')
            ->where('userId', '=', \Auth::user()->id)
            ->join('users', 'favorite_supervision_list.supervision_id', '=', 'users.id')
            ->join('user_information', 'favorite_supervision_list.supervision_id', '=', 'user_information.user_id')
            ->join('users_address', 'favorite_supervision_list.supervision_id', '=', 'users_address.user_id')
            ->join('supervision_speciality', 'favorite_supervision_list.supervision_id', '=', 'supervision_speciality.user_id')
            ->join('users_educations', 'favorite_supervision_list.supervision_id', '=', 'users_educations.user_id')
            ->select('users.name', 'users.surname', 'user_information.special_preparation', 'user_information.city', 'user_information.trained_leader',
                'user_information.avatar_path','user_information.age', 'user_information.version', 'favorite_supervision_list.created_at',
                'user_information.user_id', 'supervision_speciality.Eksistentiel_humanistisk', 'supervision_speciality.Kognitiv_adfærdsterapeutisk',
                'users_educations.primary_education', 'users_educations.secondary_education', 'users_educations.third_education',
                'supervision_speciality.Psykodynamisk_psykoanalytisk', 'supervision_speciality.Systemisk_strukturel', 'users_address.address_name', 'users_address.road_name', 'users_address.post_number')
            ->get();
    }

    /*
     * delete supervision from list favorite supervisions
     */
    public function deleteSupervisionFromFavoriteList(Request $request)
    {
        return DB::table('favorite_supervision_list')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisionId)->delete();
    }

    /*
     * delete register supervision session from table(register_supervisions)
     */
    public function deleteRegisterSupervisionsList(Request $request)
    {
        return $this->registerSupervisionModel->where('user_id', '=', \Auth::user()->id)->where('id', '=', $request->supervisionId)->delete();
    }

    /*
     *get information about Supervision created by Psychology
     */
    public function getSupervisionPsychologyInformation(Request $request)
    {
        return PsychologySupervisor::where("id", "=", $request->supervisionsId)->first();
    }

    /*
     *get information about user with role Supervision
     */
    public function getUserRoleSupervisionInformation(Request $request)
    {
        $response['user'] = User::where("id", "=", $request->supervisionsId)->with('fullInfoAboutUser', 'roles')->first();

        $response['supervision_types'] = $response['user']->getSupervisionTypes($request->supervisionsId);
        $response['supervision_specialisation'] = $response['user']->getSupervisionSpecialisation($request->supervisionsId);
        $response['supervisorPictures'] = $response['user']->getUserPictures($request->supervisionsId);
        $response['supervisorVideos'] = $response['user']->getUserVideos($request->supervisionsId);
        $response['supervision_speciality'] = $response['user']->getSupervisionSpeciality($request->supervisionsId);
        $response['supervision_address'] = $response['user']->getUserAddress($request->supervisionsId);
        $response['supervision_educations'] = $response['user']->getUserEducations($request->supervisionsId);
        return $response;
    }


    /*
     * update Psychology supervision name and surname
     */
    public function updateSupervisionPsychologyName(Request $request)
    {
        return PsychologySupervisor::where('id', '=', $request->supervisionId)->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'special_trained' => $request->special_trained,
            'special_preparation' => $request->special_preparation,
        ]);
    }

    /*
     * update Psychology supervision address
     */
    public function updateSupervisionPsychologyAddress(Request $request)
    {
        return PsychologySupervisor::where('id', '=', $request->supervisionId)->update([
            'address' => $request->address,
            'post' => $request->post,
            'city' => $request->city,
        ]);
    }

    /*
     * update Psychology supervision Email Phone
     */
    public function updateSupervisionPsychologyEmailPhone(Request $request)
    {
        return PsychologySupervisor::where('id', '=', $request->supervisionId)->update(['email' => $request->email, 'phone' => $request->phone]);
    }

    /*
    * update Psychology supervision presentation_description
    */
    public function updateSupervisionPsychologyPresentationDescription(Request $request)
    {
        return PsychologySupervisor::where('id', '=', $request->supervisionId)->update(['presentation_description' => $request->presentationDescription]);
    }

    /*
    * update Psychology supervision form type
    */
    public function updateSupervisionPsychologyFormType(Request $request)
    {
        return PsychologySupervisor::where('id', '=', $request->supervisionId)->update(['form_type' => $request->form_type]);
    }

    /*
    * delete supervisor from mine supervisor list
    */
    public function deleteSupervisorFromMineList(Request $request)
    {
        DB::table('psychologist_supervision')->where('user_id', '=', \Auth::user()->id)->where('id', '=', $request->supervisorId)->delete();

        if ($request->table == 'supervisor') {
            return DB::table('mine_supervision_list')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisorId)->delete();
        }
        if ($request->table == 'psychology') {
            return DB::table('mine_supervision_list_psychologist')->where('userId', '=', \Auth::user()->id)->where('supervision_id', '=', $request->supervisorId)->delete();
        }

        return (new \Illuminate\Http\Response)->setStatusCode(409, 'Bad request! SupervisorController=>deleteSupervisor.');
    }

    /*
     *update supervision name && surname  from managing panel
     */
    public function updateSupervisionMainInfo(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'surname' => 'required', 'age' => 'required']);
        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->save();
        $user = Auth::user()->fullInfoAboutUser;
        $user->age = $request->age;
        $user->trained_leader = $request->trained_leader;
        $user->city = $request->city;
        $user->save();
//        update supervision education
        $this->updateSupervisionModel->updateSupervisionEducation($request);
//        update speciality
        $this->updateSupervisionModel->updateSupervisionSpeciality($request);
//        $this-> updateSupervisionSpeciality($request);
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervision main info successfully updated.');

    }

    /*
    *update supervision types && phone from managing panel
    */
    public function updateSupervisionTypes(Request $request)
    {
        $result = DB::table('supervision_types')->where('user_id', '=', $request->user_id)->get();
        if ($result->isEmpty()) {
            DB::table('supervision_types')->insert(['user_id' => $request->user_id,
                'Ansigt_till' => $request->Ansigt_till,
                'Live_Video' => $request->Live_Video,
                'Gruppesupervision' => $request->Gruppesupervision,
                'Enkeltsupervision' => $request->Enkeltsupervision,
                'Egenterapi_Personligt' => $request->Egenterapi_Personligt,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('supervision_types')
                ->where('user_id', '=', $request->user_id)
                ->update([
                    'Ansigt_till' => $request->Ansigt_till,
                    'Live_Video' => $request->Live_Video,
                    'Gruppesupervision' => $request->Gruppesupervision,
                    'Enkeltsupervision' => $request->Enkeltsupervision,
                    'Egenterapi_Personligt' => $request->Egenterapi_Personligt,

                ]);
        }
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervison types  successfully updated.');
    }

    /*
    * add supervision specialisation from managing panel
    */
    public function addSupervisionSpecialisation(Request $request)
    {
        $this->validate($request, ['file' => 'file|mimes:pdf,doc,docx,jpeg,png,jpg', 'specialisation' => 'required']);
        return $this->imageModel->uploadFileVsSpecialisation($request);
    }

    /*
    * delete supervision specialisation from managing panel
    */
    public function deleteSupervisionSpecialisation(Request $request)
    {
        return $this->imageModel->deleteSpecialisation($request);
    }

    public function getSupervisionPsText(Request $request) {
        $user = auth()->user();
        $education = Educations::find($user->fullInfoAboutUser->special_preparation);
        return ! empty($education) ? $education->spv_education : "";
    }

    public function getSupervisionOptions(Request $request) {
        $user = auth()->user();
        $education = Educations::find($user->fullInfoAboutUser->special_preparation);
        return ! empty($education) ? $education->options_sv : "[]";
    }

    public function getSupervisionOptionsChecks(Request $request) {
        $user = auth()->user();
        $education = Educations::find($user->fullInfoAboutUser->special_preparation);
        return ! empty($education) ? $education->check_options : "[]";
    }
}
