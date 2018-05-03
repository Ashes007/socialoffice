<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssueTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['issue_id', 'name', 'locale'];
}
