<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyPenalty extends Model
{
    public function penalty() {
		return $this->hasOne('App\Penalty');
	}
}
