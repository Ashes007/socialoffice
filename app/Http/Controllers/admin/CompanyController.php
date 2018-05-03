<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\Language;
use App\Company;
use App\CompanyTranslation;
use App\User;
use DB;
use Validator;
use Image;
use File;


class CompanyController extends Controller
{
    public $management = 'Company';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'company_list';

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
    	$data['company_list'] = Company::get();
    	
    	return view('admin.company.list',$data);
    }

    public function add()
    {
		$data = array();
    	return view('admin.company.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'status' => 'required',
            ]
        );


    	$company = new Company;    	

        if(Input::hasFile('logo'))
        {
            $image = $request->file('logo');
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/company');
            $thumbPath = public_path('uploads/company/thumbnails');
            
            $img = Image::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);       
            $image->move($destinationPath, $imagename);
            $company->logo = $imagename;
        }

        $company->status    = $request->status;
        $company->save();
		foreach ($this->lang_locales as $locale) {
			$company->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$company->save();

    	return \Redirect::Route('company_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {
  	
    	$data['details'] = Company::find($id);
    	
    	return view('admin.company.edit',$data);
    }

    public function update(Request $request,$id)
    {
    	$company = Company::find($id);
    	$company->status 	= $request->cnt_status;

        if(Input::hasFile('logo'))
        {
            $image = $request->file('logo');
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/company');
            $thumbPath = public_path('uploads/company/thumbnails');
            
            $img = Image::make($image->getRealPath());
            $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);       
            $image->move($destinationPath, $imagename);
            $company->logo = $imagename;
        }

    	$company->save();
		    	
		foreach ($this->lang_locales as $locale) {
			$company->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$company->save();

    	return \Redirect::Route('company_list')->with('success', 'Record updated successfully');
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
            $company = Company::find($id);
            $file1 = 'uploads/company/'.$company->logo;
            $file2 = 'uploads/company/thumbnails/'.$company->logo;
            File::delete($file1, $file2);
            $company->delete();
            return \Redirect::Route('company_list')->with('success', 'Record deleted successfully');  
        } 
    }

    public function syncCompany()
    {
        $response = Curl::to('http://api.dev.tawasul.shurooq.gov.ae/api/companies')
                        ->withData( array( 'key' => 'ADF767DGH' ) )
                        ->asJson()
                         ->get();
    

        foreach ($response as $key => $res) {
            $companyName     = $res->Company;
        
            $CompanyDetails = CompanyTranslation::where('name', $companyName )->get();

            if($CompanyDetails->count() == 0)
            {
                $company        = new Company;            

                $company->status = 'Active';
                $company->save();
                $company_id = $company->id;

                foreach ($this->lang_locales as $locale) {
                    $CompanyDetails = new CompanyTranslation;
                    $CompanyDetails->company_id = $company->id;
                    $CompanyDetails->locale = $locale->code;
                    $CompanyDetails->name = $companyName;
                    $CompanyDetails->save();
                }
                
                
            }
        }
        return \Redirect::Route('company_list')->with('success', 'Record sync successfully');
    }
}
