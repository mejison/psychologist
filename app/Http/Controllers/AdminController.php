<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\ApplicationModels\User;
use App\Models\ApplicationModels\Role;
use App\Models\ApplicationModels\CourseGroups;
use App\Models\ApplicationModels\CourseSubGroups;
use App\Models\ApplicationModels\CourseNumber;
use App\Models\ApplicationModels\Educations;
use App\Models\ApplicationModels\EducationRuquire;
use App\Models\ApplicationModels\InfoPraksis;

class AdminController extends Controller
{
    public function welcome()
    {
        $counts = [];
        foreach(Role::get() as $r)
        {
            $counts[$r->id] = [];
        }

        foreach(User::get() as $u)
        {
            $counts[$u->roles->first()->id][] = $u;
        }

        
        return view("admin.dashboard", ['colors' => ['primary', 'warning', 'success', 'danger'], 'groups' => Role::get()->keyBy("id"), 'counts' => $counts]);
    }

    public function educations()
    {
        $educations = Educations::with(["groups"])->get()->keyBy("id");
        $groups = [];
        $requires = [];
        foreach(Educations::get() as $row) {
            $groups[$row->id]['groups'] = CourseGroups::with('sub', 'sub.courses')->whereNotIn("id", $row->groups->pluck('id')->toArray())->get();
            $requires[$row->id] = $row->requires->pluck("course_id")->toArray();
        }

        return view("admin.courses.educations", ['educations' => $educations, 'groups' => $groups, 'requires' => $requires]);
    }

    public function add_require_course(Request $request)
    {
        $education = EducationRuquire::where("education_id", "=", $request->education)->where("course_id", "=", $request->course);
        if ($education->count()) {
            $education->delete();
        } else {
            $link = new EducationRuquire;
            $link->education_id = $request->education;
            $link->course_id = $request->course;
            $link->save();
        }
    }

    public function add_group_to_educations(Request $request)
    {
        if ( ! empty($request->education)) {
            $group = Educations::find($request->education);
            $group->groups()->syncWithoutDetaching($request->group);
        }
    }

    public function delete_group_from_educations(Request $request) 
    {
        if ( ! empty($request->education)) {
            $group = Educations::find($request->education);
            $group->groups()->detach($request->group);
        }
    }

    public function signin()
    {
        return view("admin.auth.signin");
    }

    public function users($role)
    {
        $users = [];
		foreach(User::whereHas('role', function($q) use ($role){ $q->where("name", "=", $role); })->get() as $user)
		{
			$users[] = $user;
        }
        
        return view("admin.users.list", ['users' => $users]);
    }

    public function auth(Request $request)
    {
        $auth = ['email' => $request->input('email'), 'password' => $request->input('password')];
        if (Auth::validate($auth))
        {
            $user = User::where('email', $auth['email'])->first(); 
            if ($user->hasRole('admin'))
            {
                Auth::attempt($auth, $request->input('remember_me'));
                $this->message('Success login', 'success');
                return TRUE;
            }
            else
            {
                $this->message('You do not have access');
            }
        }
        else
        {
            $this->message('Incorect username or password');
        }
    }

    public function signout()
    {
        Auth::logout();
        $this->message('Success logout', 'success');
    }

    public function delete_user(Request $request)
    {
        if (User::where("id", "=", $request->id)->delete())
        {
            $this->message('Success delete', 'success');
        }
    }

    public function view($id)
    {
        return view("admin.users.view", ["user" => User::where("id", "=", $id)->first()]);
    }

    /* gruops */
    public function updateStatusGroup(Request $request)
    {
        $group = CourseGroups::find($request->input("id"));
        $group->dashboard = $request->input("check");
        $group->save();
        
        $this->message("Success update status", "success");
        return TRUE;
    }

    public function updateShowSubModules(Request $request)
    {
        $group = CourseGroups::find($request->input("id"));
        $group->show_sub = $request->input("check");
        $group->save();

        $this->message("Success update status show sub", "success");
        return TRUE;
    }

    public function course_groups_list()
    {
        $groups = CourseGroups::get()->keyBy("id");
        return view("admin.courses.groups", ['groups' =>  $groups]);
    }

    public function add_groups()
    {
        $group = new CourseGroups;
        $group->name = request()->input("name");
        $group->hours = request()->input("hours");
        $group->save();

        $this->message("Success add groups", "success");
        return TRUE;
    }

    public function delete_groups()
    {
        CourseGroups::where("id", "=", request()->input("id"))->delete();
        $this->message('Success delete groups', 'success');
        return TRUE;
    }

    public function update_groups()
    {
        $group = CourseGroups::where("id", "=", request()->input("id"))->first();
        $group->name = request()->input("name") ? : "";
        $group->hours = request()->input("hours") ? : "";
        $group->update();
        
        $this->message("Success update groups", "success");
        return TRUE;
    }

    /* sub groups */
    public function sub_groups($id)
    {
        $sub_groups = CourseSubGroups::where("groups_id", "=", $id)->get();
        return view("admin.courses.sub_groups", ['sub_groups' =>  $sub_groups, 'group' => CourseGroups::find($id)->name]);
    }

    public function add_sub_groups()
    {
        $sub_groups = new CourseSubGroups;
        $sub_groups->groups_id = request()->input("groups_id");
        $sub_groups->name = request()->input("name") ? : "";
        $sub_groups->number = request()->input("number") ? : "";
        $sub_groups->hours = request()->input("hours") ? : "";
        $sub_groups->save();
        
        $this->message("Success add sub groups", "success");
        return TRUE;
    }

    public function delete_sub_groups()
    {   
        CourseSubGroups::where("id", "=", request()->input("id"))->delete();
        $this->message('Success delete sub groups', 'success');
        return TRUE;
    }

    public function update_sub_groups()
    {
        $sub_groups = CourseSubGroups::where("id", "=", request()->input("id"))->first();
        $sub_groups->name = request()->input("name") ? : "";
        $sub_groups->number = request()->input("number") ? : "";
        $sub_groups->hours = request()->input("hours") ? : 0;
        $sub_groups->save();
        
        $this->message("Success update sub groups", "success");
        return TRUE;
    }

    /* courses */
    public function courses($id)
    {
        $courses = CourseNumber::where("groups_id", "=", $id)->get();
        return view("admin.courses.courses", ['courses' =>  $courses, 'sub_group' => CourseSubGroups::find($id)]);
    }

    public function add_courses()
    {
        $courses = new CourseNumber;
        $courses->groups_id = request()->input("groups_id");
        $courses->name = request()->input("name") ? : "";
        $courses->number = request()->input("number") ? : "";
        $courses->time = request()->input("time") ? : 0;
        $courses->comment = request()->input("comment") ? : "";
        $courses->save();
        
        $this->message("Success add courses", "success");
        return TRUE;
    }

    public function delete_courses()
    {   
        CourseNumber::where("id", "=", request()->input("id"))->delete();
        $this->message('Success delete courses', 'success');
        return TRUE;
    }

    public function update_courses()
    {
        $courses = CourseNumber::where("id", "=", request()->input("id"))->first();
        $courses->name = request()->input("name") ? : "";
        $courses->number = request()->input("number") ? : "";
        $courses->time = request()->input("time") ? : "";
        $courses->comment = request()->input("comment") ? : "";
        $courses->update();
        
        $this->message("Success update courses", "success");
        return TRUE;
    }

    /* --- */

    public function get_modules_all()
    {
        $result = [];
        $result['modules'] = CourseGroups::get()->keyBy("id");
        $result['sub_modules'] = CourseSubGroups::get()->groupBy("groups_id");
        $result['courses'] = CourseNumber::get()->groupBy("groups_id");
        return $result;
    }

    public function update_desc_education()
    {
        $education = Educations::where("id", "=", request()->input("education_id"))->first();
        $education->desc = request()->input("desc");
        $education->update();
    }

    /* praksis */

    public function praksis()
    {
        $educations = Educations::with(["groups"])->get()->keyBy("id");
        $groups = [];
        $requires = [];
        foreach(Educations::get() as $row) {
            $groups[$row->id]['groups'] = CourseGroups::with('sub', 'sub.courses')->whereNotIn("id", $row->groups->pluck('id')->toArray())->get();
            $requires[$row->id] = $row->requires->pluck("course_id")->toArray();
        }

        return view("admin.praksis.info", ['educations' => $educations, 'groups' => $groups, 'requires' => $requires]);
    }

    public function updateInfoPraksis(Request $request)
    {
        $info = InfoPraksis::first();
        if (empty($info)) {
            $info = new InfoPraksis;
        }

        $info->desc = $request->desc;
        $info->save();
    }

    public function update_praksis_education(Request $request)
    {
        $education = Educations::find($request->education_id);
        $education->praksis = $request->praksis;
        $education->save();
    }

    public function spv_educations() {
        $educations = Educations::with(["groups"])->get()->keyBy("id");
        return view("admin.praksis.spv-educations", ['educations' => $educations]);
    }

    public function spv_educations_update(Request $request) {
        $education = Educations::find($request->education_id);
        $education->spv_education = $request->spv_education;
        $education->save();
    }

    public function sv_option_update(Request $request) {
        $check = [];
        $data = [];

        foreach($request->all() as $key => $value) {
            if (strpos($key, "Check")) {
                if ($value) {
                    $check[] = $key;
                }
            } else {
                $data[$key] = $value;
            }
        }

        $education = Educations::find($request->education_id);
        $education->options_sv = json_encode($data);
        $education->check_options = json_encode($check);
        $education->save();
    }
}