<?php
namespace App\Models\SupervisorModels;

use DB;
use Illuminate\Http\Request;


class UpdateSupervisionModel{


    /*
    *update supervision education from managing panel
     */
    public function updateSupervisionEducation(Request $request)
    {
        $result = DB::table('users_educations')->where('user_id', '=', $request->supervisionId)->get();
        if ($result->isEmpty()) {
            DB::table('users_educations')->insert(['user_id' => $request->supervisionId,
                'primary_education' => $request->primary_education,
                'secondary_education' => $request->secondary_education,
                'third_education' => $request->third_education,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('users_educations')
                ->where('user_id', '=', $request->supervisionId)
                ->update([
                    'primary_education' => $request->primary_education,
                    'secondary_education' => $request->secondary_education,
                    'third_education' => $request->third_education,
                ]);
        }
    }




    /*
    *update supervision speciality/interest from managing panel
    */
    public function updateSupervisionSpeciality(Request $request)
    {
        $result = DB::table('supervision_speciality')->where('user_id', '=', $request->supervisionId)->get();
        if ($result->isEmpty()) {
            DB::table('supervision_speciality')->insert(['user_id' => $request->supervisionId,
                'Eksistentiel_humanistisk' => $request->Eksistentiel_humanistisk,
                'Kognitiv_adfærdsterapeutisk' => $request->Kognitiv_adfærdsterapeutisk,
                'Psykodynamisk_psykoanalytisk' => $request->Psykodynamisk_psykoanalytisk,
                'Systemisk_strukturel' => $request->Systemisk_strukturel,
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('supervision_speciality')
                ->where('user_id', '=', $request->supervisionId)
                ->update([
                    'Eksistentiel_humanistisk' => $request->Eksistentiel_humanistisk,
                    'Kognitiv_adfærdsterapeutisk' => $request->Kognitiv_adfærdsterapeutisk,
                    'Psykodynamisk_psykoanalytisk' => $request->Psykodynamisk_psykoanalytisk,
                    'Systemisk_strukturel' => $request->Systemisk_strukturel,
                ]);
        }
    }
    
}