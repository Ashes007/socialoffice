<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Slug;
use App\Language;
use App\Cms;
use DB;
use Validator;

class CmsController extends Controller
{
    public $management = 'CMS';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'cms_list';

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

		$data['cms_list'] = Cms::get();			
    	
    	return view('admin.cms.list',$data);
    }

    public function add()
    {
        $data = array();
    	return view('admin.cms.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title.*' => 'required|unique:cms_translations,title',
            'description.*' => 'required',   
            'page_name' => 'required',        
            'status' => 'required',
            ]
        );
        
        $slug = new Slug;
    	$cms = new Cms;
    	$cms->slug 		  = $slug->createSlug($request->title['en'],'Cms');
        $cms->page_name   = $request->page_name;
        $cms->meta_title  = $request->meta_title;
        $cms->meta_key    = $request->meta_key;
        $cms->meta_Description = $request->meta_Description;
    	$cms->status 	  = $request->status;

    	//$cms->save();

		foreach ($this->lang_locales as $locale) {
			$cms->translateOrNew($locale->code)->title              = $request->title[$locale->code];
            $cms->translateOrNew($locale->code)->description        = $request->description[$locale->code];
            $cms->translateOrNew($locale->code)->short_description  = $request->short_description[$locale->code];
		}
		
		$cms->save();


    	return \Redirect::Route('cms_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {	
		$data['details'] = Cms::find($id);	
    	
    	return view('admin.cms.edit',$data);
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'title.*' => 'required|unique:cms_translations,title',
            'description.*' => 'required',   
            'page_name' => 'required',        
            'status' => 'required',
            ]
        );
        
        $slug = new Slug;
        $cms = Cms::find($id);
        $cms->slug        = $slug->createSlug($request->title['en'],'Cms',$id);
        $cms->page_name   = $request->page_name;
        $cms->meta_title  = $request->meta_title;
        $cms->meta_key    = $request->meta_key;
        $cms->meta_Description = $request->meta_Description;
        $cms->status      = $request->status;

        //$cms->save();

        foreach ($this->lang_locales as $locale) {
            $cms->translateOrNew($locale->code)->title              = $request->title[$locale->code];
            $cms->translateOrNew($locale->code)->description        = $request->description[$locale->code];
            $cms->translateOrNew($locale->code)->short_description  = $request->short_description[$locale->code];
        }
        
        $cms->save();
	
    	return \Redirect::Route('cms_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {

        
        Cms::find($id)->delete();
        return \Redirect::Route('cms_list')->with('success', 'Record deleted successfully');   
        
    }
}
