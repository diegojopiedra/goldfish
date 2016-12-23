<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudiovisualMaterial extends Model
{
    public function audiovisualFormat() {
		return $this->belongsTo('App\AudiovisualFormat');
	}
	
    public function audiovisualType() {
		return $this->belongsTo('App\AudiovisualType', 'audiovisual_material_type_id');
	}
	
	    public function keyWord() {
		return $this->belongsToMany('App\KeyWord');
	}
		public function loanable() {
		return $this->hasOne('App\Loanable');
	}
	
	public function editorial(){
		return $this->belongsTo('App\Editorial');
	}
	
	public function bibliographicMaterial() {
		return $this->belongsTo('App\BibliographicMaterial', 'bibliographic_materials_id');
	}
}
