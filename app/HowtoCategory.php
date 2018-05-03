<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class HowtoCategory extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['status', 'howto_category_id', 'name', 'locale'];
	
}

