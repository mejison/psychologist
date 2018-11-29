<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfile;
use App\Models\ApplicationModels\ImageModel;
use App\Models\ApplicationModels\User;
use App\Models\ApplicationModels\UserSubInformation;
use Auth;
use DB;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    private $imageModel;
    private $userModel;

    public function __construct()
    {
        $this->imageModel = new ImageModel();
        $this->userModel = new User();
    }

    /**
     * return page dashboard
     */
    public function index()
    {
        return view('application.dashboard');
    }

    /**
     * @return all information about user
     */
    public function getInformation()
    {
        $educations = \App\Models\ApplicationModels\Educations::get()->keyBy('id');


        $informationAboutUser = \App\Models\ApplicationModels\User::with('fullInfoAboutUser', 'roles')->find(\Auth::user()->id);
        $informationAboutUser["sp_text"] = "";
        $informationAboutUser["requires"] = [];

        if ( ! empty($informationAboutUser->fullInfoAboutUser->special_preparation))
        {
            $informationAboutUser["sp_text"] = ! empty($educations[$informationAboutUser->fullInfoAboutUser->special_preparation]) ? $educations[$informationAboutUser->fullInfoAboutUser->special_preparation]->desc : '';
            $first = \App\Models\ApplicationModels\Educations::with('requires.course')->where("id", "=", $informationAboutUser->fullInfoAboutUser->special_preparation)->first();
            $informationAboutUser["requires"] = [];
            if ( ! empty($first)) {
                $informationAboutUser["requires"] = $first->requires;
            }
        }
        
        return $informationAboutUser;
    }

    /**
     * Update user profile data
     */
    public function updateInformation(UpdateUserProfile $request)
    {
        try {
            $this->userModel->updateProfile($request);
        } catch (\Exception $ex) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, $ex->getMessage());
        }
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'The profile is updated successfully!');
    }

    /**
     * Upload user profile avatar
     */
    public function imageUploadPost(Request $request)
    {
        $this->validate($request, ['image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        return $this->imageModel->uploadUserProfileAvatar($request);
    }

    /**
     * delete user profile avatar
     */
    public function deleteUserAvatar(Request $request)
    {
        $this->imageModel->deleteUserAvatar($request);
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User avatar was deleted!');
    }

    /**
     * add new comment from user
     */
    public function sendCommentMessage(Request $request)
    {
        $this->validate($request, ['message' => 'required']);
        DB::table('user_comments')->insert(['user_id' => \Auth::user()->id, 'comment' => $request->message, 'created_at' => new \DateTime()]);
        
        $mail = new \App\Mail\EamilCallbackForm(User::find(auth()->user()->id), $request->message);
        \Mail::to("frans.boeriis@gmail.com")
            ->send($mail);

        return (new \Illuminate\Http\Response)->setStatusCode(200, 'The comment was successfully added!');
    }

    /**
     * add profile visitor count +1
     */
    public function addProfileVisitor(Request $request)
    {
        $userSubInfo = UserSubInformation::where('user_id', '=', $request->visitorId)->first();
        $userSubInfo->visitors_count = $userSubInfo->visitors_count + 1;
        $userSubInfo->save();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'The visitor successfully added!');
    }
    /**
     * add profile visitor web page count +1
     */
    public function addProfileWebPageVisitor(Request $request)
    {
        $userSubInfo = UserSubInformation::where('user_id', '=', $request->userId)->first();
        $userSubInfo->website_link_count = $userSubInfo->website_link_count + 1;
        $userSubInfo->save();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'The visitor successfully added!');
    }

    /*
    *update user profile version from free to pro
    */
    public function updateUserProfileVersionPro()
    {
        $user = Auth::user()->fullInfoAboutUser;
        $user->version = "pro";
        $user->save();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User version successfully updated.');
    }

    /*
    *update user profile version from free to pro
    */
    public function updateUserProfileVersionFree()
    {
        $user = Auth::user()->fullInfoAboutUser;
        $user->version = "free";
        $user->save();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User version successfully updated.');
    }
    /*
    *update user address
    */
    public function updateUserAddress(Request $request)
    {
        $this->validate($request, ['addressName' => 'required', 'roadName' => 'required', 'postNumber' => 'required']);
        $result = DB::table('users_address')->where('user_id', '=', $request->user_id)->get();
        if ($result->isEmpty()) {
            DB::table('users_address')->insert(['user_id' => $request->user_id,
                'address_name' => $request->addressName,
                'road_name' => $request->roadName,
                'post_number' => $request->postNumber,
                'by_address' => $request->byAddress,
                'by_address2' => ! empty($request->byAddress2) ? : "",
                'created_at' => \Carbon\Carbon::now()]);
        } else {
            DB::table('users_address')
                ->where('user_id', '=', $request->user_id)
                ->update([
                    'address_name' => $request->addressName,
                    'road_name' => $request->roadName,
                    'post_number' => $request->postNumber,
                    'by_address' => $request->byAddress,
                    'by_address2' => ! empty($request->byAddress2) ? : "",
                ]);
        }
        return (new \Illuminate\Http\Response)->setStatusCode(204, 'User address successfully updated.');
    }
    /*
    *update user email && phone from managing panel
    */
    public function updateUserEmailPhone(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'phone' => 'required']);
        $user = Auth::user();
        $user->email = $request->email;
        $user->save();
        $user = Auth::user()->fullInfoAboutUser;
        $user->phone = $request->phone;
        $user->save();
        return (new \Illuminate\Http\Response)->setStatusCode(204, 'User email && phone successfully updated.');
    }

    /*
    *update user website  from managing panel
    */
    public function updateUserWebsite(Request $request)
    {
        $this->validate($request, ['website' => 'required']);
        $id = ! empty($request->supervisionId) ? $request->supervisionId : ( ! empty($request->user_id) ? $request->user_id : false);
        if ($id) {
            $user = User::find($id)->fullInfoAboutUser;
            $user->website = $request->website;
            $user->save();
        }
        return response($user->pathWebsiteScreen, 200);
    }


    /*
    * update user email && phone from managing panel
    */
    public function updateUserPresentation(Request $request)
    {
        $this->validate($request, ['presentationDescription' => 'required']);
        $user = Auth::user()->fullInfoAboutUser;
        $user->presentation = $request->presentationDescription;
        $user->save();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User presentation successfully updated.');
    }

    /*
     * delete user picture from managing panel
     */
    public function deleteUserPicture(Request $request)
    {
        return $this->imageModel->deleteSupervisionPicture($request);
    }

    /*
  * upload images from user managing panel
  */
    public function uploadUserImages(Request $request)
    {
        $this->validate($request, ['file' => 'file|mimes:jpeg,png,jpg,svg']);
        return $this->imageModel->uploadSupervisionPictures($request);
    }
    /*
    * upload videos from user managing panel
    */
    public function uploadUserVideos(Request $request)
    {
        if ( ! in_array($request->file->getClientMimeType(), ['video/mp4', 'application/octet-stream'])) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, 'Incorrect video format.');
        }
        return $this->imageModel->uploadSupervisionVideos($request);
    }
    /*
   * upload videos url from user managing panel
   */
    public function uploadUserVideosUrl(Request $request)
    {
        $this->validate($request, ['urlVideo' => 'required']);
        return $this->imageModel->uploadSupervisionVideosUrl($request);
    }


    /*
     * delete user videos from managing panel
     */
    public function deleteUserVideos(Request $request)
    {
        return $this->imageModel->deleteSupervisionVideo($request);
    }

}
