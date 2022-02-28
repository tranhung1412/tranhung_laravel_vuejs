<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Role;
use Auth;
use Hash;
use function Sodium\add;
use Validator;
use DB;

class UserController extends Controller
{
    public function registerClient(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:255',
                're_password' => 'required|same:password',

            ],
            [
                'name.required' => 'Tên không được bỏ trống',
                'name.min' => 'Tên phải có tối thiểu 2 ký tự',
                'name.max' => 'Tên phải có tối đa 255 ký tự',
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Phải có đúng định dạng email',
                'email.unique' => 'E  mail nay da duoc su dung',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.min' => 'Mật Khẩu phải có tối thiểu 6 ký tự',
                'password.max' => 'Mật khẩu phải có tối đa 255 ký tự',
                're_password.required' => 'Trường này không được bỏ trống',
                're_password.same' => 'Nhập mật khẩu không đúng với trường mật khẩu',
            ]
        );
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        if ($validator->fails()) {
            return response()->json(['error' => 'true', 'message' => $validator->errors()], 200);
        } else {
            $user = User::create($data);
            Auth::login($user);
            return response()->json(['message' => 'Dang ky thanh cong', 'data' => Auth::user()]);
        }

    }

    public function loginClient(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:255',
            ],
            [
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Phải có đúng định dạng email',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.min' => 'Mật Khẩu phải có tối thiểu 6 ký tự',
                'password.max' => 'Mật khẩu phải có tối đa 255 ký tự',
            ]
        );
        $data = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($data)) {
            return response()->json(['message' => 'Dang nhap thanh cong', 'data' => Auth::user()]);
        } else {
            return response()->json(['message' => 'Dang nhap that bai']);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return response()->json(['message' => 'Dang xuat thanh cong']);
        }
    }

    public function checklogin()
    {
        if (Auth::check()) {
            return response()->json(['message' => 'Dang nhap thanh cong', 'data' => Auth::user()]);
        } else {
            return response()->json(['message' => 'Ban chua đang nhap']);
        }
    }

    public function loginAdmin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:255',
            ],
            [
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Phải có đúng định dạng email',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.min' => 'Mật Khẩu phải có tối thiểu 6 ký tự',
                'password.max' => 'Mật khẩu phải có tối đa 255 ký tự',
            ]
        );
        $data = array('email' => $request->email, 'password' => $request->password);
        if (Auth::attempt($data)) {
            return redirect('/admin')->with('thongbao', 'Dang nhap thanh cong');
        } else {
            return back()->with('error', 'Vui long kiem tra lai tai khoan cua ban');
        }
    }

    public function getAllUser($numberItem)
    {

//        $user=User::with('role')->get();
//        $data=[];
//        foreach($user as $key =>$value){
//            if(count($value->role)!==0){
//                $data[$key]=$value;
//            }
//        }
//        return response()->json(['user'=>$data]);

        $user = User::with('role')->paginate($numberItem);
        foreach ($user as $key => $value) {
            if (empty($value->role)){
                break;
            }
            if(count($value->role)!==0){
                foreach ($value->role as $key2 => $value2) {
                    $roleId = $value2->id;
                    $user[$key]['roleId'] = $roleId;
                }
                $user[$key] = $value;
            }

        }
        return response()->json($user);
    }

    public function getAllRole()
    {
        $roles = Role::with('permissions')->get();
        foreach ($roles as $key => $value) {
            $data = [];
            foreach ($value->permissions as $key2 => $value2) {
                $roleId = $value2->id;
                $data[$key2] = $roleId;
            }
            $roles[$key]['rolePermissions'] = $data;
        }

        return response()->json(['roles' => $roles]);
    }

    public function registerAdmin(Request $request)
    {
        $this->validate($request,
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:255',
                're_password' => 'required|same:password',
                'roleId' => 'required',
            ],
            [
                'name.required' => 'Tên không được bỏ trống',
                'name.min' => 'Tên phải có tối thiểu 2 ký tự',
                'name.max' => 'Tên phải có tối đa 255 ký tự',
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Phải có đúng định dạng email',
                'email.unique' => 'E  mail nay da duoc su dung',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.min' => 'Mật Khẩu phải có tối thiểu 6 ký tự',
                'password.max' => 'Mật khẩu phải có tối đa 255 ký tự',
                're_password.required' => 'Trường này không được bỏ trống',
                're_password.same' => 'Nhập mật khẩu không đúng với trường mật khẩu',
                'role.required' => 'Trường này không được bỏ trống',
            ]
        );
        try {
            DB::beginTransaction();
            $userCreate = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            DB::table('role_user')->insert([
                'user_id' => $userCreate->id,
                'role_id' => $request->roleId,
            ]);
            DB::commit();
            return response()->json(['message' => 'Thêm thanh cong']);
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function getUserById($id)
    {
        $user = User::where('id', $id)->with('role')->get();
        return response()->json(['user' => $user]);
    }

    public function getPermissionUserLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $data = [];
            foreach ($user->role as $key => $value) {
                $value->permissions;
                $data[$key] = $value;
            }
        }
        return response()->json(['user' => $data]);
    }

    public function editUser(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            DB::table('role_user')->where('user_id', $id)->delete();
            $userCreate = User::find($id);
            $userCreate->role()->attach($request->roleId);
            DB::commit();
            return response()->json(['message' => 'Sửa thành công']);
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->role()->detach();
            $user->delete();

            DB::commit();
            return response()->json(['message' => 'Xoá thành công']);
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

}
