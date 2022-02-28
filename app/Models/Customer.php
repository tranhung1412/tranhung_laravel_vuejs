<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table ='customer';
    protected $fillable = [
        'idUser', 'name',  'address', 'phone', 'active'
    ];
    public function User(){
    	return $this->belongsTo('App\User','idUser','id');
    }
}
