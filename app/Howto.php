<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Howto extends Model
{
	use Translatable;
	public $translatedAttributes = ['title','description'];
	protected $fillable = ['Howto_category','status', 'Howto_id', 'title', 'description', 'locale'];

	public function category(){
		return $this->belongsTo('App\HowtoCategory','howto_category_id');
	}
	
}

