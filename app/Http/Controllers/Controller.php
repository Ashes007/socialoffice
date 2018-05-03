<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notification;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $lang_locales = array();
    
    public function __construct(){ 
        $languagesList = \Cache::remember('language-list', 60, function () {
		        return \App\Language::orderby('id')->get();
			});
       
        //dd($a);
        $this->lang_locales = $languagesList;
        

        //$this->test = "1111";
        //dd($notifications);
        //$notifications='epsita';
        \View::share(['lang_locales' => $this->lang_locales]);


        
    }    
}
