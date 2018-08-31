<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Draft extends Model
{
    protected $table = 'drafts';


    public function users()
    {
    	return $this->belongsToMany(User::class, 'draft_user')->withTimestamps();
    }

    public static function getTaggedUsers($draft)
    {
    	$user=Auth::user();

    	$user=User::join('draft_user','users.id','=','draft_user.user_id')
    				->where('draft_user.draft_id',$draft->id)
    				->select('users.name')
    				->get();

    	return $user;
    }

    public static function userName($user_id)
    {
    	$user=User::find($user_id);
    	return $user->name;
    }

    public static function getProjectName($project_id)
    {
    	$project=Project::find($project_id);
    	return $project->name;
    }
}
