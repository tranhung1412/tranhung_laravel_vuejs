<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\Models\Permission;
class CheckPermissionACL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission=null)
    {
        $listRoleOfUser=DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->where('users.id',auth()->id())
        ->select('roles.*')
        ->get()->pluck('id')->toArray();

        $listRoleOfUser=DB::table('roles')
        ->join('role_permissions', 'roles.id', '=', 'role_permissions.role_id')
        ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
        ->whereIn('roles.id',$listRoleOfUser)
        ->select('permissions.*')
        ->get()->pluck('id');
        $checkPermission=Permission::where('name',$permission)->value('id');
        if($listRoleOfUser->contains($checkPermission)){
            return $next($request);
        }
        return abort(401);
    }
}
