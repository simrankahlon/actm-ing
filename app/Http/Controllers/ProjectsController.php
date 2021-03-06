<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Role;
use Illuminate\Support\Facades\DB;
use Session;
use App\Permission;
use App\Idea;


class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
       $project_id="";

       if(Session::has('project_id'))
       {
            $project_id=Session::get('project_id');
       }

       if(auth()->user()->can('admin_project_'.$project_id) or auth()->user()->can('add_admin'))
       {
       		$user=Auth::user();
       		$users=User::where('id','<>',$user->id)->get();
       		return view('projects.add',compact('users'));
       }
       else
       {
       		return view('errors.403');
       }
    }

    public function store(Request $request)
    {
    	$user=Auth::user();
    	$this->validate($request,[
    	      'name' => 'required|min:2|unique:projects|max:'.config('global.maxlength'),
    	      ]);

    	$project = new Project;
    	$project->name=$request->name;
        $project->save();
        $project->users()->sync($request->project_admin);

        $admin_users = User::join('role_user','role_user.user_id','=','users.id')
                            ->join('roles','roles.id','=','role_user.role_id')
                            ->where('roles.name','administrator')
                            ->where('user.id','<>',$user->id)
                            ->select('users.id');

        $project->users()->attach($user->id); //The one who created will also be attached as a user

        
        foreach($admin_users as $ausers)
        {
            if(User::checkifAlreadyAttached($ausers->id,$project->id))
            {
                $project->users()->attach($ausers->id);// Attach all admin users to the project.
            }
        }

        //Create Project Specific Roles and Permissions
        Project::create_admin_role_permission_for_project($project->id);
        
        $role_id=Role::where('name','project_admin_'.$project->id)->value('id');

        $role=Role::find($role_id);

        $role->users()->sync($request->project_admin);

        $role->users()->attach($user->id);

        foreach($admin_users as $ausers)
        {
            if(User::checkifRoleAttached($ausers->id,$role_id))
            {
                $role->users()->attach($ausers->id);  
            }
        }

        session()->flash('message','Project added successfully!');
    	
    	return(redirect('/projects'));
    }

    public function list()
    {
    	
        $project_id="";

        if(Session::has('project_id'))
        {
             $project_id=Session::get('project_id');
        }

        if(auth()->user()->can('admin_project_'.$project_id) or auth()->user()->can('add_admin'))
        {
    		$user=Auth::user();

            $projects=Project::join('project_user','projects.id','=','project_user.project_id')
                               ->where('project_user.user_id',$user->id)
                               ->paginate(50);
                               
    		return view('projects.view',compact('projects'));
    	}
    	else
    	{
    		return view('errors.403');
    	}
    }

    public function edit(Project $project)
    {
       $project_id="";

       $user=Auth::user();

       if(Session::has('project_id'))
       {
            $project_id=Session::get('project_id');
       }

       if(auth()->user()->can('admin_project_'.$project_id) or auth()->user()->can('add_admin'))
       {
            $users=User::where('id','<>',$user->id)->get();
            return view('projects.edit',compact('project','users'));
       }
       else
       {
            return view('errors.403');
       }   
    }

    public function update(Project $project,Request $request)
    {
        $user=Auth::user();
        $this->validate($request,[
              'name' => 'required|min:2|unique:projects,name,'.$project->id.'|max:'.config('global.maxlength'),
              ]);
        $project->name=$request->name;
        $project->update();

        $project->users()->sync($request->project_admin);

        //Attaching again , since we are using a sync process.
        $project->users()->attach($user->id);//The one who created will also be attached as a user

        $admin_users = User::join('role_user','role_user.user_id','=','users.id')
                            ->join('roles','roles.id','=','role_user.role_id')
                            ->where('roles.name','administrator')
                            ->where('users.id','<>',$user->id)
                            ->select('users.id')
                            ->get();

        foreach($admin_users as $ausers)
        {
           if(User::checkifAlreadyAttached($ausers->id,$project->id))
            {
                $project->users()->attach($ausers->id);// Attach all admin users to the project.
            }
        }

        $role_id=Role::where('name','project_admin_'.$project->id)->value('id');

        $role=Role::find($role_id);

        $role->users()->sync($request->project_admin);

        $role->users()->attach($user->id);

        foreach($admin_users as $ausers)
        {
            if(User::checkifRoleAttached($ausers->id,$role_id))
            {
                $role->users()->attach($ausers->id);  
            }
        }
        
        session()->flash('message','Project updated successfully!');
            
        return(redirect('/projects'));

    }

    public function delete(Project $project)
    {
        Permission::where('project_id',$project->id)->delete();
        Role::where('project_id',$project->id)->delete();

        $project->delete();// delete the project itself
        session()->flash('message','Project deleted Successfully');
        return back();
    }

    public function ideas(Project $project)
    {
        $project_id="";

        $user=Auth::user();

        if(Session::has('project_id'))
        {
             $project_id=Session::get('project_id');
        }

        if(auth()->user()->can('admin_project_'.$project_id) or auth()->user()->can('add_admin'))
        {
            $ideas=Idea::where('project_id',$project->id)->paginate(50);
            return view('projects.viewideas',compact('ideas','project'));
        }
        else
        {
             return view('errors.403');
        }


    }

    public function viewIdea(Project $project,Idea $idea)
    {
        $user=Auth::user();

        if(auth()->user()->can('admin_project_'.$project->id) or auth()->user()->can('add_admin'))
        {
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

            if($idea->current_status =='New' or $idea->current_status=='Resubmitted')
            {
                $current_status_id=DB::table('idea_status')->insertGetId(['idea_id' =>$idea->id, 'status' =>'Under Review','user_id' => $user->id,'updated_at'=> new \DateTime(),'created_at'=>new \DateTime()]);
                $idea->current_status='Under Review';
                $idea->current_status_id=$current_status_id;
                $idea->update();
            }

            $idea_rating = DB::table('idea_ratings')
                               ->where('idea_id',$idea->id)
                               ->where('user_id',$user->id)
                               ->first();
            return view('projects.idea',compact('idea','project','idea_rating'));
        }
        else
        {
            return view('errors.403');
        }
    }

    public function status(Project $project,Idea $idea)
    {
        $user=Auth::user();

        if(auth()->user()->can('admin_project_'.$project->id) or auth()->user()->can('add_admin'))
        {
            return view('projects.status',compact('project','idea'));
        }
        else
        {
            return view('errors.403');
        }
    }

    public function addStatus(Request $request,Project $project,Idea $idea)
    {
        $user=Auth::user();

        if(auth()->user()->can('admin_project_'.$project->id) or auth()->user()->can('add_admin'))
        {
            $this->validate($request,[
                  'status' => 'required',
                  'remark' => 'required'
                  ]);

            $current_status_id=DB::table('idea_status')->insertGetId(['idea_id' =>$idea->id, 'status' =>$request->status,'user_id' => $user->id,'remark'=>$request->remark,'updated_at'=> new \DateTime(),'created_at'=>new \DateTime()]);
            $idea->current_status=$request->status;
            $idea->current_status_id=$current_status_id;
            $idea->update();

            session()->flash('message','Status updated successfully!');
            return(redirect('/projects/'.$project->id.'/ideas'));
        }
        else
        {
            return view('errors.403');
        }
    }


    public function statushistory(Project $project,Idea $idea)
    {
        $user=Auth::user();

        if(auth()->user()->can('admin_project_'.$project->id) or auth()->user()->can('add_admin'))
        {
            $idea_status=DB::table('idea_status')
                ->where('idea_id',$idea->id)
                ->paginate(50);
        
            return view('projects.statushistory',compact('idea','idea_status','project'));
        }
        else
        {
            return view('errors.403');
        }

    }

}
