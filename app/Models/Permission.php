<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $hidden = array('pivot');
    protected $table ='permissions';
    protected $fillable = [
        'name',
    ];
}
