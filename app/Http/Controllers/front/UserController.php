<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\User;
use App\City;
use App\State;
use App\Country;
use App\Designation;
use App\UserFollower;
use App\Event;
use App\Feed;
use App\GroupUser;
use App\EventInvite;
use Image;
use File;
use URL;
require base_path('vendor/autoload.php');
require base_path('vendor/algolia/algoliasearch-client-php/algoliasearch.php');
 
class UserController extends Controller
{
    public function algoliaSave($user_detail){

        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");

        $index = $client->initIndex('TAWASUL');

        $batch = array();
        foreach ($user_detail as $key => $value) {
            $object[$key]=$value;
        }
        array_push($batch,$object);
        $index->addObjects($batch);
    }
    
    public function afterlogin()
    {
    	$userId = \Auth::guard('user')->user()->id;
        //$userId = "673";
    	$data = array();
    	$userInfo = User::find($userId);
        $data['userInfo'] = $userInfo;

        $defautl = array('' => trans('common.select_date'));
        $data['day_array'] = array('' => trans('common.select_date'),  '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31' );

        $data['month_array'] = array('' => trans('common.select_month'),'1' => 'January', '2' => 'February' , '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December' );

        $data['designation_list'] = Designation::where('status','Active')->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),'');
        $data['country_list'] = Country::where('status','Active')->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),'');
        $data['state_list'] = State::where('status','Active')->where('country_id',$userInfo->country_id)->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),'');
        $data['city_list'] = City::where('status','Active')->where('state_id',$userInfo->state_id)->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),''); 
        
    	return view('front.users.afterlogin',$data);
    }

    public function update_profile()
    {
        $userId = \Auth::guard('user')->user()->id;
        $data = array();
        $userInfo = User::find($userId);
        $data['userInfo'] = $userInfo;
        $defautl = array('' => trans('common.select_date'));

        $data['day_array'] = array('' => trans('common.select_date'), '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15', '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23', '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31' );

        $data['month_array'] = array('' => trans('common.select_month'),'1' => 'January', '2' => 'February' , '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December' );

        $data['designation_list'] = Designation::where('status','Active')->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),'');
        $data['country_list'] = Country::where('status','Active')->listsTranslations('name')->pluck('name','id')->prepend( trans('common.select'),'');
        $data['state_list'] = State::where('status','Active')->where('country_id',$userInfo->country_id)->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),'');
        $data['city_list'] = City::where('status','Active')->where('state_id',$userInfo->state_id)->listsTranslations('name')->pluck('name','id')->prepend(trans('common.select'),''); 
        
        return view('front.users.update_profile',$data);
    }

    public function storeProfile(Request $request)
    {

        

        // $this->validate($request, [
        //         'cover_photo'   => 'dimensions:min_width=1250',
        //         'country' => 'required',
        //         'state' => 'required',
        //         'city' => 'required'
        //     ],
        //     [
        //         'cover_photo.dimensions'    => 'Please select atleast 1250 pixel image',
        //     ]
        // );

    	$userId = \Auth::guard('user')->user()->id;
    	// $this->validate($request,[
    	// 		'birth_day' 		=> 'required',
    	// 		'birth_month' 		=> 'required',
    	// 	]);

    	$user = User::find($userId);

        //echo $request->date_of_joining; die();

        $profile_photo_check        = $user->profile_photo;
        if($request->page_name == 'after-login')
        {
            $user->date_of_joining      = \DateTime::createFromFormat('d/m/Y', $request->date_of_joining)->format('Y-m-d');
            $user->date_of_birth        = date('Y')."-".\DateTime::createFromFormat('d/m', $request->birthday)->format('m/d');
        }
    	//$user->birth_day 		= $request->birth_day;
    	//$user->birth_month 		= $request->birth_month;
        //$user->anniversary_day  = $request->anniversary_day;
        //$user->anniversary_month= $request->anniversary_month;
        //$user->country_id       = $request->country;
        //$user->state_id         = $request->state;
        //$user->city_id          = $request->city;
        $user->description      = $request->description; 
     
        if(Input::hasFile('profile_photo'))
        {
                $profile_photo = $user->profile_photo;

                $image = $request->file('profile_photo');                     
           
                $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
                //$imagename = $userId.".png";
                $destinationPath = public_path('uploads/user_images/profile_photo');
                $thumbPath = public_path('uploads/user_images/profile_photo/thumbnails');

                
                $img = Image::make($image->getRealPath());
                // $img->resize(100, 100, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbPath.'/'.$imagename); 
                $image->move($destinationPath, $imagename);               
                $user->profile_photo = $imagename;  



                $hdn_profile_photo = $request->hdn_profile_photo;
                $ifp = fopen( $thumbPath."/".$imagename, 'wb' );
                $data = explode( ',', $hdn_profile_photo );
                fwrite( $ifp, base64_decode( $data[ 1 ] ) );
                fclose( $ifp );  

                ///////////// For Algolia ////////////////////////////////////////

                
               // if($profile_photo_check == NULL || $profile_photo_check == '')
               // {   
                    $user_detail = array();
                    $user_detail['alpha'] = strtolower(substr($user->display_name,0, 1));
                    $user_detail['employeeName'] = $user->display_name;
                    $user_detail['designation'] = $user->designation->name;
                    $user_detail['department'] = $user->department->name;
                    $user_detail['telno'] = $user->mobile;
                    $user_detail['email'] = $user->email;
                    $user_detail['_highlightResult']['employeeName']['value'] = $user->display_name;
                    $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
                    $user_detail['_highlightResult']['matchedWords']['value'] = array();
                    $user_detail['_highlightResult']['designation']['value'] = $user->designation->name;
                    $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
                    $user_detail['_highlightResult']['matchedWords']['value'] = array();
                    $user_detail['_highlightResult']['department']['value'] = $user->department->name;
                    $user_detail['_highlightResult']['matchLevel']['value'] = 'none';
                    $user_detail['_highlightResult']['matchedWords']['value'] = array();
                    $user_detail['userID'] = $user->id;
                    $user_detail['profile_photo'] = $imagename;
                    $user_detail['objectID'] = $user->ad_username;
                    $this->algoliaSave($user_detail);
                //}

                ///////////// For Algolia ////////////////////////////////////////  

                    $file1 = 'uploads/user_images/profile_photo/'.$profile_photo;
                    $file2 = 'uploads/user_images/profile_photo/thumbnails/'.$profile_photo;
                    File::delete($file1, $file2);
                    


             
        }
        
        if(Input::hasFile('cover_photo'))
        {
                $cover_photo = $user->cover_photo;
                $image = $request->file('cover_photo');                      
           
                $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
                //$imagename =  $userId.".png";
                $destinationPath = public_path('uploads/user_images/cover_photo');
                $thumbPath = public_path('uploads/user_images/cover_photo/thumbnails');

                
                $img = Image::make($image->getRealPath());
                // $img->resize(100, 100, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbPath.'/'.$imagename); 

                $image->move($destinationPath, $imagename);
                $user->cover_photo = $imagename;  

                $hdn_cover_photo = $request->hdn_cover_photo;

                $ifp = fopen( $thumbPath."/".$imagename, 'wb' );
                $data = explode( ',', $hdn_cover_photo );
                fwrite( $ifp, base64_decode( $data[ 1 ] ) );
                fclose( $ifp );   

                $file1 = 'uploads/user_images/cover_photo/'.$cover_photo;
                $file2 = 'uploads/user_images/cover_photo/thumbnails/'.$cover_photo;
                File::delete($file1, $file2);
                        
           
        }

    	$user->save();

        return redirect()->route('home')->with('success','Profile updated successfully');
        // if($request->page_name=='after-login'){
        //     return redirect()->route('home')->with('success','Profile updated successfully');
        // }else{
        //     return redirect()->back()->with('success','Profile updated successfully');
        // }
    }

    public function ajax_getState(Request $request)
    {
        $id = $request->id;
        $state_list = State::where('status','Active')->where('country_id',$id)->get();
        $stateOption = '<option value="">'. trans('common.select').' </option>';
        //dd($state_list);
        if($state_list->count()>0)
        {
            foreach ($state_list as $key => $state) {
            
                $stateOption .= '<option value="'.$state->id.'">'.$state->name.'</option>';
            }
        }
        echo $stateOption;
    }

    public function ajax_getCity(Request $request)
    {
        $id = $request->id;
        $city_list = City::where('status','Active')->where('state_id',$id)->get();
        $cityOption = '<option value="">'.trans('common.select').'</option>';
        //dd($state_list);
        if($city_list->count()>0)
        {
            foreach ($city_list as $key => $city) {
            
                $cityOption .= '<option value="'.$city->id.'">'.$city->name.'</option>';
            }
        }
        echo $cityOption;
    }

    public function user_directory(Request $request)
    {
        $data  = array();
        //$data['image_url'] = 'http://laravel.test-projects.co.in/tawasul/public/uploads/user_images/profile_photo/thumbnails/';
        $data['image_url'] = config('constant.algolia_image_path');
        return view('front.users.user_directory',$data); 
    }

    public function ajax_follow(Request $request) 
    {
        $follower_id = $request->id;
        $userId = \Auth::guard('user')->user()->id;
        $isFollow = $request->follow;

        if($isFollow == 'Yes')
        {
            $userFollow             = new UserFollower;
            $userFollow->user_id    = $userId;
            $userFollow->follower_id= $follower_id;
            $userFollow->save();
            $msg = "You have successfully followed";    
        }
        if($isFollow == 'No')
        {
            UserFollower::where('user_id',$userId)->where('follower_id',$follower_id)->delete();
            $msg = "You have successfully unfollowed";
        } 

        echo $msg;       

    }

    public function about(Request $request){
        $data  = array();
        if($request->route('username')!='' && $request->route('username')!= \Auth::guard('user')->user()->ad_username){
            $data['currentuser'] = User::where('ad_username', $request->route('username'))->first();
            $data['logedInUser'] = false;
            $data['isFollow'] = UserFollower::where('user_id',\Auth::guard('user')->user()->id)->where('follower_id', $data['currentuser']->id)->first();
        }else{
            $data['currentuser'] = User::find(\Auth::guard('user')->user()->id);
            $data['logedInUser'] = true;
        }
        
        return view('front.users.about',$data);

    }

    public function friendList(Request $request){

        $data['search_value'] = $request->search;
        if($request->route('username')!='' && $request->route('username')!= \Auth::guard('user')->user()->ad_username){
            $data['currentuser'] = User::where('ad_username', $request->route('username'))->first();
            $curUserId = $data['currentuser']->id;
            $data['logedInUser'] = false;
            $data['isFollow'] = UserFollower::where('user_id',\Auth::guard('user')->user()->id)->where('follower_id', $data['currentuser']->id)->first();
        }else{
            $data['currentuser'] = User::find(\Auth::guard('user')->user()->id);
            $curUserId = \Auth::guard('user')->user()->id;
            $data['logedInUser'] = true;
        }        
        
        $data['records'] = UserFollower::whereHas('user',function($q) use ($data){
                            $q->where('status','Active')->where('group_id', '<>', '1');

                            if($data['search_value'] != ''){
                                $q->where('display_name','like',"%".$data['search_value']."%");
                            }                                                       
                        })->where('user_id', $curUserId)->get();


       // dd($userfollowers);
       // $user_info              = User::where('status','Active')->where('group_id', '<>', '1');
        // if($request->name != '')
        // {
        //     $user_info = $user_info->where('display_name','like',$request->name."%");
        // }

        // if($request->search != '')
        // {
        //     $user_info = $user_info->where('display_name','like',"%".$request->search."%");
        // }
        
        // $data['user_info']      = $user_info->get();
        
        return view('front.users.friend_list',$data); 
    }

    public function timeline(Request $request){

        if($request->route('username')!='' && $request->route('username')!= \Auth::guard('user')->user()->ad_username){
            $data['currentuser'] = User::where('ad_username', $request->route('username'))->first();
            $curUserId = $data['currentuser']->id;
            $data['logedInUser'] = false;
            $data['isFollow'] = UserFollower::where('user_id',\Auth::guard('user')->user()->id)->where('follower_id', $data['currentuser']->id)->first();
        }else{
            $data['currentuser'] = User::find(\Auth::guard('user')->user()->id);
            $curUserId = \Auth::guard('user')->user()->id;
            $data['logedInUser'] = true;
        }        
        
        $data['friendlist'] = UserFollower::whereHas('user',function($q) use ($data){
                            $q->where('status','Active')->where('group_id', '<>', '1');                                                    
                        })->where('user_id', $curUserId)->get();

        $data['events'] = Event::where('status','Active')->where('user_id', $curUserId)->orderBy('id','desc')->get();
        
        return view('front.users.timeline',$data); 
    }

    public function user_profile($id,Request $request){
        $data=array();
        
         $data['today'] = date('Y-m-d');
        $data['userdetails'] = User::where('ad_username',$id)->first();
        if(!empty( $data['userdetails'])){


        $user_id = $data['userdetails']->id;
         $data['user_id']= $user_id;
       

        $feeds= Feed::where('user_id',$user_id)
        ->where(function($queryset){
            $queryset->where(function($query){
                $query->where('type','Event')
                ->wherehas('event', function($q){
                    $q->where('status','Active');
                });
            })
            ->OrWhere(function($query){
                $query->where('type','Group')
                ->wherehas('group', function($q){
                    $q->where('status','Active');
                });
            })
            ->OrWhere('type','Post')
            ->OrWhere('type','Occasion');            
        })
        ->orderBy('updated_at','desc')->paginate(15);


       
        $data['feeds'] = $feeds;  
        if ($request->ajax()) { 

            return view('front.users.data-profile',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
        }
        //print_r($data);
        $data['feeds'] = [];

        $data['total_feed_count'] = count($feeds);
        //dd($data['feeds']);
        $data['isInvited'] = EventInvite::where('user_id', '=',$user_id)->count();
        $data['loggedin_user'] = $user_id;
        $data['ad_username'] = $id;

        $data['events'] = Event::orderBy('id','desc')->where('status','Active')->get();

        $data['mygroups'] = GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->orderBy('grpuser.id','desc')->limit(3)->get();
        return view('front.users.user-profile',$data); 
        }else{
            return \Redirect::Route('home')->with('error', 'Sorry! The Employee does not exists!');
        }
    }

}
