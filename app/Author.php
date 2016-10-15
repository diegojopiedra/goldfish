<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    	public function article() {
		return $this->belongsToMany('App\Article');
		}
		
		public function bibliographicMaterial() {
		return $this->belongsToMany('App\BibliographicMaterial');

		}
}