<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public $management = 'Role';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $listUrl = 'role_list';

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
        $data['records'] = Role::where('id','<>',1)->get();        
        return view('admin.roles.list',$data);
    }

    public function add()
    {
        $data = array();
        return view('admin.roles.add',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           'display_name' => 'required|unique:roles,display_name'
            ]
        );
        $role = new Role;
        $role->name            = str_replace(' ','-', strtolower($request->display_name));
        $role->display_name    = $request->display_name;
        $role->description     = $request->description;
        $role->save();
        return \Redirect::Route('role_list')->with('success', 'Role added successfully');
    }


    public function edit($id)
    {       
        $data['record'] = Role::find($id);        
        return view('admin.roles.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'display_name' => 'required|unique:roles,display_name,'.$id
            ]
        );
        $role = Role::find($id);
        $role->display_name    = $request->display_name;
        $role->description     = $request->description;
        $role->save();
        return \Redirect::Route('role_list')->with('success', 'Role updated successfully');
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        return \Redirect::Route('role_list')->with('success', 'Record deleted successfully');   
    } 

    public function permission($id)
    {
        $data['role'] = Role::find($id);
        $permissions = Permission::get();
        $permissionArr = array();

        foreach ($permissions as $permission) {
            $permissionArr[$permission->permission_type][$permission->action]['id'] = $permission->id;
            $permissionArr[$permission->permission_type][$permission->action]['name'] = $permission->name;
            $permissionArr[$permission->permission_type][$permission->action]['display_name'] = $permission->display_name;
        }
        $data['permissions'] = $permissionArr;
        return view('admin.roles.permission',$data);
    }

    public function submitPermission(Request $request, $id)
    {
            $role = Role::find($id);
            $permissions = $request->permission;
            $role->perms()->sync($permissions);

//         if($role->hasPermission('edit-event')){
//             exit('has');
//         }else{
//             exit('hasNot');
//         };

           return \Redirect::Route('role_list')->with('success', 'Permission assigned successfuly.'); 
    }

    
}
