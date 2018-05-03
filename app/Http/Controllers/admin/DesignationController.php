<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use App\Language;
use App\Designation;
use App\DesignationTranslation;
use DB;
use Validator;

class DesignationController extends Controller
{
    public function getList()
    {
        $data['designation_list'] = Designation::get();
        
        return view('admin.designation.list',$data);
    }

    public function add()
    {
        $data = array();
        return view('admin.designation.add',$data);
    }

    public function store(Request $request)
    {

        

        $designation = new Designation;      
        $designation->status    = $request->status;

        $designation->save();
		foreach ($this->lang_locales as $locale) {
			$designation->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$designation->save();

        return \Redirect::Route('designation_list')->with('success', 'Record added successfully');

    }


    public function edit($id)
    {
        $data['details'] = Designation::find($id);
        
        return view('admin.designation.edit',$data);
    }

    public function update(Request $request,$id)
    {


        $designation = Designation::find($id);
        $designation->status    = $request->cnt_status;

        $designation->save();
		foreach ($this->lang_locales as $locale) {
			$designation->translateOrNew($locale->code)->name = $request->name[$locale->code];
		}
		$designation->save();

        return \Redirect::Route('designation_list')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        Designation::find($id)->delete();
        return \Redirect::Route('designation_list')->with('success', 'Record deleted successfully');   
    }

    public function syncDesignation()
    {
        $response = Curl::to('http://api.dev.tawasul.shurooq.gov.ae/api/designations')
                        ->withData( array( 'key' => 'ADF767DGH' ) )
                        ->asJson()
                         ->get();
    

        foreach ($response as $key => $res) {
            $designationName  = $res->Designation;
        
            $designationDetails = DesignationTranslation::where('name', $designationName )->get();

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
                    $designationDetails->name = $designationName;
                    $designationDetails->save();
                }
                                
            }
        }

        return \Redirect::Route('designation_list')->with('success', 'Record sync successfully'); 

    }
}
