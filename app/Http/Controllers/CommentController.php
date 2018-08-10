<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use App\Post;
use Auth;

class CommentController extends Controller
{
    //

    public function viewComment(Comment $comment)
    {
    	return \Response::json($comment);
    }

    public function addComment(Post $post,Request $request)
    {
    	$user=Auth::user();

    	if($request->comment_id == "")
    	{
    		$comment = new Comment;
    		$comment->post_id=$post->id;
    		$comment->comment=$request->comment;
    		$comment->user_id=$user->id;
    		$comment->save();
    	}
    	else
    	{
    		$comment=Comment::find($request->comment_id);
    		$comment->comment=$request->comment;
    		$comment->update();
    	}
    	return \Response::json($comment);
    }
}
