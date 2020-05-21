<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table='Tag';
    ///relacion de uno a muchos
    public function Tag(){
        return $this->hasMany('App\Message');
    }
}
