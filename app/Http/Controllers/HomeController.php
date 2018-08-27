<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Idea;
use App\Comment;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;

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
        
        $project_id = DB::table('project_user')
                          ->where('user_id',$user->id)
                          ->limit(1)
                          ->value('project_id');

        if(!empty($project_id))
        {
            Session::put('is_projectadmin','Yes');
        }

        $user_count=User::count();
        $idea_count=Idea::count();
        $comment_count=Comment::count();
        $myidea_count=Idea::where('user_id',$user->id)->count();

        $tag_ideas=Idea::join('idea_user','ideas.id','=','idea_user.idea_id')
                         ->select('ideas.*')
                         ->where('idea_user.user_id',$user->id)
                         ->limit(5)
                         ->get();

        
        //Top % Ideas
        $ideas=Idea::orderBy('updated_at','desc')->get();

        return view('home',compact('user_count','idea_count','comment_count','myidea_count','ideas','tag_ideas'));
    }
}
