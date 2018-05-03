<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	
	protected $fillable = ['country_id', 'state_code','status', 'state_id', 'name', 'locale'];
	
    public function country()
    {
    	return $this->belongsTo('App\Country');
    }
}
