<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table ='comment';
    protected $fillable = [
        'idUser', 'idProduct','noidung','status'
    ];
    public function product(){
    	return $this->belongsTo('App\Models\Products','idProduct','id');
    }
    public function user(){
    	return $this->belongsTo('App\User','idUser','id');
    }
    public function admincomment(){
    	return $this->hasMany('App\Models\AdminComment','idCommentUser','id');
    }
}
