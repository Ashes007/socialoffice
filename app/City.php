<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
	use Translatable;
    use SoftDeletes;
	public $translatedAttributes = ['name'];
	protected $fillable = ['country_id','state_id','status', 'name', 'locale'];
	
    public function country()
    {
    	return $this->belongsTo('App\Country');
    }

    public function state()
    {
    	return $this->belongsTo('App\State');
    }

}


