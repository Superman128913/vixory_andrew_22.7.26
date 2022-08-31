<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;

use SimpleSquid\Nova\Fields\Enum\Enum;
use App\Enums\UserData\UserDataSex;
use App\Enums\UserData\UserDataSchoolYear;
use App\Enums\StateCode;
use Laravel\Nova\Fields\BelongsTo;

class User extends Resource
{
    public static $group = 'General';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\User';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'first_name', 'last_name', 'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            //Standard Fields
            ID::make()->sortable(),

            Text::make('Name', function () {
                return $this->first_name.' '.$this->last_name;
            }),

            Text::make('Role', function () {
                $role = $this->roles()->first();
                if($role) {
                    return $role->name;
                }
            })->hideFromIndex(),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Boolean::make('Show Info')->hideFromIndex(),

            //User Details
            new Panel('User Details', $this->userDetailFields()),
            //new Panel('Address', $this->userAddress()),

            //These fields only show on the view screen.
            HasMany::make('Sports'),
            MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Vyuldashev\NovaPermission\Permission::class),
        ];
    }

    /**
     * Get the user detail fields for the resource.
     *
     * @return array
     */
    protected function userDetailFields()
    {
        return [
            BelongsTo::make('College')->searchable(),
            Textarea::make('Profile Description')->hideFromIndex(),
            Text::make('Phone Number')->hideFromIndex(),
            Number::make('Age')->min(15)->max(110)->hideFromIndex(),
            Date::make('Date Of Birth')->hideFromIndex(),
            Enum::make('Sex')->attachEnum(UserDataSex::class)->rules('nullable')->hideFromIndex(),
            Number::make('Height')->min(15)->max(110)->hideFromIndex(),
            Number::make('Weight')->min(80)->max(500)->hideFromIndex(),
            Enum::make('School Year')->attachEnum(UserDataSchoolYear::class)->rules('nullable')->hideFromIndex(),
            Number::make('Highschool GPA')->min(0)->max(5)->step(0.01)->hideFromIndex(),
            Number::make('ACT')->min(0)->max(36)->step(0.01)->hideFromIndex(),
            Number::make('SAT')->min(0)->max(1600)->step(1)->hideFromIndex(),
            Text::make('Hometown')->hideFromIndex(),
            Text::make('Highschool')->hideFromIndex(),
            Number::make('Credit Hours Completed')->min(0)->max(1000)->step(1)->hideFromIndex(),
            
            Text::make('Facebook', 'social_media_facebook')->hideFromIndex(),
            Text::make('Twitter', 'social_media_twitter')->hideFromIndex(),
            Text::make('Instagram', 'social_media_instagram')->hideFromIndex(),
            Text::make('LinkedIn', 'social_media_linkedin')->hideFromIndex(),
        ];
    }

    /**
     * User address fields.
     */
    protected function userAddress()
    {
        return [
            Text::make('Address')->hideFromIndex(),
            Enum::make('State')->attachEnum(StateCode::class)->rules('nullable')->hideFromIndex(),
            Text::make('City')->hideFromIndex(),
            Country::make('Country')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\UserType
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}