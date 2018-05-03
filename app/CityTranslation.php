<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['city_id', 'name', 'locale'];
}
