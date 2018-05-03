<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['department_id','issue_id','name','locale'];
}
