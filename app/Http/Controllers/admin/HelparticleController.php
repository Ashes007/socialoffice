<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helparticle, App\HelparticleCategory;

class HelparticleController extends Controller
{

    /*************************** 
    /* Variables
    /***************************/
    public $management = 'Help Article';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'helparticle_list';
    public $addUrl = 'helparticle_add';
    public $editUrl = 'helparticle_edit';
    public $deleteUrl = 'helparticle_delete';

    /*************************** 
    /* Start Constructor Finction
    /***************************/
    public function __construct()
    {
        parent::__construct();

        // **************  Breadcrum ***************/
        $this->breadcrumb = [
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

            // **************  Assign variables to view page ***************/

            \View::share([
                'management'        => $this->management,
                'listPage'          => $this->listUrl,
                'addPage'           => $this->addUrl,
                'editPage'          => $this->editUrl,
                'deletePage'        => $this->deleteUrl
            ]);

            if(\Route::current()->getActionMethod()=='index'){
                \View::share([
                    'pageType'      => $this->listMode,
                    'breadCrumb'    =>$this->breadcrumb['LISTPAGE']
                ]); 

            }elseif(\Route::current()->getActionMethod()=='add'){
                \View::share([
                    'pageType'      => $this->createMode,
                    'breadCrumb'    =>$this->breadcrumb['CREATEPAGE']
                ]); 

            }elseif(\Route::current()->getActionMethod()=='edit'){
                \View::share([
                    'pageType'      => $this->editMode,
                    'breadCrumb'    =>$this->breadcrumb['EDITPAGE']
                ]); 
            }

             // **************  End assign variables ***************/
    }

    // ********//-- End Constructor Finction --//*********** //


    public function index(){
    	$data['records'] = Helparticle::get();
    	return view('admin.helparticle.list',$data);
    }

    public function add()
    {
    	$data['helparticleCategories'] = HelparticleCategory::where('status','Active')->listsTranslations('name')->pluck('name','id');
    	return view('admin.helparticle.add',$data);
    }


    public function store(Request $request)
    {
    	$object = new Helparticle();
    	$object->helparticle_category_id 	= $request->category;
    	$object->status 		    = $request->status;

		foreach ($this->lang_locales as $locale) {
			$object->translateOrNew($locale->code)->title = $request->title[$locale->code];
            $object->translateOrNew($locale->code)->description = $request->description[$locale->code];
		}
		$object->save();
		
    	return \Redirect::Route($this->listUrl)->with('success', 'Record added successfully');
    }


    public function edit($id)
    {
    	$data['helparticleCategories'] = HelparticleCategory::where('status','Active')->listsTranslations('name')->pluck('name','id');   	
    	$data['record'] = Helparticle::find($id);    	
    	return view('admin.helparticle.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $object = Helparticle::find($id);
        $object->helparticle_category_id    = $request->category;
        $object->status             = $request->status;

        foreach ($this->lang_locales as $locale) {
            $object->translateOrNew($locale->code)->title = $request->title[$locale->code];
            $object->translateOrNew($locale->code)->description = $request->description[$locale->code];
        }
        $object->save();
		
    	return \Redirect::Route($this->listUrl)->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        Helparticle::find($id)->delete();
        return \Redirect::Route($this->listUrl)->with('success', 'Record deleted successfully');   
    }


}
