<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\AdminMenu;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\UserLocation;
use App\Models\PermissionManagement;
use Request;


class AdminAuth
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
        if(!Auth::guard('admin')->check()){
        // dd('admin');
            return redirect('admin/login');
        }
        // $auth = Auth::id();
        // if(!empty($auth)){
        //     $user = User::find($auth);
        //     if($user['type'] != 'admin'){
        //         return redirect()->intended('admin/login');
        //     }
        // }

        
        return $next($request);
    }
}
