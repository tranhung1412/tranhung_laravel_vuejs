<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Mail;
use Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


class ForgotPasswordController extends Controller
{
    public function getFormResetPassword(){
        return view('auth.passwords.email');
    }
    public function sendCodeResetPassword(Request $request){
        $email=$request->email;
        $checkUser=User::where('email',$email)->first();
        if(!$checkUser){
            return response()->json(['message'=>'Email không tồn tại']);
        }
        $code=bcrypt(md5(time().$email));
        $checkUser->code=$code;
        $checkUser->time_code=Carbon::now();
        $checkUser->save();
        $url=route('get.send.link.reset');
        $data =[
            'route'=>$url,
            'code'=>$checkUser->code
        ];
        Mail::send('admin.resetPassword',$data, function($message) use ($email){
	        $message->to($email, 'Reset Password Notification')->subject('Reset Password Notification');
        });
        return response()->json(['message'=>'Link lấy mật khẩu đã được gửi vào email của bạn']);
    }
    public function sendCodeResetPasswordAdmin(Request $request){
        $email=$request->email;
        $checkUser=User::where('email',$email)->first();
        if(!$checkUser){
            return response()->json(['message'=>'Email không tồn tại']);
        }
        $code=bcrypt(md5(time().$email));
        $checkUser->code=$code;
        $checkUser->time_code=Carbon::now();
        $checkUser->save();
        $url=route('get.send.link.reset.admin');
        $data =[
            'route'=>$url,
            'code'=>$checkUser->code
        ];
        Mail::send('admin.resetPassword',$data, function($message) use ($email){
	        $message->to($email, 'Reset Password Notification')->subject('Reset Password Notification');
        });
        return response()->json(['message'=>'Link lấy mật khẩu đã được gửi vào email của bạn']);
    }
    public function resetPassword(Request $request){
        $code=$request->code;
        $email=$request->email;
        $checkUser=User::where([
            'code'=>$code,
            'email'=>$email
        ])->first();
        if(!$checkUser){
            return response()->json(['message'=>'Đường dẫn không tồn tại']);
        }
        return view('auth.passwords.reset');
    }
    public function saveResetPassword(Request $request){
        $this->validate($request,
            [
                'password'=>'required|min:6|max:255',
                're_password'=>'required|same:password',
            ],
            [
                'password.required'=>'Mật khẩu không được bỏ trống',
   	 			'password.min'=>'Mật Khẩu phải có tối thiểu 6 ký tự',
   	 			'password.max'=>'Mật khẩu phải có tối đa 255 ký tự',
   	 			're_password.required'=>'Trường này không được bỏ trống',
   	 			're_password.same'=>'Nhập mật khẩu không đúng với trường mật khẩu',
            ]
        );
        $checkUser=User::where([
            'code'=>$request->code
        ])->first();
        if(!$checkUser){
            return response()->json(['message'=>'Đường dẫn không tồn tại']);
        }
        $checkUser->password=Hash::make($request->password);
        $code=bcrypt(md5(time()));
        $checkUser->code=$code;
        $checkUser->save();
        return response()->json(['message'=>'Thay đổi mật khẩu thành công']);
    }
}
