<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;
use App\State;
use App\Country;
use App\Language;
use App\User;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;

class CityController extends Controller
{
    public $management = 'City';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'city_list';

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

    public function index(){
    	$data['city_list'] = City::get();
    	return view('admin.city.list',$data);
    }

    public function add()
    {
    	$data['country_list'] = Country::get();
    	return view('admin.city.add',$data);
    }


    public function store(Request $request)
    {
    	$city = new City;
    	$city->state_id 	= $request->state;
    	$city->country_id 	= $request->country;
    	$city->status 		= $request->status;
    	

    	$city->save();
		foreach ($this->lang_locales as $locale) {
			$city->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$city->save();
		

    	return \Redirect::Route('city_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {
    	$data['country_list'] = Country::get();
    	$data['state_list'] = State::get();
   	
    	$data['details'] = City::find($id);
    	
    	return view('admin.city.edit',$data);
    }

    public function update(Request $request,$id)
    {
    	$city = City::find($id);
    	$city->country_id		= $request->country_id;
    	$city->state_id 		= $request->state_id;
    	$city->status 			= $request->cnt_status;
    	

    	$city->save();
		foreach ($this->lang_locales as $locale) {
			$city->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
        $city->save();
		
    	return \Redirect::Route('city_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        // $user = User::where('city_id',$id)->count();

        // if($user>0)
        // {
        //   return \Redirect::Route('city_list')->with('error', "Please remove related data first from: User");       
        // }
        // else
        // {

            City::find($id)->delete();
            //City::find($id)->softDeletes();
            return \Redirect::Route('city_list')->with('success', 'Record deleted successfully');   
        //}
    }

    public function ajax_getState(Request $request)
    {
    	$id = $request->id;
    	$state_list = State::where('country_id',$id)->get();
    	$stateOption = '';
    	//dd($state_list);
    	if($state_list->count()>0)
    	{
    		foreach ($state_list as $key => $state) {
    		
    			$stateOption .= '<option value="'.$state->id.'">'.$state->name.'</option>';
    		}
    	}
    	echo $stateOption;
    }
}
