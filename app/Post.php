<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Post extends Model
{
	protected $table = 'posts';

	public function users()
	{
		return $this->belongsTo(User::class);
	}


	public function comments()
	{
	    return $this->hasMany(Comment::class);
	}
}