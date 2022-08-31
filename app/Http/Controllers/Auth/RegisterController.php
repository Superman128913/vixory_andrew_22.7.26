<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CoachRegistered;

use App\User;
use App\Models\College;
use App\Models\Coupon;
use App\Domain\Mailchimp\Connector;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo() {
        $user = \Auth::user();
        if($user && $user->requires_approval && !$user->approval) {
            return "/pending-approval";
        }
        return "/account";
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'college'           => ['nullable'],
            'pro_team_name'     => ['nullable'],
            'consent_given'     => ['required', 'boolean'],
            'coupon'            => ['nullable', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //Make sure a college was included in the request if the pro scout field wasn't
        if(! isset($data['pro_team_name']))
        {
            $validator = Validator::make($data, [
                'college' => ['required'],
            ]);
            $validator->validated();
        }

        //Create the user
        $user = User::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'requires_approval' => true,
            'approval'          => false,
            'consent_given'     => $data['consent_given']
        ]);

        //Create coupon in backend
        if(array_key_exists("coupon", $data))
        {
            $coupon_code = $data["coupon"];
            $coupon = new Coupon();
            $coupon->code = $coupon_code;
            $coupon->user_id = $user->id;
            $coupon->save();
        }

        //Save college or team name
        if(isset($data['pro_team_name'])) {
            $user->pro_team_name = $data['pro_team_name'];
        }
        else {
            //Associate user with college
            if(is_int($data['college'])) {
                //Make sure the college exists.
                $college = College::findOrFail($data['college']);
                $user->college_id = $data['college'];
            }

            else {
                //First check to make sure a college doesn't already exist with exactly the same name. This would be weird but could occur.
                $college = College::where("name", $data['college'])->first();
                if($college) {
                    $user->college_id = $college->id;
                }

                //Save the text so that the college can be created on approval
                else {
                    $user->manual_college_entry = $data['college'];
                }
            }
        }
        $user->save();

        //Assign the role (athletes use the SubscriptionController)
        if($data['user_type'] == "coach")
        {
            $user->assignRole("coach");
            $tag = "coach";
        }
        else
        {
            $user->assignRole("pro_scout");
            $tag = "scout";
        }

        //Log the user in.
        \Auth::login($user);

        //Add the user to Mailchimp
        $mc_connector = new Connector();
        $mc_connector->addUser($user->email, $user->first_name, $user->last_name, $tag);

        //Notify all admins
        Notification::send(admin_users(), new CoachRegistered($user));

        //Return the user
        return $user;
    }
}
