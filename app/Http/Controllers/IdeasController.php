<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Idea;
use Auth;
use App\User;

class IdeasController extends Controller
{
    
    public function create()
    {
       $user=Auth::user();
       $users=User::where('id','<>',$user->id)->get();
       return view('ideas.add',compact('users'));
    }

    public function store(Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'title' => 'required',
    	      'details' =>'required',
    	      ]);

    	$idea = new Idea;
    	$idea->user_id=$user->id;
    	$idea->title=request('title');
    	$idea->details=request('details');
        $idea->save();
        $idea->users()->sync($request->tag_users);
        
    	session()->flash('message','Idea added successfully!');
    	
    	return(redirect('/ideas'));
    }

    public function list()
    {
    	$ideas=Idea::orderBy('updated_at','desc')->paginate(50);
    	return view('ideas.view',compact('ideas'));
    }

    public function edit(Idea $idea)
    {
    	$user=Auth::user();
        $users=User::where('id','<>',$user->id)->get();
        return view('ideas.edit',compact('idea','users'));
    }

    public function update(Idea $idea, Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'title' => 'required',
    	      'details' =>'required',
    	      ]);

    	$idea->user_id=$user->id;
    	$idea->title=request('title');
    	$idea->details=request('details');
        $idea->update();
        $idea->users()->sync($request->tag_users);
    	session()->flash('message','Idea updated successfully!');
    	
    	return(redirect('/ideas'));
    }

    public function delete(Idea $idea)
    {
        $idea->delete();
        session()->flash('message','Idea deleted Successfully');
        return back();
        
    }

    public function viewComments(Idea $idea)
    {
        return view('ideas.viewcomments',compact('idea'));
    }


}
