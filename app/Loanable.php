<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loanable extends Model
{
    public function state() {
		return $this->belongsTo('App\State');
	}
	
	public function loans() {
		return $this->hasMany('App\Loan');
	}
	
	public function loanCategory() {
		return $this->belongsTo('App\LoanCategory');
	}
	
	public function specific()
    {
        return $this->morphTo('specification');
    }

    public function photos()
    {
        return $this->morphMany('App\Photo', 'imageable');
    }
}
