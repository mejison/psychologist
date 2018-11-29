<?php
namespace App\Http\Controllers;


use App\Models\ApplicationModels\User;
use App\Models\TeorikurserModels\UpdateTeorikurserModel;
use Auth;
use DB;
use Illuminate\Http\Request;
use Response;
use App\Models\ApplicationModels\ImageModel;
use App\Models\ApplicationModels\CourseMainInfo;
use App\Models\ApplicationModels\CourseSubGroups;
use App\Models\ApplicationModels\CourseNumber;
use App\Models\ApplicationModels\CourseGroups;
use App\Models\ApplicationModels\CourseTeacher;
use App\Models\ApplicationModels\RegisterCourses;
use App\Models\ApplicationModels\Educations;
use App\Models\ApplicationModels\EducationRuquire;

class CourseManagingController extends Controller
{
    private $imageModel;
    private $updateTeoriKurserModel;

    public function __construct()
    {
//        TODO need change to dependency injection
        $this->imageModel = new ImageModel();
        $this->updateTeoriKurserModel = new UpdateTeorikurserModel();

    }

    public function getCourseInformation(Request $request){
        $response['user'] = User::where("id", "=", $request->courseOwnerId)->with('roles', 'fullInfoAboutUser')->first();
        $response['course_main_info'] = $response['user']->getCourseInfo($request->courseOwnerId);
        $response['course_modules'] =   $response['user']->getCourseModules($request->courseOwnerId);
        $response['course_address'] =   $response['user']->getUserAddress($request->courseOwnerId);
        $response['course_pictures'] =  $response['user']->getUserPictures($request->courseOwnerId);
        $response['course_videos'] =    $response['user']->getUserVideos($request->courseOwnerId);
        $response['course_program'] =   $response['user']->getCourseProgram($request->courseOwnerId);
        $response['course_teachers'] =  $response['user']->getCourseTeachers($request->courseOwnerId);

        return Response::json($response,200);
    }

    public function updateCourseMainInfo(Request $request)
    {
        $this->validate($request, ['course_number' => 'required', 'course_hours' => 'required']);
        $user = Auth::user()->fullInfoAboutUser;
        $user->special_preparation = json_encode($request->special_preparation);
        $user->save();
        $this->updateTeoriKurserModel->updateCourseMainInfo($request);
        //$this->updateTeoriKurserModel->updateCourseModules($request);
        return (new \Illuminate\Http\Response)->setStatusCode(204, 'Course main info successfully updated.');
    }



    public function addCourseProgram(Request $request)
    {
        $this->validate($request, ['file' => 'file|mimes:pdf,doc,docx,jpeg,png,jpg']);
        return $this->imageModel->uploadCourseProgram($request);
    }
    public function addCourseTeacher(Request $request)
    {
        $this->validate($request, ['teacherName' => 'required']);
//        return teacher id after insert
        return DB::table('course_teachers')->insertGetId(['user_id' => $request->user_id,
            'teacher_name'=>$request->teacherName,
            'created_at' => \Carbon\Carbon::now()]);
    }

    public function deleteCourseProgram(Request $request)
    {
        return $this->imageModel->deleteCourseProgram($request);
    }
    public function deleteCourseTeacher(Request $request)
    {
        DB::table('course_teachers')
            ->where('user_id', '=', \Auth::user()->id)
            ->where('id', '=', $request->id)
            ->delete();
        return (new \Illuminate\Http\Response)->setStatusCode(204, 'Teacher successfully deleted.');

    }
    public function updateCoursePrice(Request $request)
    {
        $this->validate($request, ['course_price' => 'required|numeric']);
        $result = DB::table('course_main_info')->where('user_id', '=', $request->courseOwnerId)->get();
        if ($result->isEmpty()) {
            DB::table('course_main_info')->insert(['user_id' => $request->courseOwnerId,
                'course_price'=>$request->course_price,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('course_main_info')
                ->where('user_id', '=', $request->courseOwnerId)
                ->update([
                    'course_price' => $request->course_price,
                ]);
        }
        return (new \Illuminate\Http\Response)->setStatusCode(201, 'Course price  successfully updated.');

    }

    public function updateCourseDate(Request $request)
    {   
        $this->validate($request, ['CourseDate' => 'required']);
        $result = DB::table('course_main_info')->where('user_id', '=', $request->user_id)->get();
        if ($result->isEmpty()) {
            DB::table('course_main_info')->insert(['user_id' => $request->user_id,
                'course_date'=> $request->CourseDate,
                'course_id' => 0,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('course_main_info')
                ->where('user_id', '=', $request->user_id)
                ->update([
                    'course_date' => $request->CourseDate,
                ]);
        }
        return (new \Illuminate\Http\Response)->setStatusCode(201, 'Course date  successfully updated.');
    }

    public function getAllCourseByModule(Request $request)
    {
        $courses = [];
        if ( ! empty($request->input("module_id")))
        {
            $courses_ids = [];
            $groups_ids = CourseSubGroups::where("groups_id", "=", $request->input("module_id"))->get()->pluck('id');
            if ( ! empty($groups_ids))
            {   
                $courses_ids = CourseNumber::whereIn("groups_id", $groups_ids)->get()->pluck('id');
            }

            if ( ! empty($courses_ids))
            {
                $courses = CourseMainInfo::with('groups.groups.groups')->whereIn("course_id", $courses_ids)->get();
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

            foreach($courses as $key => $course)
            {
                $user = isset($users[$course->user_id]) ? $users[$course->user_id] : []; 
                $teachers = isset($teachers[$user->id]) ? $teachers[$user->id] : [];
    
                $courses[$key] = ['course' => $course, 'user' => $user, 'teachers' => $teachers, 'info' => $user->fullInfoAboutUser()->first()];
            }
        }
        
        return $courses;
    }

    public function getDashbaordGroups(Request $request)
    {
        $educations = Educations::get()->keyBy('id');
        $educations_ids = [];
        $user = User::with('fullInfoAboutUser')->find(Auth::user()->id);
        if ( ! empty($user->fullInfoAboutUser->special_preparation)) {
            $sp = $user->fullInfoAboutUser->special_preparation;

            if ($educations[$sp]->groups()->count()) {
                $educations_ids = $educations[$sp]->groups()->get()->pluck("id");
            }
        }
        
        $groups = [];
        if ( ! empty( $educations_ids)) {
            $groups = CourseGroups::whereIn("id", $educations_ids)->with("sub")->get();
        }

        $reg_courses = RegisterCourses::where("userId", "=", Auth::user()->id)->get();
        
        $register = [];
        $sub_registers = [];
        
        foreach($reg_courses as $r) {
            if ( ! empty($register[$r->group->id])) {
                $register[$r->group->id] += $r->course->groups->time;
            } else {
                $register[$r->group->id] = $r->course->groups->time; 
            }

            if ( ! empty($sub_registers[$r->sub->id])) {
                $sub_registers[$r->sub->id] += $r->course->groups->time;
            } else {
                $sub_registers[$r->sub->id] = $r->course->groups->time; 
            }
        }
        
        $requires = [
            'groups' => [],
            'sub' => []
        ];

        foreach(EducationRuquire::with("course.groups.groups")->get() as $r) {
            if ( ! empty($r->course->groups->groups->id)) {
                $requires['groups'][]= $r->course->groups->groups->id;
            }

            if ( ! empty($r->course->groups->id)) {
                $requires['sub'][]= $r->course->groups->id;
            }                    
        }

        $requires['groups'] = array_unique($requires['groups']);
        $requires['sub'] = array_unique($requires['sub']);

       return ['gropus' => $groups, 'registers' => $register, 'sub_registers' => $sub_registers, 'requires' => $requires];
    }
}