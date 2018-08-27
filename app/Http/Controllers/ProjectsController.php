<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Role;
use Illuminate\Support\Facades\DB;
use Session;


class ProjectsController extends Controller
{
    public function create()
    {
       $project_id="";

       if(Session::has('is_projectadmin'))
       {
            $project_id=Session::get('is_projectadmin');
       }

       if(auth()->user()->can('add_projectadmin_'.$project_id) or auth()->user()->can('add_admin'))
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
            $project->users()->attach($ausers->id);// Attach all admin users to the project.
        }

        //Create Project Specific Roles and Permissions
        Project::create_admin_role_permission_for_project($project->id);
        
        /*$role_id=Role::where('name','projectadmin')->value('id');

        $role = Role::find($role_id);

        if(User::checkifRoleAttached($user,$role))
        {
            $user->roles()->attach($role_id);        
        }*/

        $role_id=Role::where('name','project_admin_'.$project->id)->value('id');

        if(!empty($request->project_admin))
        {
            foreach($request->project_admin as $user_id)
            {
                $user=User::find($user_id);
                if(User::checkifRoleAttached($user,$role))
                {
                    $user->roles()->attach($role_id);        
                }
            } 
        }

        session()->flash('message','Project added successfully!');
    	
    	return(redirect('/projects'));
    }

    public function list()
    {
    	
        $project_id="";

        if(Session::has('is_projectadmin'))
        {
             $project_id=Session::get('is_projectadmin');
        }

        if(auth()->user()->can('add_projectadmin_'.$project_id) or auth()->user()->can('add_admin'))
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
       if(auth()->user()->can('add_projectadmin'))
       {
            $logged_user=Auth::user();
            foreach($project->users as $user)
            {
                if($user->id==$logged_user->id)
                {
                    $users=User::where('id','<>',$logged_user->id)->get();
                    return view('projects.edit',compact('project','users'));
                }
            }

            return view('errors.403');
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
                            ->where('user.id','<>',$user->id)
                            ->select('users.id');

        foreach($admin_users as $ausers)
        {
            $project->users()->attach($ausers->id);// Attach all admin users to the project.
        }

        $role_id=Role::where('name','projectadmin')->value('id');

        $role = Role::find($role_id);
        
        if(!empty($request->project_admin))
        {
            foreach($request->project_admin as $user_id)
            {
                $user=User::find($user_id);
                if(User::checkifRoleAttached($user,$role))
                {
                    $user->roles()->attach($role_id);        
                }
            } 
        }

        //delete the projectadmin permission if user is no longer part of any project.
        $get_all_other_projects = Project::where('id','<>',$project->id)->get();

        foreach($project->users as $current_project_user)
        {
            $delete_role=0;
            
            foreach($get_all_other_projects as $other_projects)
            {
                foreach($other_projects->users as $user)
                {
                    if($user->id == $current_project_user->id)
                    {
                        $delete_role=1;
                        break;
                    }
                }
            }
            
            if($delete_role==0)
            {
                $role_id=Role::where('name',"projectadmin")->value('id');
                DB::table('role_user')
                    ->where('user_id',$current_project_user->id)
                    ->where('role_id',$role_id)
                    ->delete();
            }
        }

        session()->flash('message','Project updated successfully!');
            
        return(redirect('/projects'));

    }

    public function delete(Project $project)
    {
        //delete the projectadmin permission if user is no longer part of any project.
        $get_all_other_projects = Project::where('id','<>',$project->id)->get();

        foreach($project->users as $current_project_user)
        {
            $delete_role=0;
            
            foreach($get_all_other_projects as $other_projects)
            {
                foreach($other_projects->users as $user)
                {
                    if($user->id == $current_project_user->id)
                    {
                        $delete_role=1;
                        break;
                    }
                }
            }
            
            if($delete_role==0)
            {
                $role_id=Role::where('name',"projectadmin")->value('id');
                DB::table('role_user')
                    ->where('user_id',$current_project_user->id)
                    ->where('role_id',$role_id)
                    ->delete();
            }
        }

        $project->delete();// delete the project itself
        session()->flash('message','Project deleted Successfully');
        return back();
    }
}
