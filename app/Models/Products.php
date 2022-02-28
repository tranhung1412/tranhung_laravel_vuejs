<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table ='product';
    protected $fillable = [
        'name', 'description', 'slug', 'quantity','price','promotion','idCategory','idProductType','image','status',
    ];
    public function Category(){
    	return $this->belongsTo('App\Models\Categories','idCategory','id');
    }
    public function ProductType(){
    	return $this->belongsTo('App\Models\ProductTypes','idProductType','id');
    }
    public function ProductImg(){
        return $this->hasMany('App\Models\ProductImage','idProduct','id');
    }
    public function Specification(){
        return $this->hasOne('App\Models\Specifications','product_id','id');
    }
}
