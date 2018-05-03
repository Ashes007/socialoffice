<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['code', 'status', 'country_id', 'name', 'locale'];
	
    //public function countryname()
    //{
    //	return $this->hasMany('App\CountryTranslation','country_id','id');
    //}
}
