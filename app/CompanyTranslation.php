<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['company_id', 'name', 'locale'];
}
