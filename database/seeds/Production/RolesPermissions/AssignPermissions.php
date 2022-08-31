<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Note: This array should be a duplicate of what's under "CreatePermissions.php"
        $permissions = [
            'update_profile',
            'cancel_account',
            'manage_billing',

            'create_saved_search',
            'read_saved_search',
            'update_saved_search',
            'delete_saved_search',

            'create_video',
            'read_video',
            'edit_video',
            'delete_video',

            'create_articles',
            'read_articles',
            'edit_articles',
            'delete_articles',
            
            'send_connection',
            'respond_to_connection',
            'perform_user_search'
        ];

        //Give all permissions to admin
        foreach($permissions as $permission)
        {
            $admin = Role::where('name', 'admin')->first();
            $admin->givePermissionTo($permission);
        }

        //Give all relevant permissions to coach
        $coach = Role::where('name', 'coach')->first();
        $coach->givePermissionTo('update_profile');
        $coach->givePermissionTo('create_saved_search');
        $coach->givePermissionTo('read_saved_search');
        $coach->givePermissionTo('update_saved_search');
        $coach->givePermissionTo('delete_saved_search');
        $coach->givePermissionTo('send_connection');
        $coach->givePermissionTo('perform_user_search');

        //Give the same permissions to pro scouts
        $pro_scout = Role::where('name', 'pro_scout')->first();
        $pro_scout->givePermissionTo('update_profile');
        $pro_scout->givePermissionTo('create_saved_search');
        $pro_scout->givePermissionTo('read_saved_search');
        $pro_scout->givePermissionTo('update_saved_search');
        $pro_scout->givePermissionTo('delete_saved_search');
        $pro_scout->givePermissionTo('send_connection');
        $pro_scout->givePermissionTo('perform_user_search');

        /**
         * Note: Athlete permissions are assigned based on their subscription role. The only permissions
         * that should be assigned to the athlete role are things that any athlete can do.
         */
        $athlete = Role::where('name', 'athlete')->first();
        $athlete->givePermissionTo('update_profile');
        $athlete->givePermissionTo('cancel_account');
        $athlete->givePermissionTo('manage_billing');
        $athlete->givePermissionTo('respond_to_connection');

        //Give all relevant permissions to founder
        $founder = Role::where('name', 'founder')->first();
        $founder->givePermissionTo('create_video');
        $founder->givePermissionTo('read_video');
        $founder->givePermissionTo('edit_video');
        $founder->givePermissionTo('delete_video');

        $founder->givePermissionTo('create_articles');
        $founder->givePermissionTo('read_articles');
        $founder->givePermissionTo('edit_articles');
        $founder->givePermissionTo('delete_articles');
    }
}
