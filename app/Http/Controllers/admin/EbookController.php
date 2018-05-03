<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Slug;
use App\Language;
use App\Ebook;
use DB;
use Validator;

class EbookController extends Controller
{
    public $management = 'Ebook';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'ebook_list';

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

		$data['ebook_list'] = Ebook::get();			
    	
    	return view('admin.ebook.list',$data);
    }

    public function add()
    {
        $data = array();
    	return view('admin.ebook.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title.*' => 'required',
            'description.*' => 'required',      
            'file_name' => 'required',
            ]
        );

    	$ebook = new Ebook;

        if($request->file('file_name')){
                $file = $request->file('file_name');
                $fileName  = 'ebook-'.time(). '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks/'), $fileName);
                $ebook->file_name  = $fileName;          
        }

		foreach ($this->lang_locales as $locale) {
			$ebook->translateOrNew($locale->code)->title              = $request->title[$locale->code];
            $ebook->translateOrNew($locale->code)->description        = $request->description[$locale->code];
		}
		
		$ebook->save();

    	return \Redirect::Route('ebook_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {	
		$data['details'] = Ebook::find($id);	
    	
    	return view('admin.ebook.edit',$data);
    }

    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'title.*' => 'required',
            'description.*' => 'required'
            ]
        );

        $ebook = Ebook::find($id);

        if($request->file('file_name')){
                $file = $request->file('file_name');
                $fileName  = 'ebook-'.time(). '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/ebooks/'), $fileName);
                $ebook->file_name  = $fileName;          
        }

        foreach ($this->lang_locales as $locale) {
            $ebook->translateOrNew($locale->code)->title              = $request->title[$locale->code];
            $ebook->translateOrNew($locale->code)->description        = $request->description[$locale->code];
        }
        
        $ebook->save();
	
    	return \Redirect::Route('ebook_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {

        
        Ebook::find($id)->delete();
        return \Redirect::Route('ebook_list')->with('success', 'Record deleted successfully');   
        
    }
}
