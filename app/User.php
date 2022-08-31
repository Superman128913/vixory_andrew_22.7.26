<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use ProtoneMedia\LaravelVerifyNewEmail\MustVerifyNewEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use BenSampo\Enum\Traits\CastsEnums;
use Laravel\Cashier\Billable;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use App\Mail\CustomPasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use App\Enums\StateCode;
use App\Enums\SchoolDivision;
use App\Enums\SchoolType;
use App\Enums\UserData\UserDataSex;
use App\Enums\UserData\UserDataSchoolYear;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Notifiable, Billable, CastsEnums, HasRoles, InteractsWithMedia, SoftDeletes, MustVerifyNewEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'email_verified_at', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $enumCasts = [
        'state' => StateCode::class,
        'division' => SchoolDivision::class,
        'type' => SchoolType::class,
        'sex' => UserDataSex::class,
        'school_year' => UserDataSchoolYear::class
    ];

    /**
     * Model events
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\UserCreated::class,
    ];

    /**
     * Override default laravel email verification
     */
    public function sendEmailVerificationNotification()
    {
        $this->newEmail($this->getEmailForVerification());
    }

    /**
     * Custom password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::to(request()->email)->send(new CustomPasswordReset($token));
    }

    /**
     * The phone number notifications will be sent too.
     */
    public function routeNotificationForTwilio()
    {
        return $this->phone_number;
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'state_code' => 'int',
        'division' => 'int',
        'type' => 'int',
        'email_verified_at' => 'datetime',
        'sex' => 'int',
        'school_year' => 'int',
        'date_of_birth' => 'date:Y-m-d'
    ];

    protected $appends = ['name', 'profile_image', 'rapsodo_media', 'blast_media', 'trackman_media', 'state_name'];
    protected $with = ['sports', 'sportpositions', 'college', 'notificationsettings', 'pending_email'];

    public function hideContactInfo()
    {
        $this->makeHidden(['social_media_facebook', 'social_media_twitter', 'social_media_instagram', 'social_media_linkedin', 'phone_number', 'name', 'first_name', 'last_name', 'email']);
    }

    //Accessors & Mutators
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfileImageAttribute()
    {
        $media = $this->getMedia("profile-image")->first();
        if($media) {
            return $media->getUrl();
        }
    }

    public function getRapsodoMediaAttribute()
    {
        $media = $this->getMedia("rapsodo")->first();
        $thumb = $this->getMedia("rapsodo_thumb")->first();
        if($media && $thumb) {
            $download_url = $media->getUrl();
            return [
                "thumb_url" => $thumb->getUrl(),
                "download_url" => $download_url
            ];
        }
    }

    public function getTrackmanMediaAttribute()
    {
        $media = $this->getMedia("trackman")->first();
        $thumb = $this->getMedia("trackman_thumb")->first();
        if($media && $thumb) {
            $download_url = $media->getUrl();
            return [
                "thumb_url" => $thumb->getUrl(),
                "download_url" => $download_url
            ];
        }
    }

    public function getBlastMediaAttribute()
    {
        $media = $this->getMedia("blast")->first();
        $thumb = $this->getMedia("blast_thumb")->first();
        if($media && $thumb) {
            $download_url = $media->getUrl();
            return [
                "thumb_url" => $thumb->getUrl(),
                "download_url" => $download_url
            ];
        }
    }

    public function getStateNameAttribute() {
        if($this->state) {
            return $this->attributes["state_name"] = StateCode::fromValue($this->state)->key;
        }
        else {
            return "";
        }
    }

    public function getHeightAttribute($height)
    {
        if($height)
        {
            return convert_inches_to_empirical($height);
        }
    }

    public function setHeightAttribute($height)
    {
        $this->attributes['height'] = convert_empirical_to_inches($height);
    }

    //Define media collections
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('profile-image')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->singleFile();

        $this
            ->addMediaCollection('tmp')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->singleFile();

        $this
            ->addMediaCollection('rapsodo')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
        $this
            ->addMediaCollection('rapsodo_thumb')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile();

        $this
            ->addMediaCollection('trackman')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
        $this
            ->addMediaCollection('trackman_thumb')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile();

        $this
            ->addMediaCollection('blast')
            ->acceptsMimeTypes(['application/pdf'])
            ->singleFile();
        $this
            ->addMediaCollection('blast_thumb')
            ->acceptsMimeTypes(['image/jpeg'])
            ->singleFile();
    }

    //Relations
    public function pending_email()
    {
        return $this->hasOne('ProtoneMedia\LaravelVerifyNewEmail\PendingUserEmail');
    }

    public function sportpositions()
    {
        return $this->belongsToMany('App\Models\SportPosition');
    }

    public function connections()
    {
        if(\Auth::user()->hasRole(['coach', 'pro_scout']))
        {
            return $this->hasMany('App\Models\Connection', "user_id");
        }
        else
        {
            return $this->hasMany('App\Models\Connection', "requested_user_id");
        }
    }

    public function coupon()
    {
        return $this->hasOne('App\Models\Coupon');
    }

    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College');
    }

    public function sports()
    {
        return $this->belongsToMany('App\Models\Sport');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function savedsearches()
    {
        return $this->hasMany('App\Models\SavedSearch');
    }

    public function notificationsettings()
    {
        return $this->belongsToMany('App\Models\NotificationSetting');
    }

    /**
     * Get the users payment methods and convert the cashier objects into a plain array.
     */
    public function getPaymentMethodArray()
    {
        return $this->paymentMethods()->map(function($item, $key){
            return $item->asStripePaymentMethod();
        });
    }

    /**
     * Check to see if this user has an accepted connection with the supplied user.
     */
    public function hasApprovedConnection($user_id)
    {
        $connections = $this->connections;

        $approved_connections = $connections->first(function($connection) use ($user_id){
            return ($connection->accepted && $connection->requested_user_id === $user_id);
        });

        return $approved_connections ? true : false;
    }
}
