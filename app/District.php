<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function canton(){
        return $this->belongsTo('App\Canton');
    }
}
