<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\Country;
use App\CountryDetail;
use App\User;
use App\State;
use DB;
use Validator;

class CountryController extends Controller
{
    public $management = 'Country';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'country_list';

    public function __construct()
    {       
        parent::__construct();
        $this->breadcrumb = $breadcrumb = [
                            'LISTPAGE' => 
                                [
                                    ['label' => 'List', 'url' => 'THIS']
                                ],
                            'CREATEPAGE' => 
                                [
                                    ['label' => $this->management, 'url' => \URL::route($this->listUrl)],
                                    ['label' => 'Create', 'url' => 'THIS']
                                ],                                 
                            'EDITPAGE' => 
                                [
                                    ['label' => $this->management, 'url' => \URL::route($this->listUrl)],
                                    ['label' => 'Edit', 'url' => 'THIS']
                                ]                                
                            ];

                            \View::share([
                                'management' => $this->management,
                                'breadcrumb' => $this->breadcrumb,
                            ]);

                            if(\Route::current()->getActionMethod()=='index'){
                                \View::share(['pageType' => $this->listMode]);                                
                            }elseif(\Route::current()->getActionMethod()=='add'){
                                \View::share(['pageType' => $this->createMode]); 
                            }elseif(\Route::current()->getActionMethod()=='edit'){
                                \View::share(['pageType' => $this->editMode]); 
                            }
    }

    public function index()
    {
    
		//\App::setLocale('ar');
    	//$data['country_list'] = Country::leftJoin('country_details','countries.id','=','country_details.country_id')
    	//	->where('country_details.lang_id','1')    		
    	//	->get();
		//dd(config('app.locales'));
		
		$data['country_list'] = Country::get();			
    	
    	return view('admin.country.list',$data);
    }

    public function add()
    {
        $data = array();
    	//$data['language'] = Language::pluck('language_name','id');
    	return view('admin.country.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|unique:countries,code', 
            'name.*' => 'required|unique:country_translations,name',           
            'status' => 'required',
            ],
            [
                'code.unique'   => 'Country Code already exists'
            ]
        );

        

    	$country = new Country;
    	$country->code 		= $request->code;
    	$country->status 	= $request->status;

    	$country->save();
		
		foreach ($this->lang_locales as $locale) {
			$country->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		
		$country->save();
		
//    	$name = $request->name;
//
//    	foreach ($name as $lang => $value) {
//
//    		if($value != '')
//    		{
//    		
//	    		$countryDetails 			= new CountryDetail;
//	    		$countryDetails->country_id = $country->id;
//	    		$countryDetails->lang_id 	= $lang;
//	    		$countryDetails->name 		= $value;
//	    		$countryDetails->save(); 
//	    	}
//	    	
//    	}

    	return \Redirect::Route('country_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {	
		$data['details'] = Country::find($id);	
    	
    	return view('admin.country.edit',$data);
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'code' => 'required|unique:countries,code,'.$id.',id',
            'name.*' => 'required|unique:country_translations,name,'.$id.',country_id',
            'cnt_status' => 'required',
        ],
        [
            'code.unique'           => 'Country Code already exists',
            'cnt_status.required'   => 'Please select Status'
        ]
        );

    	$country = Country::find($id);
    	$country->code 		= $request->code;
    	$country->status 	= $request->cnt_status;

    	$country->save();
		
		foreach ($this->lang_locales as $locale) {
			$country->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		
		$country->save();
	
    	return \Redirect::Route('country_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {

        $user = User::where('country_id',$id)->count();
        $state = State::where('country_id',$id)->count();
        $msg = "Please remove related data first from: ";
        
        $isExists = 'No';
        if($user>0)
        {
            $msg .= "User";
            $isExists = 'Yes';
        } 
        if($user>0 && $state > 0)
        {
            $msg .= " and ";
        }

        if($state > 0)
        {
            $msg .= "State";
            $isExists = 'Yes';
        }
        if($isExists == 'Yes')
        {
            return \Redirect::Route('country_list')->with('error', $msg);       
        }
        else
        {
            Country::find($id)->delete();
            return \Redirect::Route('country_list')->with('success', 'Record deleted successfully');   
        }
    }
}
