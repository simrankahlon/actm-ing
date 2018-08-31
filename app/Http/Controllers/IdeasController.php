<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Idea;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\Draft;

class IdeasController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
       $user=Auth::user();
       $users=User::where('id','<>',$user->id)->get();
       $projects = Project::all();
       return view('ideas.add',compact('users','projects'));
    }

    public function store(Request $request)
    {
    	$user=Auth::user();
        switch ($request->input('save')) {
            case 'save':
                        $this->validate($request,[
                              'problem_statement' => 'required',
                              'project' => 'required',
                              'opportunity' =>'required',
                              
                              ]);

                        $idea = new Idea;
                        $idea->user_id=$user->id;
                        $idea->problem_statement=request('problem_statement');
                        $idea->project_id=request('project');
                        $idea->opportunity=request('opportunity');
                        $idea->implementation=request('implementation');
                        $idea->benefits=request('added_benefits');
                        $idea->current_status='New';
                        $idea->save();
                        DB::table('idea_status')->insert(['idea_id' =>$idea->id, 'status' =>'New','updated_at'=> new \DateTime(),'created_at'=>new \DateTime()]);
                        $idea->users()->sync($request->tag_users);
                          
                        session()->flash('message','Idea added successfully!');
                        
                        return(redirect('/user/ideas'));

                    break;
            
            case 'draft':
                        $this->validate($request,[
                              'problem_statement' => 'required',
                              ]);

                        $draft = new Draft;
                        $draft->user_id=$user->id;
                        $draft->problem_statement=request('problem_statement');
                        $draft->project_id=request('project');
                        $draft->opportunity=request('opportunity');
                        $draft->implementation=request('implementation');
                        $draft->benefits=request('added_benefits');
                        $draft->save();
                        
                        $draft->users()->sync($request->tag_users);
                          
                        session()->flash('message','Idea added as draft successfully!');
                        
                        return(redirect('/user/ideas/drafts'));

        }
    	
    }

    /*public function list()
    {
    	$ideas=Idea::orderBy('updated_at','desc')->paginate(50);
    	return view('ideas.view',compact('ideas'));
    }*/

    public function edit(Idea $idea)
    {
    	$user=Auth::user();
        $users=User::where('id','<>',$user->id)->get();
        $projects = Project::all();
        return view('ideas.edit',compact('idea','users','projects'));
    }

    public function update(Idea $idea, Request $request)
    {
    	$user=Auth::user();

        $this->validate($request,[
              'problem_statement' => 'required',
              'project' => 'required',
              'opportunity' =>'required',
              ]);

        $idea->user_id=$user->id;
        $idea->problem_statement=request('problem_statement');
        $idea->project_id=request('project');
        $idea->opportunity=request('opportunity');
        $idea->implementation=request('implementation');
        $idea->benefits=request('added_benefits');
        $idea->update();
        $idea->users()->sync($request->tag_users);

        if($idea->current_status=='RETURNFORUPDATION')
        {
            if($request->mark_as_updated=='on')
            {
                $current_status_id=DB::table('idea_status')->insertGetId(['idea_id' =>$idea->id, 'status' =>'Resubmitted','user_id'=>$user->id,'updated_at'=> new \DateTime(),'created_at'=>new \DateTime()]);
                $idea->current_status='Resubmitted';
                $idea->current_status_id=$current_status_id;
                $idea->update();

            }
        }
    	session()->flash('message','Idea updated successfully!');
    	
    	return(redirect('/user/ideas'));
    }

    public function delete(Idea $idea)
    {
        $idea->delete();
        session()->flash('message','Idea deleted Successfully');
        return back();
        
    }

    public function viewComments(Idea $idea)
    {
        $user=Auth::user();

        if($idea->user_id!=$user->id)
        {
            $user_id=DB::table('idea_view')
                        ->where('idea_view.idea_id',$idea->id)
                        ->where('idea_view.user_id',$user->id)
                        ->value('idea_view.user_id');

            
            if(empty($user_id))
            {
                $idea->views()->attach($user->id);    
            }
        }
        
        return view('ideas.viewcomments',compact('idea'));
    }

    public function like(Idea $idea)
    {
        $user=Auth::user();
        $idea->likes()->attach($user->id);
        session()->flash('message','You liked the Idea');
        return back();
    }

    public function dislike(Idea $idea)
    {
        $user=Auth::user();
        DB::table('idea_like')
            ->where('idea_like.idea_id',$idea->id)
            ->where('idea_like.user_id',$user->id)
            ->delete();

        session()->flash('message','You dislike the Idea');
        return back();
    }

    public function statushistory(Idea $idea)
    {
        $idea_status=DB::table('idea_status')
            ->where('idea_id',$idea->id)
            ->paginate(50);
        
        return view('ideas.statushistory',compact('idea','idea_status'));
    }


    public function userideas()
    {
        $user=Auth::user();

        $ideas=Idea::where('user_id',$user->id)->paginate(50);

        return view('ideas.useridea',compact('ideas'));
    }


}
