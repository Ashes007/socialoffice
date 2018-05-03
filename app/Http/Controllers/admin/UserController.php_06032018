<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\User;
use App\GroupType;
use App\UserGroup;
use App\Menu, App\Role;

use App\Department;
use App\DepartmentTranslation;
use App\Company;
use App\CompanyTranslation;
use App\GroupTypeTranslation;
use App\Designation;
use App\DesignationTranslation;

use App\Country;


class UserController extends Controller
{
    public $management = 'User';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'user_list';

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
    	$data['user_list'] = User::wherehas('roleuser', function($q){
                    $q->where('role_id','<>', 1);
                })->get();
    	return view('admin.user.list',$data);
    }

    public function changeUserStatus(Request $request)
    {
    	$id = $request->user_id;
    	$user = User::find($id);
    	if($user->status == 'Active')
    	{
    		$user->status = 'Inactive';
            $status = '<span class="ion-android-close"></span>';
    	}
    	else
    	{
    		$user->status = 'Active';
            $status = '<span class="ion-checkmark"></span>';
    	}
    	$user->save();
    	echo $status;
    }

    public function viewDetails($id)
    {
        $data['details'] = User::find($id);
        return view('admin.user.details',$data);
    }

    public function addeditRole($userId)
    {
        $data['user'] = User::find($userId);
        $data['roles'] = Role::where('id','<>',1)->get();        
        return view ('admin.user.addedit_role',$data);
    }

    public function submitAddeditRole(Request $request,$userId)
    {
        $user = User::find($userId);
        $roles = $request->role;
        $user->roles()->sync($roles);               
        return \Redirect::Route('user_list')->with('succmsg', "Role Assigned Successfuly.");
    }

    public function syncUser()
    {
        $response = Curl::to('http://api.dev.tawasul.shurooq.gov.ae/api/allusers')
                        ->withData( array( 'key' => 'ADF767DGH' ) )
                        ->asJson()
                         ->get();
                     
        foreach ($response as $key => $res) {

            $companyName     = $res->userCompany;
            $departmentName  = $res->userDepartment;
            $groupName       = $res->userGroup;
            $userEmail       = $res->userEmail;
            $display_name    = $res->displayName; 
            $userTitle       = $res->userTitle; 
            $userPhone       = $res->userPhone;
            $userDateOfJoin  = $res->userDateOfJoin;
            $userDateOfBirth = $res->userDateOfBirth;   


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
            else
            {
                $company_id = $CompanyDetails[0]->company_id;
            }
           

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
            else
            {
                $department_id = $departmentDetails[0]->department_id;
            }

            $designationDetails = DesignationTranslation::where('name', $userTitle )->get();

            if($designationDetails->count() == 0)
            {
                $designation        = new Designation;
                

                $designation->status = 'Active';
                $designation->save();
                $designation_id = $designation->id;

                foreach ($this->lang_locales as $locale) {
                    $designationDetails = new DesignationTranslation;
                    $designationDetails->designation_id = $designation->id;
                    $designationDetails->locale = $locale->code;
                    $designationDetails->name = $userTitle;
                    $designationDetails->save();
                }
                                
            }
            else
            {
                $designation_id = $designationDetails[0]->designation_id;
            }

            $grouptypeDetails = GroupTypeTranslation::where('name', $groupName )->get();

            if($grouptypeDetails->count() == 0)
            {
               
                $grouptype        = new GroupType;               

                $grouptype->status = 'Active';
                $grouptype->save();
                $group_id = $grouptype->id;

                foreach ($this->lang_locales as $locale) {
                    $grouptypeDetails = new GroupTypeTranslation;
                    $grouptypeDetails->group_type_id = $grouptype->id;
                    $grouptypeDetails->locale = $locale->code;
                    $grouptypeDetails->name = $groupName;
                    $grouptypeDetails->save();
                }
                
                
            }
            else
            {
                
                $group_id = $grouptypeDetails[0]->group_type_id;
            }
            

            $expEmail = explode('@',$userEmail);
            $username = $expEmail[0];
            $user = User::where('ad_username', $username )->first();
            
            $newuser = 'No';
            if($user == NULL)
             {            
                $user = new User;
                $user->access_token  = \Hash::make(time());
                $newuser = 'Yes';
                $user->ad_username = $username; 
                
             }

          
            $user->title       = $userTitle;
            $user->email       = $userEmail;
            $user->display_name = $display_name;
            $user->group_id    = $group_id;
            $user->company_id  = $company_id;
            $user->department_id = $department_id;
            $user->designation_id = $designation_id;
            $user->mobile = $userPhone;
            if($userDateOfJoin != '')
            $user->date_of_joining = \DateTime::createFromFormat('d/m/Y', $userDateOfJoin)->format('Y-m-d');
            if($userDateOfBirth != '')
            $user->date_of_birth = \DateTime::createFromFormat('d/m/Y', $userDateOfBirth)->format('Y-m-d');
            
            $user->save();

            if($newuser == 'Yes')
            { 
                $user->attachRole(5);
            }
        }
        return \Redirect::Route('user_list')->with('success', "Users Sync Successfuly.");
    }


    public function statusChange(Request $request)
    {
        $id = $request->id;
        $model = $request->model;
        $model = "\App\\".$model;
        $record = $model::find($id);

        if($record->status == 'Active')
        {
            $record->status = 'Inactive';
            $status = '<span class="ion-android-close"></span>';
        }
        else
        {
            $record->status = 'Active';
            $status = '<span class="ion-checkmark"></span>';
        }
        $record->save();
        echo $status;
    }
   
}
