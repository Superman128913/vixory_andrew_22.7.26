<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //1. Truncate the existing permissions
        $permissions = Permission::all();
        foreach($permissions as $permission)
        {
            $permission->delete();
        }

        //2. Create all the relevant permissions
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

        foreach($permissions as $permission)
        {
            $permission = Permission::create(['name' => $permission]);
        }
    }
}
