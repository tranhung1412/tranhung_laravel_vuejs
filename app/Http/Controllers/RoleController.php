<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\User;
use Auth;
use Hash;
use Validator;
use DB;

class RoleController extends Controller
{
    public function getAllPermissions(){
        $permission =Permission::all();
        return response()->json(['permission'=>$permission]);
    }
    public function addRole(Request $request){
        $this->validate($request,
            [
              'name'=>'required|min:2|max:255',
            ],
            [
              'name.required'=>'Tên không được bỏ trống',
              'name.min'=>'Tên phải có tối thiểu 2 ký tự',
              'name.max'=>'Tên phải có tối đa 255 ký tự',
            ]
          );
          try{
            DB::beginTransaction();
            $roleCreate = Role::create([
              'name' => $request->name,
            ]);
            $roleCreate->permissions()->attach($request->rolePermissions);
            DB::commit();
            return response()->json(['message'=>'Thêm thanh cong']);
          }catch(Exception $exception){
            DB::rollBack();
          }
      }
      public function editRole(Request $request,$id){
        $this->validate($request,
            [
              'name'=>'required|min:2|max:255',
            ],
            [
              'name.required'=>'Tên không được bỏ trống',
              'name.min'=>'Tên phải có tối thiểu 2 ký tự',
              'name.max'=>'Tên phải có tối đa 255 ký tự',
            ]
          );
          try{
            DB::beginTransaction();
            $role=Role::where('id',$id)->update([
              'name'=>$request->name,
            ]);
            DB::table('role_permissions')->where('role_id',$id)->delete();
            $roleCreate=Role::find($id);
            $roleCreate->permissions()->attach($request->rolePermissions);
            DB::commit();
            return response()->json(['message'=>'Sửa thành công']);
          }catch(Exception $exception){
            DB::rollBack();
          }
      }
      public function deleteRole(Request $request,$id){
        try{
          DB::beginTransaction();
          $role=Role::find($id);
          $role->user()->detach();
          $role->permissions()->detach();
          $role->delete();
    
          DB::commit();
          return response()->json(['message'=>'Xoá thành công']);
        }catch(Exception $exception){
          DB::rollBack();
        }
      }
      public function getRoleById($id){
        $role=Role::find($id);
        return response()->json(['role'=>$role]);
      }
}
