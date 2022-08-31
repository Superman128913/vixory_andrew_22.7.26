<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use Org_Heigl\Ghostscript\Ghostscript;
use Spatie\Image\Image;

use App\User;
use App\Models\College;

class UserController extends Controller
{
    /**
     * Reactivate the user.
     */
    public function reactivate(Request $request)
    {
        $activeUser = \Auth::user();
        $activeUser->is_deactivated = false;
        $activeUser->save();

        return response()->json($activeUser, 200);
    }

    /**
     * Deactivate the user.
     */
    public function deactivate(Request $request)
    {
        $activeUser = \Auth::user();
        $activeUser->is_deactivated = true;
        $activeUser->save();

        return response()->json($activeUser, 200);
    }

    /**
     * List all of the steps which a user needs to complete in order for their profile to be approved.
     */
    public function listSteps()
    {
        $user = \Auth::user();

        $steps = [
            (object) [
                "name" => "Email Verified",
                "status" => (bool) $user->profile_status_verified
            ],
            (object) [
                "name" => "Basic Informatioon",
                "status" => (bool) $user->profile_status_basic
            ],
            (object) [
                "name" => "Sports Data",
                "status" => (bool) $user->profile_status_sports
            ],
            (object) [
                "name" => "Finished",
                "status" => false
            ]
        ];
        return response()->json($steps, 200);
    }

    /**
     * Delete the user.
     */
    public function deleteUser()
    {
        $user = \Auth::user();
        $user->delete();

        return response()->json("User deleted", 200);
    }

    /**
     * Upload an image to the users temp directory.
     */
    public function uploadTempImage(Request $request)
    {
        $user = \Auth::user();

        //Clear all of the existing images in the tmp collection and add the new temporary file.
        $user->clearMediaCollection("tmp");
        $user->addMedia($request->file)->toMediaCollection("tmp");
        $url = $user->getMedia('tmp')->first()->getUrl();

        return response()->json($url, 200);
    }

    /**
     * Accept an image, upload it, and associate it with the users profile.
     */
    public function uploadReservedFile(Request $request)
    {
        $user = \Auth::user();
        $reserved_name = $request->name;
        $media = $user->addMedia($request->file)->toMediaCollection($reserved_name);
        $media_path =  $media->getPath();

        /**
         * Since spatie/pdf-to-image is poorly written we have to manually convert the PDF to an image, and then store it seperately instead of just using a conversion.
         */
        $gs = new Ghostscript();
        $gs->setGsPath("/usr/bin/gs");

        $gs_output = $gs->setDevice('jpeg')
            ->setInputFile($media_path)
            ->setOutputFile($request->name . "_thumb.jpeg")
            ->setResolution(96)
            ->setTextAntiAliasing(Ghostscript::ANTIALIASING_HIGH);

        if (true === $gs->render())
        {
            //Save the jpeg we just created to the media collection.
            $thumb = $user->addMedia($gs->getOutputFile())->toMediaCollection($reserved_name . "_thumb");

            //Use spaties image manipulations to reduce the size to prevent the need for using a conversion. No need to load spatie/image as its a req of spatie/medialibrary
            Image::load($thumb->getPath())->width(368)->height(232)->save();
        }

        return response()->json(["thumb_url" => $thumb->getFullUrl(), "download_url" => $media->getFullUrl()], 200);
    }

    /**
     * Accept an image, upload it, and associate it with the users profile.
     */
    public function uploadProfileImage(Request $request)
    {
        $user = \Auth::user();
        $user->addMedia($request->file)->toMediaCollection("profile-image");
        $url = $user->getMedia("profile-image")->first()->getUrl();

        return response()->json($url, 200);
    }

    /**
     * Get a user by their id.
     */
    public function getOtherUser(Request $request, User $user)
    {
        //Check to see if user has information set to public or if we are the user
        $authed_user = \Auth::user();
        if($user->show_info || ($authed_user && $authed_user->id == $user->id))
        {
            return response()->json($user, 200);
        }
        else
        {
            //Check to see if the user has accepted an invite from us
            if($authed_user->hasApprovedConnection($user->id))
            {
                return response()->json($user, 200);
            }
            else
            {
                return response()->json(["message" => "This athlete has set their account to private."], 403);
            }
        }
    }

    /**
     * Get the logged in user.
     */
    public function getUser(Request $request)
    {
        $user = \Auth::user();
        if($user) {
            $user->role_names = $user->getRoleNames();
            $user->all_permissions = $user->getAllPermissions()->pluck("name")->toArray();
            return response()->json($user, 200);
        }
        else {
            return response()->json("No user is logged in!", 204);
        }
    }

    /**
     * Set the users header image.
     */
    public function updateHeader(Request $request, $theme_id)
    {
        $user = \Auth::user();
        $user->profile_theme_id = $theme_id;
        $user->save();

        return response()->json($user, 200);
    }


    /**
     * Update user.
     */
    public function updatePartial (Request $request, User $user)
    {
        $fields = $request->all();

        //Update relations and remove the relation fields from the data.
        if(array_key_exists('sports_selected', $fields))
        {
            $sports_selected = collect($fields["sports_selected"]);
            $user->sports()->sync($sports_selected->pluck("value"));
            unset($fields["sports_selected"]);
        }

        //Update sport positions
        $positions = array();
        if(array_key_exists('baseball_position', $fields)) {
            $positions = array_merge($positions, $fields["baseball_position"]);
            unset($fields["baseball_position"]);
        }
        if(array_key_exists('football_position', $fields)) {
            $positions = array_merge($positions, $fields["football_position"]);
            unset($fields["football_position"]);
        }
        if(array_key_exists('basketball_position', $fields)) {
            $positions = array_merge($positions, $fields["basketball_position"]);
            unset($fields["basketball_position"]);
        }
        if(array_key_exists('soccer_position', $fields)) {
            $positions = array_merge($positions, $fields["soccer_position"]);
            unset($fields["soccer_position"]);
        }
        $user->sportpositions()->sync($positions);

        //Initiate approval process if college isn't in the system.
        if(is_int($fields['college_id'])) {
            //Make sure the college exists.
            $college = College::findOrFail($fields['college_id']);
            $user->college_id = $fields['college_id'];
        }
        else {
            $college_text = $fields['college_id'];
            unset($fields['college_id']);

            //If the user didn't specify a college, we need to clear their existing selection.
            if($college_text)
            {
                //First check to make sure a college doesn't already exist with exactly the same name. This would be weird but could occur.
                $college = College::where("name", $college_text)->first();
                if($college) {
                    $user->college_id = $college->id;
                }

                //Save the text so that the college can be created on approval
                else {
                    $user->manual_college_entry = $college_text;
                    $user->requires_approval = true;
                }
            }
            else {
                $user->college_id = null;
            }
        }

        //Update the user.
        $user->update($fields);

        //Load the users data so that front end logic doesn't break when we reset the user in vuex.
        $user->load('sports', 'sportpositions', 'college', 'notificationsettings', 'pending_email');
        $user->role_names = $user->getRoleNames();
        $user->all_permissions = $user->getAllPermissions()->pluck("name")->toArray();

        return response()->json($user, 200);
    }

    /**
     * Update user.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //Validate all the fields and make sure we have access.
        $fields = $request->validated();
        $this->customUpdateValidation($request);

        //Convert state from string to integer.
        if(array_key_exists('state', $fields)) {
            $fields["state"] = (int) $fields["state"];
        }

        //Update relations and remove the relation fields from the data.
        if(array_key_exists('sports_selected', $fields))
        {
            $sports_selected = collect($fields["sports_selected"]);
            $user->sports()->sync($sports_selected->pluck("value"));
            unset($fields["sports_selected"]);
        }
        if(array_key_exists('notificationsettings', $fields))
        {
            $notification_settings = collect($fields["notificationsettings"]);
            $user->notificationsettings()->sync($notification_settings->pluck("value"));
            unset($fields["notificationsettings"]);
        }

        //Update sport positions
        $positions = array();
        if(array_key_exists('baseball_position', $fields)) {
            $positions = array_merge($positions, $fields["baseball_position"]);
            unset($fields["baseball_position"]);
        }
        if(array_key_exists('football_position', $fields)) {
            $positions = array_merge($positions, $fields["football_position"]);
            unset($fields["football_position"]);
        }
        if(array_key_exists('basketball_position', $fields)) {
            $positions = array_merge($positions, $fields["basketball_position"]);
            unset($fields["basketball_position"]);
        }
        if(array_key_exists('soccer_position', $fields)) {
            $positions = array_merge($positions, $fields["soccer_position"]);
            unset($fields["soccer_position"]);
        }
        $user->sportpositions()->sync($positions);

        //Start email verification flow if the email is different.
        if($fields['email'] !== $user->email)
        {
            $user->newEmail($fields['email']);
        }

        //Initiate approval process if college isn't in the system.
        if(is_int($fields['college_id'])) {
            //Make sure the college exists.
            $college = College::findOrFail($fields['college_id']);
            $user->college_id = $fields['college_id'];
        }
        else {
            $college_text = $fields['college_id'];
            unset($fields['college_id']);

            //If the user didn't specify a college, we need to clear their existing selection.
            if($college_text)
            {
                //First check to make sure a college doesn't already exist with exactly the same name. This would be weird but could occur.
                $college = College::where("name", $college_text)->first();
                if($college) {
                    $user->college_id = $college->id;
                }

                //Save the text so that the college can be created on approval
                else {
                    $user->manual_college_entry = $college_text;
                    $user->requires_approval = true;
                }
            }
            else {
                $user->college_id = null;
            }
        }

        //Update the user.
        $user->update($fields);

        //Load the users data so that front end logic doesn't break when we reset the user in vuex.
        $user->load('sports', 'sportpositions', 'college', 'notificationsettings', 'pending_email');
        $user->role_names = $user->getRoleNames();
        $user->all_permissions = $user->getAllPermissions()->pluck("name")->toArray();

        return response()->json($user, 200);
    }

    public function customUpdateValidation($request)
    {
        $is_athlete = \Auth::user()->hasRole('athlete');
        if($is_athlete)
        {
            $validation = Validator::make($request->all(), [
                'phone_number' => [
                    function($attribute, $value, $fail)
                    {
                        if (empty($value))
                        {
                            $fail('Phone number is required.');
                        }
                    }
                ]
            ]);
            $validation->validated();
        }
        return true;
    }

    //Make sure phone number is set if the SMS notification option is.
    /*
    $notifications = array_column($request->input('notificationsettings'), "key");
    if(in_array("SMS", $notifications))
    {
        $sms_validation = Validator::make($request->all(), [
            'phone_number' => [
                function($attribute, $value, $fail)
                {
                    if (empty($value))
                    {
                        $fail('Required when SMS notifications are enabled.');
                    }
                }
            ]
        ]);
        $sms_validation->validated();
    }
    */

}
