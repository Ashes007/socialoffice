<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
	use Translatable;
	public $translatedAttributes = ['title','description', 'short_description'];
	protected $fillable = ['slug', 'page_name', 'meta_title', 'meta_key', 'meta_Description', 'status', 'cms_id', 'title','description', 'locale'];
}
