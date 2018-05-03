<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['designation_id','status', 'name', 'locale'];
}
