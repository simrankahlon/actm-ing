<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;


class Idea extends Model
{
	protected $table = 'ideas';

	
	//Tag.
	public function users()
	{
		return $this->belongsToMany(User::class, 'idea_user')->withTimestamps();
	}

	public function ratings()
	{
		return $this->belongsToMany(User::class,'idea_ratings')->withPivot('rating_type')->withTimestamps();
	}

	public function views()
	{
		return $this->belongsToMany(User::class,'idea_view')->withTimestamps();
	}

	public function comments()
	{
	    return $this->hasMany(Comment::class);
	}
	
	public function projects()
	{
	    return $this->belongsTo(Project::class);
	}

	public static function userName($user_id)
	{
		$user=User::find($user_id);
		return $user->name;
	}

	public static function checkIfTagged($idea)
	{
		$user=Auth::user();

		$user_id=DB::table('idea_user')
					->where('idea_user.idea_id',$idea->id)
					->where('idea_user.user_id',$user->id)
					->value('idea_user.user_id');

		if(empty($user_id))
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public static function getTaggedUsers($idea)
	{
		$user=Auth::user();

		$user=User::join('idea_user','users.id','=','idea_user.user_id')
					->where('idea_user.idea_id',$idea->id)
					->select('users.name')
					->get();

		return $user;
	}

	public static function checkifLiked($idea)
	{
		$user=Auth::user();

		$user_id=DB::table('idea_like')
					->where('idea_like.idea_id',$idea->id)
					->where('idea_like.user_id',$user->id)
					->value('idea_like.user_id');

		if(empty($user_id))
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public static function getLikeCount($idea)
	{
		$idea_count = DB::table('idea_like')
						  ->where('idea_like.idea_id',$idea->id)
						  ->count();

		return $idea_count;
	}

	public static function getViewCount($idea)
	{
		$idea_count = DB::table('idea_view')
						  ->where('idea_view.idea_id',$idea->id)
						  ->count();

		return $idea_count;
	}

	public static function getLikeList($idea)
	{
		$users = DB::table('idea_like')
					->join('users','users.id','=','idea_like.user_id')
					->where('idea_like.idea_id',$idea->id)
					->select('users.name')
					->get();

		return $users;
	}

	public static function getViewList($idea)
	{
		$users = DB::table('idea_view')
					->join('users','users.id','=','idea_view.user_id')
					->where('idea_view.idea_id',$idea->id)
					->select('users.name')
					->get();

		return $users;
	}

	public static function getProjectName($project_id)
	{
		$project=Project::find($project_id);
		return $project->name;
	}
}