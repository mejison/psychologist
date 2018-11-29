<?php

namespace App\Helpers;

//        TODO if we pass different types of checkbox need to filter by $role (supervisor or kursus)
class FindFilter
{
    private static $markDegree = false;
    private static $markPlace = false;
    private static $markPreference= false;
    private static $markUddannet= false;
    private static $markNotFound = false;

    public static function filter($request, $listUsers, $role)
    {
        $userResult = [];
        if ($request->userDegree != 'default') {
            self::$markDegree = true;
            foreach ($listUsers as $user) {
                if ($user->fullInfoAboutUser->special_preparation == $request->userDegree) {
                    array_push($userResult, $user);
                }
            }
            if(count($userResult)==0){
                self::$markNotFound = true;
            }
        }

        if(count($userResult)>0) {
            $userResult = self::filterByPlace($request, $userResult);
            $userResult = self::filterByTheoreticalPreference($request, $userResult);
            $userResult = self::filterByUddannet($request, $userResult);
        }else{
            $userResult = self::filterByPlace($request, $listUsers);
            $userResult = self::filterByTheoreticalPreference($request, $userResult);
            $userResult = self::filterByUddannet($request, $userResult);
        }


        if(self::$markNotFound){
            return [];
        }
        else if (self::$markDegree ||self::$markPlace||self::$markPreference||self::$markUddannet) {
            return $userResult;
        }
        return $listUsers;
    }

    private static function filterByPlace($request, $userResult)
    {
        $result = [];
        if ($request->userPlace != 'default') {
            self::$markPlace = true;
            foreach ($userResult as $user) {
                if ($user->fullInfoAboutUser->city == $request->userPlace) {
                    array_push($result, $user);
                }
            }
            if(count($result)==0){
                self::$markNotFound = true;
            }
            return $result;
        }
        return $userResult;
    }

    private static function filterByTheoreticalPreference($request, $userResult)
    {
        $result = [];
        if ($request->userTheoreticalPreference != 'default') {
            self::$markPreference= true;
            foreach ($userResult as $user) {
                if ($user->speciality) {
                    if (($user->speciality->Eksistentiel_humanistisk )&&  $request->userTheoreticalPreference=='Eksistentiel_humanistisk'){
                        array_push($result, $user);
                    }   if ($user->speciality->Kognitiv_adfærdsterapeutisk &&  $request->userTheoreticalPreference=='Kognitiv_adfærdsterapeutisk'){
                        array_push($result, $user);
                    }   if ($user->speciality->Psykodynamisk_psykoanalytisk &&  $request->userTheoreticalPreference=='Psykodynamisk_psykoanalytisk'){
                        array_push($result, $user);
                    }   if ($user->speciality->Systemisk_strukturel &&  $request->userTheoreticalPreference=='Systemisk_strukturel'){
                        array_push($result, $user);
                    }
                }
            }
            if(count($result)==0){
                self::$markNotFound = true;
            }
            return $result;

        }
        return $userResult;
    }

    private static function filterByUddannet($request, $userResult)
    {
        $result = [];
        if ($request->userUddannet) {
            self::$markUddannet = true;
            foreach ($userResult as $user) {
//                if we have 1 (true value for trained_leader)
                if ($user->fullInfoAboutUser->trained_leader) {
                    array_push($result, $user);
                }
            }
            if(count($result)==0){
                self::$markNotFound = true;
            }
            return $result;
        }
        return $userResult;
    }
}