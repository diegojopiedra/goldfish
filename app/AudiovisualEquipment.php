<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudiovisualEquipment extends Model
{
    public function brand() {
		return $this->belongsTo('App\Brand');
	}
	
	    public function model() {
		return $this->belongsTo('App\AudiovisualModel');
	}
	
	public function type() {
		return $this->belongsTo('App\Type');
	}

	public function loanable()
    {
        return $this->morphOne('App\Loanable', 'specification');
    }
    
}

