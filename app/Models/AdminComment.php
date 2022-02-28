<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminComment extends Model
{
    protected $table ='admincomment';
    protected $fillable = [
        'idUser','idCommentUser', 'idProduct','content',
    ];
    public function comment(){
    	return $this->belongsTo('App\Models\Comment','idCommentUser','id');
    }
    public function usercomment(){
    	return $this->belongsTo('App\User','idUser','id');
    }
    // public function replies()
    // {
    //     return $this->hasMany(Comment::class);
    // }
}
