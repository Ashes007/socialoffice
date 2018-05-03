<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\GroupUser;
use App\UserGroupUser;
use App\Language;
use App\Post;
use App\Feed;
use App\Comment;
use App\Like;
use App\GroupUserModerator;
use App\GroupUserTranslation;
use App\User;
use App\GroupInvite;
use App\Notification;
use App\Department;
use App\ArchiveFeed;
use App\ArchivePost;
use App\ArchiveComment;
use App\ArchiveLike;
use App\NotificationCount;
use DB;
use Image;
use File;
use Mail;
use LRedis;

class GroupController extends Controller
{
    public $management = 'Group';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $postMode = 'Post';
    public $listUrl = 'group_list';

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
                ['label' => $this->management.' '.$this->listMode, 'url' => \URL::route($this->listUrl)],
                ['label' => 'Create', 'url' => 'THIS']
            ],                                 
        'EDITPAGE' => 
            [
                ['label' => $this->management.' '.$this->listMode, 'url' => \URL::route($this->listUrl)],
                ['label' => 'Edit', 'url' => 'THIS']
            ] ,
       'POSTPAGE' => 
            [
                ['label' => $this->management.' '.$this->listMode, 'url' => \URL::route($this->listUrl)],
                ['label' => 'Post', 'url' => 'THIS']
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
        }elseif(\Route::current()->getActionMethod()=='view_posts'){
            \View::share(['pageType' => $this->postMode]); 
        }
    }

    public function groupAlgoliaSave($event_algolia_details){

        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");
        $index = $client->initIndex('TAWASUL-Groups');
        $batch = array();
        foreach ($event_algolia_details as $key => $value) {
            $object[$key]=$value;
        }
        array_push($batch,$object);
        $index->addObjects($batch);
    }
    public function groupAlgoliaUpdate($event_algolia_details){
       // print_r($event_algolia_details);
        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");
        $index = $client->initIndex('TAWASUL-Groups');       
        $index->partialUpdateObject($event_algolia_details);
    }
    public function index()
    {
    	$data['group_list'] = GroupUser::get();
       // dd($data['group_list']);        
    	return view('admin.group.list',$data);
    }

    public function statusChange(Request $request)
    {
        $id = $request->id;
        $record = GroupUser::find($id); 
        if($record->status == 'Active')
        {
            $record->status = 'Disapprove';
            $status = '<span class="ion-android-close"></span>';
            //$status = '<span class="fa fa-hourglass-start"></span>';
            $algoliagroup=array();
            $algoliagroup['groupStatus']= 'Inactive';        
            $algoliagroup['objectID']  = 'group_'.$id;
            $this->groupAlgoliaUpdate($algoliagroup);
        }
        else
        {
            $varnew = encrypt($id);
            //$varnew = ( $var - 100 );
            //echo $varnew;die;
            $record->status = 'Active';
            $status = '<span class="ion-checkmark"></span>';
            $algoliagroup['groupStatus']= 'Active';        
            $algoliagroup['objectID']  = 'group_'.$id;
            $this->groupAlgoliaUpdate($algoliagroup);           
        }
        $record->save();
        echo $status;
    }
    
    public function statusChangeApprove(Request $request) {
    $id = $request->id;
    $record = GroupUser::find($id);

    $varnew = encrypt($id);
    //$varnew = ( $var - 100 );
    //echo $varnew;die;
    if($record->status=='Inactive'){
        $record->status = 'Active';
        $status = '<span class="ion-checkmark"></span>';
        $usrgrpusr = UserGroupUser::where('group_id',$id)->get();
        if(!empty($usrgrpusr)){
           foreach ($usrgrpusr as $usrgrp) {
            
            $groupnotification = new Notification;
            $groupnotification->notificationable_id   = $id;
            $groupnotification->notificationable_type = 'GroupInsert';
            $groupnotification->text                  = 'A new group <a href="'.route('group_details').'/'.$varnew.'">'.$record->group_name.'</a> has been published on ';
            $groupnotification->user_id               = $usrgrp->user_id;
            $groupnotification->added_by              = $record->user_id;
            $groupnotification->save();
            }
        }
        $record->save();
        $algoliagroup['groupStatus']= 'Active';        
        $algoliagroup['objectID']  = 'group_'.$id;
        $this->groupAlgoliaUpdate($algoliagroup); 
        echo $status;
    }else{
        $record->status = 'Active';
        $status = '<span class="ion-checkmark"></span>';
        $record->save();
        $algoliagroup['groupStatus']= 'Active';        
        $algoliagroup['objectID']  = 'group_'.$id;
        $this->groupAlgoliaUpdate($algoliagroup);
        echo $status;
    }
        
    }

    public function statusChangeDisapprove(Request $request) {
        $id     = $request->id;
        $record = GroupUser::find($id);
        $reason = $request->reason;
        $alt    = $request->alt;
        $varnew = encrypt($id);
        //$varnew = ( $var - 100 );
        //echo $varnew;die;
        $record->status = 'Disapprove';
        $record->disapprove_reason = $reason;
        // if($alt=='inactive_approve'){
        //    $status = '<span class="ion-android-close"></span>'; 
        // }else{
        //    $status = '<span class="ion-checkmark"></span>';
        // } 
        $from_email_admin   =  \App\Sitesetting::where('id', 8)->select('sitesettings_value')->first();                              
        $fromEmail          = $from_email_admin->sitesettings_value;
        $from               = 'Tawasul Team'; 

        $toEmail            = 'epsita@matrixnmedia.com'; //$record->user->email;
        $to                 = $record->user->display_name;                 
        $subject            = 'Group Disapprove';                 
        $data['name']       = $record->user->display_name;
        $data['group_name'] = $record->group_name;
        $data['reason']     = $reason;
        $data['content_message']    = "Your group: '".$record['group_name']."'' has been disapproved, because: ".$reason;    


        Mail::send('emails.disapprove_status', $data, function($sent) use($toEmail,$to,$fromEmail,$from,$subject)
        {
                $sent->from($fromEmail, $from);                                
                $sent->to($toEmail, $to)->subject($subject);
        }); 
        $status = '<span class="ion-android-close"></span>'; 
        $record->save();
        $algoliagroup['groupStatus']= 'Inactive';        
        $algoliagroup['objectID']  = 'group_'.$id;
        $this->groupAlgoliaUpdate($algoliagroup);
        echo $status;        
    }

    public function add()
    {
        $data = array();
        //$data['group_list'] = EventType::where('status','Active')->get();
        return view('admin.group.add',$data);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
                'group_image'   => 'required',
                'group_image'   => 'max:2000',
                'group_image'   => 'dimensions:min_width=1280',
                'upload_profile_img'   => 'max:2000',
                'upload_profile_img'   => 'dimensions:max_width=300',
                'upload_profile_img'   => 'dimensions:max_height=300',
                'name.*'        => 'required',
                'description.*' => 'required'
                
            ],
            [
                'group_image.required'      => 'Please select group cover image',
                'group_image.max'           => 'Uploaded image size maximum 2MB allowed',
                'group_image.dimensions'    => 'Please select atleast 1250 pixel image',
                'upload_profile_img.max'    => 'Uploaded image size maximum 2MB allowed',
                'upload_profile_img.dimensions'=> 'Please select maximum 300px image',
                'upload_profile_img.dimensions'=> 'Please select maximum 300px image',
                'name.en.required'          => 'Please enter group name for English',
                'name.ar.required'          => 'Please enter group name for Arabic',
                'description.en.required'   => 'Please enter group description for English',
                'description.ar.required'   => 'Please enter group description for Arabic'
            ]
        );
        $dept_id='';
        $group_type_id     = $request->group_type_id;
        $owner_id          = 1;
        $group_name        = $request->name;
        $group_description = $request->description;

        $group_user = new GroupUser;
        if(Input::hasFile('group_image')) {
            $image = $request->file('group_image');                        
            
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/group_images');
            $thumbPath = public_path('uploads/group_images/thumb');
            

            $img = Image::make($image->getRealPath());
            $img->resize(1280, 382, function ($constraint) {
             //   $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);  
             $img = Image::make($image->getRealPath());
             $img->save($destinationPath.'/'.$imagename);  
            $group_user->cover_image = $imagename;
           
        }else{
            $imagename ='';
        }

        if(Input::hasFile('upload_profile_img')) {
            $image1 = $request->file('upload_profile_img');                        
            
            $imagename1 = mt_rand(100,999)."_".time().".".$image1->getClientOriginalExtension();

            $destinationPath1 = public_path('uploads/group_images/profile_image/');
            

            $img1 = Image::make($image1->getRealPath());
            
             $img1->save($destinationPath1.'/'.$imagename1);  
            $group_user->profile_image = $imagename1;
           
        }else{
            $imagename1 ='';
        }


        $group_user->department_id = rtrim($dept_id,',');
        $group_user->group_type_id = $group_type_id;
        $group_user->user_id      = $owner_id;
        $group_user->status        = 'Active';
        $group_user->created_at   = date('Y-m-d H:i:s');
        $group_user->save(); 

        foreach ($this->lang_locales as $locale) {           
            $group_user->translateOrNew($locale->code)->group_name = $request->name[$locale->code];
            $group_user->translateOrNew($locale->code)->group_description = $request->description[$locale->code];
        }

        $group_user->save(); 

        if($group_type_id==1){ $gtype ='Global';}elseif($group_type_id==2){ $gtype='Departmental';}else{ $gtype='Activity';}
        $algoliagroup =array();
        $algoliagroup['groupName_en']       = $group_name['en'];
        $algoliagroup['groupName_ar']       = $group_name['ar'];
        $algoliagroup['groupDescription_en']= $group_description['en'];
        $algoliagroup['groupDescription_ar']= $group_description['ar'];
        $algoliagroup['group_encode_id']    = encrypt($group_user->id);
        $algoliagroup['groupStatus']        = 'Active';
        $algoliagroup['creatorUserID']      = $owner_id;
        $algoliagroup['objectID']           = "group_".$group_user->id;
        $algoliagroup['group_id']           = $group_user->id;
        $algoliagroup['groupCoverImage']    = $imagename;
        $algoliagroup['groupProfileImage']  = $imagename1;
        $algoliagroup['groupType']          = $gtype;
        $algoliagroup['groupDept']          = getDepartmentName(rtrim($dept_id,','));
        $algoliagroup['groupLang']          = 'en';
        $this->groupAlgoliaSave($algoliagroup);

        $feed = new Feed;
        $feed->user_id = $owner_id;
        $feed->feedable_id = $group_user->id;
        $feed->type =  'Group';
        $feed->save();

        if($group_type_id==1) {
           $users = User::select('id')->where('status','Active')->where('group_id','>',1)->get();
            if(!empty($users)){
                foreach($users as $user){
                    $usergroupusr = new UserGroupUser;
                    $usergroupusr->user_id  = $user->id;
                    $usergroupusr->group_id = $group_user->id;
                    $usergroupusr->save(); 


                    $groupnotification = new Notification;
                    $groupnotification->notificationable_id   = $group_user->id;
                    $groupnotification->notificationable_type = 'GroupInsert';
                    $groupnotification->text                  = ' <a href="'.route('group_details').'/'.encrypt($group_user->id).'">'.group_name($group_user->id).'</a>  has been added on ';
                    $groupnotification->user_id               = $user->id;
                    $groupnotification->added_by              = 1;
                    $groupnotification->save();

                    $NotificationCount = NotificationCount::where('user_id', $user->id)->first();
                    if($NotificationCount)
                    {
                        $NotificationCount->increment('unread_count');
                    }
                    else
                    {
                        $NotificationCount = new NotificationCount();
                        $NotificationCount->user_id = $user->id;
                        $NotificationCount->unread_count = 1;
                        $NotificationCount->save();
                    }
                    $redis = LRedis::connection();           
                    if( $group_user->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $group_user->profile_image))){
                        $prof_img_path='uploads/group_images/profile_image/'.$group_user->profile_image;
                    }else{
                        $prof_img_path='frontend/images/no-image-event-list.jpg';
                    }        
                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
                    $redis->publish('user_message'.$user->id, $redis_message);
                }
            }
        }
        

    return \Redirect::Route('group_list')->with('success', 'Group added successfully');   
    }

    public function edit($id)
    {
        //$data['eventtype_list'] = EventType::where('status','Active')->get();
        $data['details'] = GroupUser::find($id);
        //dd($data['details']);
        return view('admin.group.edit',$data);
    }

    public function update(Request $request,$id)
    {
           $this->validate($request, [
                'group_image'   => 'max:2000',
                'group_image'   => 'dimensions:min_width=1280',
                'upload_profile_img'   => 'max:2000',
                'upload_profile_img'   => 'dimensions:max_width=300',
                'upload_profile_img'   => 'dimensions:max_height=300',
                'name.*'        => 'required',
                'description.*' => 'required'
                
            ],
            [
                'group_image.max'           => 'Uploaded image size maximum 2MB allowed',
                'group_image.dimensions'    => 'Please select atleast 1250 pixel image',
                'upload_profile_img.max'    => 'Uploaded image size maximum 2MB allowed',
                'upload_profile_img.dimensions'=> 'Please select maximum 300px image',
                'upload_profile_img.dimensions'=> 'Please select maximum 300px image',
                'name.en.required'          => 'Please enter group name for English',
                'name.ar.required'          => 'Please enter group name for Arabic',
                'description.en.required'   => 'Please enter group description for English',
                'description.ar.required'   => 'Please enter group description for Arabic'
            ]
        );
        if($request->status=='Disapprove'){
        $this->validate($request, [
            
            'disapprove_reason' => 'required'
            
        ],
        [            
            'disapprove_reason.required'   => 'Please enter disapprove reason'
        ]
        );

        }

        $dept_id='';
        $group_type_id     = $request->group_type_id;
        //$owner_id          = 1;
        $group_name        = $request->name;
        $group_description = $request->description;
        $disapprove_reason = $request->disapprove_reason;

        $group_user = GroupUser::find($id);
        
        if(Input::hasFile('group_image')) {
            $image = $request->file('group_image');                        
            $file1 = 'uploads/group_images/'.$group_user->cover_image;
            $file2 = 'uploads/group_images/thumb/'.$group_user->cover_image;
            
            File::delete($file1, $file2);
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/group_images');
            $thumbPath = public_path('uploads/group_images/thumb');
            

            $img = Image::make($image->getRealPath());
            $img->resize(1280, 382, function ($constraint) {
             //   $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);  
             $img = Image::make($image->getRealPath());
             $img->save($destinationPath.'/'.$imagename);  
            $group_user->cover_image = $imagename;           
           
        }else{
            $imagename='';
        }

        if(Input::hasFile('upload_profile_img')) {
            $image1 = $request->file('upload_profile_img');                        
             $file3 = 'uploads/group_images/profile_image/'.$group_user->profile_image;
            File::delete($file3);
            $imagename1 = mt_rand(100,999)."_".time().".".$image1->getClientOriginalExtension();

            $destinationPath1 = public_path('uploads/group_images/profile_image/');
            

            $img1 = Image::make($image1->getRealPath());
            
             $img1->save($destinationPath1.'/'.$imagename1);  
            $group_user->profile_image = $imagename1;
        }else{
           $imagename1 =''; 
        }


        //$group_user->department_id = rtrim($dept_id,',');
        $group_user->group_type_id = $group_type_id;
        //$group_user->user_id      = $owner_id;
        $group_user->status        = $request->status;

        if($request->status=='Disapprove'){
            $group_user->disapprove_reason =   $disapprove_reason;
            $from_email_admin   =  \App\Sitesetting::where('id', 8)->select('sitesettings_value')->first();                              
            $fromEmail          = $from_email_admin->sitesettings_value;
            $from               = 'Tawasul Team'; 

            $toEmail            = 'epsita@matrixnmedia.com'; //$record->user->email;
            $to                 = $group_user->user->display_name;                 
            $subject            = 'Group Disapprove';                 
            $data['name']       = $group_user->user->display_name;
            $data['group_name'] = $group_user->group_name;
            $data['reason']     = $disapprove_reason;
            $data['content_message']    = "Your group: '".$group_user['group_name']."'' has been disapproved, because: ".$disapprove_reason;
            Mail::send('emails.disapprove_status', $data, function($sent) use($toEmail,$to,$fromEmail,$from,$subject)
            {
               $sent->from($fromEmail, $from);                                
               $sent->to($toEmail, $to)->subject($subject);
            }); 
        }
        $group_user->created_at   = date('Y-m-d H:i:s');
        $group_user->save(); 
        foreach ($this->lang_locales as $locale) {           
            $group_user->translateOrNew($locale->code)->group_name = $request->name[$locale->code];
            $group_user->translateOrNew($locale->code)->group_description = $request->description[$locale->code];
        }

        $group_user->save(); 
        $algoliagroup =array();
        $algoliagroup['groupName_en']       = $group_name['en'];
        $algoliagroup['groupName_ar']       = $group_name['ar'];
        $algoliagroup['groupDescription_en']= $group_description['en'];
        $algoliagroup['groupDescription_ar']= $group_description['ar'];
        $algoliagroup['groupStatus']        = $request->status;        
        $algoliagroup['objectID']           = "group_".$id;   
        if( $imagename!='') {
        $algoliagroup['groupCoverImage']    = $imagename;  
        } if( $imagename1!='') {
        $algoliagroup['groupProfileImage']  = $imagename1;
        } 
        $this->groupAlgoliaUpdate($algoliagroup); 

       Feed::where('type', 'Group')
          ->where('feedable_id', $id)
          ->update(['created_at' => date('Y-m-d H:i:s')]);
       
       $usrgrpusr = UserGroupUser::where('group_id',$id)->get();
        if(!empty($usrgrpusr)){
            foreach($usrgrpusr as $usrgrp) {
                //echo $usrgrp->user_id;die;
                $groupnotification = new Notification;
                $groupnotification->notificationable_id   = $id;
                $groupnotification->notificationable_type = 'GroupUpdate';
                $groupnotification->text                  = ' <a href="'.route('group_details').'/'.encrypt($id).'">'.group_name($id).'</a>  has been edited on ';
                $groupnotification->user_id               = $usrgrp->user_id;
                $groupnotification->added_by              = 1;
                $groupnotification->save();

                 $NotificationCount = NotificationCount::where('user_id', $usrgrp->user_id)->first();
                if($NotificationCount)
                {
                    $NotificationCount->increment('unread_count');
                }
                else
                {
                    $NotificationCount = new NotificationCount();
                    $NotificationCount->user_id = $usrgrp->user_id;
                    $NotificationCount->unread_count = 1;
                    $NotificationCount->save();
                }
                $redis = LRedis::connection();           
                if( $group_user->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $group_user->profile_image))){
                    $prof_img_path='uploads/group_images/profile_image/'.$group_user->profile_image;
                }else{
                    $prof_img_path='frontend/images/no-image-event-list.jpg';
                }        
                $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
                $redis->publish('user_message'.$usrgrp->user_id, $redis_message);
            }
        }
        

    return \Redirect::Route('group_list')->with('success', 'Group updated successfully');  
    }

    public function delete($id)
    {
        $group = GroupUser::find($id);
       // Notification::where('notificationable_id','=',$group->id)->where('notificationable_type','=','GroupModerator')->orWhere('notificationable_type','=','GroupMember')->orWhere('notificationable_type','=','GroupUpdate')->orWhere('notificationable_type','=','GroupDelete')->orWhere('notificationable_type','=','GroupInsert')->orWhere('notificationable_type','=','GroupAccept')->orWhere('notificationable_type','=','GroupReject')->orWhere('notificationable_type','=','GroupModeratorAccept')->orWhere('notificationable_type','=','GroupModeratorReject')->delete();
        Notification::where('notificationable_id','=',$group->id)->where('notificationable_type','like','%Group%')->where('notificationable_type','!=','GroupDelete')->delete();
        GroupInvite::where('group_id','=',$group->id)->delete();
        $usrgrpusr = UserGroupUser::where('group_id',$group->id)->get();
        if(!empty($usrgrpusr)){
            foreach($usrgrpusr as $usrgrp) {                
                $groupnotification = new Notification;
                $groupnotification->notificationable_id   = $id;
                $groupnotification->notificationable_type = 'GroupDelete';
                $groupnotification->text                  = group_name($id).'</a>  has been deleted on ';
                $groupnotification->user_id               = $usrgrp->user_id;
                $groupnotification->added_by              = 1;
                $groupnotification->save();

                $redis = LRedis::connection();           
                if( $group->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $group->profile_image))){
                    $prof_img_path='uploads/group_images/profile_image/'.$group->profile_image;
                }else{
                    $prof_img_path='frontend/images/no-image-event-list.jpg';
                }        
                $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';
                $redis->publish('user_message'.$usrgrp->id, $redis_message);
            }
        }
        Feed::where('type','=','Group')->where('feedable_id','=',$group->id)->delete();
        $getposts=Post::where('type','=','Group')->where('group_id','=',$group->id)->get();
        if(!empty($getposts)){
            foreach($getposts as $posts){
               Feed::where('type','=','Post')->where('feedable_id','=',$posts->id)->delete(); 
               Comment::where('commentable_type','=','App\Post')->where('commentable_id','=',$posts->id)->delete();
               Like::where('likeable_type','=','App\Post')->where('likeable_id','=',$posts->id)->delete(); 
            }
        }
        Post::where('type','=','Group')->where('group_id','=',$group->id)->delete();

       /* $file1 = 'uploads/group_images/'.$group->cover_image;
        $file2 = 'uploads/group_images/thumb/'.$group->cover_image;
        $file3 = 'uploads/group_images/profile_image/'.$group->profile_image;
        File::delete($file1, $file2,$file3);*/
        UserGroupUser::where('group_id','=',$group->id)->delete();
        GroupUserModerator::where('group_id','=',$group->id)->delete();
        $group->delete();
        return \Redirect::Route('group_list')->with('success', 'Record deleted successfully');
    } 

    public function view_posts($id,Request $request){

        $group_posts = Post::where('type','Group')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.group_id',$id)->orderBy('pst.id', 'desc')->paginate(10);
        $data['group_posts'] = $group_posts;
        $data['group_id'] = $id;
        return view('admin.group.view-post',$data);
    }  

    public function delete_post($postid,$group_id,$type=''){
       
        $feeds = Feed::where('type','=','Post')->where('feedable_id','=',$postid)->get();
        if(!empty($feeds)){
            foreach($feeds as $feed){
                $havefeed= ArchiveFeed::find($feed->id);
                if(count($havefeed)==0){
                    $archive_feed_insert                = new ArchiveFeed;
                    $archive_feed_insert->id            = $feed->id;
                    $archive_feed_insert->user_id       = $feed->user_id;
                    $archive_feed_insert->feedable_id   = $feed->feedable_id;
                    $archive_feed_insert->type          = $feed->type;
                    $archive_feed_insert->created_at    = $feed->created_at;
                    $archive_feed_insert->updated_at    = $feed->updated_at;
                    $archive_feed_insert->save();
                }                
            }
        Feed::where('type','=','Post')->where('feedable_id','=',$postid)->delete(); 
       }

       $comments = Comment::where('commentable_type','=','App\Post')->where('commentable_id','=',$postid)->get();
        if(!empty($comments)){
            foreach($comments as $comment){
                $havecomment= ArchiveComment::find($comment->id);
                if(count($havecomment)==0){
                $archive_comment_insert                  = new ArchiveComment;
                $archive_comment_insert->id              = $comment->id;
                $archive_comment_insert->user_id         = $comment->user_id;
                $archive_comment_insert->body            = $comment->body;
                $archive_comment_insert->commentable_id  = $comment->commentable_id;
                $archive_comment_insert->commentable_type= $comment->commentable_type;
                $archive_comment_insert->created_at      = $comment->created_at;
                $archive_comment_insert->updated_at      = $comment->updated_at;
                $archive_comment_insert->save();
                }

            }
        Comment::where('commentable_type','=','App\Post')->where('commentable_id','=',$postid)->delete();   
        }
       
       $likes = Like::where('likeable_type','=','App\Post')->where('likeable_id','=',$postid)->get();
        if(!empty($likes)){
            foreach($likes as $like){
                $havelike= ArchiveLike::find($like->id);
                if(count($havelike)==0){
                $archive_like_insert                  = new ArchiveLike;
                $archive_like_insert->id              = $like->id;
                $archive_like_insert->user_id         = $like->user_id;
                $archive_like_insert->likeable_id     = $like->likeable_id;
                $archive_like_insert->likeable_type   = $like->likeable_type;                
                $archive_like_insert->created_at      = $like->created_at;
                $archive_like_insert->updated_at      = $like->updated_at;
                $archive_like_insert->save();
                }

            }
        Like::where('likeable_type','=','App\Post')->where('likeable_id','=',$postid)->delete();    
        }
        $posts = Post::where('id',$postid)->get();
        if(!empty($posts)){
            foreach($posts as $post){
                $havepost= ArchivePost::find($post->id);
                if(count($havepost)==0){
                $archive_post_insert              = new ArchivePost;
                $archive_post_insert->id          = $post->id;
                $archive_post_insert->user_id     = $post->user_id;
                $archive_post_insert->text        = $post->text;
                $archive_post_insert->image       = $post->image;   
                $archive_post_insert->type        = $post->type; 
                $archive_post_insert->event_id    = $post->event_id; 
                $archive_post_insert->group_id    = $post->group_id; 
                $archive_post_insert->location    = $post->location;             
                $archive_post_insert->created_at  = $post->created_at;
                $archive_post_insert->updated_at  = $post->updated_at;
                $archive_post_insert->save();
                }

            }
        Post::where('id',$postid)->delete();
        } 
        if($type==''){
          return \Redirect::Route('group_posts', [$group_id])->with('success', 'Record deleted successfully');
        }else{
          return \Redirect::Route('event_posts', [$group_id])->with('success', 'Record deleted successfully');
        }      

    } 

    public function delete_comment($commentid,$group_id,$type=''){ 
        $comments = Comment::where('commentable_type','=','App\Post')->where('id','=',$commentid)->get();
        if(!empty($comments)){
            foreach($comments as $comment){
                $havecomment= ArchiveComment::find($comment->id);
                if(count($havecomment)==0){
                $archive_comment_insert                  = new ArchiveComment;
                $archive_comment_insert->id              = $comment->id;
                $archive_comment_insert->user_id         = $comment->user_id;
                $archive_comment_insert->body            = $comment->body;
                $archive_comment_insert->commentable_id  = $comment->commentable_id;
                $archive_comment_insert->commentable_type= $comment->commentable_type;
                $archive_comment_insert->created_at      = $comment->created_at;
                $archive_comment_insert->updated_at      = $comment->updated_at;
                $archive_comment_insert->save();
                }
            }
        Comment::where('commentable_type','=','App\Post')->where('id','=',$commentid)->delete();  
        }
             
        if($type==''){
         return \Redirect::Route('group_posts', [$group_id])->with('success', 'Record deleted successfully');
        }else{
         return \Redirect::Route('event_posts', [$group_id])->with('success', 'Record deleted successfully');
        }

    } 

    public function likelist($postid,$group_id,Request $request){
        $data= array();
        $groupid = $this->decodeid($group_id);
        $group_posts = Post::where('type','Group')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.group_id',$groupid)->where('pst.id',$postid)->orderBy('pst.id', 'desc')->first();
        $data['count_like'] = count($group_posts->likes);
        $data['post_likes'] = $group_posts->likes;
        return view('admin.group.like-list',$data);
    }
}

