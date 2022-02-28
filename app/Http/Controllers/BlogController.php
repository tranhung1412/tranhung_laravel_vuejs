<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Services\ImgurService;
use File;

class BlogController extends Controller
{
    public function getAllBlog(){
        $blog =Blog::all();
        return response()->json(['blog'=>$blog]);
    }
    public function getTreeBlog(){
        $blog =Blog::orderBy('created_at', 'desc')->take(3)->get();
        return response()->json(['blog'=>$blog]);
    }
    public function addBlog(Request $request){
        $this->validate($request,
            [
                'title' => 'required|min:2|max:255',
                'slug' => 'required|min:2|max:255',
                'content' => 'required|min:2',
            ],
            [
                'required' => ':attribute không được bỏ trống',
                'min' => ':attribute tối thiểu có 2 ký tự',
                'max' => ':attribute tối đa có 255 ký tự',
            ],
            [
                'title' => 'Đầu đề',
                'slug' => 'Tên không dấu',
                'content' => 'Nội dung',
            ]
        );
        $data = $request->all();
        if($request->hasFile('file')){
            $file=$request->file;
            $file_type= $file->getMimeType();
            if($file_type == 'image/png'|| $file_type=='image/jpg'|| $file_type=='image/jpeg'||$file_type=='image/gif'){
                $file_url = ImgurService::uploadImage($file->getRealPath());
                $data['image']=$file_url;
                $blog=Blog::create($data);
            }else{
                return response()->json(['message' => 'file bạn chọn không phải là hình']);
            }
        }else{
            return response()->json(['message' => 'Ban chua chon hinh']);
        }
        return response()->json(['message'=>'Thêm thành công','blog' => $blog]);
    } 
    public function editBlog(Request $request,$id){
        $this->validate($request,
        [
            'title' => 'required|min:2|max:255',
            'slug' => 'required|min:2|max:255',
            'content' => 'required|min:2',
        ],
        [
            'required' => ':attribute không được bỏ trống',
            'min' => ':attribute tối thiểu có 2 ký tự',
            'max' => ':attribute tối đa có 255 ký tự',
        ],
        [
            'title' => 'Đầu đề',
            'slug' => 'Tên không dấu',
            'content' => 'Nội dung',
        ]
    );
        $blog=Blog::find($id);
        $data = $request->all();
        if($request->hasFile('file')){
            $file=$request->file;
            $file_type= $file->getMimeType();
            if($file_type == 'image/png'|| $file_type=='image/jpg'|| $file_type=='image/jpeg'||$file_type=='image/gif'){
                $file_url = ImgurService::uploadImage($file->getRealPath());
                $data['image']=$file_url;
            }else{
                return response()->json(['message' => 'file bạn chọn không phải là hình']);
            }
        }else{
            $data['image']=$blog->image;
        }
        $blog->update($data);
        return response()->json(['message'=>'Sửa thành công','blog' => $blog]);
    } 
    public function deleteBlog($id){
        $blog=Blog::find($id);
        $blog->delete();
        return response()->json(['message'=>'Xoá thành công']);
    }
    public function getBlogById($id){
        $blog=Blog::find($id);
        return response()->json([$blog]);
    }
    public function getBlogBySlug($slug){
        $blog=Blog::where('slug',$slug)->first();
        return response()->json(['blog'=>$blog]);
    }
}
