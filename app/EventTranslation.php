<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['event_id','description','location','name','locale'];
}
