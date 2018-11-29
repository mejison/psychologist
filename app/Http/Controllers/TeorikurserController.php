<?php

namespace App\Http\Controllers;

use App\Helpers\Enum_Roles;
use App\Models\ApplicationModels\Role;
use App\Models\ApplicationModels\User;
use Illuminate\Http\Request;
use App\Models\ApplicationModels\CourseTeacher;
use App\Models\ApplicationModels\CourseMainInfo;
use App\Models\ApplicationModels\PsychologistCourse;
use App\Models\ApplicationModels\FavoritePsychologist;
use App\Models\ApplicationModels\RegisterCourses;
use App\Models\ApplicationModels\RegisterCoursesAttaches;
use App\Models\ApplicationModels\Educations;
use App\Models\ApplicationModels\InfoPraksis;
use DB;
use Auth;
use Image;

class TeorikurserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getRegisterCourses()
    {
        return RegisterCourses::with(["course", "course.user", "course.user.fullInfoAboutUser", "course.modules", "course.programs", "course.teachers"])->where("userId", "=", Auth::user()->id)->get();
    }

    public function removeFavorite(Request $request)
    {
        return FavoritePsychologist::where("courseId", "=", $request->input("course_id"))->where("userId", "=", Auth::user()->id)->delete();
    }

    public function removeMine(Request $request)
    {
        return PsychologistCourse::where("courseId", "=", $request->input("course_id"))->where("userId", "=", Auth::user()->id)->delete();
    }

    public function getFavoritsListCourses()
    {
        return FavoritePsychologist::where("userId", "=", Auth::user()->id)->with(["course"])->get();   
    }

    public function addToMineListPsychologist(Request $request)
    {
        $course_id = CourseMainInfo::where("user_id", "=",  $request->input("courseId"))->first()->id;
        if (PsychologistCourse::where("userId", "=", Auth::user()->id)->where("courseId", "=", $course_id)->count())
        {
            return json_encode(['title' => 'Fejle!', 'status' => 'error', 'message' => 'Du har allerede tilføjet kurset til dine favoritter']);
        }

        $mine = new PsychologistCourse;
        $mine->userId = Auth::user()->id;
        $mine->courseId = $course_id;
        $mine->save();
        return json_encode(['title' => 'Success!', 'status' => 'success', 'message' => 'Success']);
    }

    public function addToFavoriteListPsychologist(Request $request)
    {
        $course_id = CourseMainInfo::where("user_id", "=",  $request->input("courseId"))->first()->id;
        if (FavoritePsychologist::where("userId", "=", Auth::user()->id)->where("courseId", "=", $course_id)->count())
        {
             return json_encode(['title' => 'Fejle!', 'status' => 'error', 'message' => 'Du har allerede tilføjet kurset til dine favoritter']);
        }

        $favorite = new FavoritePsychologist;
        $favorite->userId = Auth::user()->id;
        $favorite->courseId = CourseMainInfo::where("user_id", "=",  $request->input("courseId"))->first()->id;
        $favorite->save();
        return json_encode(['title' => 'Success!', 'status' => 'success', 'message' => 'Success']);
    }

    public function getAllRegisterCourses()
    {
        return RegisterCourses::with('course')->where("userId", "=", Auth::user()->id)->get();
    }

    public function getRegisterCourseInformation(Request $request)
    {
        return RegisterCourses::where("id", "=", $request->input("id"))->with(['course', 'files', 'course.teachers_all', 'course.groups.groups'])->first();
    }

    public function deleteFileRegisterCourse(Request $request)
    {
        return RegisterCoursesAttaches::where("id", "=", $request->input("id"))->delete();
    }

    public function getCourseAllByDate(Request $request)
    {
        $users = [];
        foreach(User::get() as $row)
        {
            $users[$row->id] = $row;
        }

        $teachers = [];
        foreach(CourseTeacher::get() as $row)
        {
            $teachers[$row->user_id][] = $row;
        }

        $courses = [];
        foreach(CourseMainInfo::where("course_date", "=", $request->input("date"))->get() as $row)
        {
            $user = isset($users[$row->user_id]) ? $users[$row->user_id] : []; 
            $teachers = isset($teachers[$row->id]) ? $teachers[$row->id] : [];
            $courses[] = ['course' => $row, 'user' => $user, 'teachers' => $teachers];
        }

        return json_encode($courses);
    }

    public function getCourse(Request $request)
    {
        $users = [];
        foreach(User::with('fullInfoAboutUser')->get() as $row)
        {
            $users[$row->id] = $row;
        }

        $teachers = [];
        foreach(CourseTeacher::get() as $row)
        {
            $teachers[$row->user_id][] = $row;
        }

        $course = CourseMainInfo::with("groups.groups")->where("user_id", "=", $request->input("id"))->first();
        $user = isset($users[$course->user_id]) ? $users[$course->user_id] : []; 
        $teachers = isset($teachers[$user->id]) ? $teachers[$user->id] : [];
        
        return ['course' => $course, 'user' => $user, 'teachers' => $teachers];
    }

    public function addRegisterCourse(Request $request)
    {   
        $course = CourseMainInfo::where("id", "=", $request->input("course_id"))->first();
        if (RegisterCourses::where("userId", "=", Auth::user()->id)->where("courseId", "=", $course->id)->count())
        {
            return json_encode(['title' => 'Fejle!', 'status' => 'error', 'message' => 'Du har allerede tilføjet kurset til dine favoritter']);
        }


        $register = new RegisterCourses;
        $register->userId = Auth::user()->id;
        $register->courseId = $request->input("course_id");
        $register->name = $course->course_name ? : "";
        $register->code = $course->course_number ? : "";
        $register->date = $course->course_date ? : "";
        $register->timer = $course->course_hours ? : "";
        $register->comment = isset($request->comment) ? $request->comment : "";
        $register->save();


        if ( ! empty($request->file('files')))
        {
           foreach ($request->file('files') as $key => $file)
            {
                $path = $file->store("public");

                $attach = new RegisterCoursesAttaches;
                $attach->registerId = $register->id;
                $attach->file = $path;
                $attach->name = $file->getClientOriginalName();
                $attach->type = "";
                $attach->save();
            }
        
            return json_encode(['title' => 'Godt arbejde, registrering godkendt!', 'status' => 'success', 'message' => 'Success']);
        }
        return json_encode(['title' => 'Godt arbejde, registrering godkendt!', 'status' => 'success', 'message' => 'Success']);
    }

    public function deleteRegisterCourse(Request $request)
    {
        return RegisterCourses::where("id", "=", $request->input("id"))->delete();
    }

    public function updateRegisterCourse(Request $request)
    {
        if ($request->id) {
            $files = [];
            if ($request->course['files']) {
                foreach($request->course['files'] as $file) {
                    if ( ! empty($file["dataUrl"])) {
                        list($type, $ext) = explode("/", substr($file["dataUrl"], 0, strpos($file["dataUrl"], ';')));
                        $path = time() . '.' . $ext;
                        Image::make(base64_decode(substr($file["dataUrl"], strpos($file["dataUrl"], ",") + 1)))->save(storage_path("app/public") . '/' . $path);
                        $files[] = $path;
                    } else {
                        if ($file["file"]) {
                            $files[] = $file["file"];
                        }
                    }
                }
            }
            
            RegisterCourses::where("id", "=", $request->id)->update(['comment' => $request->course["comment"] ? : ""]);
            RegisterCoursesAttaches::where("registerId", "=", $request->id)->delete();

            foreach($files as $file) {
                $attach = new RegisterCoursesAttaches;
                $attach->registerId = $request->id;
                $attach->name = "attach-" . time();
                $attach->file = $file;
                $attach->type = "";
                $attach->save();
            }
        }
    }

    /**
     *find teorikursus global kursus
     */
    public function searchGlobalKurser(Request $request)
    {
        $this->validate($request, ['find' => 'required']);
        $users = [];
        foreach(User::get() as $row)
        {
            $users[$row->id] = $row;
        }

        $teachers = [];
        foreach(CourseTeacher::get() as $row)
        {
            $teachers[$row->user_id][] = $row;
        }

        $courses = [];

        foreach (CourseMainInfo::where('course_name', 'LIKE', '%' . $request->find . '%')->orWhere('course_name', 'LIKE', '%' . $request->find. '%')->get() as $course)
        {   
            $user = isset($users[$course->user_id]) ? $users[$course->user_id] : []; 
            $teachers = isset($teachers[$user->id]) ? $teachers[$user->id] : [];

            $course->course_date = json_decode($course->course_date);
            if ( ! empty($request->input("date")) && ! empty($course->course_date))
            {
                $arr1 = array_map(function($a){
                    return strtotime($a);
                }, $course->course_date);

                $arr2 = array_map(function($a){
                    return strtotime($a);
                }, json_decode($request->input("date")));

                if (array_intersect($arr1, $arr2))
                {
                    $courses[$course->id] = ['course' => $course, 'user' => $user, 'teachers' => $teachers, 'info' => $user->fullInfoAboutUser()->first()];
                }
            } else {
                $courses[$course->id] = ['course' => $course, 'user' => $user, 'teachers' => $teachers, 'info' => $user->fullInfoAboutUser()->first()];
            }

        }
        
        return $courses;
    }

    public function searchGlobalCoursesByTeachers(Request $request)
    {
        $this->validate($request, ['find' => 'required']);
        $courses = [];
        foreach (CourseTeacher::where('teacher_name', 'like', '%' . $request->find . '%')->get() as $teacher) 
        {
            $user = $teacher->user()->first();
            $course = $user->getThisCourseInfo();
            $courses[$course->id] = ['course' => $course, 'user' => $user, 'info' =>$user->fullInfoAboutUser()->first() ];
        }
        return $courses;
    }

    public function findKursusProfile(Request $request)
    {
        $date = [];
        foreach(CourseMainInfo::with(['groups.groups.groups'])->get() as $course) {
            $course->course_date = json_decode($course->course_date) ? : [];
           
            $check = true;
            foreach($course->course_date as $time) {
                $check = false;
                if ($request->input("dateFrom") && $request->input("dateTo")) {
                    
                    if (strtotime($time) >= strtotime($request->input("dateFrom")) && strtotime($time) <= strtotime($request->input("dateTo"))) {
                        $check = true;
                    }
                } else if ($request->input("dateFrom") && ! $request->input("dateTo")) {
                    if (strtotime($time) >= strtotime($request->input("dateFrom"))) {
                        $check = true;
                    }
                   
                } else if ($request->input("dateTo") && ! $request->input("dateFrom")) {
                    if (strtotime($time) <= strtotime($request->input("dateTo"))) {
                        $check = true;
                    }
                    
                } else {
                   $check = true;
                }
            } 

            if ($check) {
                $date[] = $course;
            }
        }

        $preparation = [];
        foreach($date as $course)
        {
            if($request->input("userDegree") != "default") {
               if( ! empty($course->user->fullInfoAboutUser->educations) && count($course->user->fullInfoAboutUser->educations) &&
                     in_array($request->input("userDegree"), $course->user->fullInfoAboutUser->educations)) {
                        $preparation[] = $course;
                }
            }
            else if($request->input("userPlace") != "default") {
                $address = $course->user->getUserAddress($course->user->id);
                if( ! empty($address) && $address->by_address2 == $request->input("userPlace")) {
                        $preparation[] = $course;
                }
            } else {
                $preparation[] = $course;
            }
        }

        $approved = [];
        foreach($preparation as $course)
        {
            if($request->input("approved") ) {
               if($course->course_approved) {
                    $approved[] = $course;
                }
            } else {
                $approved[] = $course;
            }
        }


        $users = [];
        foreach(User::get() as $row)
        {
            $users[$row->id] = $row;
        }

        $teachers = [];
        foreach(CourseTeacher::get() as $row)
        {
            $teachers[$row->user_id][] = $row;
        }

        $courses = [];
        foreach($approved as $course)
        {
            $user = isset($users[$course->user_id]) ? $users[$course->user_id] : $user; 
            $teacher = isset($teachers[$user->id]) ? $teachers[$user->id] : [];

            $courses[$course->id] = ['course' => $course, 'user' => $user, 'teachers' => $teacher, 'info' => $user->fullInfoAboutUser()->first()];
        }
        return $courses;
    }

    public function getInfoPsychologist(Request $request)
    {
        $user = auth()->user();
        $info = Educations::find($user->fullInfoAboutUser->special_preparation);
        if ($info) {
            return ["info" => ! empty($info) ? $info->praksis : ""];
        } else {
            return ["info" => ""];
        }
    }

    public function updateInfoPsychologist(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->info = $request->input("info");
        $user->save();
    }

    public function get_education_all(Request $reqeust)
    {
        $education = Educations::get()->toArray();

        $headers = [
            "0" => ['name' => 'Børneområdet: '],
            "6" => ['name' => 'Voksenområdet: '],
            "13" => ['name' => 'Arbejds- og organisationspsykologi: ']
        ];
    
        foreach($headers as $i => $e) {
            array_splice($education, $i, 0, $e);
        }

        array_splice($education, 0, 0, "");
        array_splice($education, 7, 0, "");
        array_splice($education, 15, 0, "");
        
        return $education;
    }

    public function get_user(Request $reqeust) 
    {
        $full_info = User::where("id", auth()->user()->id)->first();
        $educations = Educations::get()->keyBy("id");
    
        $ps = "";
        if ( ! empty($full_info->fullInfoAboutUser->special_preparation)) {
            $ps = \App\Models\ApplicationModels\Educations::where("id", $full_info->fullInfoAboutUser->special_preparation)->first();
        }

        return ['user' => $full_info, 'ps' => $ps ];   
    }
}
