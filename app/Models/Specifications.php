<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specifications extends Model
{
    protected $table ='specifications';
    protected $fillable = [
       'product_id', 'screen', 'operating_system', 'rear_camera', 'front_camera', 'cpu', 'ram', 'internal_memory', 'sim', 'battery', 'design'
    ];

    public function Product(){
        return $this->belongsTo('App\Models\Products','product_id','id');
    }
}
