<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\User;
use App\Models\Products;
use App\Models\Comment;
use App\Models\AdminComment;
use Auth;
use Validator;
use Illuminate\Http\Request;


class AdminCommentController extends Controller
{
    public function postComment(Request $request,$id){
        if(Auth::check()){
            $data['content']=$request->content;
            $comment=Comment::find($id);
            $product_id=$comment->idProduct;
            $data['idUser']=Auth::user()->id;
            $data['idProduct']=$product_id;
            $data['idCommentUser']=$comment->id;
            $admincomment=AdminComment::create($data);
            $comment->update(['status'=>0]);
            return response()->json(['message'=>'bình luận thành công','comment'=>$admincomment]);
        }else{
            return response()->json(['message'=>'bạn phải đăng nhập trước khi bình luận']);
        }
    }
}
