<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['country_id', 'name', 'locale'];
}
