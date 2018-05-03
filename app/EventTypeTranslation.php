<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTypeTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['event_type_id', 'name', 'locale'];
}
