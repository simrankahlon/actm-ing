<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $user_count=User::count();
        $post_count=Post::count();
        $comment_count=Comment::count();
        $mypost_count=Post::where('user_id',$user->id)->count();

        //Top % Posts
        $posts=Post::orderBy('updated_at','desc')->limit(5)->get();

        return view('home',compact('user_count','post_count','comment_count','mypost_count','posts'));
    }
}
