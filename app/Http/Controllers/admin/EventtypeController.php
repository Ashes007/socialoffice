<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\EventType AS Eventtype;
use App\EventtypeDetail;
use DB;
use Validator;

class EventtypeController extends Controller
{
    public $management = 'Event Type';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'eventtype_list';

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
        $data['eventtype_list'] = Eventtype::get();
        
        return view('admin.eventtype.list',$data);
    }

    public function add()
    {
        $data = array();
        return view('admin.eventtype.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
           'name.*' => 'unique:event_type_translations,name',
           'status' => 'required',
            ]
        );

        

        $eventtype = new Eventtype;
        $eventtype->status    = $request->status;

        $eventtype->save();
		foreach ($this->lang_locales as $locale) {
			$eventtype->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$eventtype->save();

        return \Redirect::Route('eventtype_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {      
        $data['details'] = Eventtype::find($id);
        
        return view('admin.eventtype.edit',$data);
    }

    public function update(Request $request,$id)
    {


        $this->validate($request, [
            'name.*' => 'unique:event_type_translations,name,'.$id.',event_type_id',
            'cnt_status' => 'required',
            'color' => 'required',
        ],
        [
            'cnt_status.required'   => 'Please select status',
            'color.required'   => 'Please choose color'
        ]
        );

        $eventtype = Eventtype::find($id);
        $eventtype->status      = $request->cnt_status;
        $eventtype->color       = $request->color;

        $eventtype->save();
		foreach ($this->lang_locales as $locale) {
			$eventtype->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$eventtype->save();

        return \Redirect::Route('eventtype_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        Eventtype::find($id)->delete();
        return \Redirect::Route('eventtype_list')->with('success', 'Record deleted successfully');   
    }
}
