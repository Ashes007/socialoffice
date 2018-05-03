<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUserTranslation extends Model
{
	public $timestamps = false;

	protected $fillable = ['group_user_id', 'group_name', 'locale'];
}
