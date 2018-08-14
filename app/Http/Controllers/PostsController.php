<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\User;

class PostsController extends Controller
{
    
    public function create()
    {
       $user=Auth::user();
       $users=User::where('id','<>',$user->id)->get();
       return view('posts.add',compact('users'));
    }

    public function store(Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'title' => 'required',
    	      'details' =>'required',
    	      ]);

    	$post = new Post;
    	$post->user_id=$user->id;
    	$post->title=request('title');
    	$post->description=request('details');
        $post->save();
        $post->users()->sync($request->tag_users);
        
    	session()->flash('message','Post added successfully!');
    	
    	return(redirect('/posts'));
    }

    public function list()
    {
    	$posts=Post::orderBy('updated_at','desc')->paginate(50);
    	return view('posts.view',compact('posts'));
    }

    public function edit(Post $post)
    {
    	$user=Auth::user();
        $users=User::where('id','<>',$user->id)->get();
        return view('posts.edit',compact('post','users'));
    }

    public function update(Post $post, Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'title' => 'required',
    	      'details' =>'required',
    	      ]);

    	$post->user_id=$user->id;
    	$post->title=request('title');
    	$post->description=request('details');
        $post->update();
        $post->users()->sync($request->tag_users);
    	session()->flash('message','Post updated successfully!');
    	
    	return(redirect('/posts'));
    }

    public function delete(Post $post)
    {
        $post->delete();
        session()->flash('message','Post deleted Successfully');
        return back();
        
    }

    public function viewComments(Post $post)
    {
        return view('posts.viewcomments',compact('post'));
    }


}
