<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Role extends Model
{
    protected $hidden = array('pivot');
    protected $table ='roles';
    protected $fillable = [
        'name', 'id_user',
    ];
    public function permissions(){
        return $this->belongsToMany(Permission::class,'role_permissions');
    }
    public function user(){
        return $this->belongsToMany(User::class);
    }
}
