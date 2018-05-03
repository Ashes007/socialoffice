<?php

function isActiveRoute($menuArr)
{
	$currentPrefix =  Route::getCurrentRoute()->getPrefix();
	$mainMenu = explode('/', $currentPrefix);
	$selectMenu = $mainMenu[1];
	if(in_array($selectMenu , $menuArr))
	{
		return 'active';
	}
	else
	{
		return '';
	}

	//return 
}


function getFileIcon($type){
    
    switch(strtolower($type)){
        case 'text':
            $class = 'fa fa-file-text-o';
            break;
        case 'xlsx':
        case 'xls' :    
            $class = 'fa fa-file-excel-o';
            break;
        case 'doc':
        case 'docx':
            $class = 'fa fa-file-word-o';
            break;
        case 'pdf':
            $class = 'fa fa-file-pdf-o';
            break;
        case 'jpg':
        case 'jpeg':
        case 'gif':
        case 'png':                
            $class = 'fa fa-file-photo-o';
            break;
        case 'ppt':
            $class = 'fa fa-file-powerpoint-o';
            break;
        case 'zip':
            $class = 'fa fa-file-zip-o';
            break;
        case 'rar':
            $class = 'fa fa-file-zip-o';
            break;            

        default:
            $class = 'fa fa-file';
            break;
        
            
    }
    
    return $class;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function convertTimeToUSERzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){
    if(empty($str)){
        return '';
    }
        
    $new_str = new DateTime($str, new DateTimeZone('UTC') );
    $new_str->setTimeZone(new DateTimeZone( $userTimezone ));
    return $new_str->format( $format);
}

function get_memeber_group($group_id){  
    $data = \App\UserGroupUser::where('group_id',$group_id)->count(); 
    return $data;
}

function active_memeber_group($datetime){
   $datetm = explode(' ',$datetime);
   $date = $datetm[0]; 
   $prevdateyr   = date("Y-m-d",strtotime("-1 year"));
   $prevdatemnth = date("Y-m-d",strtotime("-1 month"));
   $prevdateweek = date("Y-m-d",strtotime("-1 week"));
   if($date<$prevdateyr){
    $data = '2 '.trans('common.days');
   }
   elseif($date>=$prevdateyr && $date < $prevdatemnth){
   
    $data = '2 '.trans('common.months');
   }
   elseif($date>=$prevdatemnth && $date < $prevdateweek){
    
    $data = '2 '.trans('common.weeks');
   }else{
     
     $data = '2 '.trans('common.days');
   }
   return $data;
}

function is_liked_post($user_id,$post_id){  
    $data = \App\Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\Post')->count(); 
    return $data;
}
function is_liked_occasion($user_id,$post_id){  
    $data = \App\Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\OccationPost')->count(); 
    return $data;
}

function has_moderator($group_id){
     $varnew = decrypt($group_id);
     //$varnew = ( $var - 100 );
     $data = \App\GroupUserModerator::where('group_id',$varnew)->count(); 
    
    return $data;
}

function is_moderator_group($user_id,$group_id){
     $varnew = decrypt($group_id);
     //$varnew = ( $var - 100 );
     $data = \App\GroupUserModerator::where('group_id',$varnew)->where('user_id',$user_id)->count(); 
    
    return $data;
}

function is_member_group($user_id,$group_id){
    $data = \App\UserGroupUser::where('group_id',$group_id)->where('user_id',$user_id)->count(); 
    
    return $data;

}
function group_name($group_id){
    $data = \App\GroupUser::where('id',$group_id)->first(); 
    
    return $data->group_name;

}
function group_type($group_id){ 
   $data = \App\GroupUser::where('id',$group_id)->first(); 
   // dd($data);
    return $data->group_type_id;

}

function member_name($user_id){
   $data = \App\User::where('id',$user_id)->first(); 
   // dd($data);
    return '<a href="'.route("user_profile").'/'.$data->ad_username.'">'.$data->display_name.'</a>';

}

function eventInviteCheck($event_id,$user_id){
   $data = \App\EventInvite::where('event_id', '=',$event_id)->where('user_id', '=',$user_id)->count();

   return $data;

}
function alreadywish($user_id,$login_user_id,$type,$date){
   // echo $user_id.'@@'.$login_user_id.'@@'.$type.'@@'.$date;
   // $data = \App\OccationPost::where('user_id', '=',$user_id)->where('post_by', '=',$login_user_id)->where('type', '=',$type)->where('occation_date', '=',$date)->count();
     $data = \App\OccationPost::where('user_id', '=',$user_id)->where('type', '=',$type)->where('occation_date', '=',$date)->first();
    // dd($data);
     if(!empty($data)){
        $occ_id = $data->id;
         $count_cmnt = \App\Comment::where('commentable_type', '=','App\OccationPost')->where('commentable_id',$occ_id)->where('user_id', '=',$login_user_id)->count(); 
     }else{
        $count_cmnt =0;
     }
    
    //echo $data;    
   return $count_cmnt;
}
function moderatorRequestCheck($group_id,$user_id){
   $varnew = decrypt($group_id);   
   $noti_cnt= \App\Notification::where('notificationable_id',$varnew)->where('notificationable_type','GroupModerator')->where('user_id',$user_id)->count();
   
    if($noti_cnt>0){
        return '1';
    }else{
        return '0';
    }

}

function getDepartmentName($department_ids)
{
    $department = array();

    $d_id = explode(',', $department_ids);
    $result = \App\DepartmentTranslation::where('locale','en')->whereIn('department_id',$d_id)->get();

    if(count($result)>0)
    {
        foreach ($result as $key => $value) {
            $department[]  =   $value->name;
        }
    }

    $names = implode(', ',$department);
    return $names;    
}


function getDepartmentGroupName($department_ids)
{
    $department = array();

    $d_id = explode(',', $department_ids);
    $result = \App\GroupUserTranslation::where('locale','en')->whereIn('group_user_id',$d_id)->get();

    if(count($result)>0)
    {
        foreach ($result as $key => $value) {
            $department[]  =   $value->group_name;
        }
    }

    $names = implode(', ',$department);
    return $names;    
}

function getDetailsGroupEvent($description){
    return strip_tags($description);
}
function havePostEventGroup($id,$type){
    if($type=='Event'){
         $cnt = \App\Post::where('type','Event')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.event_id',$id)->orderBy('pst.id', 'desc')->count();
    }elseif($type=='Group'){
        $cnt = \App\Post::where('type','Group')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.group_id',$id)->orderBy('pst.id', 'desc')->count();
    }else{
         $cnt = \App\OccationPost::where('user_id',$id)->count();
    }
    return $cnt;
}
function isbirthday($user_id){
    $date = date('m-d');
    if(\Auth::guard('user')->user()->id == $user_id)
    {
        $cnt =0;
    }else{
        $cnt = \App\User::where('id',$user_id)->where('date_of_birth','like','%'.$date)->count();  
    }    
    return $cnt;
}
function isanniversary($user_id){
    $date = date('m-d');
    if(\Auth::guard('user')->user()->id == $user_id)
    {
        $cnt =0;
    }else{
    $cnt = \App\User::where('id',$user_id)->where('date_of_joining','like','%'.$date)->count();
    }
    return $cnt;
}
function get_owner_group($group_id){  
    $data = \App\GroupUser::where('id',$group_id)->first(); 
    return $data->user_id;
}


function notification_count($user_id){  
    $data = \App\NotificationCount::where('user_id',$user_id)->first(); 
    if($data)
        return $data['unread_count'];
    else
        return 0;
}