<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['department_id','code','status', 'name', 'locale'];
}
