<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($role)
    {
        if(is_string($role))
        {
            return $this->roles->contains('name',$role);
        }

        return !! $role->intersect($this->roles)->count();

    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')->withTimestamps();
    }

    public static function checkifRoleAttached($user_id,$role_id)
    {
        $role_id=DB::table('role_user')
                    ->where('role_id',$role_id)
                    ->where('user_id',$user_id)
                    ->value('role_id');

        if(empty($role_id))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function checkifAdmin(User $user)
    {
        $role_id=Role::join('role_user','role_user.role_id','=','roles.id')
                       ->where('roles.name','administrator')
                       ->where('role_user.user_id',$user->id)
                       ->first();
        
        if(empty($role_id))
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    public function assignRole($role){
        $role = Role::whereName($role)->firstOrFail();
        return $this->roles()->attach([$role->id]);
    }

    public static function checkifAlreadyAttached($user_id,$project_id)
    {
        $project_id=DB::table('project_user')
                    ->where('project_id',$project_id)
                    ->where('user_id',$user_id)
                    ->value('project_id');

        if(empty($project_id))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function checkifAttachedToProjectRole($user_id,$project_id)
    {
        $role_name=Role::join('role_user','roles.id','=','role_user.role_id')
                               ->where('roles.project_id',$project_id)
                               ->where('role_user.user_id',$user_id)
                               ->first();

        if(empty($role_name))
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}
