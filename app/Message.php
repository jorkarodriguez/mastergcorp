<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $Table = 'message';
    //relacion de muchos a uno 

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function Tag(){
        return $this->belongsTo('App\Tag','id_tag');
    }
}
