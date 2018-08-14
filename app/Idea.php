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

	public function comments()
	{
	    return $this->hasMany(Comment::class);
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
					->where('idea_user.post_id',$post->id)
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
}