<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Videos\VideoDeleteRequest;
use App\Http\Requests\Videos\VideoUpdateRequest;
use App\Http\Requests\Videos\VideoListRequest;
use App\Http\Requests\Videos\VideoStoreRequest;
use App\Http\Requests\Videos\VideoListUsersRequest;

use App\User;
use App\Models\Video;
use App\Enums\VideoSource;
use App\Domain\Vimeo\VimeoManager;

class VideoController extends Controller
{
    public function getSources()
    {
        $data = VideoSource::toObjectArray();
        return response()->json($data, 200);
    }

    public function getSingle(Request $request, Video $video)
    {
        return response()->json($video, 200);
    }

    public function listUsers(VideoListUsersRequest $request, User $user)
    {
        $request->validated();
        return response()->json($user->videos, 200);
    }

    public function list(VideoListRequest $request)
    {
        $request->validated();

        $user = \Auth::user();
        return response()->json($user->videos, 200);
    }

    public function uploadByReference(VideoStoreRequest $request)
    {
        $fields = $request->validated();
        $fields["user_id"] = \Auth::user()->id;
        $video = Video::create($fields);
        return response()->json($video, 200);
    }

    public function upload(VideoStoreRequest $request)
    {
        $fields = $request->validated();

        //Add the current users id to the request
        $user = \Auth::user();
        $fields["user_id"] = $user->id;

        //Upload the video to YouTube.
        $vimeo_manager = new VimeoManager();
        $video = $vimeo_manager->uploadVideo($request, $fields);

        //Return generic video uploading message, we'll update the frontend via echo.
        return response()->json($video, 200);
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $fields = $request->validated();
        $video->update($fields);

        return response()->json($video);
    }

    public function delete(VideoDeleteRequest $request, Video $video)
    {
        //Remove the video from YouTube.
        try {
            $vimeo_manager = new VimeoManager();
            $vimeo_manager->deleteVideo($video);
        }
        catch(\Exception $e) {
            //Sometimes videos are added by pasting in a link in which case we don't have the authority to delete them.
            if($e->getCode() == 403) 
            {
                //Continue processing so that the video is deleted from the DB if we get a 403.
                report($e);
            }
        }

        //Delete the video in our DB.
        $video->delete();
        $fields = $request->validated("Video deleted", 200);
    }
}
