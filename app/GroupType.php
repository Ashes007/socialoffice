<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['group_type_id','status', 'name', 'locale'];
	

}
