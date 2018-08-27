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
        $role_contributer = Role::create(['name' => 'contributer','label' => 'Contributer']);

        $permission_ids = array();

        $role_admins = [
                       "add_admin",
                       "idea_contributer"
                      ];
        $permission_ids = Permission::ConvertNametoId($role_admins); 
        $role_admin->permissions()->attach($permission_ids);


        $role_contributers = [
                       "idea_contributer"
                      ];
        $permission_ids = Permission::ConvertNametoId($role_contributers); 
        $role_contributer->permissions()->attach($permission_ids);

    }
}
