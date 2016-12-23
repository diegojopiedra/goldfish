<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    public function user() {
		return $this->hasMany('App\User');
	}
}
