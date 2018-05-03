<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['cms_id', 'title','description', 'short_description', 'locale'];
}
