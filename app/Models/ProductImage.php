<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table ='image_product';
    protected $fillable = [
        'url', 'idProduct',
    ];
     public function Product(){
    	return $this->belongsTo('App\Models\Products','idProduct','id');
    }
}
