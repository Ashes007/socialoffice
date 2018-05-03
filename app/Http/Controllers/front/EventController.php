<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Event;
use App\EventType;
use App\User;
use App\UserFollower;
use App\EventAttend;
use App\Comment;
use App\EventInvite;
use Image, File;
use Auth;
use Vimeo;
use App\EventImage;
use App\Notification;
use App\Post, App\Feed;
use App\NotificationCount;
use LRedis;

require base_path('vendor/autoload.php');
require base_path('vendor/algolia/algoliasearch-client-php/algoliasearch.php');

class EventController extends Controller
{

    public function eventAlgoliaSave($event_algolia_details){

        $client = new \AlgoliaSearch\Client("YSH65GN3MY", "ffbeeae2ddb6eb225e77af5c9e0adfd0");

        $index = $client->initIndex('TAWASUL-Events');

        $batch = array();
        foreach ($event_algolia_details as $key => $value) {
            $object[$key]=$value;
        }
        array_push($batch,$object);
        $index->addObjects($batch);
    }

    public function index(Request $request)
    {
        

        $userId        = auth()->guard('user')->user()->id;
        $today          = date('Y-m-d');
        $tomorrow       = date('Y-m-d', strtotime($today. '+ 1 days'));
        $weekStartDate  = date("Y-m-d H:i:s", strtotime('monday this week'));
        $weekEndDate    = date("Y-m-d 11:59:59", strtotime('sunday this week'));
        $firstDayMonth  = date('Y-m-01 00:00:00');
        $lastDayMonth   = date('Y-m-t 11:59:59');

        $eventDay = $request->route('eventDay');

        $fromDate   = $request->from;
        $toDate     = $request->end;

        $limit              = config('constant.event_list_per_page');
        $data['limit']      = $limit;         
        $data['today']      = $today;
        $data['eventDay']   = $eventDay;
        $data['user_id']    = $userId;


        // if($request->route('username')!='' && $request->route('username')!= \Auth::guard('user')->user()->ad_username){
        //     $data['currentuser'] = User::where('ad_username', $request->route('username'))->first();
        //     $data['logedInUser'] = false;
        //     $data['isFollow'] = UserFollower::where('user_id',\Auth::guard('user')->user()->id)->where('follower_id', $data['currentuser']->id)->first();            
        // }else{
        //     $data['currentuser'] = User::find(\Auth::guard('user')->user()->id);
        //     $data['logedInUser'] = true;          
        // }
        $data['fromDate']   = '';
        $data['toDate']     = '';
        $data['isSearch'] = 'No';
        if($eventDay == 'search')
        {
            if($fromDate != '' && $toDate != '')
            {
                $data['isSearch'] = 'Yes';
                $expFromDate = explode('-', $fromDate);
                $expToDate = explode('-', $toDate);
                $searchFromDate = $expFromDate[2]."-".$expFromDate[1]."-".$expFromDate[0];
                $searchToDate = $expToDate[2]."-".$expToDate[1]."-".$expToDate[0];

                $data['eventList'] = Event::where('status','Active')
                                      ->where(function($q) use ($searchFromDate, $searchToDate){
                                        $q->whereBetween('event_start_date',[$searchFromDate, $searchToDate])
                                        ->orWhereBetween('event_end_date',[$searchFromDate, $searchToDate])
                                        ->orWhereRaw("'".$searchFromDate."' BETWEEN event_start_date AND event_end_date");
                                    })
                                    ->whereHas('invites',function($query) use ($userId){
                                        $query->where('user_id','=',$userId);
                                    })
                                    ->orderBy('event_start_date','DESC')
                                    ->limit($limit)->offset('0')->get();
                
                $data['fromDate']   = $fromDate;
                $data['toDate']     = $toDate;
            }
            else
            {
                return \Redirect::Route('event','month')->with('error', '');
            }
        }

       elseif($eventDay == 'own')
        {
           $data['eventList'] = Event::where('user_id', $userId)
                                ->orderBy('id','DESC')
                                ->limit($limit)->offset('0')->get();   
        }

        elseif($eventDay == 'today')
        {
    	   $data['eventList'] = Event::where('status','=','Active')->where('event_start_date', $today)
                                ->whereHas('invites',function($query) use ($userId){
                                    $query->where('user_id','=',$userId);
                                })
                                ->limit($limit)->offset('0')->get();   
        }
        elseif($eventDay == 'tomorrow')	
        {
            $data['eventList'] = Event::where('status','=','Active')
            ->where(function($q) use ($tomorrow){
                $q->where('event_start_date', $tomorrow)
                ->orWhereRaw("'".$tomorrow."' BETWEEN event_start_date AND event_end_date");
            })
            ->whereHas('invites',function($query) use ($userId){
                        $query->where('user_id','=',$userId);
                    })
           ->limit($limit)->offset('0')->get();
        }
        elseif($eventDay == 'week')
        {
            $data['eventList'] = Event::where('status','=','Active')
                    ->where(function($q) use ($weekStartDate, $weekEndDate){
                        $q->whereBetween('event_start_date',[$weekStartDate, $weekEndDate])
                        ->orWhereBetween('event_end_date',[$weekStartDate, $weekEndDate])
                        ->orWhereRaw("'".$weekStartDate."' BETWEEN event_start_date AND event_end_date");
                    })
                    //->where('event_end_date','>',$today)
                    ->whereHas('invites',function($query) use ($userId){
                        $query->where('user_id','=',$userId);
                    })
                ->orderBy('event_start_date','DESC')->limit($limit)->offset('0')->get();
        }

        elseif($eventDay == 'month')
        {
            $data['eventList'] = Event::where('status','Active')
            ->where(function($q) use ($firstDayMonth, $lastDayMonth){
                $q->whereBetween('event_start_date',[$firstDayMonth, $lastDayMonth])
                ->orWhereBetween('event_end_date',[$firstDayMonth, $lastDayMonth])
                ->orWhereRaw("'".$firstDayMonth."' BETWEEN event_start_date AND event_end_date");
            })
            //->where('event_end_date','>',$today)
            ->whereHas('invites',function($query) use ($userId){
                $query->where('user_id','=',$userId);
            })
            ->orderBy('event_start_date','DESC')->limit($limit)->offset('0')->get();
        }
        else
        {
            return view('errors.404');
        }

        $data['isInvited'] = EventInvite::where('user_id', '=',$userId)->count();
        return view('front.events.event_list',$data);
    }

    public function ajax_event(Request $request)
    {
        $userId        = auth()->guard('user')->user()->id;
        $data['isInvited'] = EventInvite::where('user_id', '=',$userId)->count();

        $today          = date('Y-m-d');
        $tomorrow       = date('Y-m-d', strtotime($today. '+ 1 days'));
        $weekStartDate  = date("Y-m-d H:i:s", strtotime('monday this week'));
        $weekEndDate    = date("Y-m-d 11:59:59", strtotime('sunday this week'));
        $firstDayMonth  = date('Y-m-01 00:00:00');
        $lastDayMonth   = date('Y-m-t 11:59:59');

        $eventDay       = $request->post('event');
        $offset         = $request->post('offset');

        $fromDate       = $request->from;
        $toDate         = $request->end;

        $limit              = config('constant.event_list_per_page');
        $data['limit']      = $limit;         
        $data['today']      = $today;
        $data['eventDay']   = $eventDay;
        $data['user_id']    = $userId;

        $data['isSearch'] = 'No';
        if($eventDay == 'search')
        {
            if($fromDate != '' && $toDate != '')
            {
                $data['isSearch'] = 'Yes';
                $expFromDate = explode('-', $fromDate);
                $expToDate = explode('-', $toDate);
                $searchFromDate = $expFromDate[2]."-".$expFromDate[1]."-".$expFromDate[0];
                $searchToDate = $expToDate[2]."-".$expToDate[1]."-".$expToDate[0];

                $data['eventList'] = Event::where('status','Active')
                                     ->where(function($q) use ($searchFromDate, $searchToDate){
                                            $q->whereBetween('event_start_date',[$searchFromDate, $searchToDate])
                                            ->orWhereBetween('event_end_date',[$searchFromDate, $searchToDate])
                                            ->orWhereRaw("'".$searchFromDate."' BETWEEN event_start_date AND event_end_date");
                                        })
                                    ->whereHas('invites',function($query) use ($userId){
                                        $query->where('user_id','=',$userId);
                                    })
                                    ->orderBy('event_start_date','DESC')
                                    ->limit($limit)->offset($offset)->get();
            }
        } 
        if($eventDay == 'own')
        {
            $data['eventList'] = Event::where('user_id', $userId)
                                 ->orderBy('id','DESC')   
                                ->limit($limit)->offset($offset)->get();   
        }     

        if($eventDay == 'today')
        {
            $data['eventList'] = Event::where('status','=','Active')->where('event_start_date', $today)
                            ->whereHas('invites',function($query) use ($userId){
                                $query->where('user_id','=',$userId);
                            })
                            ->limit($limit)->offset($offset)->get();   
        }
        if($eventDay == 'tomorrow')
        {   
            $data['eventList'] = Event::where('status','=','Active')
             ->where(function($q) use ($tomorrow){
                $q->where('event_start_date', $tomorrow)
                ->orWhereRaw("'".$tomorrow."' BETWEEN event_start_date AND event_end_date");
            })
             ->whereHas('invites',function($query) use ($userId){
                        $query->where('user_id','=',$userId);
                    })

            ->limit($limit)->offset($offset)->get();
        }

        if($eventDay == 'week')
        {
            $data['eventList'] = Event::where('status','=','Active')
                    ->where(function($q) use ($weekStartDate, $weekEndDate){
                        $q->whereBetween('event_start_date',[$weekStartDate, $weekEndDate])
                        ->orWhereBetween('event_end_date',[$weekStartDate, $weekEndDate])
                        ->orWhereRaw("'".$weekStartDate."' BETWEEN event_start_date AND event_end_date");
                    })
                    //->where('event_end_date','>',$today)
                    ->whereHas('invites',function($query) use ($userId){
                        $query->where('user_id','=',$userId);
                    })

                    ->orderBy('event_start_date','DESC')->limit($limit)->offset($offset)->get();
        }
        if($eventDay == 'month')
        {
            $data['eventList'] = Event::where('status','Active')
            ->where(function($q) use ($firstDayMonth, $lastDayMonth){
                $q->whereBetween('event_start_date',[$firstDayMonth, $lastDayMonth])
                ->orWhereBetween('event_end_date',[$firstDayMonth, $lastDayMonth])
                ->orWhereRaw("'".$firstDayMonth."' BETWEEN event_start_date AND event_end_date");
            })
            //->where('event_end_date','>',$today)
            ->whereHas('invites',function($query) use ($userId){
                $query->where('user_id','=',$userId);
            })
            ->orderBy('event_start_date','DESC')->limit($limit)->offset($offset)->get();
        }
        if(count($data['eventList']) > 0)
        {
          echo view('front.events.event_list_ajax',$data);
        }
        else
        {
          echo "0";
        }
    }

    public function createEvent(){
        
       $data = array();
       return view('front.events.create-event',$data);
       // if(auth()->guard('user')->user()->can('add-event')){
    	// 	echo 'ok';
    	// }else{
    	// 	return view('front.access_denied');
    	// }

    }

    public function addEvent(Request $request)
    {
        $userId        = auth()->guard('user')->user()->id;
        $user = User::find($userId);

        $this->validate($request, [
                'eventName'     => 'required',
                'event_image'   => 'max:2000',
                'event_image'   => 'dimensions:min_width=1280',                
                'event_start_date' => 'required',
                'event_end_date' => 'required'
            ],
            [
                'event_image.max'           => trans('eventController.Uploaded_image_size_maximum_2MB_allowed'),
                'event_image.dimensions'    => trans('eventController.Please_select_atleast_1280_pixel_image'),
            ]
        );

        $event               = new Event();
        $event->type_id      = 1;
        if($request->event_type != '')
        {
            $event->type_id      = $request->event_type;
        }
        
        $event->user_id      = $userId;
        $event->location     = $request->location;

        if($request->event_start_date != '' && $request->event_end_date != '')
        {
            $event->event_start_date = \DateTime::createFromFormat('d/m/Y', $request->event_start_date)->format('Y-m-d');
            $event->event_end_date = \DateTime::createFromFormat('d/m/Y', $request->event_end_date)->format('Y-m-d');
        }
        $event->status       = 'Inactive';   

        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $event_start_time = '';
        $event_end_time = '';

        

        if($request->allday_event == 'Yes') 
            $allday_event = 'Yes';
        else
        {
            $allday_event = 'No';
            $event_start_time = \DateTime::createFromFormat('H:i', $start_time)->format('h:i A');
            $event_end_time = \DateTime::createFromFormat('H:i', $end_time)->format('h:i A');
            
                $event->start_time = \DateTime::createFromFormat('H:i', $start_time)->format('h:i A');
                $event->end_time = \DateTime::createFromFormat('H:i', $end_time)->format('h:i A');
           
            
        }

        $event->allday_event = $allday_event;

        foreach ($this->lang_locales as $locale) {
            $event->translateOrNew($locale->code)->name = $request->eventName;
            $event->translateOrNew($locale->code)->description = $request->description;
  
        }

        $event_profile_image = 'no_profile_image.jpg';
        if($request->file('upload_profile_img'))
        {
            $image = $request->file('upload_profile_img');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $originalPath = public_path('uploads/event_images/profile_image');         

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $event->event_profile_image = $imagename;
            $event_profile_image = $imagename;
        }

        $event->save();

        // $eventAttend = new EventAttend;
        // $eventAttend->user_id   =  $userId;
        // $eventAttend->event_id  =  $event->id;
        // $eventAttend->attend_status = '1'; 
        // $eventAttend->save();         

        $feed = new Feed();
        $feed->user_id = $userId;
        $feed->feedable_id = $event->id;
        $feed->type = 'Event';
        $feed->save();

        
        

        if($event->type_id == 1)
        {
            $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
            foreach ($userList as $key => $user) {
                $eventInvite = new EventInvite;
                $eventInvite->sender_id = $userId;
                $eventInvite->user_id   = $user->id;
                $eventInvite->event_id  = $event->id;
                $eventInvite->save();

                // $notification = new Notification();
                // $notification->notificationable_id = $event->id;
                // $notification->notificationable_type = 'Event';
                // $notification->text = 'A new event has been posted';
                // $notification->added_by = $userId;
                // $notification->user_id  = $user->id;
                // $notification->save();
            }
        }

        if($event->type_id == 2)
        {
            $department_id = auth()->guard('user')->user()->department_id;
            $userList = User::where('status','=','Active')->where('group_id','>',1)->where('department_id',$department_id)->get();
            foreach ($userList as $key => $user) {
                $eventInvite = new EventInvite;
                $eventInvite->sender_id = $userId;
                $eventInvite->user_id   = $user->id;
                $eventInvite->event_id  = $event->id;
                $eventInvite->save();

                // $notification = new Notification();
                // $notification->notificationable_id = $event->id;
                // $notification->notificationable_type = 'Event';
                // $notification->text = 'A new event has been posted';
                // $notification->added_by = $userId;
                // $notification->user_id  = $user->id;
                // $notification->save();
            }
        }
        
        if($event->type_id == 3)
        {
            $eventInvite = new EventInvite;
            $eventInvite->sender_id = $userId;
            $eventInvite->user_id   = $userId;
            $eventInvite->event_id  = $event->id;
            $eventInvite->save();

        }

        

        if($request->file('upload_cont_img'))
        {
            $image = $request->file('upload_cont_img');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $thumbPath = public_path('uploads/event_images/thumbnails');
            $originalPath = public_path('uploads/event_images/original');

            $img = Image::make($image->getRealPath());
            $img->resize(376, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);               

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $eventImage             = new EventImage;
            $eventImage->image_name = $imagename;
            $eventImage->event_id   = $event->id;
            $eventImage->save();
        }

        ///////////// For Algolia ////////////////////////////////////////

   
                    $event_algolia_details = array();
                    
                    $event_algolia_details['eventName']       = $request->eventName;
                    $event_algolia_details['eventStartDate']  = $request->event_start_date;
                    $event_algolia_details['eventEndDate']    = $request->event_end_date;
                    $event_algolia_details['alldayEvent']     = $allday_event;
                    $event_algolia_details['eventStartTime']  = $event_start_time;
                    $event_algolia_details['eventEndTime']    = $event_end_time;                    
                    $event_algolia_details['creatorUserID']   = $userId;
                    $event_algolia_details['creatorUserName'] = $user->display_name;
                    $event_algolia_details['objectID']        = "event_".$event->id;
                    $event_algolia_details['event_id']        = $event->id;
                    $event_algolia_details['eventStatus']     = $event->status;
                    $event_algolia_details['eventImage']      = $eventImage->image_name;  
                    $event_algolia_details['eventProfileImage']= $event_profile_image;
                    $event_algolia_details['eventLang']       = 'en';
                    $event_algolia_details['eventDescription']= $request->description;
                    $event_algolia_details['encryptId']       = encrypt($event->id);

                    
                    $this->eventAlgoliaSave($event_algolia_details);
       

        ///////////// For Algolia ////////////////////////////////////////  

       return \Redirect::Route('event','month')->with('success', trans('eventController.You_have_Successfully_Submitted_an_Event_for_admin_approval'));
    }

    public function editEvent(Request $request){

        $data = array();
        $userId             = auth()->guard('user')->user()->id;
        $eventId            = decrypt($request->route('id'));
        $data['record']     = Event::find($eventId);
        return view('front.events.edit-event',$data);

    }

    public function updateEvent(Request $request)
    {
        $userId        = auth()->guard('user')->user()->id;
        $eventId       = decrypt($request->route('id'));

        $event               = Event::find($eventId);
        
        
        $event->user_id      = $userId;
        $event->location     = $request->location;

        if($request->event_start_date != '' && $request->event_end_date != '')
        {
            $event->event_start_date = \DateTime::createFromFormat('d/m/Y', $request->event_start_date)->format('Y-m-d');
            $event->event_end_date = \DateTime::createFromFormat('d/m/Y', $request->event_end_date)->format('Y-m-d');
        }

        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $event_start_time = '';
        $event_end_time = '';
        $eventImageName =  '';

        if($request->allday_event == 'Yes') 
        {
            $allday_event = 'Yes';
            $event->start_time = NULL;
            $event->end_time = NULL;
        }
        else
        {
            $allday_event = 'No';
            $event->start_time = \DateTime::createFromFormat('H:i', $start_time)->format('h:i A');
            $event->end_time = \DateTime::createFromFormat('H:i', $end_time)->format('h:i A');  

            $event_start_time = $event->start_time;  
            $event_end_time = $event_end_time;    
            
        }

        $event->allday_event = $allday_event;

        foreach ($this->lang_locales as $locale) {
            $event->translateOrNew($locale->code)->name = $request->eventName;
            $event->translateOrNew($locale->code)->description = $request->description;
  
        }
        $event_profile_image = 'no_profile_image.jpg';
        if($request->file('upload_profile_img'))
        {
            $image = $request->file('upload_profile_img');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $originalPath = public_path('uploads/event_images/profile_image');         

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $event->event_profile_image = $imagename;
            $event_profile_image        = $imagename;
        }

        $event->save();

    
        if($request->file('upload_cont_img'))
        {
            $image = $request->file('upload_cont_img');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $thumbPath = public_path('uploads/event_images/thumbnails');
            $originalPath = public_path('uploads/event_images/original');

            $img = Image::make($image->getRealPath());
            $img->resize(376, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);               

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $eventImage = EventImage::where('event_id', $event->id)->get();
            foreach ($eventImage as $key => $image) {
                $file1 = 'uploads/event_images/original/'.$image->image_name;
                $file2 = 'uploads/event_images/thumbnails/'.$image->image_name;
                File::delete($file1, $file2);
                $image->delete();
            }

            $eventImage             = new EventImage;
            $eventImage->image_name = $imagename;
            $eventImage->event_id   = $event->id;
            $eventImage->save();

            $eventImageName = $imagename;
        }


        if($event->status == 'Active')
        {
            $redis = LRedis::connection();

            if($event->type_id == 1)
            {
                $userId = $event->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {
                    if($userId != $user->id)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $event->id;
                        $notification->notificationable_type = 'EventEdit';                        
                        $notification_txt = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.trans('eventController.has_been_edited_on');
                        $notification->text = $notification_txt;
                        $notification->added_by = $userId;
                        $notification->user_id  = $user->id;
                        $notification->save();

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

                        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                        $redis->publish('user_message'.$user->id, $redis_message);
                    }
                }
            }

            if($event->type_id == 2)
            {
                $userId = $event->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->where('department_id',$department_id)->get();
                foreach ($userList as $key => $user) {

                    if($userId != $user->id)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $event->id;
                        $notification->notificationable_type = 'EventEdit';
                        $notification_txt = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.trans('eventController.has_been_edited_on');
                        $notification->text = $notification_txt;
                        $notification->added_by = $userId;
                        $notification->user_id  = $user->id;
                        $notification->save();

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

                        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                        $redis->publish('user_message'.$user->id, $redis_message);
                    }
                }
            }

            if($event->type_id == 3)
            {
                $userId = $event->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = EventInvite::where('event_id','=',$event->id)->get();
                foreach ($userList as $key => $user) {
                    if($userId != $user->user_id)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $event->id;
                        $notification->notificationable_type = 'EventEdit';
                        $notification_txt = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.trans('eventController.has_been_edited_on');
                        $notification->text = $notification_txt;
                        $notification->added_by = $userId;
                        $notification->user_id  = $user->user_id;
                        $notification->save();

                        $NotificationCount = NotificationCount::where('user_id', $user->user_id)->first();

                        if($NotificationCount)
                        {
                            $NotificationCount->increment('unread_count');
                        }
                        else
                        {
                            $NotificationCount = new NotificationCount();
                            $NotificationCount->user_id = $user->user_id;
                            $NotificationCount->unread_count = 1;
                            $NotificationCount->save();
                        }

                        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                        $redis->publish('user_message'.$user->user_id, $redis_message);
                    }
                }
            }
        }

        ///////////// For Algolia ////////////////////////////////////////

   
                    $event_algolia_details = array();
                    
                    $event_algolia_details['eventName']       = $request->eventName;
                    $event_algolia_details['eventStartDate']  = $request->event_start_date;
                    $event_algolia_details['eventEndDate']    = $request->event_end_date;
                    $event_algolia_details['alldayEvent']     = $allday_event;
                    $event_algolia_details['eventStartTime']  = $event_start_time;
                    $event_algolia_details['eventEndTime']    = $event_end_time;                    
                    $event_algolia_details['creatorUserID']   = $userId;
                    $event_algolia_details['creatorUserName'] = $user->display_name;
                    $event_algolia_details['objectID']        = "event_".$event->id;
                    $event_algolia_details['event_id']        = $event->id;
                    $event_algolia_details['eventStatus']     = $event->status;
                    if($eventImageName != '')
                    {
                        $event_algolia_details['eventImage']      = $eventImageName;    
                    }
                    
                    $event_algolia_details['eventProfileImage']= $event_profile_image;
                    $event_algolia_details['eventLang']       = 'en';
                    $event_algolia_details['eventDescription']= $request->description;
                    $event_algolia_details['encryptId']       = encrypt($event->id);

                    
                    $this->eventAlgoliaSave($event_algolia_details);
       

        ///////////// For Algolia ////////////////////////////////////////

       return \Redirect::Route('event','own')->with('success', trans('eventController.Your_event_has_been_updated_successfully'));
    }

    public function calendar(request $request)
    {   
        if($request->route('username')!='' && $request->route('username')!= \Auth::guard('user')->user()->ad_username){
            $data['currentuser'] = User::where('ad_username', $request->route('username'))->first();
            $data['logedInUser'] = false;
            $data['isFollow'] = UserFollower::where('user_id',\Auth::guard('user')->user()->id)->where('follower_id', $data['currentuser']->id)->first();            
        }else{
            $data['currentuser'] = User::find(\Auth::guard('user')->user()->id);
            $data['logedInUser'] = true;       
        }

        $data['eventType'] = EventType::where('status','Active')->get();
        $data['eventList'] = Event::where('status','Active')->select('id','event_start_date','event_end_date','start_time','end_time','type_id','allday_event')->get();
        
        $data['userInfo'] = User::select('id','birth_day','birth_month','anniversary_day','anniversary_month','display_name')->where('status','Active')->get();
        return view('front.events.calendar',$data);
    }
	
    

    public function details(Request $request){
        $userId         = auth()->guard('user')->user()->id;

        try {
            $eventId        = decrypt($request->route('id'));
        } catch (DecryptException $e) {
            return view('errors.404');
        }
        

        $is_exists = Event::find($eventId);
        if($is_exists == '')
        {
            return view('errors.404');
             //return \Redirect::Route('event','today')->with('error', trans('eventController.Unable_to_access'));   
        }
       
        //$eventId = 104;
        $logged_in_user = Auth::guard('user')->user()->id;
        $data['today'] = date('Y-m-d');
        $data['isInvited'] = EventInvite::where('event_id','=',$eventId)->where('user_id', '=',$userId)->count();

       //  $invite = EventInvite::where('event_id','=',$eventId)
       // // ->with('InviteRequests')
       //  ->get();
      
       //  $invite        = EventInvite::where('event_id','=',$eventId)
       //                              ->whereDoesntHave('InviteRequests', function($event_pending_query) use ($eventId){

       //                               })->get();
       // //  // echo '<pre>';
       // //  // print_r($invite->toArray());
       // //  // exit;
       // //  // echo $eventId;
       //  foreach ($invite as $key => $iv) {
       //      echo '<br/>'.$iv->user_id;
       //      $dd = $iv->InviteRequests;
       //      dd($dd);
       //  }

       //  exit;

        $data['event_attend']       = EventAttend::where('event_id','=',$eventId)->whereIn('attend_status', [1])->get();
        $data['event_tentetive']    = EventAttend::where('event_id','=',$eventId)->whereIn('attend_status', [3,4])->get();
        $data['event_cancel']       = EventAttend::where('event_id','=',$eventId)->whereIn('attend_status', [2,6])->get();
        $event_pending_query        = EventInvite::where('event_id','=',$eventId)
                                    ->whereDoesntHave('InviteRequests', function($event_pending_query) use ($eventId){
                                        $event_pending_query->where('event_id','=',$eventId); 
                                     })->get();



        $data['event_pending']      = $event_pending_query;
        $data['attend_user_count']  = EventAttend::where('event_id','=',$eventId)->where('attend_status','=','1')->count();

        $data['record']         = Event::find($eventId);
              
        $user_list_query        = User::where('status','Active')
                                    ->where('group_id','>','1')
                                    ->whereDoesntHave('eventInvites', function($user_list_query) use ($logged_in_user,$eventId){
                                            $user_list_query->where('sender_id','=',$logged_in_user);
                                            $user_list_query->where('event_id', '=', $eventId);
                                    })
                                    ->orderBy('display_name','ASC')
                                    ->get();
        $data['user_list']      = $user_list_query;
        $data['logged_in_user'] = $logged_in_user;
        $limit = config('constant.event_post_list_per_page');
        $data['post_record']    = Post::where('event_id','=',$eventId)->orderBy('id','desc')->paginate($limit);  

        if($request->ajax())
        {
            return view('front.events.ajax_post_data',$data);
        }        

        return view('front.events.details',$data);
    }

  
    public function event_response_ajax(Request $request)
    {
        $eventId       = $request->post('eventId');
        $status        = $request->post('status');
        $userId        = auth()->guard('user')->user()->id;

        $is_exit = Event::find($eventId);
        if($is_exit == '')
        {
            echo "fail";
        }
        else
        {
            $eventAttend = EventAttend::where('event_id','=',$eventId)->where('user_id','=',$userId)->first();
            if(!$eventAttend)
                $eventAttend = new EventAttend;

            $eventAttend->user_id   =  $userId;
            $eventAttend->event_id  =  $eventId;
            $eventAttend->attend_status = $status; 

            $eventAttend->save(); 
            echo "success";
        } 

    }

    public function event_post(Request $request){


        $userId             = auth()->guard('user')->user()->id;

        $post               = new Post();
        $post->text         = $request->post_text;
        $post->event_id     = $request->event_id;
        $post->user_id      = $userId;

        $event = Event::find($request->event_id);
        $data['event_type'] = $event->type_id;
        $data['event_creator'] = $event->user_id;

        if($request->file('post_image'))
        {
            $image = $request->file('post_image');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $thumbPath = public_path('uploads/posts/thumbnails');
            $originalPath = public_path('uploads/posts/original');

            $img = Image::make($image->getRealPath());
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbPath.'/'.$imagename);               

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $post->image = $imagename;
        }

        $is_video = 'No';
        if($request->hasFile('post_video')){
              //$getWebinar=Webinar::where('id',$insertId)->first();
              $vimeoFile =$request->file('post_video');
              $response = Vimeo::upload($vimeoFile);

                  $vimeo_request = Vimeo::request($response, array('name'=>'Tawasul','embed' => array('buttons' => array( 'embed' => false, 'share' => false, 'watchlater' => false, 'like' =>false), 'title' => array('name' => 'hide', 'owner' => 'hide', 'portrait' => 'hide'), 'logos' => array('vimeo' => false, 'custom' => array('active' => false, 'sticky' => false))), 'upload' => array('size' => '80000000000'),array('privacy' => array('view'=>'enable','embed'=>'whitelist','add'=>true,'download'=>false, 'comments'=>'nobody'))), 'PATCH');
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

        //$post->location = $request->location;
        $post->type = 'Event';
        $post->save();

        $record = Post::find($post->id);

        $data['post'] = $record;
        if($is_video == 'Yes')
        {
            return 2;
        }
        else
        {
            return view('front.events.ajax_post',$data);    
        }
        

    }

    public function saveeventcomment(Request $request){
        $post_id = $request->post_id;
        $comment_text = $request->comment_text;
        $user_id = \Auth::guard('user')->user()->id;
        $comment = new Comment;
        $comment->user_id           = $user_id;
        $comment->body              = $comment_text;
        $comment->commentable_id    = $post_id;
        $comment->commentable_type  = 'App\Post';
        $comment->save();
        $comment_data = Comment::find($comment->id);
        if(\Auth::guard('user')->user()->profile_photo != NULL && file_exists(public_path('uploads/user_images/profile_photo/thumbnails/' . \Auth::guard('user')->user()->profile_photo))) {
            $img ='<img src="'.asset('uploads/user_images/profile_photo/thumbnails/'.\Auth::guard('user')->user()->profile_photo).'" alt=""/>';
           // $img='';

        }else{
            $img='<img src="'.asset('frontend/images/no_user_thumb.png').'" />';
        }
        $comment_delete_permission_global_event =\Auth::user()->can('comment-delete-global-event');
        $comment_delete_permission_departmental_event =\Auth::user()->can('comment-delete-departmental-event');
        $comment_delete_permission_activity_event =\Auth::user()->can('comment-delete-activity-event');
        
         $del_html ='';
         
         $event_details = Event::find($comment_data->post['event_id']);

         $event_type = $event_details->type_id;

         if($event_type==1) { $permission_delete_comment =$comment_delete_permission_global_event;} elseif($event_type==2){ $permission_delete_comment = $comment_delete_permission_departmental_event;} elseif($event_type==3){ $permission_delete_comment = $comment_delete_permission_activity_event;}

        if(($event_details->user_id == \Auth::guard('user')->user()->id)|| $permission_delete_comment==1){
            $del_html ='<span style="float: right;"><a href="javascript::void(0);" alt="'.$comment->id.'" data-toggle="tooltip" data-placement="left" class="deletecomment" title="Delete Comment"> &nbsp;&nbsp;<i class="fa fa-times"></i></a></span>&nbsp; ';
        }

        $html ='<div class="comment-other-single"> <div class="image-div">'.$img.'</div>  <h2><a href="'.Route('user_profile').'/'.($comment->user->ad_username).'">'.\Auth::guard('user')->user()->display_name .'</a>'.$del_html.'<span>'. \DateTime::createFromFormat('Y-m-d H:i:s', $comment_data->created_at)->format('dS M Y h:i A').'</span></h2><p>'.$comment_data->body.'</p></div>';
        return $html;
    }

    public function getLocation(Request $request) {
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

    public function ajax_event_invite(Request $request)
    {
        $userId = $request->userId;
        $eventId = $request->event_id;
        $event = Event::find($eventId);
        $redis = LRedis::connection();
        foreach ($userId as $key => $user) {

            $eventInvite = new EventInvite;
            $eventInvite->sender_id = Auth::guard('user')->user()->id;
            $eventInvite->user_id   = $user;
            $eventInvite->event_id  = $eventId;
            $eventInvite->save();

            $notification = new Notification();
            $notification->notificationable_id = $eventId;
            $notification->notificationable_type = 'Event';
            $notification_txt   = '<a href="'.route('event_details', encrypt($eventId)).'">'.$event->name.'</a>'.trans('eventController.has_been_published_on');
            $notification->text = $notification_txt;
            $notification->added_by = Auth::guard('user')->user()->id;
            $notification->user_id  = $user;
            $notification->save();

            $notificationButton = '<div class="notibtn"><input type="button" class="go event_response event_btn" data-eventId = "'.$event->id.'" data-status="1" value="Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$event->id.'" data-status="2" value="Not Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$event->id.'" data-status="3" value="Tentetive" />  </div>';

            $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$notificationButton.'</div>';

            $redis->publish('user_message'.$user, $redis_message);

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
        }
        \Session::flash('success', trans('eventDetails.invitation_sent_successfully'));

    }

    public function ajax_cancel_invite(Request $request)
    {
            $id         = $request->id;
            $event_id   = $request->event_id;
            $user_id    = $request->user_id;
            $status     = $request->status;
            EventInvite::where('event_id',$event_id)->where('user_id',$user_id)->delete();
            EventAttend::where('event_id',$event_id)->where('user_id',$user_id)->delete();
            Notification::where('user_id',$user_id)->where('notificationable_id',$event_id)->whereIn('notificationable_type',['Event','EventEdit','EventDelete'])->delete();
    }

    public function likelist($postid,$event_id,Request $request)  {
        $data= array();
        $eventid = decrypt($event_id);
        $group_posts = Post::where('type','Event')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.event_id',$eventid)->where('pst.id',$postid)->orderBy('pst.id', 'desc')->first();
        $data['count_like'] = count($group_posts->likes);
        $data['post_likes'] = $group_posts->likes;
        return view('front.groups.like-list',$data);
    }

    public function deleteEvent($event_id)
    {
        $id = decrypt($event_id);
        $event = Event::find($id);
        $eventImage = EventImage::where('event_id', $id)->get();


        if($event->status == 'Active')
        {
            if($event->type_id == 1)
            {
                $userId = $event->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {

                    $notification = new Notification();
                    $notification->notificationable_id = 0;
                    $notification->notificationable_type = 'EventDelete';
                    $notification->text = $event->name.trans('eventController.has_been_deleted_on');
                    $notification->added_by = $userId;
                    $notification->user_id  = $user->id;
                    $notification->save();

                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                    $redis->publish('user_message'.$user->id, $redis_message);

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
                }
            }

            if($event->type_id == 2)
            {
                $userId = $event->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->where('department_id',$department_id)->get();
                foreach ($userList as $key => $user) {


                    $notification = new Notification();
                    $notification->notificationable_id = 0;
                    $notification->notificationable_type = 'EventDelete';
                    $notification->text = $event->name.trans('eventController.has_been_deleted_on');
                    $notification->added_by = $userId;
                    $notification->user_id  = $user->id;
                    $notification->save();

                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                    $redis->publish('user_message'.$user->user_id, $redis_message);

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
                }
            }

            if($event->type_id == 3)
            {
                $userId = $event->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = EventInvite::where('event_id','=',$event->id)->get();
                foreach ($userList as $key => $user) {

                    $notification = new Notification();
                    $notification->notificationable_id = 0;
                    $notification->notificationable_type = 'EventDelete';
                    $notification->text = $event->name.trans('eventController.has_been_deleted_on');
                    $notification->added_by = $userId;
                    $notification->user_id  = $user->user_id;
                    $notification->save();

                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p></div>';

                    $redis->publish('user_message'.$user->user_id, $redis_message);

                    $NotificationCount = NotificationCount::where('user_id', $user->user_id)->first();
                        if($NotificationCount)
                        {
                            $NotificationCount->increment('unread_count');
                        }
                        else
                        {
                            $NotificationCount = new NotificationCount();
                            $NotificationCount->user_id = $user->user_id;
                            $NotificationCount->unread_count = 1;
                            $NotificationCount->save();
                        }
                }
            }

            Notification::where('notificationable_id','=',$event->id)->where('notificationable_type','=','Event')->delete();
            EventInvite::where('event_id','=',$event->id)->delete();
            EventAttend::where('event_id','=',$event->id)->delete();
        }


        foreach ($eventImage as $key => $image) {           
        
        $file1 = 'uploads/event_images/'.$image->image_name;
        $file2 = 'uploads/event_images/thumbnails/'.$image->image_name;
        File::delete($file1, $file2);
        $image->delete();
        }
        $event->delete();
        return \Redirect::Route('event','month')->with('success', trans('eventController.Record_deleted_successfully'));   
    }

}
