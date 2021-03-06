<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function drafts()
    {
        return $this->hasMany(Draft::class);
    }

    public static function create_admin_role_permission_for_project($project_id)
    {
        $role=new Role();
        $role->name='project_admin_'. $project_id;
        $role->label='Project Admin';
        $role->project_id=$project_id;
        $role->save();

        $permission=new Permission();
        $permission->name='admin_project_'. $project_id;
        $permission->label='Admin Project';
        $permission->project_id=$project_id;
        $permission->save();

        $user=User::find(auth()->user()->id);
        
        $role->givePermissionTo($permission);
        
        $roleadmin=Role::where('name','administrator')->first();

        $roleadmin->givePermissionTo($permission);
    }
}
