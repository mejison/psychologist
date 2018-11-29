<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/application';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'verified' => 1,
        ];
    }

    /*
     * checking user role after auth
     */
    protected function authenticated(Request $request, $user)
    {
//        redirect user with role "supervisor" to vue.js app (managing)
        if ($user->roles->first()->name == 'supervisor') {
            if ($user->fullInfoAboutUser->version == 'free') {
                return redirect("/home#SupervisorProfilesideManagingFree/" . $user->id);
            } else {
//                if user has pro version
                return redirect("/home#SupervisorProfilesideManagingPro/" . $user->id);
            }
        }
        //        redirect user with role "courseOrganizer" to vue.js app (managing)
        if ($user->roles->first()->name == 'courseOrganizer') {
            if ($user->fullInfoAboutUser->version == 'free') {
                return redirect("/home#CourseOrganizerProfilesideManagingFree/" . $user->id);
            } else {
//                if user has pro version
                return redirect("/home#CourseOrganizerProfilesideManagingPro/" . $user->id);
            }
        }


    }

}
