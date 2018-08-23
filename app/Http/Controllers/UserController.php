<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function list()
    {
    	if(auth()->user()->can('add_projectadmin'))
       	{
       		$users=User::all();
       		return view('users.view',compact('users'));
       	}
       	else
       	{
       		return view('errors.403');
       	}
    }
}
