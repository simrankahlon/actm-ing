<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'add_admin', 'label' => 'Add Admin']);
        Permission::create(['name' => 'idea_contributer', 'label' => 'Idea Contributer']);
    }
}
