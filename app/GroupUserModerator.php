<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupUserModerator extends Model
{
	public $timestamps = false;

	protected $fillable = ['group_id', 'user_id'];
}
