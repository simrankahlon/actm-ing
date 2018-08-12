<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;


class Post extends Model
{
	protected $table = 'posts';

	
	//Tag.
	public function users()
	{
		return $this->belongsToMany(User::class, 'post_user')->withTimestamps();
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

	public static function checkIfTagged($post)
	{
		$user=Auth::user();

		$user_id=DB::table('post_user')
					->where('post_user.post_id',$post->id)
					->where('post_user.user_id',$user->id)
					->value('post_user.user_id');

		if(empty($user_id))
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public static function getTaggedUsers($post)
	{
		$user=Auth::user();

		$user=User::join('post_user','users.id','=','post_user.user_id')
					->where('post_user.post_id',$post->id)
					->select('users.name')
					->get();

		return $user;
	}
}