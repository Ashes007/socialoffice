<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignationTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['designation_id', 'name', 'locale'];
}
