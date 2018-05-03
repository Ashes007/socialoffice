<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;

class CommonController extends Controller
{
 
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
            //$status = '<span class="fa fa-hourglass-start"></span>';

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
