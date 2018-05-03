<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['status', 'faq_category_id', 'name', 'locale'];
	
}

