<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;

class PostsController extends Controller
{
    
    public function create()
    {
       	
       	return view('posts.add');
    
    }

    public function store(Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'post_title' => 'required',
    	      'description' =>'required',
    	      ]);

    	$post = new Post;
    	$post->user_id=$user->id;
    	$post->title=request('post_title');
    	$post->description=request('description');

    	$post->save();
    	session()->flash('message','Post added successfully!');
    	
    	return(redirect('/posts'));
    }

    public function list()
    {
    	$posts=Post::paginate(50);
    	return view('posts.view',compact('posts'));
    }

    public function edit(Post $post)
    {
    	return view('posts.edit',compact('post'));
    }

    public function update(Post $post, Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'post_title' => 'required',
    	      'description' =>'required',
    	      ]);

    	$post->user_id=$user->id;
    	$post->title=request('post_title');
    	$post->description=request('description');

    	$post->save();
    	session()->flash('message','Post updated successfully!');
    	
    	return(redirect('/posts'));
    }

    public function delete(Post $post)
    {
        $post->delete();
        session()->flash('message','Post deleted Successfully');
        return back();
        
    }


}
