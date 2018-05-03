<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmailTemplate, App\EmailTemplateTranslation;

class EmailTemplateController extends Controller
{

    /*************************** 
    /* Variables
    /***************************/
    public $management = 'Email Template';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'emailtemplate_list';
    public $addUrl = 'emailtemplate_add';
    public $editUrl = 'emailtemplate_edit';
    public $deleteUrl = 'emailtemplate_delete';

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

         // $emailtemp  = EmailTemplate::find(7);
         // echo $emailtemp->created_at;
         // echo '<br/>';
         // echo convertTimeToUSERzone($emailtemp->created_at,'Asia/Kolkata');  
         // date_default_timezone_set('Asia/Kolkata');
         // echo date('Y-m-d H:i:s');
         // echo '<br/>';
         // date_default_timezone_set('UTC');
         // echo date('Y-m-d H:i:s');     

    	$data['records'] = EmailTemplate::get();
    	return view('admin.emailtemplate.list',$data);
    }

    public function add()
    {
        $data['templateFiles'] = [
            'simple-text'=>'simple-text'
        ];
    	return view('admin.emailtemplate.add',$data);
    }


    public function store(Request $request)
    {
    	$object = new EmailTemplate();
    	$object->template_file 	= $request->template_file;
    	$object->slug 		    = $request->slug;
        $object->template_name             = $request->template_name;
        $object->email_subject             = $request->email_subject;
        $object->template_variables             = $request->template_variables;

		foreach ($this->lang_locales as $locale) {
			$object->translateOrNew($locale->code)->email_content = $request->email_content[$locale->code];
		}
		$object->save();
		
    	return \Redirect::Route($this->listUrl)->with('success', 'Record added successfully');
    }


    public function edit($id)
    {	
        $data['templateFiles'] = [
            'simple-text'=>'simple-text'
        ];        
    	$data['record'] = EmailTemplate::find($id);    	
    	return view('admin.emailtemplate.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $object = EmailTemplate::find($id);
        $object->template_file  = $request->template_file;
        $object->slug           = $request->slug;
        $object->template_name             = $request->template_name;
        $object->email_subject             = $request->email_subject;
        $object->template_variables             = $request->template_variables;

        foreach ($this->lang_locales as $locale) {
            $object->translateOrNew($locale->code)->email_content = $request->email_content[$locale->code];
        }
        $object->save();
		
    	return \Redirect::Route($this->listUrl)->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        EmailTemplate::find($id)->delete();
        return \Redirect::Route($this->listUrl)->with('success', 'Record deleted successfully');   
    }


}
