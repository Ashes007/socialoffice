<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Sitesetting extends Model
{
    public static function findValByLebel($label)
    {
        $res = static::where('sitesettings_lebel', $label)->first();
        if(count($res)>0){
            return $res->sitesettings_value;
        }else{
            return '';
        }
    }	
}
