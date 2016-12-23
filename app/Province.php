<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function canton(){
        return $this->hasMany('App\Canton');
    }
}
