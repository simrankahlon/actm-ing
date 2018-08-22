<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $simran = User::create(['name' => 'Simran Kahlon', 'email' => 'actm@atos.net', 'password'=> bcrypt('Pass@123')]); 
        
        $role_ids = array();
        
        $simran_role = [
                       "administrator"
                      ];

        $role_ids = Role::ConvertNametoId($simran_role); 
        $simran->roles()->attach($role_ids);

    }
}
