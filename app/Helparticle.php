<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Helparticle extends Model
{
	use Translatable;
	public $translatedAttributes = ['title','description'];
	protected $fillable = ['helparticle_category','status', 'helparticle_id', 'title', 'description', 'locale'];

	public function category(){
		return $this->belongsTo('App\HelparticleCategory','helparticle_category_id');
	}
	
}

