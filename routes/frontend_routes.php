<?php

/*------------------------------------
/ Frontend Routes
/------------------------------------*/

Route::group(['namespace' => 'front','middleware' => 'language'], function() {

	Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@index']);
	Route::post('/login', ['as' => 'do_user_login', 'uses' => 'LoginController@userLogin']);
	Route::any('/cron-video-check', ['as' => 'cron_video_check',  'uses' => 'HomeController@cron_video_check']);


});

/*
* Using User Middleware
*/
Route::get('/after-login', 		['as' => 'afterlogin',  'middleware' => ['language','auth:user','user'],	'uses' => 'front\UserController@afterlogin']);


Route::group(['namespace' => 'front', 'middleware' => ['language','auth:user','user']], function() {

	Route::get('/', 				['as' => 'home',  			'uses' => 'HomeController@index']);
	Route::get('/logout', 			['as' => 'user_logout',  	'uses' => 'LoginController@logout' ]);
	//Route::get('/after-login', 		['as' => 'afterlogin',  	'uses' => 'UserController@afterlogin']);

	Route::get('/update-profile', 	['as' => 'update_profile',  'uses' => 'UserController@update_profile']);	
	Route::post('/update-profile',  		['as' => 'store_profile',	'uses' => 'UserController@storeProfile']);
	Route::get('/user-directory', 	['as' => 'user_directory',  'uses' => 'UserController@user_directory']);	
	Route::post('/ajax_follow', 	['as' => 'ajax_follow', 	'uses' => 'UserController@ajax_follow']);

	Route::post('/ajax_statelist', 	['as' => 'ajax_statelist', 	'uses' => 'UserController@ajax_getState']);
	Route::post('/ajax_citylist', 	['as' => 'ajax_citylist', 	'uses' => 'UserController@ajax_getCity']);

	Route::get('/calendar/{username?}',		['as' => 'calendar', 		'uses' => 'EventController@calendar']);

	//Route::get('/event/{username?}', 	['as' => 'event',  'uses' => 'EventController@index']);
	Route::any('/event/{eventDay}', 	['as' => 'event',  'uses' => 'EventController@index']);
	Route::any('/event_ajax_list', 		['as' => 'ajax_event',  'uses' => 'EventController@ajax_event']);
	Route::any('/event_response_ajax', 	['as' => 'event_response_ajax',  'uses' => 'EventController@event_response_ajax']);

	Route::get('/create-event', 		['as' => 'create_event', 'uses' => 'EventController@createEvent']);
	Route::post('/add-event', 			['as' => 'add_event', 'uses' => 'EventController@addEvent']);
	Route::get('/edit-event/{id}',		['as' => 'edit_event',   'uses' => 'EventController@editEvent']);
	Route::post('/edit-event/{id}',		['as' => 'update_event',   'uses' => 'EventController@updateEvent']);
	Route::get('/delete-event/{id}',	['as' => 'delete_event',   'uses' => 'EventController@deleteEvent']);
    Route::get('/event/details/{id}', ['as' => 'event_details',   'uses' => 'EventController@details']);
    Route::post('/event-post', 		['as' => 'event_post_create',  'uses' => 'EventController@event_post']);
    Route::any('/getLocation', 		['as' => 'getLocation',  'uses' => 'EventController@getLocation']);
	Route::any('/saveeventcomment', ['as' => 'saveeventcomment',  'uses' => 'EventController@saveeventcomment']);

	Route::post('/event-invite', 	['as' => 'ajax_event_invite',  'uses' => 'EventController@ajax_event_invite']);
	Route::post('/cancel-invite', 	['as' => 'ajax_cancel_invite',  'uses' => 'EventController@ajax_cancel_invite']);
	Route::get('/eventlikelist/{pid?}/{gid?}', ['as' => 'eventlikelist',  'uses' => 'EventController@likelist']);


	Route::get('/tickets/{type?}', ['as' => 'tickets',  'uses' => 'TicketController@index']);
	Route::post('/create-ticket', ['as' => 'create_ticket',  'uses' => 'TicketController@create']);
	Route::get('/get-issues', ['as' => 'get_issues',  'uses' => 'TicketController@getIssues']);
	Route::get('/view-ticket/{id}', ['as' => 'view_ticket',  'uses' => 'TicketController@viewTicket']);
	Route::post('/reply-ticket/{id}', ['as' => 'reply_ticket',  'uses' => 'TicketController@reply']);
    Route::post('/close-ticket/{id}', ['as' => 'close_ticket',  'uses' => 'TicketController@closeTicket']);

	Route::get('/posted-tickets/{type?}', ['as' => 'posted_tickets',  'uses' => 'TicketController@postedTickets']);
    Route::get('/view-posted-ticket/{id}', ['as' => 'view_posted_ticket',  'uses' => 'TicketController@viewPostedTicket']);

    Route::get('/about/{username?}', ['as' => 'user_about',  'uses' => 'UserController@about']);
    Route::get('/friends/{username?}', ['as' => 'user_friends',  'uses' => 'UserController@friendList']);
    Route::get('/timeline/{username?}', ['as' => 'user_timeline',  'uses' => 'UserController@timeline']);

    Route::post('/create-post', ['as' => 'user_post_create',  'uses' => 'PostController@add']);
    Route::post('/create-comment', ['as' => 'user_post_comment',  'uses' => 'CommentController@add']);

    Route::get('/group-list/{keywords?}', ['as' => 'group',  'uses' => 'GroupController@index']);
	Route::get('/group-list', ['as' => 'group',  'uses' => 'GroupController@index']);
	Route::get('/group-details/{gid?}', ['as' => 'group_details',  'uses' => 'GroupController@details']);
	Route::get('/group-add', ['as' => 'group_add',  'uses' => 'GroupController@add']);
	Route::any('/savegroup', ['as' => 'save_group',  'uses' => 'GroupController@savegroup']);
	Route::get('/group-edit/{gid?}', ['as' => 'group_edit',  'uses' => 'GroupController@edit']);
	Route::any('/updategroup', ['as' => 'update_group',  'uses' => 'GroupController@updategroup']);
	Route::any('/savepost', ['as' => 'post_add',  'uses' => 'GroupController@savepost']);
	Route::any('/getAddress', ['as' => 'getAddress',  'uses' => 'GroupController@getAddress']);
	Route::any('/savepostcomment', ['as' => 'savepostcomment',  'uses' => 'GroupController@savepostcomment']);
	Route::get('/likelist/{pid?}/{gid?}', ['as' => 'likelist',  'uses' => 'GroupController@likelist']);
	Route::any('/likeunlike', ['as' => 'likeunlike',  'uses' => 'GroupController@likeunlike']);
	Route::any('/delete-group/{gid?}', ['as' => 'delete_group',  'uses' => 'GroupController@delete_group']);
	Route::any('/leave-group/{gid?}/{uid?}', ['as' => 'leave_group',  'uses' => 'GroupController@leave_group']);
	Route::any('/add-moderator/{gid?}/{uid?}', ['as' => 'add_moderator',  'uses' => 'GroupController@add_moderator']);
	Route::any('/group-invite', ['as' => 'group_invite',  'uses' => 'GroupController@group_invite']);
	Route::any('/recent-updates', ['as' => 'recent_updates',  'uses' => 'HomeController@recent_updates']);
	Route::any('/acceptmember', ['as' => 'acceptmember',  'uses' => 'HomeController@accept_member_request']);
	Route::any('/rejectmember', ['as' => 'rejectmember',  'uses' => 'HomeController@reject_member_request']);
	Route::any('/acceptmoderator', ['as' => 'acceptmoderator',  'uses' => 'HomeController@accept_moderator_request']);
	Route::any('/rejectmoderator', ['as' => 'rejectmoderator',  'uses' => 'HomeController@reject_moderator_request']);
	Route::any('/recent-notification', ['as' => 'notifications',  'uses' => 'HomeController@recent_notifications']);
	Route::any('/post-home', ['as' => 'post_home',  'uses' => 'HomeController@post_home']);
	Route::any('/user-profile/{id?}', ['as' => 'user_profile',  'uses' => 'UserController@user_profile']);

	Route::any('/occasion', ['as' => 'occasion',  'uses' => 'HomeController@occation_list']);
	Route::any('/occasion-birthday/{pid?}/{gid?}/{did?}/{uid?}', ['as' => 'occasion_birthday',  'uses' => 'HomeController@occation_birthday_post']);
	Route::any('/occasion-birthday-submit/{pid?}/{gid?}', ['as' => 'occasion_birthday_submit',  'uses' => 'HomeController@occation_birthday_submit']);
	Route::any('/occasion-anniversary/{pid?}/{gid?}/{did?}/{uid?}', ['as' => 'occasion_anniversary',  'uses' => 'HomeController@occation_anniversary_post']);
	Route::any('/occasion-anniversary-submit/{pid?}/{gid?}', ['as' => 'occasion_anniversary_submit',  'uses' => 'HomeController@occation_anniversary_submit']);
	Route::any('/likeunlikeoccation', ['as' => 'likeunlikeoccation',  'uses' => 'HomeController@likeunlikeoccation']);
	Route::get('/likelistocc/{pid?}', ['as' => 'likelistocc',  'uses' => 'HomeController@likelistocc']);
	Route::any('/savepostcommentocc', ['as' => 'savepostcommentocc',  'uses' => 'HomeController@savepostcommentocc']);
	Route::get('/delete-posts/{id?}/{gid?}/{uid?}/{uname?}', ['as' => 'posts_delete', 'uses' =>  'GroupController@delete_post']);
	Route::get('/delete-comments/{id?}/{gid?}/{uid?}/{uname?}', ['as' =>'comments_delete','uses' =>  'GroupController@delete_comment']);
	Route::get('/remove_moderator/{id?}/{uid?}', ['as' =>'remove_moderator','uses' =>  'GroupController@remove_moderator']);

	Route::any('/socket-recent-update', ['as' => 'socket_recent_update',  'uses' => 'HomeController@socket_recent_update']);
	Route::any('/update-notification-count', ['as' => 'update_notification_count',  'uses' => 'HomeController@update_notification_count']);
	

});


