<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventType;
use App\Language;
use App\EventImage;
use App\Notification;
use App\EventInvite;
use App\EventAttend;
use App\Feed;
use App\User;
use App\Post;
use DB;
use Image;
use File;
use Mail;
use LRedis;
use App\NotificationCount;



class EventController extends Controller
{
    public $management = 'Event';
    public $breadcrumb;
    public $listMode = 'List';    
    public $createMode = 'Add';                                
    public $editMode = 'Edit';
    public $postMode = 'Post';
    public $listUrl = 'event_list';

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
                                ],
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

    public function index()
    {
    	$data['event_list'] = Event::get();        
    	return view('admin.event.list',$data);
    }

    public function add()
    {
    	$data['eventtype_list'] = EventType::where('status','Active')->get();
    	return view('admin.event.add',$data);
    }


    public function store(Request $request)
    {
        
        $this->validate($request, [
                'event_image'   => 'max:2000',
                'event_image'   => 'dimensions:min_width=1250',
                'event_profile_image' => 'max:2000',
                'event_profile_image' => 'image|dimensions:min_width=300,min_height=300,max_width=300,max_height=300,ratio=1/1',
                'description.*' => 'required',
                'event_start_date' => 'required',
                'event_end_date' => 'required'
            ],
            [
                'event_image.max'                   => 'Uploaded image size maximum 2MB allowed',
                'event_image.dimensions'            => 'Please select atleast 1280 pixel image',
                'event_profile_image.max'           => 'Uploaded image size maximum 2MB allowed',
                'event_profile_image.dimensions'    => 'Please select profile image 300X300 pixel image',
                'description.en.required'           => 'Please enter event description for English',
                'description.ar.required'           => 'Please enter event description for Arabic'
            ]
        );

        $eventtype_id   = $request->eventtype_id;
        $startDate      = $request->event_start_date;
        $endDate        = $request->event_end_date;

        $sDate = explode('-', $startDate) ;
        $startDate  = $sDate[2]."-".$sDate[1]."-".$sDate[0];
        $eDate = explode('-', $endDate);
        $endDate = $eDate[2]."-".$eDate[1]."-".$eDate[0];

        $start_time     = $request->start_time;
        $end_time       = $request->end_time;

        if(strtotime($startDate) > strtotime($endDate))
        {
            return \Redirect::Route('event_add')->withInput($request->input())->with('error', 'Event end date must be greater than start date');
        }
    
        if((strtotime($startDate) == strtotime($endDate)) && (strtotime($start_time) > strtotime($end_time)))
        {
            return \Redirect::Route('event_add')->withInput($request->input())->with('error', 'Event end time must be greater than start time');
        }

    	$event = new Event;
    	$event->type_id 	        = $eventtype_id;
        $event->user_id             = 1;
    	$event->status 		        = $request->status;
    	$event->event_start_date 	= $startDate;
        $event->event_end_date      = $endDate;
        $event->start_time          = $start_time;
        $event->end_time            = $end_time;
        $event->location            = $request->location;
        if($request->allday_event == 'Yes'){
            $event->allday_event       = $request->allday_event;
        }

    	//$event->save();
		foreach ($this->lang_locales as $locale) {
			$event->translateOrNew($locale->code)->name = $request->name[$locale->code];
			$event->translateOrNew($locale->code)->description = $request->description[$locale->code];
            //$event->translateOrNew($locale->code)->short_description = $request->short_description[$locale->code];
		}

        if($request->file('event_profile_image'))
        {
            $image = $request->file('event_profile_image');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $originalPath = public_path('uploads/event_images/profile_image');         

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $event->event_profile_image = $imagename;
        }
        
		$event->save();

        $redis = LRedis::connection();
        
        if($event->status == 'Active')
        {

            $notificationButton = '<div class="notibtn"><input type="button" class="go event_response event_btn" data-eventId = "'.$event->id.'" data-status="1" value="Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$event->id.'" data-status="2" value="Not Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$event->id.'" data-status="3" value="Tentetive" />  </div>';


            if($event->type_id == 1)
            {
                $userId = $event->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {

                    $notification = new Notification();
                    $notification->notificationable_id = $event->id;
                    $notification->notificationable_type = 'Event';
                    $notification->text = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.' has been published on ';
                    $notification->added_by = $userId;
                    $notification->user_id  = $user->id;
                    $notification->save();

                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$notificationButton.'</div>';

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
                    $notification->notificationable_id = $event->id;
                    $notification->notificationable_type = 'Event';
                    $notification->text = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.' has been published on ';
                    $notification->added_by = $userId;
                    $notification->user_id  = $user->id;
                    $notification->save();

                    $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$event->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification->text.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$notificationButton.'</div>';

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

        }

        // $notification = new Notification();
        // $notification->notificationable_id = $event->id;
        // $notification->notificationable_type = 'Event';
        // $notification->text = 'a new event has been posted';
        // $notification->added_by = 1;
        // $notification->save();

    	if(Input::hasFile('event_image'))
        {
            $image = $request->file('event_image');
            //foreach ($imageArr as $key => $image) {            	
           
	            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

	            $destinationPath = public_path('uploads/event_images');
	            $thumbPath = public_path('uploads/event_images/thumbnails');
                $listthumbPath = public_path('uploads/event_images/listthumb');
	            $detailsPath = public_path('uploads/event_images/details');
                $originalPath = public_path('uploads/event_images/original');

                $img = Image::make($image->getRealPath());
                $img->resize(1250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath.'/'.$imagename);               

                $img = Image::make($image->getRealPath());
                $img->resize(376, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($listthumbPath.'/'.$imagename); 

                $img = Image::make($image->getRealPath());
                $img->resize(1250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($detailsPath.'/'.$imagename); 

                $img = Image::make($image->getRealPath());
                $img->save($originalPath.'/'.$imagename);                                

	            //$image->move($destinationPath, $imagename);

	            $eventImage = new EventImage;
	            $eventImage->image_name = $imagename;
	            $eventImage->event_id = $event->id;
	            $eventImage->save();
        	//}
        }

        $feed = new Feed();
        $feed->user_id = 1;
        $feed->feedable_id = $event->id;
        $feed->type = 'Event';
        $feed->save();

        $redis_recent_update['feed_id'] = $feed->id; 
        $redis->publish('new_post_update', 'Y');
        $redis->publish('recent_update', json_encode($redis_recent_update));

    	return \Redirect::Route('event_list')->with('success', 'Event added successfully');

    }


    public function edit($id)
    {
		$data['eventtype_list'] = EventType::where('status','Active')->get();
    	$data['details'] = Event::find($id);
    	return view('admin.event.edit',$data);
    }

    public function update(Request $request,$id)
    {



        $this->validate($request, [
                'event_image'   => 'max:2000',
                'event_image'   => 'dimensions:min_width=1250',
                'event_profile_image' => 'max:2000',
                'event_profile_image' => 'image|dimensions:min_width=300,min_height=300,max_width=300,max_height=300,ratio=1/1',
                'description.*' => 'required',
                'event_start_date' => 'required',
                'event_end_date' => 'required'
            ],
            [
                'event_image.max'                   => 'Uploaded image size maximum 2MB allowed',
                'event_image.dimensions'            => 'Please select atleast 1280 pixel image',
                'event_profile_image.max'           => 'Uploaded image size maximum 2MB allowed',
                'event_profile_image.dimensions'    => 'Please select profile image 300X300 pixel image',
                'description.en.required'           => 'Please enter event description for English',
                'description.ar.required'           => 'Please enter event description for Arabic'
            ]
        );

        $eventtype_id   = $request->eventtype_id;
        $startDate      = $request->event_start_date;
        $endDate        = $request->event_end_date;
        $start_time     = $request->start_time;
        $end_time       = $request->end_time;

        $sDate = explode('-', $startDate) ;
        $startDate  = $sDate[2]."-".$sDate[1]."-".$sDate[0];
        $eDate = explode('-', $endDate);
        $endDate = $eDate[2]."-".$eDate[1]."-".$eDate[0];


        if(strtotime($startDate) > strtotime($endDate))
        {
            return \Redirect::Route('event_edit',$id)->with('error', 'Event end date must be greater than start date');
        }

        if((strtotime($startDate) == strtotime($endDate)) && (strtotime($start_time) > strtotime($end_time)))
        {
            return \Redirect::Route('event_edit',$id)->with('error', 'Event end time must be greater than start time');
        }
        
    	$event = Event::find($id);
    	$event->type_id 	       = $eventtype_id;
    	$event->status 		       = $request->status;
    	$event->event_start_date   = $startDate;
        $event->event_end_date     = $endDate;
        $event->start_time         = $start_time;
        $event->end_time           = $end_time;        
        $event->location           = $request->location;
        if($request->allday_event == 'Yes'){
            $event->allday_event       = $request->allday_event;
        }else
        {
            $event->allday_event       = 'No';
        }

        if($event->status == 'Disapprove')
        {
            $reason = $request->disapprove_reason;
            $event->disapprove_reason = $reason;

            $from_email_admin   =  \App\Sitesetting::where('id', 8)->select('sitesettings_value')->first();                              
            $fromEmail          = $from_email_admin->sitesettings_value;
            $from               = 'Tawasul Team'; 

            $toEmail            = 'ashes@matrixnmedia.com'; //$event->user->email;
            $to                 = $event->user->display_name;                 
            $subject            = 'Event Disapprove';                 
            $data['name']       = $event->user->display_name;
            $data['event_name'] = $event->name;
            $data['reason']     = $reason;
            $data['content_message']    = "Your event: '".$event['name']."'' has been disapproved, because: ".$reason;    


            Mail::send('emails.disapprove_status', $data, function($sent) use($toEmail,$to,$fromEmail,$from,$subject)
            {
                    $sent->from($fromEmail, $from);                                
                    $sent->to($toEmail, $to)->subject($subject);
            }); 
        }
        else
        {
            $event->disapprove_reason = "";
        }

        if($request->file('event_profile_image'))
        {
            $image = $request->file('event_profile_image');                   
            $imagename = auth()->guard('user')->user()->id.'_'.mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();
            $originalPath = public_path('uploads/event_images/profile_image');         

            $img = Image::make($image->getRealPath());
            $img->save($originalPath.'/'.$imagename);                                

            $event->event_profile_image = $imagename;
        }

    	$event->save();
		foreach ($this->lang_locales as $locale) {
			$event->translateOrNew($locale->code)->name = $request->name[$locale->code];
			$event->translateOrNew($locale->code)->description = $request->description[$locale->code];
            //$event->translateOrNew($locale->code)->short_description = $request->short_description[$locale->code];
		}
		$event->save();

        if($event->status == 'Active')
        {
            $redis = LRedis::connection();
            if($event->type_id == 1)
            {
                $userId = $event->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {
                    if($userId != $user->user_id)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $event->id;
                        $notification->notificationable_type = 'EventEdit';
                        $notification->text = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.' has been edited on ';
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
            }

            if($event->type_id == 2)
            {
                $userId = $event->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->where('department_id',$department_id)->get();
                foreach ($userList as $key => $user) {

                    if($userId != $user->user_id)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $event->id;
                        $notification->notificationable_type = 'EventEdit';
                        $notification->text = '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.' has been edited on ';
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
                        $notification->text =  '<a href="'.route('event_details', encrypt($event->id)).'">'.$event->name.'</a>'.' has been edited on ';
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
            }
        }


    	if(Input::hasFile('event_image'))
        {
            $image = $request->file('event_image');
            //foreach ($imageArr as $key => $image) {            	
           
	            $imagename = mt_rand(1000,9999)."_".time().".".$image->getClientOriginalExtension();

	            $destinationPath = public_path('uploads/event_images');
            
                $thumbPath = public_path('uploads/event_images/thumbnails');
                $listthumbPath = public_path('uploads/event_images/listthumb');
                $detailsPath = public_path('uploads/event_images/details');
                $originalPath = public_path('uploads/event_images/original');

                $img = Image::make($image->getRealPath());
                $img->resize(1250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbPath.'/'.$imagename);               

                $img = Image::make($image->getRealPath());
                $img->resize(376, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($listthumbPath.'/'.$imagename); 

                $img = Image::make($image->getRealPath());
                $img->resize(1250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($detailsPath.'/'.$imagename);  

                $img = Image::make($image->getRealPath());
                $img->save($originalPath.'/'.$imagename);                 

                $eventImage = EventImage::where('event_id', $event->id)->get();
                foreach ($eventImage as $key => $image) {
                    $file1 = 'uploads/event_images/'.$image->image_name;
                    $file2 = 'uploads/event_images/thumbnails/'.$image->image_name;
                    File::delete($file1, $file2);
                    $image->delete();
                }

	            $eventImage = new EventImage;
	            $eventImage->image_name = $imagename;
	            $eventImage->event_id = $event->id;
	            $eventImage->save();
        	//}
        }

    	return \Redirect::Route('event_list')->with('success', 'Event updated successfully');
    }

    public function delete($id)
    {
        $event = Event::find($id);
        $eventImage = EventImage::where('event_id', $id)->get();

        if($event->status == 'Active')
        {

            $redis = LRedis::connection();
            if($event->type_id == 1)
            {
                $userId = $event->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {

                    $notification = new Notification();
                    $notification->notificationable_id = 0;
                    $notification->notificationable_type = 'EventDelete';
                    $notification->text = $event->name.' has been deleted';
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
                    $notification->text = $event->name.' has been deleted';
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
                    $notification->text = $event->name.' has been deleted';
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
                        $NotificationCount->user_id = $user->id;
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
        return \Redirect::Route('event_list')->with('success', 'Record deleted successfully');   
    }

    public function delete_eventimage($id)
    {
    	$image = EventImage::find($id);
    	$file1 = 'uploads/event_images/'.$image->image_name;
        $file2 = 'uploads/event_images/thumbnails/'.$image->image_name;
        File::delete($file1, $file2);
        $image->delete();
        return \Redirect::Route('event_edit',$image->event_id)->with('success', 'Record deleted successfully');
    }

    public function statusChange(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $reason = $request->reason;
        $record = Event::find($id);

        if($status == 'Disapprove')
        {
            $record->status = 'Disapprove';
            $record->disapprove_reason = $reason;
            $status = '<span class="ion-android-close"></span>';
            //$status = '<span class="fa fa-hourglass-start"></span>';

            $from_email_admin   =  \App\Sitesetting::where('id', 8)->select('sitesettings_value')->first();                              
            $fromEmail          = $from_email_admin->sitesettings_value;
            $from               = 'Tawasul Team'; 

            $toEmail            = 'ashes@matrixnmedia.com'; //$record->user->email;
            $to                 = $record->user->display_name;                 
            $subject            = 'Event Disapprove';                 
            $data['name']       = $record->user->display_name;
            $data['event_name'] = $record->name;
            $data['reason']     = $reason;
            $data['content_message']    = "Your event: '".$record['name']."'' has been disapproved, because: ".$reason;    


            Mail::send('emails.disapprove_status', $data, function($sent) use($toEmail,$to,$fromEmail,$from,$subject)
            {
                    $sent->from($fromEmail, $from);                                
                    $sent->to($toEmail, $to)->subject($subject);
            }); 


        }
        else
        {
            $record->disapprove_reason = "";
            $record->status = 'Active';
            $status = '<span class="ion-checkmark"></span>';
            $redis = LRedis::connection();

            if($record->type_id == 1)
            {
                $userId = $record->user_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->get();
                foreach ($userList as $key => $user) {
                    $is_exists = Notification::where('notificationable_id','=',$record->id)->where('added_by','=',$userId)->where('user_id','=',$user->id)->count();
                    if($is_exists == 0)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $record->id;
                        $notification->notificationable_type = 'Event';
                        $notification_txt   = '<a href="'.route('event_details', encrypt($record->id)).'">'.$record->name.'</a>'.' has been published on '; 
                        $notification->text = $notification_txt; 
                        $notification->added_by = $userId;
                        $notification->user_id  = $user->id;
                        $notification->save();

                        $notificationButton = '<div class="notibtn"><input type="button" class="go event_response event_btn" data-eventId = "'.$record->id.'" data-status="1" value="Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$record->id.'" data-status="2" value="Not Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$record->id.'" data-status="3" value="Tentetive" />  </div>';

                        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$record->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$notificationButton.'</div>';

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
            }

            if($record->type_id == 2)
            {
                $userId = $record->user_id;
                $creator_user = User::find($userId );
                $department_id = $creator_user->department_id;
                $userList = User::where('status','=','Active')->where('group_id','>',1)->where('department_id',$department_id)->get();
                foreach ($userList as $key => $user) {

                    $is_exists = Notification::where('notificationable_id','=',$record->id)->where('added_by','=',$userId)->where('user_id','=',$user->id)->count();
                    if($is_exists == 0)
                    {
                        $notification = new Notification();
                        $notification->notificationable_id = $record->id;
                        $notification->notificationable_type = 'Event';
                        $notification_txt   = '<a href="'.route('event_details', encrypt($record->id)).'">'.$record->name.'</a>'.' has been published on '; 
                        $notification->text = $notification_txt; 
                        $notification->added_by = $userId;
                        $notification->user_id  = $user->id;
                        $notification->save();

                        $notificationButton = '<div class="notibtn"><input type="button" class="go event_response event_btn" data-eventId = "'.$record->id.'" data-status="1" value="Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$record->id.'" data-status="2" value="Not Attending" /><input type="button" class="not_go event_response event_btn" data-eventId = "'.$record->id.'" data-status="3" value="Tentetive" />  </div>';

                        $redis_message = '<div class="notific-cont-single"><div class="notific-img-user"><img src="'.asset('timthumb.php').'?src='.asset('uploads/event_images/profile_image/'.$record->event_profile_image).'&w=68&h=68&q=100" alt=""></div><p>'.$notification_txt.'</p><p class="posted-time"><i class="fa fa-calendar" aria-hidden="true"></i> '.date('dS M Y h:i A') .'</p>'.$notificationButton.'</div>';

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
            }
        }
        $record->save();
        echo $status;
    }

    public function view_posts($id,Request $request){

        $group_posts = Post::where('type','Event')->from('users as usr')->join('posts as pst','usr.id','=','pst.user_id')->where('pst.event_id',$id)->orderBy('pst.id', 'desc')->paginate(10);
        $data['event_posts'] = $group_posts;
        $data['event_id'] = $id;
        $events = Event::where('id',$id)->first();
        $data['event_name'] = $events['name'];
        return view('admin.event.view-post',$data);
    }  
}
