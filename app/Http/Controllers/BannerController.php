<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    public function getBanner(){
        $banner=Banner::all();
        return response()->json(['banner'=>$banner]);
    }
}
