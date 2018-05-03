<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\Language;
use App\GroupType AS Grouptype;
use App\GroupTypeTranslation;
use DB;
use Validator;
use App\Menu;
use App\Permission;

class GrouptypeController extends Controller
{
    public $management = 'Group Type';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'grouptype_list';

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
        $data['grouptype_list'] = Grouptype::get();
        
        return view('admin.grouptype.list',$data);
    }

    public function add()
    {
        $data = array();
        return view('admin.grouptype.add',$data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
           'name.*' => 'unique:group_type_translations,name',
           'status' => 'required',
            ]
        );

        

        $grouptype = new Grouptype;
        $grouptype->status    = $request->status;

        $grouptype->save();
		foreach ($this->lang_locales as $locale) {
			$grouptype->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$grouptype->save();

        return \Redirect::Route('grouptype_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {       
        $data['details'] = Grouptype::find($id);
        
        return view('admin.grouptype.edit',$data);
    }

    public function update(Request $request,$id)
    {


        $this->validate($request, [
            'name.*' => 'unique:group_type_translations,name,'.$id.',group_type_id',
            'cnt_status' => 'required',
        ],
        [
            'cnt_status.required'   => 'Please select Status'
        ]
        );

        $grouptype = Grouptype::find($id);
        $grouptype->status    = $request->cnt_status;

        $grouptype->save();
		foreach ($this->lang_locales as $locale) {
			$grouptype->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$grouptype->save();

        return \Redirect::Route('grouptype_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        Grouptype::find($id)->delete();
        return \Redirect::Route('grouptype_list')->with('success', 'Record deleted successfully');   
    }

    public function permission($id)
    {
        $userpermission = Permission::get();
        //dd($userpermission);
        $data['menu_list'] = Menu::all();
        $selectedPermission = array();
        
        if(count($userpermission)>0)
        {

            foreach ($userpermission as  $permission) {
                $selectedPermission[] = $permission->access_id;
            }
        }
        $data['selectedPermission'] = $selectedPermission;

        return view('admin.grouptype.permission',$data);
    }

    public function submitPermission(Request $request, $groupId)
    {
            $permission = $request->accessTypeIds;
            Permission::where('group_id',$groupId)->delete();
            //dd($permission);
            if(is_array($permission))
            {
                foreach ($permission as $prmission) {
                    //echo $groupId."...".$prmission;
                   $userPermission              = new Permission;
                   $userPermission->group_id    = $groupId;
                   $userPermission->access_id   = $prmission;
                   $userPermission->save();
                }
            }

            return \Redirect::Route('user_permission',$groupId)->with('succmsg', "Permission changed Successfuly.");
    }

    public function syncGroup()
    {
        $response = Curl::to('http://api.dev.tawasul.shurooq.gov.ae/api/groups')
                        ->withData( array( 'key' => 'ADF767DGH' ) )
                        ->asJson()
                         ->get();
    

        foreach ($response as $key => $res) {
            $groupName       = $res->Group;
        
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
        }

        return \Redirect::Route('grouptype_list')->with('success', 'Record sync successfully');

    }
}
