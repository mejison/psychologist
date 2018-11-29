<?php
namespace App\Models\ApplicationModels;

use DB;
use JonnyW\PhantomJs\Client;

class ImageModel
{
    /**
     * Upload user profile avatar
     */
    public function uploadUserProfileAvatar($request)
    {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        if ((strpos($imageName, '.') !== false)) {
            $imageName = $imageName . 'jpg';
        }
        $request->image->move(public_path('user_avatars'), $imageName);
        $pathToImg = '/user_avatars/' . $imageName;
        $user = \App\Models\ApplicationModels\User::find(\Auth::user()->id);
        if ($user->fullInfoAboutUser->avatar_path != null) {
            $current_user_avatar = $user->fullInfoAboutUser->avatar_path;
            $current_user_avatar_path = base_path('/public/' . $current_user_avatar);
            if (\File::isFile($current_user_avatar_path)) {
                if (strpos($current_user_avatar_path, 'user_avatars') !== false) {
                    \File::delete($current_user_avatar_path);
                }
            }
        }
        $user->fullInfoAboutUser()->update(['avatar_path' => $pathToImg]);
        $user->save();
        return $pathToImg;
    }

    /**
     * delete user profile avatar
     */
    public function deleteUserAvatar($request)
    {
        $user = \App\Models\ApplicationModels\User::find(\Auth::user()->id);
//        if request from manager (we insert admin-icon placeholder) else  simple user-ava
        if (isset($request->managingPlaceholder)) {
            $placeholderAvatar = '/image/admin-icon.png';
        } else {
            $placeholderAvatar = '/image/avatar-placeholder.png';
        }
        if (isset($user->fullInfoAboutUser->avatar_path)) {
            $current_user_avatar = $user->fullInfoAboutUser->avatar_path;
            $current_user_avatar_path = base_path('/public/' . $current_user_avatar);
            if (\File::isFile($current_user_avatar_path)) {
                if (strpos($current_user_avatar_path, 'user_avatars') !== false) {
                    \File::delete($current_user_avatar_path);
                }
            }
            $user->fullInfoAboutUser()->update(['avatar_path' => $placeholderAvatar]);
        }
    }

    /**
     * upload file from register supervision bilag
     */
    public function uploadFile($request)
    {
        $fileName = $request->file->getClientOriginalName();
        $request->file->move(public_path('bilag_files'), $fileName);
        $pathToFile = '/bilag_files/' . $fileName;
        $fileExtension = $request->file->getClientOriginalExtension();
        try {
            $file_id = DB::table('register_supervisions_bilag')->insertGetId(
                [
                    'user_id' => \Auth::user()->id,
                    'session_id' => $request->sessionId,
                    'file_name' => $fileName,
                    'file_path' => $pathToFile,
                    'file_type' => $fileExtension
                ]
            );
        } catch (\Exception $ex) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, 'File must be unique.');
        }
        $file_data = array(
            'file_id' => $file_id,
            'file_name' => $fileName,
            'file_path' => $pathToFile,
            'file_extension' => $fileExtension,
        );
        return $file_data;
    }

    /**
     * upload file from managing supervision specialisation type
     */
    public function uploadFileVsSpecialisation($request)
    {
        $fileName = $request->file->getClientOriginalName();
        $serverName = time() . $fileName;
        $request->file->move(public_path('specialisation_files'), $serverName);
        $pathToFile = '/specialisation_files/' . $serverName;

        $file_id = DB::table('supervision_file_specialisation')->insertGetId(
            [
                'user_id' => $request->user_id,
                'file_name' => $fileName,
                'path_to_file' => $pathToFile,
                'specialisation' => $request->specialisation,
            ]
        );

        $file_data = array(
            'file_id' => $file_id,
            'file_name' => $fileName,
            'path_to_file' => $pathToFile,
            'specialisation' => $request->specialisation,
        );
        return $file_data;
    }

    /**
     * delete file from register supervision bilag
     */
    public function deleteFile($request)
    {
        $file = DB::table('register_supervisions_bilag')
            ->where('user_id', '=', \Auth::user()->id)
            ->where('id', '=', $request->file_id)
            ->first();
        $current_file_path = base_path('/public/' . $file->file_path);
        \File::delete($current_file_path);

        DB::table('register_supervisions_bilag')
            ->where('user_id', '=', \Auth::user()->id)
            ->where('id', '=', $request->file_id)
            ->delete();
    }

    /**
     * delete file from supervision_file_specialisation
     */
    public function deleteSpecialisation($request)
    {
        $file = DB::table('supervision_file_specialisation')
            ->where('id', '=', $request->id)
            ->first();
        $current_file_path = base_path('/public/' . $file->path_to_file);
        \File::delete($current_file_path);

        DB::table('supervision_file_specialisation')
            ->where('id', '=', $request->id)
            ->delete();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'Supervisor specialisation  successfully deleted.');
    }

    /**
     * create screenshot site
     */
    public function createScreenshotsWebsite($url, $user)
    {
        if ($user->pathWebsiteScreen != null) {
            $current_file_path = base_path('/public/' . $user->pathWebsiteScreen);
            \File::delete($current_file_path);
        }
        $client = Client::getInstance();
        $path = base_path();
//        path to phantomjs.exe
        $path = $path . '/bin/phantomjs.exe';
        $client->getEngine()->setPath($path);
        $request = $client->getMessageFactory()->createCaptureRequest($url);

        $response = $client->getMessageFactory()->createResponse();
        $name = str_random(10);
        $file = '../bin/' . $name . '.jpg';

        $testPath1 = base_path() . '\\bin\\' . $name . '.jpg';
        $testPath2 = public_path() . '/screenshots/' . $name . '.jpg';

        $request->setOutputFile($file);

        $client->send($request, $response);
        rename($file, 'screenshots/' . $name . '.jpg');
        return $pathToFile = '/screenshots/' . $name . '.jpg';

    }

    /**
     * upload pictures from managing supervision specialisation type
     */
    public function uploadSupervisionPictures($request)
    {

        $picturesCount = DB::table('user_pictures')->where('user_id', '=', \Auth::user()->id)->get()->count();
        if ($picturesCount >= 8) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, 'Maximum pictures.');
        }
        $fileName = $request->file->getClientOriginalName();
        $serverName = time() . $fileName;
        $request->file->move(public_path('pictures'), $serverName);
        $pathToFile = '/pictures/' . $serverName;

        $file_id = DB::table('user_pictures')->insertGetId(
            [
                'user_id' => \Auth::user()->id,
                'file_name' => $fileName,
                'path_to_file' => $pathToFile,
            ]
        );

        $file_data = array(
            'file_id' => $file_id,
            'file_name' => $fileName,
            'path_to_file' => $pathToFile,
        );
        return $file_data;
    }

    /**
     * upload videos from managing supervision
     */
    public function uploadSupervisionVideos($request)
    {

        $videosCount = DB::table('user_videos')->where('user_id', '=', \Auth::user()->id)->get()->count();
        if ($videosCount >= 8) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, 'Maximum videos.');
        }
        $fileName = $request->file->getClientOriginalName();
        $serverName = time() . $fileName;
        $request->file->move(public_path('videos'), $serverName);
        $pathToFile = '/videos/' . $serverName;

        $file_id = DB::table('user_videos')->insertGetId(
            [
                'user_id' => \Auth::user()->id,
                'file_name' => $fileName,
                'path_to_file' => $pathToFile,
            ]
        );

        $file_data = array(
            'file_id' => $file_id,
            'file_name' => $fileName,
            'path_to_file' => $pathToFile,
        );
        return $file_data;
    }

    /**
     * upload video Url from managing supervision specialisation type
     */
    public function uploadSupervisionVideosUrl($request)
    {
        $videosCount = DB::table('user_videos')->where('user_id', '=', \Auth::user()->id)->get()->count();
        if ($videosCount >= 8) {
            return (new \Illuminate\Http\Response)->setStatusCode(409, 'Maximum videos.');
        }
        $file_id = DB::table('user_videos')->insertGetId(
            [
                'user_id' => \Auth::user()->id,
                'file_name' =>  ! empty($request->nameVideo) ? $request->nameVideo : 'Video from url' ,
                'path_to_file' => $request->urlVideo,
            ]
        );
        $file_data = array(
            'file_id' => $file_id,
            'file_name' => ! empty($request->nameVideo) ? $request->nameVideo : 'Video from url',
            'path_to_file' => $request->urlVideo,
        );
        return $file_data;
    }

    /**
     * delete file from user_pictures
     */
    public function deleteSupervisionPicture($request)
    {
        $file = DB::table('user_pictures')
            ->where('id', '=', $request->id)
            ->first();
        $current_file_path = base_path('/public/' . $file->path_to_file);
        \File::delete($current_file_path);

        DB::table('user_pictures')
            ->where('id', '=', $request->id)
            ->delete();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User picture  successfully deleted.');
    }

    /**
     * delete file from supervision_videos
     */
    public function deleteSupervisionVideo($request)
    {
        $file = DB::table('user_videos')
            ->where('id', '=', $request->id)
            ->first();
        $current_file_path = base_path('/public/' . $file->path_to_file);
        \File::delete($current_file_path);

        DB::table('user_videos')
            ->where('id', '=', $request->id)
            ->delete();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'User video  successfully deleted.');
    }

    /**
     * upload file from managing course program type
     */
    public function uploadCourseProgram($request)
    {
        $fileName = $request->file->getClientOriginalName();
        $serverName = time() . $fileName;
        $request->file->move(public_path('course_programs'), $serverName);
        $pathToFile = '/course_programs/' . $serverName;

        $file_id = DB::table('course_programs')->insertGetId(
            [
                'user_id' => $request->user_id,
                'file_name' => $fileName,
                'path_to_file' => $pathToFile,
            ]
        );

        $file_data = array(
            'file_id' => $file_id,
            'file_name' => $fileName,
            'path_to_file' => $pathToFile,
        );
        return $file_data;
    }


    /**
     * delete file from course_programs
     */
    public function deleteCourseProgram($request)
    {
        $file = DB::table('course_programs')
            ->where('id', '=', $request->id)
            ->first();
        $current_file_path = base_path('/public/' . $file->path_to_file);
        \File::delete($current_file_path);

        DB::table('course_programs')
            ->where('id', '=', $request->id)
            ->delete();
        return (new \Illuminate\Http\Response)->setStatusCode(200, 'course program successfully deleted.');
    }

}