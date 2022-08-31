<?php
namespace App\Domain\Vimeo;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Notification;
use App\Events\VideoUploaded;
use Illuminate\Support\Facades\Log;

use App\Models\Video;
use Vimeo\Laravel\Facades\Vimeo;

session_start();

class VimeoManager
{
    /**
     * Uploads a video to vimeo.
     */
    public function uploadVideo($request, $data)
    {
        try{
            //Store the video so that we can get it's path.
            $path = "storage/" . $request->file('file')->store('video_tmp', 'public');

            $response = Vimeo::upload($path, [
                'name' => $data["title"],
                'description' => $data["description"]
            ]);

            if(!is_array($response))
            {
                $parts = explode("/", $response);
                $video_id = end($parts);

                $video = Video::create([
                    "user_id" => $data["user_id"],
                    "title" => $data["title"],
                    "description" => $data["description"],
                    "source_id" => $video_id
                ]);
    
                $user = \Auth::user();
                event(new VideoUploaded($user->id, $video));
    
                return $video;
            }
        }
        catch (\Exception $e)
        {
            Log::error("There was an error uploading a video.");
            throw $e;
        }
    }

    /**
     * Deletes a video from vimeo.
     */
    public function deleteVideo($video)
    {
        try {
            Vimeo::request("/videos/" . $video->source_id, [], "DELETE");
        }
        catch (\Exception $e)
        {
            Log::error("There was an error uploading a video.");
            throw $e;
        }
    }
}
