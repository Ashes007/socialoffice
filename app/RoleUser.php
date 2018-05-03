<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table ="role_user";
    public $primaryKey  = 'user_id';
    public $timestamps = false;
	

}
