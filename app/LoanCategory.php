<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanCategory extends Model
{
    public function loanable() {
		return $this->hasMany('App\Loanables');
	}
}
