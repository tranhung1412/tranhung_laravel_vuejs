<?php

namespace App\Http\Controllers;
use App\User;
use App\Models\Products;
use App\Models\Comment;
use App\Models\AdminComment;
use Auth;
use Validator;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function addComment(Request $request,$id){
        if(Auth::check()){
            $data['noidung']=$request->noidung;
            $data['idUser']=Auth::user()->id;
            $data['idProduct']=$id;
            $comment=Comment::create($data);
            return response()->json(['message'=>'bình luận thành công','comment'=>$comment]);
        }else{
            return response()->json(['message'=>'bạn phải đăng nhập trước khi bình luận']);
        }
    }
    public function getAllComment(){
        $comment=Comment::where('status',1)->with('user')->with('product')->get();
        return response()->json(['comment'=>$comment]);
    }
    public function getComment($id){
        $comment=Comment::where('idProduct',$id)->get();
        $data=[];
        foreach ($comment as $key => $value){
            $value->user;
            $value->admincomment;
            foreach ($value->admincomment as $key1 => $value1){
                $value1->usercomment;
            }
            $data[$key]=$value;
        }
        return response()->json(['comment'=>$data]);
    }

    
    public function deleteComment($id){
        $comment = Comment::find($id);
        if (count($comment->admincomment) === 0) {
            if ($comment->delete()) {
                return response()->json(['message' => 'Đã xóa thành công'], 200);
            } else {
                return response()->json(['message' => 'Đã xóa không thành công ' . $id], 200);
            }
        } else {
            return response() > json(['message' => 'Xoa that bai. Mot comment su dung truong nay xin vui long kiem tra lai']);
        }
    }
}
