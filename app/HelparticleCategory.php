<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class HelparticleCategory extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['status', 'helparticle_category_id', 'name', 'locale'];
	
}

