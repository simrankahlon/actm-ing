<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   	protected $toTruncate = [
   	    'role_user',
   	    'permission_role',
   	    'permissions',
   	    'roles',
   	    'users',
   	    ];

    public function run()
    {
        	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
            foreach($this->toTruncate as $table){
               DB::table($table)->truncate();  
            }

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
