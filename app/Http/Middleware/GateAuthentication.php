<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use App\Permission;

class GateAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($this->getPermissions() as $permission)
        {
            Gate::define($permission->name, function($user) use($permission) 
            {
                return $user->hasRole($permission->roles);
            });
        }
         return $next($request);
        
    }

    protected function getPermissions(){
        return Permission::with('roles')->get();
    }
}
