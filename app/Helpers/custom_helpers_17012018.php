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
    $data = '2 days';
   }
   elseif($date>=$prevdateyr && $date < $prevdatemnth){
   
    $data = '2 months';
   }
   elseif($date>=$prevdatemnth && $date < $prevdateweek){
    
    $data = '2 weeks';
   }else{
     
     $data = '2 days';
   }
   return $data;
}

function is_liked_post($user_id,$post_id){  
    $data = \App\Like::where('user_id',$user_id)->where('likeable_id',$post_id)->where('likeable_type','App\Post')->count(); 
    return $data;
}

function has_moderator($group_id){
     $var = base64_decode($group_id);
     $varnew = ( $var - 100 );
     $data = \App\GroupUserModerator::where('group_id',$varnew)->count(); 
    
    return $data;
}

function is_moderator_group($user_id,$group_id){
     $var = base64_decode($group_id);
     $varnew = ( $var - 100 );
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