<?php
namespace App\Models\TeorikurserModels;

use DB;
use Illuminate\Http\Request;
use App\Models\ApplicationModels\CourseNumber;
use App\Models\ApplicationModels\CourseSubGroups;
use App\Models\ApplicationModels\CourseGroups;

class UpdateTeorikurserModel {

    /*
     * update course main info  from managing panel
    */

    public function updateCourseMainInfo(Request $request)
    {
        $couser_name = "";
        if ( ! empty($request->course_id))
        {
            $couser_name = CourseNumber::find($request->course_id)->name;
        }

        $result = DB::table('course_main_info')->where('user_id', '=', $request->user_id)->get();
        if ($result->isEmpty()) {
            DB::table('course_main_info')->insert(['user_id' => $request->user_id,
                'course_id' => $request->course_id,
                'course_name' => $couser_name,
                'course_number' => $request->course_number,
                'course_hours' => $request->course_hours,
                'course_approved' => $request->course_approved,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('course_main_info')
                ->where('user_id', '=', $request->user_id)
                ->update([
                    'course_id' => $request->course_id,
                    'course_name' => $couser_name,
                    'course_number' => $request->course_number,
                    'course_hours' => $request->course_hours,
                    'course_approved' => $request->course_approved,
                ]);
        }
    }
    /*
    *update course modules  from managing panel
    */
    public function updateCourseModules(Request $request)
    {
        $result = DB::table('course_modules')->where('user_id', '=', $request->user_id)->get();
        if ($result->isEmpty()) {
            DB::table('course_modules')->insert(['user_id' => $request->user_id,
                'Arbejds_og_organisationspsykologi' => $request->Arbejds_og_organisationspsykologi,
                'Børnemodulet' => $request->Børnemodulet,
                'Voksenmodulet' => $request->Voksenmodulet,
                'Det_tværgående' => $request->Det_tværgående,
                'Forsknings_og_formidlingsmodulet' => $request->Forsknings_og_formidlingsmodulet,
                'Specialiseringsmodulerne' => $request->Specialiseringsmodulerne,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('course_modules')
                ->where('user_id', '=', $request->user_id)
                ->update([
                    'Arbejds_og_organisationspsykologi' => $request->Arbejds_og_organisationspsykologi,
                    'Børnemodulet' => $request->Børnemodulet,
                    'Voksenmodulet' => $request->Voksenmodulet,
                    'Det_tværgående' => $request->Det_tværgående,
                    'Forsknings_og_formidlingsmodulet' => $request->Forsknings_og_formidlingsmodulet,
                    'Specialiseringsmodulerne' => $request->Specialiseringsmodulerne,
                ]);
        }
    }

    
}