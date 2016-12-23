<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    public function loan (){
        return $this->belongsTo('App\Loan');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
