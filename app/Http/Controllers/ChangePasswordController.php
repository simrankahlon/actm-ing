<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show()
    {
    	return view('auth.changepassword');
    }
    
    public function validatepassword(Request $request,User $user)
    {
        $validator=$this->validate($request,[
        'current_password' =>'required|min:6|max:'.config('global.passlength'),
        'password'=>'required|min:6|max:'.config('global.passlength'),
        'password_confirmation' => 'required|min:6|max:'.config('global.passlength'),
        ]);
    	$data=$request->all();
    	$user=User::find(auth()->user()->id);
    	if(Hash::check($data['current_password'],$user->password)) //check password with db
    	{
            $validator=$this->validate($request,[
            /*'current_password' =>'required|min:6|max:'.config('global.passlength'),*/
            'password'=>'required|min:6|confirmed|max:'.config('global.passlength'),
            'password_confirmation' => 'required|min:6|max:'.config('global.passlength'),
            ]);
            $user->password = bcrypt($request->password);
            $newpass=$request->password;
            $oldpass=$request->current_password;
            if($newpass!= $oldpass)
            {
                User::where('id',$user->id) 
                                  ->update(['password' =>$user->password]);
                session()->flash('message','Password updated successfully!');
                return redirect('/home');
            }
            else
            {
               return back()->with('password','New password should not be same as a old password.'); 
            }
        }  
    	else
    	{
           return back()->with('current_password','Current password is incorrect.');   
        }
    } 
}
