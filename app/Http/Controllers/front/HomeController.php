<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Input;
use Image;
use File;
use Vimeo;
use LRedis;

use App\Department;
use App\DepartmentTranslation;
use App\Company;
use App\CompanyTranslation;
use App\GroupType;
use App\GroupUser;
use App\GroupTypeTranslation;
use App\Designation;
use App\DesignationTranslation;
use App\Feed;
use App\Post;
use App\OccationPost;
use App\Like;
use App\Comment;

use App\EventInvite;
use App\GroupInvite;
use App\UserGroupUser;
use App\GroupUserModerator;
use App\Notification, App\User, App\Event;
use App\NotificationCount;
 

class HomeController extends Controller
{
    public function groupAlgoliaUpdate($event_algolia_details){

         $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");
        $index = $client->initIndex('TAWASUL-Groups');       
        $index->partialUpdateObject($event_algolia_details);
    }
    public function index(Request $request)
    {  
    
        //$data['feeds'] = Feed::orderBy('id','desc')->get();
        $feeds= Feed::where(function($queryset){
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
        $data['feedall'] = Feed::orderBy('id','desc')->get();
        $data['today'] = date('Y-m-d');
        $feds = array();
        if(!empty($data['feedall'])){
            foreach($data['feedall'] as $feeds){
                if($feeds->type=='Group') {                   
                    $feed = $feeds->group;
                    if(count($feed)){
                        if($feed->group_type_id==1 && $feed->status=='Active'){
                        if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {
                        $fed['image'] ='uploads/group_images/'.'/'.$feed->cover_image ;
                        }else{ 
                        $fed['image'] ='frontend/images/no-image-event-details.jpg';
                        }    
                        
                        if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                        }

                        if(count($feed->profile_image) && file_exists(public_path('uploads/group_images/profile_image/'.$feed->profile_image)) && ($feed->profile_image!=''||$feed->profile_image!=NULL)) {
                            $fed['profile_image'] =  'uploads/group_images/profile_image/'.$feed->profile_image;
                            }
                            else{
                            $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;
                        $group_id = encrypt($feed->group_user_id);   
                        $fed['text'] = trans('home.created_new_group');
                        if(strlen($feed->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($feed->group_name,0,20).$add_dot;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $fed['created_at'] = $feed->created_at;
                        $feds[]=$fed;
                        }
                    }
                }
                elseif($feeds->type=='Event') {                   
                    $feed = $feeds->event;
                    if(count($feed)){
                        if($feed->type_id==1){
                            if(count($feed->event_profile_image) && file_exists(public_path('uploads/event_images/profile_image/'.$feed->event_profile_image))) {
                            $fed['profile_image'] =  'uploads/event_images/profile_image/'.$feed->event_profile_image;
                            }
                            else{
                            $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }

                            if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) {
                            $fed['image'] =  'uploads/event_images/original/'.$feed->eventImage[0]->image_name;
                            }
                            else{
                            $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                            }
                            if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                                $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                            }else{
                                $fed['userimage']='frontend/images/no_user_thumb.png';
                            } 
                        $fed['user_id']     = $feed->user->ad_username;  
                        $fed['user_name']   = $feed->user->display_name;      
                        $fed['text']        = trans('home.created_new_event');
                        $fed['textlink']    = $feed->name;
                        $fed['url']         = route('event_details', encrypt($feed->id));
                        $fed['created_at']  = $feed->created_at;
                        $feds[]             = $fed;
                        }
                    }
                }
                elseif($feeds->type=='Post'){
                    $feed = $feeds->post;
                    if(count($feed)){
                       // echo ($feed->group_id).'@@' ;
                        $type_ids=GroupUser::where('id',$feed->group_id)->first(); 
                        //dd($type_ids);
                       // echo $type_ids['group_type_id'].'@@';
                        if( $type_ids['group_type_id']==1){
                        if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image))){
                    
                        $fed['image'] =  'uploads/post_images/'.$feed->image;
                        }
                        else{
                        $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                        }
                        if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                        if($type_ids['profile_image'] != NULL && file_exists(public_path('uploads/group_images/profile_image/' .$type_ids['profile_image']))){
                    
                        $fed['profile_image'] =  'uploads/group_images/profile_image/'.$type_ids['profile_image'];
                        }
                        else{
                        $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                        }
                       

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;  
                        $group_id = encrypt($feed->group_id);  
                        $fed['text'] =  trans('home.posted_in');
                        if(strlen($type_ids['group_name'])>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($type_ids['group_name'],0,20).$add_dot;
                        //$fed['textlink'] = $type_ids->group_name;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $fed['created_at'] = $feed->created_at;
                        $feds[]=$fed;
                        }

                    }
                }
            }
        }
       
        $ord = array();
        foreach ($feds as $key => $res)
        {       
            $ord[$key] = $res['created_at'];       
        }
        array_multisort($ord, SORT_DESC, $feds);      
        $data['total_feed_count'] = count($feeds);
        //dd($feds);
        $data['recent_updates'] = array_slice($feds,0,4);
        //dd($data['recent_updates']);
        //exit;
        $user_id = \Auth::guard('user')->user()->id;
        $data['isInvited'] = EventInvite::where('user_id', '=',$user_id)->count();
        $data['loggedin_user'] = $user_id;

        $data['events'] = Event::orderBy('id','desc')->where('status','Active')->get();
        $data['mygroups'] = GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->orderBy('grpuser.id','desc')->limit(3)->get();

        $data['mygroupall'] = GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->orderBy('grpuser.id','desc')->get(); 

        if ($request->ajax()) { 
            return view('front.home-data',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
        }
        //print_r($data);
        $data['feeds'] = []; 
        //$occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where('date_of_birth','like','%'.date('m-d'))->OrWhere('date_of_joining','like','%'.date('m-d'))->get(); 

        // $occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where(function($query){  $query->where('date_of_birth','like','%'.date('m-d'))->OrWhere('date_of_joining','like','%'.date('m-d'));  })->get(); 
       $join_occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->Where('date_of_joining','like','%'.date('m-d'))->select('*')->selectRaw('"DOJ" as field_type');
       $occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where('date_of_birth','like','%'.date('m-d'))->union($join_occations)->select('*')->selectRaw('"DOB" as field_type')->get();
       
        $data['occasions']  = $occasions;             
    	return view('front.home',$data);
    }

    //========================= recent updates secton =====================================//
    public function recent_updates(Request $request)
    { 
        $user_id = \Auth::guard('user')->user()->id;       
        //$data['feeds'] = Feed::orderBy('id','desc')->paginate(15);
        $data['feeds'] =Feed::where(function($queryset){
            $queryset->where(function($query){
                $query->where('type','Event')
                ->wherehas('event', function($q){
                    $q->where('status','Active');
                    $q->where('type_id','1');
                });
            })
            ->OrWhere(function($query){
                $query->where('type','Group')
                ->wherehas('group', function($q){
                    $q->where('status','Active');
                    $q->where('group_type_id','1');
                });
            })
            ->OrWhere('type','Post');            
        })
        ->orderBy('created_at','desc')->paginate(25);
        $feds = array();
        if(!empty($data['feeds'])){
            foreach($data['feeds'] as $feeds){
                if($feeds->type=='Group') {                   
                    $feed = $feeds->group;
                    if(count($feed)){
                        if($feed->group_type_id==1 && $feed->status=='Active'){
                        if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {
                        $fed['image'] ='uploads/group_images/'.'/'.$feed->cover_image ;
                        }else{ 
                        $fed['image'] ='frontend/images/no-image-event-details.jpg';
                        }   

                         if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                        }

                        if(count($feed->profile_image) && file_exists(public_path('uploads/group_images/profile_image/'.$feed->profile_image)) && ($feed->profile_image!=''||$feed->profile_image!=NULL)) {
                            $fed['profile_image'] =  'uploads/group_images/profile_image/'.$feed->profile_image;
                            }
                            else{
                            $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;  
                        $group_id = encrypt($feed->group_user_id);    
                       
                        $fed['text'] = trans('home.created_new_group');
                        if(strlen($feed->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($feed->group_name,0,20).$add_dot;                        
                        $fed['created_at'] = $feed->created_at;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $feds[]=$fed;
                        }
                    }
                }
                elseif($feeds->type=='Event') {                   
                    $feed = $feeds->event;
                    if(count($feed)){
                        if($feed->type_id==1){
                            if(count($feed->event_profile_image) && file_exists(public_path('uploads/event_images/profile_image/'.$feed->event_profile_image))) {
                                $fed['profile_image'] =  'uploads/event_images/profile_image/'.$feed->event_profile_image;
                            }
                            else{
                                $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }    

                            
                            if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) {
                            $fed['image'] =  'uploads/event_images/original/'.$feed->eventImage[0]->image_name;
                            }
                            else{
                            $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                            }
                              
                            if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                                $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                            }else{
                                $fed['userimage']='frontend/images/no_user_thumb.png';
                            }

                            $fed['user_id']= $feed->user->ad_username;
                            $fed['user_name'] =  $feed->user->display_name;

                            $fed['text'] = trans('home.created_new_event');
                            $fed['textlink'] = $feed->name;
                            
                            $fed['created_at'] = $feed->created_at;
                            $fed['url'] =route('event_details', encrypt($feed->id));
                            $feds[]=$fed;
                        }
                    }
                }
                elseif($feeds->type=='Post'){
                    $feed = $feeds->post;
                    if(count($feed)){
                        //echo ($feed->group_id).'@@' ;
                        $type_ids=GroupUser::where('id',$feed->group_id)->first(); 
                        //dd($type_ids);
                        if( $type_ids['group_type_id']==1){
                        if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image))){
                    
                        $fed['image'] =  'uploads/post_images/'.$feed->image;
                        }
                        else{
                        $fed['image'] =  '';
                        }
                         if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                       if($type_ids['profile_image'] != NULL && file_exists(public_path('uploads/group_images/profile_image/' .$type_ids['profile_image']))){
                    
                        $fed['profile_image'] =  'uploads/group_images/profile_image/'.$type_ids['profile_image'];
                        }
                        else{
                        $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                        }

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;
                         
                        $fed['text'] =  trans('home.posted_in');
                        if(strlen($type_ids->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($type_ids->group_name,0,20).$add_dot;
                        $group_id = encrypt($feed->group_id);
                        $fed['created_at'] = $feed->created_at;
                         $fed['url'] =Route('group_details').'/'.$group_id;
                        $feds[]=$fed;
                        }
                    }
                }
            }
        }        
        $ord = array();
        foreach ($feds as $key => $res)
        {       
            $ord[$key] = $res['created_at'];       
        }
        array_multisort($ord, SORT_DESC, $feds); 
        $data['recent_updates'] = array_slice($feds,0,4);
        $data['recent_updates_all'] = $feds;
        
        $data['mygroups'] = GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->orderBy('grpuser.id','desc')->limit(3)->get();

        // $occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where(function($query){  $query->where('date_of_birth','like','%'.date('m-d'))->OrWhere('date_of_joining','like','%'.date('m-d'));  })->get();  
        $join_occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->Where('date_of_joining','like','%'.date('m-d'))->select('*')->selectRaw('"DOJ" as field_type');
      	$occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where('date_of_birth','like','%'.date('m-d'))->union($join_occations)->select('*')->selectRaw('"DOB" as field_type')->get();                    
        $data['occasions']  = $occasions;
        if($request->ajax()){ 
            return view('front.data-recent-updates',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
        }
            //print_r($data);
        $data['recent_updates_all']   = [];                    
        return view('front.recent-updates',$data);
    }
    public function recent_notifications(Request $request)
    {
        $data=array();
        $data['feeds'] = Feed::orderBy('id','desc')->get();
        $feds = array();
        if(!empty($data['feeds'])){
            foreach($data['feeds'] as $feeds){
                if($feeds->type=='Group') {                   
                    $feed = $feeds->group;
                    if(count($feed)){
                        if($feed->group_type_id==1 && $feed->status=='Active'){
                        if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {
                        $fed['image'] ='uploads/group_images/'.'/'.$feed->cover_image ;
                        }else{ 
                        $fed['image'] ='frontend/images/no-image-event-details.jpg';
                        }   
                         if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                       if(count($feed->profile_image) && file_exists(public_path('uploads/group_images/profile_image/'.$feed->profile_image)) && ($feed->profile_image!=''||$feed->profile_image!=NULL)) {
                            $fed['profile_image'] =  'uploads/group_images/profile_image/'.$feed->profile_image;
                            }
                            else{
                            $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }
                         
                        $fed['user_id']= $feed->user->ad_username;   
                        $fed['user_name'] =  $feed->user->display_name;  
                        $group_id = encrypt($feed->group_user_id);    
                        $fed['text'] = trans('home.created_new_group');
                        if(strlen($feed->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($feed->group_name,0,20).$add_dot;                       
                        $fed['created_at'] = $feed->created_at;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $feds[]=$fed;
                        }
                    }
                }
                elseif($feeds->type=='Event') {                   
                    $feed = $feeds->event;
                    if(count($feed)){
                        if($feed->type_id==1){
                        if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) {
                        $fed['image'] =  'uploads/event_images/original/'.$feed->eventImage[0]->image_name;
                        }
                        else{
                        $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                        }
                         if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                        if(count($feed->event_profile_image) && file_exists(public_path('uploads/event_images/profile_image/'.$feed->event_profile_image))) {
                                $fed['profile_image'] =  'uploads/event_images/profile_image/'.$feed->event_profile_image;
                            }
                            else{
                                $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            } 
                       $fed['user_name'] =  $feed->user->display_name;   
                        $fed['user_id']= $feed->user->ad_username;      
                        $fed['text'] = trans('home.created_new_event');
                        $fed['textlink'] = $feed->name;
                        
                        $fed['created_at'] = $feed->created_at;
                        $fed['url'] =route('event_details', encrypt($feed->id));
                        $feds[]=$fed;
                        }
                    }
                }
                elseif($feeds->type=='Post'){
                    $feed = $feeds->post;
                    if(count($feed)){
                        //echo ($feed->group_id).'@@' ;
                        $type_ids=GroupUser::where('id',$feed->group_id)->first(); 
                        //dd($type_ids);
                        if( $type_ids['group_type_id']==1){
                        if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image))){
                    
                        $fed['image'] =  'uploads/post_images/'.$feed->image;
                        }
                        else{
                        $fed['image'] =  '';
                        }
                         if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                        if($type_ids['profile_image'] != NULL && file_exists(public_path('uploads/group_images/profile_image/' .$type_ids['profile_image']))){                    
                        $fed['profile_image'] =  'uploads/group_images/profile_image/'.$type_ids['profile_image'];
                        }
                        else{
                        $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                        }
                          $fed['user_id']= $feed->user->ad_username;
                          $fed['user_name'] =  $feed->user->display_name;
                          $group_id = encrypt($feed->group_id);    
                          $fed['text'] = trans('home.posted_in');
                          if(strlen($type_ids->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                          $fed['textlink'] =  substr($type_ids->group_name,0,20).$add_dot;
                        
                          $fed['created_at'] = $feed->created_at;
                          $fed['url'] =Route('group_details').'/'.$group_id;;
                          $feds[]=$fed;
                        }

                    }
                }
            }
        }
        //print_r($feds);die;
        $ord = array();
        foreach ($feds as $key => $res)
        {       
            $ord[$key] = $res['created_at'];       
        }
        array_multisort($ord, SORT_DESC, $feds); 
        $data['recent_updates'] = array_slice($feds,0,4);
        $user_id=\Auth::guard('user')->user()->id;
         $data['mygroups'] = GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->orderBy('grpuser.id','desc')->limit(3)->get();
        $data['header_notifications'] = Notification::where('user_id',$user_id)->orderBy('id','Desc')->paginate(15);
        if($request->ajax()){ 
            return view('front.data-notification',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
        }
            //print_r($data);
        $data['header_notifications']   = [];   
        // $occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where(function($query){  $query->where('date_of_birth','like','%'.date('m-d'))->OrWhere('date_of_joining','like','%'.date('m-d'));  })->get();  
        $join_occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->Where('date_of_joining','like','%'.date('m-d'))->select('*')->selectRaw('"DOJ" as field_type');
      	$occasions = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where('date_of_birth','like','%'.date('m-d'))->union($join_occations)->select('*')->selectRaw('"DOB" as field_type')->get();
        $data['occasions']  = $occasions;

        return view('front.notifications',$data);
    }

    //================== accept member request       ==========================//

    public function accept_member_request(Request $request){
        $notification_id= $request->notification_id; 
        $invite = Notification::where('id', $notification_id)->first();
        //dd($invite);
        $usergroupusr = new UserGroupUser;
        $usergroupusr->user_id  = $invite->user_id;
        $usergroupusr->group_id = $invite->notificationable_id;
        $usergroupusr->save(); 
        $grp_details=GroupUser::find($usergroupusr->group_id);
        GroupInvite::where('notification_id', $notification_id)->delete();
        Notification::where('id', $notification_id)->update(['accept_status' => 1]);
        $groupnotification = new Notification;
        $groupnotification->notificationable_id   = $usergroupusr->group_id;
        $groupnotification->notificationable_type = 'GroupAccept';
        $groupnotification->text                  = strip_tags(member_name($usergroupusr->user_id),"<a>").' has accepted the invitation to join <a href="'.route('group_details').'/'.encrypt($usergroupusr->group_id).'">'.$grp_details->group_name.'</a> on ';
        $groupnotification->user_id               = $grp_details->user_id;
        $groupnotification->added_by              = $usergroupusr->user_id;
        $groupnotification->save();
        $NotificationCount = NotificationCount::where('user_id', $grp_details->user_id)->first();
        if($NotificationCount)
        {
            $NotificationCount->increment('unread_count');
        }
        else
        {
            $NotificationCount = new NotificationCount();
            $NotificationCount->user_id = $grp_details->user_id;
            $NotificationCount->unread_count = 1;
            $NotificationCount->save();
        }
        $redis = LRedis::connection();           
        if( $grp_details->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $grp_details->profile_image))){
            $prof_img_path='uploads/group_images/profile_image/'.$grp_details->profile_image;
        }else{
            $prof_img_path='frontend/images/no-image-event-list.jpg';
        }        
        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
        $redis->publish('user_message'.$grp_details->user_id, $redis_message);

        $memberlist = UserGroupUser::where('group_id',$usergroupusr->group_id)->get();
        $member_ids = '';
        if(!empty($memberlist)){
            foreach ($memberlist as $member_id) {
                $member_ids .=$member_id->user_id.',';
            }
        }
        $algoliagroup =array();
        $algoliagroup['groupMembers']       = rtrim($member_ids,',');              
        $algoliagroup['objectID']           = "group_".$usergroupusr->group_id;   
        
        $this->groupAlgoliaUpdate($algoliagroup); 

        return 1;
    }

    public function reject_member_request(Request $request){
        $notification_id= $request->notification_id; 
        $invite = Notification::where('id', $notification_id)->first();
        $grp_details=GroupUser::find($invite->notificationable_id);

        $groupnotification = new Notification;
        $groupnotification->notificationable_id   = $invite->notificationable_id;
        $groupnotification->notificationable_type = 'GroupReject';
        $groupnotification->text                  = strip_tags(member_name($invite->user_id),"<a>").' has rejected the invitation to join <a href="'.route('group_details').'/'.encrypt($invite->notificationable_id).'">'.$grp_details->group_name.'</a> on ';
        $groupnotification->user_id               = $grp_details->user_id;
        $groupnotification->added_by              = $invite->user_id;
        $groupnotification->save();

        $NotificationCount = NotificationCount::where('user_id', $grp_details->user_id)->first();
        if($NotificationCount)
        {
            $NotificationCount->increment('unread_count');
        }
        else
        {
            $NotificationCount = new NotificationCount();
            $NotificationCount->user_id = $grp_details->user_id;
            $NotificationCount->unread_count = 1;
            $NotificationCount->save();
        }
        $redis = LRedis::connection();           
        if( $grp_details->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $grp_details->profile_image))){
            $prof_img_path='uploads/group_images/profile_image/'.$grp_details->profile_image;
        }else{
            $prof_img_path='frontend/images/no-image-event-list.jpg';
        }        
        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
        $redis->publish('user_message'.$grp_details->user_id, $redis_message);

        GroupInvite::where('notification_id', $notification_id)->delete();
        Notification::where('id', $notification_id)->update(['accept_status' => 2]);

       
        return 1;
    }

    //=============== accept moderator =================//
    public function accept_moderator_request(Request $request){
        $notification_id= $request->notification_id; 
        $invite = Notification::where('id', $notification_id)->first();
        //dd($invite);
        $moderator_grp = new GroupUserModerator;
        $moderator_grp->group_id = $invite->notificationable_id;
        $moderator_grp->user_id  = $invite->user_id;
        $moderator_grp->save();
        $grp_details=GroupUser::find($moderator_grp->group_id);
        Notification::where('id', $notification_id)->update(['accept_status' => 1]);

        $groupnotification = new Notification;
        $groupnotification->notificationable_id   = $moderator_grp->group_id;
        $groupnotification->notificationable_type = 'GroupModeratorAccept';
        $groupnotification->text                  = strip_tags(member_name($moderator_grp->user_id),"<a>").' has accepted the invitation to became moderator for <a href="'.route('group_details').'/'.encrypt($moderator_grp->group_id).'">'.$grp_details->group_name.'</a> on ';
        $groupnotification->user_id               = $grp_details->user_id;
        $groupnotification->added_by              = $moderator_grp->user_id;
        $groupnotification->save();

        $NotificationCount = NotificationCount::where('user_id', $grp_details->user_id)->first();
        if($NotificationCount)
        {
            $NotificationCount->increment('unread_count');
        }
        else
        {
            $NotificationCount = new NotificationCount();
            $NotificationCount->user_id = $grp_details->user_id;
            $NotificationCount->unread_count = 1;
            $NotificationCount->save();
        }
        $redis = LRedis::connection();           
        if( $grp_details->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $grp_details->profile_image))){
            $prof_img_path='uploads/group_images/profile_image/'.$grp_details->profile_image;
        }else{
            $prof_img_path='frontend/images/no-image-event-list.jpg';
        }        
        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
        $redis->publish('user_message'.$grp_details->user_id, $redis_message);
        

        return 1;
    }

    public function reject_moderator_request(Request $request){
        $notification_id= $request->notification_id; 
        $invite = Notification::where('id', $notification_id)->first();
        $grp_details=GroupUser::find($invite->notificationable_id);

        $groupnotification = new Notification;
        $groupnotification->notificationable_id   = $invite->notificationable_id;
        $groupnotification->notificationable_type = 'GroupModeratorReject';
        $groupnotification->text                  = strip_tags(member_name($invite->user_id),"<a>").' has rejected the invitation to became moderator for <a href="'.route('group_details').'/'.encrypt($invite->notificationable_id).'">'.$grp_details->group_name.'</a> on ';
        $groupnotification->user_id               = $grp_details->user_id;
        $groupnotification->added_by              = $invite->user_id;
        $groupnotification->save();
        GroupInvite::where('notification_id', $notification_id)->delete();
        Notification::where('id', $notification_id)->update(['accept_status' => 2]);
        $NotificationCount = NotificationCount::where('user_id', $grp_details->user_id)->first();
        if($NotificationCount)
        {
            $NotificationCount->increment('unread_count');
        }
        else
        {
            $NotificationCount = new NotificationCount();
            $NotificationCount->user_id = $grp_details->user_id;
            $NotificationCount->unread_count = 1;
            $NotificationCount->save();
        }
        $redis = LRedis::connection();           
        if( $grp_details->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $grp_details->profile_image))){
            $prof_img_path='uploads/group_images/profile_image/'.$grp_details->profile_image;
        }else{
            $prof_img_path='frontend/images/no-image-event-list.jpg';
        }        
        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
        $redis->publish('user_message'.$grp_details->user_id, $redis_message);
        return 1;
    }
    

    //--------------------------------------- post add --------------------------------///

    public function post_home(Request $request){        
        $user_id = \Auth::guard('user')->user()->id;
        $group_id = $request->groupids;     
        // $group_id = 128;
        
        //foreach ($groupids as $key => $group_id) { 
            $post = new Post;
            if(Input::hasFile('post_image')) {
                $image = $request->file('post_image');                        
               
                $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

                $destinationPath = public_path('uploads/post_images');
                $thumbPath = public_path('uploads/post_images/thumb');
                

                $img = Image::make($image->getRealPath());
                $img->resize(350, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath.'/'.$imagename);  
                 $img = Image::make($image->getRealPath());
                 $img->save($destinationPath.'/'.$imagename);  
                $post->image = $imagename;               
            }
 
            $is_video = 'No';

            if($request->hasFile('post_video')){
                  //$getWebinar=Webinar::where('id',$insertId)->first();
                  $vimeoFile =$request->file('post_video');
                  $response = Vimeo::upload($vimeoFile);

                      $vimeo_request = Vimeo::request($response, array('name'=>'Tawasul','embed' => array('color' => '2bc4e6', 'buttons' => array('fullscreen' => true, 'embed' => false, 'share' => false, 'watchlater' => false, 'like' =>false), 'title' => array('name' => 'hide', 'owner' => 'hide', 'portrait' => 'hide'), 'logos' => array('vimeo' => false)), 'upload' => array('size' => '80000000000'),array('privacy' => array('view'=>'enable','embed'=>'whitelist','add'=>true,'download'=>false, 'comments'=>'nobody'))), 'PATCH');
                      $getData=Vimeo::request($response);
                      if(!empty($getData))
                      {
                         
                        if(isset($getData['body']['embed']['html']))
                        {
                          $post->vimeo_upload="Yes";
                          $post->webinar_code_file=$getData['body']['embed']['html'];
                          $post->vimeo_url=$getData['body']['link'];
                          $uri = explode('/',$getData['body']['uri']);
                          $post->vimeo_video_id = $uri[2];
                          $is_video = 'Yes';
                        }
                  }

            }
           


            $location= $request->location;
            $post->user_id = $user_id;
            $post->text    = $request->post_text;
            $post->location    = "$location";
            $post->type    = 'Group';
            $post->group_id = $group_id;
            $post->save();

            $feed = new Feed;
            $feed->user_id = $user_id;
            $feed->feedable_id = $post->id;
            $feed->type =  'Post';
            $feed->save();

            if($is_video == 'No')
            {
                $redis_recent_update['feed_id'] = $feed->id; 
                $redis = LRedis::connection();
                $group_users = UserGroupUser::select('user_id')->where('group_id',$group_id)->get();
                if(count($group_users))
                {
                    foreach ($group_users as $key => $user) {
                        $group_user_id = $user->user_id;
                        $redis->publish('new_post_update'.$group_user_id, 'Y');
                        $redis->publish('recent_update'.$group_user_id, json_encode($redis_recent_update));
                    }
                }
            }
            else
            {
                return 2; //redirect('/')->with('success', 'Your video has been uploaded successfully, it will be published shortly.');
            }
        //}

            // $userList = \App\UserGroupUser::where('group_id',$group_id)->select('user_id')->get(); 
            // if(count($userList) > 0 && $userList->user_id != $user_id ){

            //     $NotificationCount = NotificationCount::where('user_id', $user_id)->first();
            //     if($NotificationCount)
            //     {
            //         $NotificationCount->increment('unread_count');
            //     }
            //     else
            //     {
            //         $NotificationCount = new NotificationCount();
            //         $NotificationCount->user_id = $userList->user_id;
            //         $NotificationCount->unread_count = 1;
            //         $NotificationCount->save();
            //     }
            // }

            

       //return redirect('/');
        return 1;
    }

    public function cron_video_check()
    {
            $post_list = Post::where('type','Group')->where('vimeo_upload','Yes')->where('is_video_published','No')->get();

            
            if(!empty($post_list))
            {
                foreach ($post_list as $key => $post) {
                    if(time() >=  (strtotime($post->created_at) +120))
                    {
                        
                            $feed = Feed::where('feedable_id',$post->id)->where('type','Post')->first();
                            
                            $redis_recent_update['feed_id'] = $feed['id']; 
                            $redis = LRedis::connection();
                            $group_users = UserGroupUser::select('user_id')->where('group_id',$post->group_id)->get();
                            if(count($group_users))
                            {

                                foreach ($group_users as $key => $user) {
                                    $group_user_id = $user->user_id;
                                    $redis->publish('new_post_update'.$group_user_id, 'Y');
                                    $redis->publish('recent_update'.$group_user_id, json_encode($redis_recent_update));
                                }

                            }
                            $newPost = Post::find($post->id);
                            $newPost->is_video_published = 'Yes';
                            $newPost->save();
                    }
                }

                
            }
    }

    //================================ Occations ==================================//
    public function occation_list()
    {
        $data = array();
        $occationlist =array();
        $occationlists = array();
        
        $user_occations = User:: where('group_id','>','1')->where('status','Active')->groupBy('date_of_birth')->get();
        //dd($user_occations);
        if(!empty($user_occations)){ $i=0;
            foreach($user_occations as $user_occation){
                $date = date('m-d',strtotime("+".$i." days"));
                $dateyr = date('Y-m-d',strtotime("+".$i." days"));
                $join_occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->Where('date_of_joining','like','%'.$date)->select('*')->selectRaw('"DOJ" as field_type');
       			$occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where('date_of_birth','like','%'.$date)->union($join_occations)->select('*')->selectRaw('"DOB" as field_type')->get();
               // $occations = User::where('id','!=',\Auth::guard('user')->user()->id)->where('status','Active')->where(function($query) use ($date){  $query->where('date_of_birth','like','%'.$date)->OrWhere('date_of_joining','like','%'.$date);  })->get();
                //print_r($occations);
                if(!empty($occations)){$j=0;
                    foreach($occations as $occ){    
                        $j++;
                        $occationlist['id']              = $i.$j;
                        $occationlist['user_id']         = $occ['id'];
                        $occationlist['name']            = $occ['display_name'];
                        $occationlist['username']        = $occ['ad_username'];
                        $occationlist['title']           = $occ['title'];
                        $occationlist['profile_photo']   = $occ['profile_photo'];
                        $occationlist['date_of_birth']   = $occ['date_of_birth'];
                        $occationlist['date_of_joining'] = $occ['date_of_joining'];
                        $occationlist['field_type'] 	 = $occ['field_type'];
                        $occationlists[$dateyr][]        = $occationlist;
                    }
                }$i++;
                if(count($occationlists) == 5){
                    break;
                }
            }
        }
        
        //echo count($tests);
        //print_r($occationlists);
        $data['occationlists'] = $occationlists;
        return view('front.occations',$data);
    }

    public function occation_birthday_post($user_id,$login_user_id,$date,$uid)
    {
        $data = array();
        $data['user_id'] = $user_id;
        $data['login_user_id'] = $login_user_id;
        $data['occasion_date'] = $date;
        $data['uid'] = $uid;
        return view('front.occation-birthday',$data);
    }

    public function occation_birthday_submit(Request $request){

       $count_occation = OccationPost::where('type','BDAY')->where('user_id',$request->user_id)->where('occation_date',$request->occasion_date)->first();
        if(count($count_occation)==0){
        $occ_post = new OccationPost;

        $occ_post->user_id = $request->user_id;       
        $occ_post->type    = 'BDAY';        
        $occ_post->occation_date =$request->occasion_date;
        $occ_post->save();

        $feed = new Feed;
        $feed->user_id = $request->user_id;
        $feed->feedable_id = $occ_post->id;
        $feed->type =  'Occasion';
        $feed->save();
        $occ_id = $occ_post->id;
        }else{
           $occ_id = $count_occation->id;
        }
       $comment = new Comment;
       $comment->user_id = $request->login_user_id;
       $comment->body = $request->text;
       $comment->commentable_id = $occ_id;
       $comment->commentable_type ='App\OccationPost';
       $comment->save();

       if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))) {
            $img ='<img src="'.asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo).'" alt=""/>';
           // $img='';

        }else{
            $img='<img src="'.asset('uploads/no_img.png').'" />';
        }
        $html ='<div class="comment-other-single"> <div class="image-div">'.$img.'</div>  <h2><a href="'.Route('user_profile').'/'.($comment->user->ad_username).'">'.\Auth::guard('user')->user()->display_name .'</a><span>'. \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A').'</span></h2><p>'.$request->text.'</p></div>###'.$occ_id;
        return $html;
      
       return 1;
    }

    public function occation_anniversary_post($user_id,$login_user_id,$date,$uid)
    {
        $data = array();
        $data['user_id'] = $user_id;
        $data['login_user_id'] = $login_user_id;
        $data['occasion_date'] = $date;
        $data['uid'] = $uid;
        return view('front.occation-anniversary',$data);
    }

    public function occation_anniversary_submit(Request $request){

       $count_occation = OccationPost::where('type','ANNIVERSARY')->where('user_id',$request->user_id)->where('occation_date',$request->occasion_date)->first();
       if(count($count_occation)==0){
           $occ_post = new OccationPost;
           $occ_post->user_id = $request->user_id;          
           $occ_post->type    = 'ANNIVERSARY';           
           $occ_post->occation_date =$request->occasion_date;
           $occ_post->save();
           
           $feed = new Feed;
           $feed->user_id = $request->user_id;
           $feed->feedable_id = $occ_post->id;
           $feed->type =  'Occasion';
           $feed->save();

           $occ_id = $occ_post->id;
        }else{
           $occ_id = $count_occation->id;
        }
        $comment = new Comment;
        $comment->user_id = $request->login_user_id;
        $comment->body = $request->text;
        $comment->commentable_id = $occ_id;
        $comment->commentable_type ='App\OccationPost';
        $comment->save();
        if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))) {
            $img ='<img src="'.asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo).'" alt=""/>';
           // $img='';

        }else{
            $img='<img src="'.asset('uploads/no_img.png').'" />';
        }
        $html ='<div class="comment-other-single"> <div class="image-div">'.$img.'</div>  <h2><a href="'.Route('user_profile').'/'.($comment->user->ad_username).'">'.\Auth::guard('user')->user()->display_name .'</a><span>'. \DateTime::createFromFormat('Y-m-d H:i:s', $comment->created_at)->format('dS M Y h:i A').'</span></h2><p>'.$request->text.'</p></div>###'.$occ_id;
        return $html;
    }

     public function likeunlikeoccation(Request $request) {
        $post_id = $request->post_id;
        $user_id = \Auth::guard('user')->user()->id;
        $post_likes = Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\OccationPost')->count();
        if($post_likes == 0) {
        $like = new Like;
        $like->user_id        = $user_id;        
        $like->likeable_id    = $post_id;
        $like->likeable_type  = 'App\OccationPost';
        $like->save();
        return '1';        
       }else {
        Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\OccationPost')->delete();
        return '0';
       }

    }

    public function likelistocc($postid,Request $request)  {
        $data= array();
        
        $group_posts = OccationPost::from('users as usr')->join('occation_posts as pst','usr.id','=','pst.user_id')->where('pst.id',$postid)->orderBy('pst.id', 'desc')->first();
        $data['count_like'] = count($group_posts->likes);
        $data['post_likes'] = $group_posts->likes;
        return view('front.groups.like-list',$data);
    }

    public function savepostcommentocc(Request $request){
        $post_id = $request->post_id;
        $comment_text = $request->comment_text;
        $user_id = \Auth::guard('user')->user()->id;
        $comment = new Comment;
        $comment->user_id           = $user_id;
        $comment->body              = $comment_text;
        $comment->commentable_id    = $post_id;
        $comment->commentable_type  = 'App\OccationPost';
        $comment->save();
        Feed::where('feedable_id',$post_id)->where('type','Occasion')->update(['updated_at' => date('Y-m-d H:i:s')]);
        $comment_data = Comment::find($comment->id);
        if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))) {
            $img ='<img src="'.asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo).'" alt=""/>';
           // $img='';

        }else{
            $img='<img src="'.asset('uploads/no_img.png').'" />';
        }
        $html ='<div class="comment-other-single"> <div class="image-div">'.$img.'</div>  <h2><a href="'.Route('user_profile').'/'.($comment->user->ad_username).'">'.\Auth::guard('user')->user()->display_name .'</a><span>'. \DateTime::createFromFormat('Y-m-d H:i:s', $comment_data->created_at)->format('dS M Y h:i A').'</span></h2><p>'.$comment_data->body.'</p></div>';
        return $html;
    }


    //================================ End Occations ==================================//


    /////////////******************* Insert data from Api *******************************////////////

    public function saveDepartment()
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

    }

    public function saveCompany()
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

    }

    public function saveGroup()
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

    }

    public function saveDesignation()
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

    }

    public function saveUser()
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
            $userDetails = User::where('ad_username', $username )->get();
 			
 			//dd($userDetails);
            if($userDetails->count() == 0)
            {
	            $user = new User;
	            $user->ad_username = $username; 
	            $user->title       = $userTitle;
	            $user->email       = $userEmail;
	            //$user->password    = bcrypt($password);
	            $user->display_name = $display_name;
	            $user->group_id    = $group_id;
	            $user->company_id  = $company_id;
	            $user->department_id = $department_id;
	            $user->access_token  = \Hash::make(time());

	            $user->save();
        	}
        }
    }

    /////////////******************* Insert data from Api *******************************////////////


    //////////////////////// Realtime Recent Update ///////////////////////////////////////////

    public function socket_recent_update(Request $request)
    {
        $feeds = Feed::where('id',$request->feed_id)->first();
        $data['today'] = date('Y-m-d');
        $fed = array();
        $is_record_exists = 0;
            if($feeds->type=='Group') {                   
                $feed = $feeds->group;
                if(count($feed)){
                    if($feed->group_type_id==1 && $feed->status=='Active'){
                        if(file_exists( public_path('uploads/group_images/'.$feed->cover_image) )&& ($feed->cover_image!='' || $feed->cover_image!=NULL)) {
                        $fed['image'] ='uploads/group_images/'.'/'.$feed->cover_image ;
                        }else{ 
                        $fed['image'] ='frontend/images/no-image-event-details.jpg';
                        }    
                        
                        if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                        }

                        if(count($feed->profile_image) && file_exists(public_path('uploads/group_images/profile_image/'.$feed->profile_image)) && ($feed->profile_image!=''||$feed->profile_image!=NULL)) {
                            $fed['profile_image'] =  'uploads/group_images/profile_image/'.$feed->profile_image;
                            }
                            else{
                            $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                            }

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;
                        $group_id = encrypt($feed->group_user_id);   
                        $fed['text'] = trans('home.created_new_group');
                        if(strlen($feed->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($feed->group_name,0,20).$add_dot;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $fed['created_at'] = $feed->created_at;
                        
                        $is_record_exists = 1;
                    }
                }
            }
            elseif($feeds->type=='Event') {                   
                $feed = $feeds->event;
                if(count($feed)){
                    if($feed->type_id==1){
                        if(count($feed->event_profile_image) && file_exists(public_path('uploads/event_images/profile_image/'.$feed->event_profile_image))) {
                        $fed['profile_image'] =  'uploads/event_images/profile_image/'.$feed->event_profile_image;
                        }
                        else{
                        $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                        }

                        if(count($feed->eventImage) && file_exists(public_path('uploads/event_images/original/'.$feed->eventImage[0]->image_name))) {
                        $fed['image'] =  'uploads/event_images/original/'.$feed->eventImage[0]->image_name;
                        }
                        else{
                        $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                        }
                        if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                        } 

                        $fed['user_id']     = $feed->user->ad_username;  
                        $fed['user_name']   = $feed->user->display_name;      
                        $fed['text']        = trans('home.created_new_event');
                        $fed['textlink']    = $feed->name;
                        $fed['url']         = route('event_details', encrypt($feed->id));
                        $fed['created_at']  = $feed->created_at;
                        
                        $is_record_exists = 1;

                    }
                }
            }
            elseif($feeds->type=='Post'){
                $feed = $feeds->post;

                if(count($feed)){
                    $type_ids=GroupUser::where('id',$feed->group_id)->first(); 
                    if( $type_ids['group_type_id']==1){
                        if($feed->image != NULL && file_exists(public_path('uploads/post_images/' .$feed->image))){
                    
                        $fed['image'] =  'uploads/post_images/'.$feed->image;
                        }
                        else{
                        $fed['image'] =  'frontend/images/no-image-event-home.jpg';
                        }
                        if($feed->user->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . $feed->user->profile_photo))){
                            $fed['userimage']='uploads/user_images/profile_photo/thumbnails/'.$feed->user->profile_photo;
                        }else{
                            $fed['userimage']='frontend/images/no_user_thumb.png';
                          }

                        if($type_ids['profile_image'] != NULL && file_exists(public_path('uploads/group_images/profile_image/' .$type_ids['profile_image']))){
                    
                        $fed['profile_image'] =  'uploads/group_images/profile_image/'.$type_ids['profile_image'];
                        }
                        else{
                        $fed['profile_image'] =  'frontend/images/no-image-event-list.jpg';
                        }
                       

                        $fed['user_id']= $feed->user->ad_username;  
                        $fed['user_name'] =  $feed->user->display_name;  
                        $group_id = encrypt($feed->group_id);  
                        $fed['text'] =  trans('home.posted_in');
                        if(strlen($type_ids->group_name)>20){$add_dot ='...';}else{ $add_dot ='';}
                        $fed['textlink'] =  substr($type_ids->group_name,0,20).$add_dot;
                        //$fed['textlink'] = $type_ids->group_name;
                        $fed['url'] =Route('group_details').'/'.$group_id;
                        $fed['created_at'] = $feed->created_at;
                        
                        $is_record_exists = 1;
                    }

                }
            }
            if( $is_record_exists == 1)
                return view('front.socket-recent-updates',$fed);
            else
                return '0';
    }

    /////////////////////// Realtime Recent Update ///////////////////////////////////////////

    public function update_notification_count(Request $request)
    {
        $NotificationCount = NotificationCount::where('user_id',$request->user_id)->first();
        $NotificationCount->unread_count = 0;
        $NotificationCount->save();
    }

}
