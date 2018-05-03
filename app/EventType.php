<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['event_type_id','status', 'name', 'locale'];
	

}
