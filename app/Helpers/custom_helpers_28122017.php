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