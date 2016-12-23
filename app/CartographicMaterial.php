<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartographicMaterial extends Model
{
    public function loanable() {
		return $this->hasOne('App\Loanable');
	}
	
	public function bibliographicMaterial() {
		return $this->belongsTo('App\BibliographicMaterial', 'bibliographic_materials_id');
	}
	
	public function keyWord() {
		return $this->belongsToMany('App\KeyWord');
	}
	
	public function editorial(){
		return $this->belongsTo('App\Editorial');
	}
	
	public function cartographicFormat(){
		return $this->belongsTo('App\CartographicFormat');
	}
}
