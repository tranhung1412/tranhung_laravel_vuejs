<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table ='category';
    protected $fillable = [
        'name', 'status', 'slug'
    ];
    public function productType(){
    	return $this->hasMany('App\Models\ProductTypes','idCategory','id');
    }
    public function product(){
    	return $this->hasMany('App\Models\Products','idProduct','id');
    }
}
