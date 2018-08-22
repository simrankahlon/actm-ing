<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::create(['name' => 'administrator', 'label' => 'Administrator']);
        $role_groupadmin = Role::create(['name' => 'projectadmin', 'label' => 'Project Admin']);

        $permission_ids = array();

        $role_admins = [
                       "add_admin",
                       "add_projectadmin",
                      ];
        $permission_ids = Permission::ConvertNametoId($role_admins); 
        $role_admin->permissions()->attach($permission_ids);


        $role_groupadmins = [
                       "add_projectadmin",
                      ];
        $permission_ids = Permission::ConvertNametoId($role_groupadmins); 
        $role_groupadmin->permissions()->attach($permission_ids);

    }
}
