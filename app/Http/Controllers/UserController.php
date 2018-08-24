<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Project;

class UserController extends Controller
{
    public function list()
    {
    	if(auth()->user()->can('add_projectadmin'))
       	{
       		$users=User::paginate(50);
       		return view('users.view',compact('users'));
       	}
       	else
       	{
       		return view('errors.403');
       	}
    }

    public function makeAdmin(User $user,$checked)
    {
        $role_id=Role::where('name','administrator')->value('id');

        $projects=Project::all();

        if($checked == 1)
        {
            $user->roles()->attach($role_id);
            foreach($projects as $project)
            {
              $user->projects()->attach($project->id);
            }
        }
        else if($checked == 0)
        {
            $user->roles()->detach($role_id);
            foreach($projects as $project)
            {
              $user->projects()->detach($project->id);
            }
        }

        return \Response::json($user);
    }
}
