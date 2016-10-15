<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudiovisualModel extends Model
{
	protected $table = 'models';
    public function audiovisualEquipment() {
		return $this->hasMany('AudiovisualEquipment');
	}
}
