<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\State;
use App\Country;
use App\Language;
use App\User;
use App\City;
use DB;

class StateController extends Controller
{

    public $management = 'State';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'state_list';

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
    	$data['state_list'] = State::get();
   
    	return view('admin.state.list',$data);
    }

    public function add()
    {
    	$data['country_list'] = Country::get();
    	return view('admin.state.add',$data);
    }


    public function store(Request $request)
    {
        $country_id = $request->country;
        $this->validate($request, [
                'code'      => 'required|unique:states,state_code',
                'name.*'    =>  'unique:state_translations,name,NULL,id'
            ]);


    	$state = new State;
    	$state->state_code 	= $request->code;
    	$state->status 		= $request->status;
    	$state->country_id 	= $country_id;

    	$state->save();

		foreach ($this->lang_locales as $locale) {
			$state->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$state->save();		

    	return \Redirect::Route('state_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {
    	$data['country_list'] = Country::get();
    	
    	$data['details'] = State::find($id);
    	
    	return view('admin.state.edit',$data);
    }

    public function update(Request $request,$id)
    {

        $country_id = $request->country_id;
        $this->validate($request, [
                'code'     => 'required|unique:states,state_code,'.$id.',id',
                'name.*'   =>  'unique:state_translations,name,'.$id.',state_id'
            ]);
    	$state = State::find($id);
    	$state->state_code 		= $request->code;
    	$state->status 			= $request->cnt_status;
    	$state->country_id		= $request->country_id;

    	$state->save();
		
		foreach ($this->lang_locales as $locale) {
			$state->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$state->save();
		
    	return \Redirect::Route('state_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        $user = User::where('state_id',$id)->count();
        $city = City::where('state_id',$id)->count();
        $msg = "Please remove related data first from: ";
        
        $isExists = 'No';
        if($user>0)
        {
            $msg .= "User";
            $isExists = 'Yes';
        } 
        if($user>0 && $city > 0)
        {
            $msg .= " and ";
        }

        if($city > 0)
        {
            $msg .= "City";
            $isExists = 'Yes';
        }
        if($isExists == 'Yes')
        {
            return \Redirect::Route('state_list')->with('error', $msg);       
        }
        else
        {
            State::find($id)->delete();
            return \Redirect::Route('state_list')->with('success', 'Record deleted successfully');       
        }

        
    }
}
