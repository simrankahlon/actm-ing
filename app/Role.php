<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function permissions(){
    	return $this->belongsToMany(Permission::class)->withTimestamps();
    }
    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public static function ConvertNametoId($roleNames)
    {
    	$roleids=[];
    	$roles = Role::whereIn("name", $roleNames)->get();
    	foreach($roles as $role)
    	{
    		$roleids[] = $role->id;	
    	}
    	return $roleids;
    }
}
