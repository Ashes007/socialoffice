<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\Language;
use App\Department;
use App\DepartmentTranslation;
use App\User;
use DB;
use Validator;

class DepartmentController extends Controller
{
    public $management = 'Department';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'department_list';

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
        $data['department_list'] = Department::get();
        
        return view('admin.department.list',$data);
    }

    public function add()
    {
        $data = array();
        return view('admin.department.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|unique:departments,code',
            'status' => 'required',
            ],
            [
                'code.unique'   => 'Department Code already exists'
            ]
        );

        $department = new Department;
        $department->code      = $request->code;
        $department->status    = $request->status;

        $department->save();
		foreach ($this->lang_locales as $locale) {
			$department->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$department->save();

        return \Redirect::Route('department_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {
        $data['details'] = Department::find($id);
        
        return view('admin.department.edit',$data);
    }

    public function update(Request $request,$id)
    {


        $this->validate($request, [

            'cnt_status' => 'required',
        ],
        [
            
            'cnt_status.required'   => 'Please select Status'
        ]
        );

        $department = Department::find($id);
        $department->code         = $request->code;
        $department->status       = $request->cnt_status;
        $department->in_ticket    = $request->in_ticket;

        $department->save();
		foreach ($this->lang_locales as $locale) {
			$department->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$department->save();

        return \Redirect::Route('department_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        $user = User::where('company_id',$id)->count();

        if($user>0)
        {
          return \Redirect::Route('company_id')->with('error', "Please remove related data first from: User");       
        }
        else
        {
            Department::find($id)->delete();
            return \Redirect::Route('department_list')->with('success', 'Record deleted successfully');   
       }
    }

    public function syncDepartment()
    {
        $response = Curl::to('http://api.dev.tawasul.shurooq.gov.ae/api/departments')
                        ->withData( array( 'key' => 'ADF767DGH' ) )
                        ->asJson()
                         ->get();
    

        foreach ($response as $key => $res) {
            $departmentName  = $res->Department;
        
            $departmentDetails = DepartmentTranslation::where('name', $departmentName )->get();

            if($departmentDetails->count() == 0)
            {
                $department        = new Department;
                

                $department->status = 'Active';
                $department->save();
                $department_id = $department->id;

                foreach ($this->lang_locales as $locale) {
                    $departmentDetails = new DepartmentTranslation;
                    $departmentDetails->department_id = $department->id;
                    $departmentDetails->locale = $locale->code;
                    $departmentDetails->name = $departmentName;
                    $departmentDetails->save();
                }
                                
            }
        }

        return \Redirect::Route('department_list')->with('success', 'Record sync successfully');

    }

}
