<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;
use App\AccessType;

class AccessTypeController extends Controller
{
    public function add()
    {
    	$data['menu_list'] = Menu::all();
    	return view('admin.user.access_type_add',$data);
    }

    public function store(Request $request)
    {
    	$accessType = new AccessType;
    	$accessType->menu_id = $request->menu;
    	$accessType->name = $request->name;
    	$accessType->route_name = $request->route_name;
    	$accessType->save();

    	return \Redirect::Route('accesstype_add');
    }
}
