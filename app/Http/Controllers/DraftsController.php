<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Draft;
use App\User;
use App\Project;
use App\Idea;
use Illuminate\Support\Facades\DB;

class DraftsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $user=Auth::user();

        $drafts=Draft::where('user_id',$user->id)->paginate(50);

        return view('drafts.view',compact('drafts'));
    }

    public function edit(Draft $draft)
    {
    	$user=Auth::user();
        $users=User::where('id','<>',$user->id)->get();
        $projects = Project::all();
        return view('drafts.edit',compact('draft','users','projects'));
    }

    public function update(Draft $draft, Request $request)
    {
    	$user=Auth::user();

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
                            $draft->delete();
                            DB::table('idea_status')->insert(['idea_id' =>$idea->id, 'status' =>'New','updated_at'=> new \DateTime(),'created_at'=>new \DateTime()]);
                            $idea->users()->sync($request->tag_users);
                              
                            session()->flash('message','Idea added successfully!');
                            
                            return(redirect('/user/ideas'));

                        break;
                
                case 'draft':
                            $this->validate($request,[
                                  'problem_statement' => 'required',
                                  ]);

                            $draft->user_id=$user->id;
                            $draft->problem_statement=request('problem_statement');
                            $draft->project_id=request('project');
                            $draft->opportunity=request('opportunity');
                            $draft->implementation=request('implementation');
                            $draft->benefits=request('added_benefits');
                            $draft->update();

                            $draft->users()->sync($request->tag_users);
                              
                            session()->flash('message','Draft updated successfully!');
                            
                            return(redirect('/user/ideas/drafts'));

            }
    }

    public function delete(Draft $draft)
    {
        $draft->delete();
        session()->flash('message','Draft deleted Successfully');
        return back();
        
    }
}
