<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibliographicMaterial extends Model
{
	public function authors() {
		return $this->belongsToMany('App\Author', 'bibliographic_material_authors');
	}
						
	public function loanable()
    {
        return $this->morphOne('App\Loanable', 'specification');
    }
	
	public function editorial() {
		return $this->belongsTo('App\Editorial');
	}
	
	public function material() {
		return $this->morphTo('material');
	}
	
	
}
