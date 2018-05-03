<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
	use Translatable;
	public $translatedAttributes = ['title','description'];
	protected $fillable = ['ebook_id', 'title','description', 'locale'];
}
