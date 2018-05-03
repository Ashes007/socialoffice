<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	use Translatable;
	public $translatedAttributes = ['name'];
	protected $fillable = ['company_id','logo','status', 'name', 'locale'];
    
}
