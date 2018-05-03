<?php

namespace App\Http\Controllers\front;

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
use App\RoleUser;
use App\Department;
use App\Notification;
use App\ArchiveFeed;
use App\ArchivePost;
use App\ArchiveComment;
use App\ArchiveLike;
use App\NotificationCount;
use Illuminate\Contracts\Encryption\DecryptException;
use Image;
use File;
use Mail;
use Vimeo;
use LRedis;


class GroupController extends Controller {
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

         $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");
        $index = $client->initIndex('TAWASUL-Groups');       
        $index->partialUpdateObject($event_algolia_details);
    }
    public function groupAlgoliaDelete($objectid){
        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");
        $index = $client->initIndex('TAWASUL-Groups');        
        $index->deleteObject($objectid);
    }
    public function index($keyword='',Request $request) {       
        $groups = array();
        if($keyword =='') {
            $keyword ='all';
        }       
        $data = array();  
        $user_id = \Auth::guard('user')->user()->id;      
        if($keyword=='all') {          
          // $groups = UserGroupUser::where('user_id',$user_id)->get();  
          // echo $locale = App::getLocale();
           $groups =GroupUser::from('user_group_users as ugu') 
                            ->leftJoin('group_users as grpuser','ugu.group_id', '=','grpuser.id' )
                            ->where('grpuser.status','Active')
                            ->where('ugu.user_id',$user_id)->paginate(15);
          
        }
        elseif($keyword=='global') {
             $groups =GroupUser::from('user_group_users as ugu') 
                            ->join('group_users as grpuser','ugu.group_id', '=', 'grpuser.id')
                            ->where('ugu.user_id',$user_id)
                            ->where('grpuser.status','Active')
                            ->where('grpuser.group_type_id',1)
                            ->paginate(15);                   

        }
        elseif($keyword=='departmental') {
             
             $groups =GroupUser::from('user_group_users as ugu') 
                            ->join('group_users as grpuser', 'ugu.group_id', '=','grpuser.id')
                            ->where('ugu.user_id',$user_id)
                            ->where('grpuser.status','Active')
                            ->where('grpuser.group_type_id',2)
                            ->paginate(15);                

        }
        elseif($keyword=='own'){          
           $groups =GroupUser::where('user_id',$user_id)->where('status','Active')->paginate(15);   
          // dd($groups);            
        }else{
             $groups =GroupUser::from('user_group_users as ugu') 
                            ->join('group_users as grpuser','ugu.group_id', '=', 'grpuser.id')
                            ->where('ugu.user_id',$user_id)
                            ->where('grpuser.status','Active')
                            ->where('grpuser.group_type_id',3)
                            ->paginate(15);       
        }
       //  dd(count($groups));
        $data['groups'] = $groups;
        $data['group_type'] = $keyword;
        //echo $grptype= 'group.'.$keyword.'_group';
        //if($keyword=='own'){ $title = trans('group.group_i_created'); }else{ $title = trans('group.'.$keyword.'');}
        $title='""';
        $data['title'] = $title;
        $data['total_group_count'] = count($groups);
        if ($request->ajax()) { 
            return view('front.groups.data_group',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
        }
        //print_r($data);
        $data['groups'] = [];
        return view('front.groups.group_list',$data);
    }

    public function details($groupid='' ,Request $request) {
        if($groupid==''){             
            return \Redirect::Route('group')->with('error', trans('common.unable_to_access'));
        }else{
            try {            
             $group_id = decrypt($groupid);
            } catch (DecryptException $e) {
                return view('errors.404');
            }
           // echo $group_id = $this->decodeid($groupid);die;
            $data=array();      
            $group_details=GroupUser::find($group_id);
            if(count($group_details)>0){
            $isvalidgroup = UserGroupUser::select('id')->where('group_id',$group_id)->where('user_id',\Auth::guard('user')->user()->id)->count();
            if($isvalidgroup>0 && $group_details->status=='Active'){
            
           // dd($group_details);
            $group_memebers = UserGroupUser::from('user_group_users as ugu')->join('users as usr','usr.id', '=', 'ugu.user_id')->where('ugu.group_id',$group_id)->orderBy('display_name','ASC')->get(); 
            $group_posts = Post::where('type','Group')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.group_id',$group_id)->orderBy('pst.id', 'desc')->paginate(15);
          // dd($group_memebers);
            $memberids= array();
            if(!empty($group_memebers)){
                foreach($group_memebers as $membr) {
                    $memberids[]=$membr->user_id;
                }
            }
            $invited_members = GroupInvite::select('user_id')->where('group_id',$group_id)->get();
            $groupInvite=array();
            if(!empty($invited_members)){
                foreach ($invited_members as $key => $invited_member) {                     
                    $groupInvite[]  = $invited_member->user_id;                  
                }
            }
            //dd($memberids);
            // dd($groupInvite);
            $result_array = array_merge($groupInvite, $memberids);
            //dd($result_array);die;
            $data['group_encode_id'] = $groupid;
            $data['group_details']   = $group_details;           
            $data['group_memebers']  = $group_memebers;
            $data['group_posts']     = $group_posts;
            $data['user_list']       = User::where('status','Active')->where('group_id','>',1)->whereNotIn('id',$result_array)->orderBy('display_name','ASC')->get();
           // dd($group_posts->comment);
           // dd($group_details->owner_id);
            $data['groupid']       = $groupid;
            $data['total_post']     =count($group_posts);
            if($request->ajax()){ 
            return view('front.groups.data_group_details',$data);
            //$view = view('front.groups.data_group',$data)->render();
            //return response()->json(['html'=>$view]);
            }
            //print_r($data);
            $data['group_posts']   = [];
            return view('front.groups.group_details',$data); 
            }else{
                return \Redirect::Route('group')->with('error', trans('common.unable_to_access')); 
               
            }
            }else{
               return view('errors.404'); 
            }
        }
    }
    public function savepost(Request $request) {
        // if(!Input::hasFile('post_image') && $request->post_text=='') {
        //     $this->validate($request, [               
        //             'post_text' => 'required'                
        //         ],
        //         [
                    
        //             'post_text.required'   => trans('group.Either_enter_text_for_post_or_upload_image_file')
        //         ]
        //     );
        //  }

        $user_id = \Auth::guard('user')->user()->id;
        $group_id = $this->decodeid($request->groupid);
        $isvalidgroup = UserGroupUser::select('id')->where('group_id',$group_id)->where('user_id',$user_id)->count();
        if($isvalidgroup>0){
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

                  $vimeo_request = Vimeo::request($response, array('name'=>'Tawasul','embed' => array('buttons' => array( 'embed' => false, 'share' => false, 'watchlater' => false), 'title' => array('name' => 'hide', 'owner' => 'hide', 'portrait' => 'hide'), 'logos' => array('vimeo' => false, 'custom' => array('active' => false, 'sticky' => false))), 'upload' => array('size' => '80000000000'),array('privacy' => array('view'=>'enable','embed'=>'whitelist','add'=>true,'download'=>false, 'comments'=>'nobody'))), 'PATCH');
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
        $post_txt = $request->post_text;
        $location= $request->location;
        $post->user_id = $user_id;
        $post->text    = "$post_txt";
        $post->location    = "$location";
        $post->type    = 'Group';
        $post->group_id = $group_id;
        $post->save();

        $feed = new Feed;
        $feed->user_id = $user_id;
        $feed->feedable_id = $post->id;
        $feed->type =  'Post';
        $feed->save();
        if($is_video == 'Yes')
        {
            return \Redirect::Route('group_details', [$request->groupid])->with('video_message', 'Your video is being processed and will be published shortly');
        }
        else
        {
            return \Redirect::Route('group_details', [$request->groupid]);    
        }
        
        }else{
            return \Redirect::Route('group_details', [$request->groupid])->with('error', trans('common.unable_to_access'));
        }
    }

    public function savepostcomment(Request $request){
        $post_id = $request->post_id;
        $comment_text = $request->comment_text;
        $user_id = \Auth::guard('user')->user()->id;
        $comment = new Comment;
        $comment->user_id           = $user_id;
        $comment->body              = $comment_text;
        $comment->commentable_id    = $post_id;
        $comment->commentable_type  = 'App\Post';
        $comment->save();

        $posts = Post::select('group_id')->find($post_id);

        $grup = GroupUser::select('id','group_type_id','user_id')->find($posts->group_id);
        Feed::where('feedable_id',$post_id)->where('type','Post')->update(['updated_at' => date('Y-m-d H:i:s')]);
        $comment_data = Comment::find($comment->id);
        if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))) {
            $img ='<img src="'.asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo).'" alt=""/>';
           // $img='';

        }else{
            $img='<img src="'.asset('uploads/no_img.png').'" />';
        }

        $comment_delete_permission_global_group =\Auth::user()->can('comment-delete-global-group');
        $comment_delete_permission_departmental_group =\Auth::user()->can('comment-delete-departmental-group');
        $comment_delete_permission_activity_group =\Auth::user()->can('comment-delete-activity-group');
        //echo $grup->id; die;
         if($grup->group_type_id==1) { $permission_delete_comment =$comment_delete_permission_global_group;} elseif($grup->group_type_id==2){ $permission_delete_comment = $comment_delete_permission_departmental_group;} elseif($grup->group_type_id==3){ $permission_delete_comment = $comment_delete_permission_activity_group;}
        if(($grup->user_id == \Auth::guard('user')->user()->id)|| $permission_delete_comment==1 || (is_moderator_group(\Auth::guard('user')->user()->id,encrypt($grup->id))>0)){
            $del_html ='<span style="float: right;"><a href="javascript::void(0);" alt="'.$comment->id.'" data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"><i class="fa fa-times" aria-hidden="true"></i></a></span>&nbsp; ';
        }else{
            $del_html ='';
        }

        $html ='<div class="comment-other-single"> <div class="image-div">'.$img.'</div>  <h2><a href="'.Route('user_profile').'/'.($comment->user->ad_username).'">'.\Auth::guard('user')->user()->display_name .'</a>'.$del_html.'<span>'. \DateTime::createFromFormat('Y-m-d H:i:s', $comment_data->created_at)->format('dS M Y h:i A').'&nbsp;&nbsp;</span></h2><p>'.$comment_data->body.'</p></div>';
        return $html;
        
    }

    public function likeunlike(Request $request) {
        $post_id    = $request->post_id;
        $user_id    = \Auth::guard('user')->user()->id;
        $post_likes = Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\Post')->count();
        if($post_likes == 0) {
            $like = new Like;
            $like->user_id        = $user_id;        
            $like->likeable_id    = $post_id;
            $like->likeable_type  = 'App\Post';
            $like->save();
            return '1';        
       }else {
            Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\Post')->delete();
            return '0';
       }

    }

    public function add(Request $request) { 
        $data = array(); 
        $user_id         = \Auth::guard('user')->user()->id;
        $department_usr  = User::find($user_id);        
        $department_list = Department::get();        
        $data['department_id_user'] = $department_usr->department_id;
        $data['department_list']    = $department_list;

        return view('front.groups.group_add',$data);
    }

    public function savegroup(Request $request) {
        
        $this->validate($request, [               
                'group_name' => 'required',
                'group_description'  => 'required',
                         
            ],
            [
                
                'group_name.required'   => trans('group.Please_give_a_group_name'),
                'group_description.required'   => trans('group.Please_enter_group_description'),
                
            ]
        );
        $count_group=GroupUser::join('group_user_translations','group_user_translations.group_user_id', '=', 'group_users.id')->where('group_user_translations.group_name','=',$request->group_name)->where('group_users.user_id', \Auth::guard('user')->user()->id)->where('group_users.group_type_id',$request->group_type_id)->count();
        if($count_group>0){
            $data['validate'] = 'Error';
            $data['message'] = 'Two group having the same name under same group type, should not be allowed';
            return \Redirect::Route('group')->with('error','Two group having the same name under same group type, should not be allowed'); 
        }else{
        $department_ids    = $request->department_ids;
        //print_r($department_ids);die;
        $dept_id = '';
        if(!empty($department_ids)&&$request->group_type_id==2){
        foreach ($department_ids as $key => $department_id) {
            $dept_id .=$department_id.',';
        }
        }
        $group_type_id     = $request->group_type_id;
        $owner_id          = \Auth::guard('user')->user()->id;
        $group_name        = $request->group_name;
        $group_description = $request->group_description;

        $group_user = new GroupUser;
        if(Input::hasFile('upload_cont_img')) {
            $image = $request->file('upload_cont_img');                        
            
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/group_images');
            $thumbPath = public_path('uploads/group_images/thumb');
            

            $img = Image::make($image->getRealPath());
            $img->resize(1250, 200, function ($constraint) {
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
        $group_user->status        = 'Inactive';
        $group_user->save(); 
        foreach ($this->lang_locales as $locale) {           
            $group_user->translateOrNew($locale->code)->group_name = $group_name;
            $group_user->translateOrNew($locale->code)->group_description = $group_description;
        }
        $group_user->save(); 



        $feed = new Feed;
        $feed->user_id = $owner_id;
        $feed->feedable_id = $group_user->id;
        $feed->type =  'Group';
        $feed->save();

        if($group_type_id==1){
           $users = User::select('id')->where('status','Active')->where('group_id','>',1)->get();
            if(!empty($users)){
                foreach($users as $user){
                    $usergroupusr = new UserGroupUser;
                    $usergroupusr->user_id  = $user->id;
                    $usergroupusr->group_id = $group_user->id;
                    $usergroupusr->save(); 
                }
            }

        }elseif($group_type_id==2){
            if(!empty($department_ids)){
                foreach ($department_ids as $key => $department_id) { 
                    $users = User::select('id')->where('status','Active')->where('department_id',$department_id)->where('group_id','>',1)->get();
                    if(!empty($users)){
                        foreach($users as $user){
                            $usergroupusr = new UserGroupUser;
                            $usergroupusr->user_id  = $user->id;
                            $usergroupusr->group_id = $group_user->id;
                            $usergroupusr->save(); 
                        }
                    }
                }
               $cnt= UserGroupUser::where('user_id',$owner_id)->where('group_id',$group_user->id)->count();
               if($cnt==0){
                   $usergroupusr = new UserGroupUser;
                   $usergroupusr->user_id  = $owner_id;
                   $usergroupusr->group_id = $group_user->id;
                   $usergroupusr->save();  
               }
            }
        }else{
            $usergroupusr = new UserGroupUser;
            $usergroupusr->user_id  = $owner_id;
            $usergroupusr->group_id = $group_user->id;
            $usergroupusr->save(); 
        } 
        $memberlist = UserGroupUser::where('group_id',$group_user->id)->get();
        $member_ids = '';
        if(!empty($memberlist)){
            foreach ($memberlist as $member_id) {
                $member_ids .=$member_id->user_id.',';
            }
        }
        if($group_type_id==1){ $gtype ='Global';}elseif($group_type_id==2){ $gtype='Departmental';}else{ $gtype='Activity';}
        $algoliagroup =array();
        $algoliagroup['groupName_en']       = $group_name;
        $algoliagroup['groupName_ar']       = $group_name;
        $algoliagroup['groupDescription_en']= $group_description;
        $algoliagroup['groupDescription_ar']= $group_description;
        $algoliagroup['groupStatus']        = 'Inactive';
        $algoliagroup['group_encode_id']    = encrypt($group_user->id);
        $algoliagroup['creatorUserID']      = $owner_id;
        $algoliagroup['objectID']           = "group_".$group_user->id;
        $algoliagroup['group_id']           = $group_user->id;       
        $algoliagroup['groupCoverImage']    = "$imagename";
        $algoliagroup['groupProfileImage']  = "$imagename1";
        $algoliagroup['groupType']          = $gtype;
        $algoliagroup['groupMembers']       = rtrim($member_ids,',');
        $algoliagroup['groupDept']          = getDepartmentName(rtrim($dept_id,','));
        $algoliagroup['groupLang']          = 'en';
        $this->groupAlgoliaSave($algoliagroup);
        return \Redirect::Route('group')->with('success', trans('group.group_create_success_msg')); 
        } 
    }
    
    public function edit(Request $request,$id) {        
        //$group_id = $this->decodeid($id);
         try {            
             $group_id = decrypt($id);
            } catch (DecryptException $e) {
                return view('errors.404');
            }
        $data=array(); 
        $data['group_user']=GroupUser::find($group_id); 

        $edit_permission_global_group =\Auth::user()->can('edit-global-group');
        $edit_permission_departmental_group =\Auth::user()->can('edit-departmental-group');
        $edit_permission_activity_group =\Auth::user()->can('edit-activity-group');
        $group_type=$data['group_user']->group_type_id;

          if($group_type==1) { $permission_edit =$edit_permission_global_group;} elseif($group_type==2){ $permission_edit = $edit_permission_departmental_group;} elseif($group_type==3){ $permission_edit = $edit_permission_activity_group;}

        if(((is_moderator_group(\Auth::guard('user')->user()->id,$id)>0) || ($data['group_user']->user_id == \Auth::guard('user')->user()->id) ) || $permission_edit==1)  {
           $data['group_encode_id'] = $id;
            return view('front.groups.group_edit',$data); 
        } else{
            return \Redirect::Route('group')->with('error', trans('common.unable_to_access'));
        } 

        // $data['group_encode_id'] = $id;
        // return view('front.groups.group_edit',$data);
    }

    public function updategroup(Request $request) {
        
        $this->validate($request, [               
                'group_name' => 'required',
                'group_description'  => 'required',
                         
            ],
            [                
                'group_name.required'   => trans('group.Please_give_a_group_name'),
                'group_description.required'   => trans('group.Please_enter_group_description'),
                
            ]
        );
        //echo $request->id; die;
        $group_id          = $this->decodeid($request->id);
        $group_user        = GroupUser::find($group_id);        
        $owner_id          = \Auth::guard('user')->user()->id;
        $group_name        = $request->group_name;
        $group_description = $request->group_description;

       
        if(Input::hasFile('upload_cont_img')) {
            $image = $request->file('upload_cont_img');                        
            
            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/group_images');
            $thumbPath = public_path('uploads/group_images/thumb');
            

            $img = Image::make($image->getRealPath());
            $img->resize(1250, 200, function ($constraint) {
             //   $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);  
             $img = Image::make($image->getRealPath());
             $img->save($destinationPath.'/'.$imagename);  
             File::delete(public_path('uploads/group_images/' . $group_user->cover_image)); 
             File::delete(public_path('uploads/group_images/thumb/' . $group_user->cover_image)); 
            $group_user->cover_image = $imagename;
           
        } else{
            $imagename='';
        }       
       
        if(Input::hasFile('upload_profile_img')) {
            $image1 = $request->file('upload_profile_img');                        
            
            $imagename1 = mt_rand(100,999)."_".time().".".$image1->getClientOriginalExtension();

            $destinationPath1 = public_path('uploads/group_images/profile_image/');
            

            $img1 = Image::make($image1->getRealPath());
            
             $img1->save($destinationPath1.'/'.$imagename1);  
             File::delete(public_path('uploads/group_images/profile_image/' . $group_user->profile_image));
            $group_user->profile_image = $imagename1;
           
        }else{
            $imagename1='';
        }

        $group_user->user_id      = $owner_id;
       
        $group_user->save(); 
        foreach ($this->lang_locales as $locale) {           
            $group_user->translateOrNew($locale->code)->group_name = $group_name;
            $group_user->translateOrNew($locale->code)->group_description = $group_description;
        }
        $group_user->save();

        $algoliagroup =array();
        $algoliagroup['groupName_en']       = $group_name;
        $algoliagroup['groupName_ar']       = $group_name;
        $algoliagroup['groupDescription_en']= $group_description;
        $algoliagroup['groupDescription_ar']= $group_description;        
        $algoliagroup['objectID']           = "group_".$group_id;   
        if( $imagename!='') {
        $algoliagroup['groupCoverImage']    = $imagename;  
        } if( $imagename1!='') {
        $algoliagroup['groupProfileImage']  = $imagename1;
        } 
        $this->groupAlgoliaUpdate($algoliagroup); 

        $usrgrpusr = UserGroupUser::where('group_id',$group_id)->get();
        if(!empty($usrgrpusr)){
            foreach($usrgrpusr as $usrgrp) {
                //echo $usrgrp->user_id;die;
                $groupnotification = new Notification;
                $groupnotification->notificationable_id   = $group_id;
                $groupnotification->notificationable_type = 'GroupUpdate';
                $groupnotification->text                  = ' <a href="'.route('group_details').'/'.$request->id.'">'.group_name($group_id).'</a>  has been edited on ';
                $groupnotification->user_id               = $usrgrp->user_id;
                $groupnotification->added_by              = \Auth::guard('user')->user()->id;
                $groupnotification->save();
            }
        }

        return \Redirect::Route('group')->with('success', trans('group.group_update_success_msg'));  
    }

    public function decodeid($group_id)  {       
         $varnew = decrypt($group_id);
         //$varnew = ( $var - 100 );
         return $varnew;
    }

    public function getAddress(Request $request) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude
            if(!empty($address)){
                return $address;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }

    public function delete_group($id,Request $request) {
        $group_id = $this->decodeid($id);
        $grup=GroupUser::find($group_id);
        $usrgrpusr = UserGroupUser::where('group_id',$group_id)->get();
        if(!empty($usrgrpusr)){
            foreach($usrgrpusr as $usrgrp) {
                $groupnotification = new Notification;
                $groupnotification->notificationable_id   = $group_id;
                $groupnotification->notificationable_type = 'GroupDelete';
                $groupnotification->text                  = '<a href="'.route('group_details').'/'.$id.'">'.group_name($group_id).'</a> '.trans('common.has_been_deleted_on');
                $groupnotification->user_id               = $usrgrp['user_id'];
                $groupnotification->added_by              = \Auth::guard('user')->user()->id;
                $groupnotification->save();
            }
        }
        
        UserGroupUser::where('group_id',$group_id)->delete();
        GroupUserModerator::where('group_id',$group_id)->delete();
        Feed::where('type','=','Group')->where('feedable_id','=',$group_id)->delete();
        $posts = Post::where('group_id',$group_id)->get();
        if(!empty($posts)){
            foreach($posts as $post){
             Feed::where('type','=','Post')->where('feedable_id','=',$posts->id)->delete();   
             Like::where('likeable_id',$post->id)->where('likeable_type','App\Post')->delete();
             Comment::where('commentable_id',$post->id)->where('commentable_type','App\Post')->delete();   
            }
        }
        Post::where('group_id',$group_id)->delete();
        GroupUser::where('id',$group_id)->delete();     
        $this->groupAlgoliaDelete('group_'.$group_id); 
   
        return \Redirect::Route('group')->with('success', trans('group.group_delete_success_msg')); 
        //exit();
        
    }

    public function leave_group($id,$user_id) {
        $group_id = $this->decodeid($id);        
        UserGroupUser::where('group_id',$group_id)->where('user_id',$user_id)->delete(); 
        GroupUserModerator::where('group_id',$group_id)->where('user_id',$user_id)->delete();        
        return \Redirect::Route('group')->with('success', trans('group.group_left_success_msg'));
        
    }

    public function add_moderator($id,$user_id) {
        $group_id = $this->decodeid($id); 
        /*$moderator_grp = new GroupUserModerator;
        $moderator_grp->group_id = $group_id;
        $moderator_grp->user_id  = $user_id;
        $moderator_grp->save();*/
        $noti_cnt=Notification::where('notificationable_id',$group_id)->where('notificationable_type','GroupModerator')->where('user_id',$user_id)->count();
        if($noti_cnt>0)
        {
            return \Redirect::Route('group_details', [$id])->with('success', trans('group.already_send_request'));

        }else{
        $groupnotification = new Notification;
        $groupnotification->notificationable_id   = $group_id;
        $groupnotification->notificationable_type = 'GroupModerator';
        $groupnotification->text                  = "You are requested to be a moderator of group <a href=".route('group_details').'/'.$id.'>'.group_name($group_id).'</a>';
        $groupnotification->user_id               = $user_id;
        $groupnotification->added_by              = \Auth::guard('user')->user()->id;
        $groupnotification->save();

        $NotificationCount = NotificationCount::where('user_id', $user_id)->first();
        if($NotificationCount)
        {
            $NotificationCount->increment('unread_count');
        }
        else
        {
            $NotificationCount = new NotificationCount();
            $NotificationCount->user_id = $user_id;
            $NotificationCount->unread_count = 1;
            $NotificationCount->save();
        }
        $redis = LRedis::connection();

        if( $group_user->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $group_user->profile_image))){
            $prof_img_path='uploads/group_images/profile_image/'.$group_user->profile_image;
        }else{
            $prof_img_path='frontend/images/no-image-event-list.jpg';
        }
        $btntxt ='<input type="button" value="Accept" alt="'.$groupnotification->id.'" class="view_all accept_moderator_noti_id ">&nbsp<input type="button" alt="'.$groupnotification->id.'" value="Reject"  class="view_all reject_moderator_noti_id ">';
        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p> <p id="status_id_notification_'.$groupnotification->id.'" class="notibtn">'.$btntxt.'</div>';

        $redis->publish('user_message'.$user_id, $redis_message);

        $user_details = User::find($user_id);
        $role = RoleUser::where('user_id',$user_id)->where('role_id',3)->count();
        if($role==0) {

            $from_email_admin   =  \App\Sitesetting::where('id', 8)->select('sitesettings_value')->first();
            $toEmail_admin = \App\Sitesetting::where('id', 1)->select('sitesettings_value')->first();
            $toEmail = $toEmail_admin->sitesettings_value;
            $to ='Tawasul';                  
            $fromEmail = $from_email_admin->sitesettings_value;
            $from = 'Tawasul Team';                  
            $subject = 'Tawasul : New Moderator request.';                 
            $data['name']    = $user_details->display_name;
            $data['email']   = $user_details->email;
           // dd($data);
            //$data['message'] = "Thank you for your registration.";
            //print_r($data); die;
            // mail send
            Mail::send('emails.new_moderator', $data, function($sent) use($toEmail,$to,$fromEmail,$from,$subject)
            {
                    $sent->from($fromEmail, $from);                                
                    $sent->to($toEmail, $to)->subject($subject);
            }); 

        }

        return \Redirect::Route('group_details', [$id])->with('success', trans('group.request_success_message'));
        }
    }

     public function group_invite(Request $request)  {
        $userId = $request->userId;
        $group_id = $this->decodeid($request->group_id); 
        foreach ($userId as $key => $user) {

            $groupnotification = new Notification;
            $groupnotification->notificationable_id   = $group_id;
            $groupnotification->notificationable_type = 'GroupMember';
            $groupnotification->text                  = "You are requested to be a member of group <a href=".route('group_details').'/'.$request->group_id.'>'.group_name($group_id).'</a>';
            $groupnotification->user_id               = $user;
            $groupnotification->added_by              = \Auth::guard('user')->user()->id;
            $groupnotification->save();


            $groupInvite = new GroupInvite;
            $groupInvite->group_id = $group_id;
            $groupInvite->notification_id = $groupnotification->id;
            $groupInvite->sender_id = \Auth::guard('user')->user()->id;
            $groupInvite->user_id   = $user;
            $groupInvite->save();

            $NotificationCount = NotificationCount::where('user_id', $user)->first();
            if($NotificationCount)
            {
                $NotificationCount->increment('unread_count');
            }
            else
            {
                $NotificationCount = new NotificationCount();
                $NotificationCount->user_id = $user;
                $NotificationCount->unread_count = 1;
                $NotificationCount->save();
            }
            $redis = LRedis::connection();
            $group_user = GroupUser::where('id',$group_id)->first();
            if( $group_user->profile_image != NULL && file_exists(public_path('uploads/group_images/profile_image/' . $group_user->profile_image))){
                $prof_img_path='uploads/group_images/profile_image/'.$group_user->profile_image;
            }else{
                $prof_img_path='frontend/images/no-image-event-list.jpg';
            }
            $btntxt= '<p id="status_id_notification_'.$groupnotification->id.'" class="notibtn"><input type="button" value="Accept" alt="'.$groupnotification->id.'" class="view_all accept_noti_id ">&nbsp<input type="button" alt="'.$groupnotification->id.'" value="Reject"  class="view_all  reject_noti_id"></p>';
            $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset( $prof_img_path).'&w=68&h=68&q=100" alt=""></div><input type="hidden" name="notification_id" value="'.$groupnotification->id.'" id="h_noti_id" /><p>'.$groupnotification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$btntxt.'</div>';

            $redis->publish('user_message'.$user, $redis_message);

        }
        \Session::flash('success', trans('eventDetails.invitation_sent_successfully'));
        return '1';
    }
    public function likelist($postid,$group_id,Request $request)  {
        $data= array();
        $groupid = $this->decodeid($group_id);
        $group_posts = Post::where('type','Group')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.group_id',$groupid)->where('pst.id',$postid)->orderBy('pst.id', 'desc')->first();
        $data['count_like'] = count($group_posts->likes);
        $data['post_likes'] = $group_posts->likes;
        return view('front.groups.like-list',$data);
    }

    public function delete_post($postid,$group_id,$type='',$user_name=''){
       
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
        if($type == 'event')
        {
            return \Redirect::Route('event_details', [encrypt($group_id)])->with('success', 'Record deleted successfully');  
        } 
        else if($type=='home')  {
            return \Redirect::Route('home')->with('success', 'Record deleted successfully');
        }else if($type=='profile')  {
            return \Redirect::Route('user_profile',[$user_name])->with('success', 'Record deleted successfully');
        } else{
            return \Redirect::Route('group_details', [encrypt($group_id)])->with('success', 'Record deleted successfully');  
        }   
        

    } 

    public function delete_comment($commentid,$group_id,$type='',$user_name=''){ 
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
        if($type == 'event')
        {
            return \Redirect::Route('event_details', [encrypt($group_id)])->with('success', 'Record deleted successfully');  
        } 
        else if($type=='home')  {
            return \Redirect::Route('home')->with('success', 'Record deleted successfully');
        }else if($type=='profile')  {
            return \Redirect::Route('user_profile',[$user_name])->with('success', 'Record deleted successfully');
        } else{
            return \Redirect::Route('group_details', [encrypt($group_id)])->with('success', 'Record deleted successfully');  
        }   
    } 

    public function remove_moderator($id,$user_id) {
        $group_id = $this->decodeid($id);        
        Notification::where('notificationable_id',$group_id)->where('notificationable_type','GroupModerator')->delete(); 
        Notification::where('notificationable_id',$group_id)->where('notificationable_type','GroupModeratorAccept')->delete(); 
        GroupUserModerator::where('group_id',$group_id)->where('user_id',$user_id)->delete();        
        return \Redirect::Route('group_details', [encrypt($group_id)])->with('success', trans('group.group_remove_moderator_success_msg'));
        
    }
   

}