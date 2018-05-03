<?php

/*------------------------------------
/ Admin Routes
/------------------------------------*/


Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function() {
	Route::get('/', 		['as' => 'admin_login', 	'uses' => 'LoginController@login' ]);
	Route::post('/', 		['as' => 'do_admin_login', 'uses' => 'LoginController@dologin'  ]);	
    Route::get('/forgot-password',  array('as' => 'admin_forgot_password',   'uses'=>'DashboardController@forgot_password' ));
    Route::post('/forgot-password-action',array('as' => 'admin_forgot_password_action','uses'=>'DashboardController@forgot_password_action'));
    Route::get('/reset-password/{token}', array('as' =>'admin_reset_newpassword', 'uses'=> 'DashboardController@password_reset' ));
    Route::post('/reset-password/{token}',array('as' =>'admin_password_update', 'uses'=> 'DashboardController@password_update' )); 	
});

Route::group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => 'admin'], function() {
	Route::get('/dashboard', ['as' => 'admin_dashboard', 'uses' => 'DashboardController@index' ]);
	Route::get('/logout', 	['as' => 'logout', 'uses' => 'LoginController@logout' ]);		
    Route::any('/change-password',        array('as' => 'admin_change_password',  'uses'=>'DashboardController@change_password' ));
    Route::post('/update-password',       array('as' => 'admin_update_password',  'uses'=>'DashboardController@change_password_action' ));
	Route::post('/user_status', 	['as' => 'user_status', 	'uses' => 'UserController@changeUserStatus' ]);
	Route::post('/statusChange', 	['as' => 'statusChange', 	'uses' => 'CommonController@statusChange' ]);

	Route::group(['prefix' => 'users'], function(){
		Route::get('/', 	['as' => 'user_list', 	'uses' => 'UserController@index' ]);
		Route::get('/view/{id}', 	['as' => 'user_details', 	'uses' => 'UserController@viewDetails' ]);
		Route::get('/asignrole/{id}', 	['as' => 'user_addedit_role', 	'uses' => 'UserController@addeditRole' ]);
		Route::post('/asignrole/{id}', 	['as' => 'user_addedit_role', 	'uses' => 'UserController@submitAddeditRole' ]);
		Route::get('/sync', 	['as' => 'user_sync', 	'uses' => 'UserController@syncUser' ]);
		Route::get('/occasion-list/{id?}', 	['as' => 'occasion_list', 	'uses' => 'UserController@occasion_list' ]);
		// Route::get('/add-accesstype', 	['as' => 'accesstype_add', 'uses' =>  'AccessTypeController@add']);
		// Route::post('/add-accesstype', 	['as' => 'accesstype_store', 'uses' =>  'AccessTypeController@store']);
	});

	Route::group(['prefix' => 'countries'], function(){
		Route::get('/', 	['as' => 'country_list', 'uses' =>  'CountryController@index']);
		Route::get('/add', 	['as' => 'country_add', 'uses' =>  'CountryController@add']);
		Route::post('/add', 	['as' => 'country_store', 'uses' =>  'CountryController@store']);
		Route::get('/edit/{id}', 	['as' => 'country_edit', 'uses' =>  'CountryController@edit']);
		Route::post('/edit/{id}', 	['as' => 'country_update', 'uses' =>  'CountryController@update']);
		Route::post('/delete/{id}', 	['as' => 'country_delete', 'uses' =>  'CountryController@delete']);
	});

	Route::group(['prefix' => 'states' ], function(){
		Route::get('/', ['as' => 'state_list', 'uses' => 'StateController@index']);
		Route::get('/add', 			['as' => 'state_add', 'uses' =>  'StateController@add']);
		Route::post('/add', 		['as' => 'state_store', 'uses' =>  'StateController@store']);
		Route::get('/edit/{id}', 	['as' => 'state_edit', 'uses' =>  'StateController@edit']);
		Route::post('/edit/{id}', 	['as' => 'state_update', 'uses' =>  'StateController@update']);
		Route::post('/delete/{id}', ['as' => 'state_delete', 'uses' =>  'StateController@delete']);
	});

	Route::group(['prefix' => 'cities' ], function(){
		Route::get('/', ['as' => 'city_list', 'uses' => 'CityController@index']);
		Route::get('/add', 			['as' => 'city_add', 'uses' =>  'CityController@add']);
		Route::post('/add', 		['as' => 'city_store', 'uses' =>  'CityController@store']);
		Route::get('/edit/{id}', 	['as' => 'city_edit', 'uses' =>  'CityController@edit']);
		Route::post('/edit/{id}', 	['as' => 'city_update', 'uses' =>  'CityController@update']);
		Route::post('/delete/{id}', 	['as' => 'city_delete', 'uses' =>  'CityController@delete']);
		Route::post('/ajax_statelist', 		['as' => 'ajax_statelist', 'uses' =>  'CityController@ajax_getState']);
	});

	Route::group(['prefix' => 'companies'], function(){
		Route::get('/', 	['as' => 'company_list', 'uses' =>  'CompanyController@index']);
		Route::get('/add', 	['as' => 'company_add', 'uses' =>  'CompanyController@add']);
		Route::post('/add', 	['as' => 'company_store', 'uses' =>  'CompanyController@store']);
		Route::get('/edit/{id}', 	['as' => 'company_edit', 'uses' =>  'CompanyController@edit']);
		Route::post('/edit/{id}', 	['as' => 'company_update', 'uses' =>  'CompanyController@update']);
		Route::get('/delete/{id}', 	['as' => 'company_delete', 'uses' =>  'CompanyController@delete']);
		Route::get('/sync', 		['as' => 'company_sync', 'uses' =>  'CompanyController@syncCompany']);
	});

	Route::group(['prefix' => 'departments'], function(){
		Route::get('/', 	['as' => 'department_list', 'uses' =>  'DepartmentController@index']);
		Route::get('/add', 	['as' => 'department_add', 'uses' =>  'DepartmentController@add']);
		Route::post('/add', 	['as' => 'department_store', 'uses' =>  'DepartmentController@store']);
		Route::get('/edit/{id}', 	['as' => 'department_edit', 'uses' =>  'DepartmentController@edit']);
		Route::post('/edit/{id}', 	['as' => 'department_update', 'uses' =>  'DepartmentController@update']);
		Route::get('/delete/{id}', 	['as' => 'department_delete', 'uses' =>  'DepartmentController@delete']);
		Route::get('/sync', 		['as' => 'department_sync', 'uses' =>  'DepartmentController@syncDepartment']);
	});

	Route::group(['prefix' => 'designations'], function(){
		Route::get('/', 	['as' => 'designation_list', 'uses' =>  'DesignationController@getList']);
		Route::get('/add', 	['as' => 'designation_add', 'uses' =>  'DesignationController@add']);
		Route::post('/add', 	['as' => 'designation_store', 'uses' =>  'DesignationController@store']);
		Route::get('/edit/{id}', 	['as' => 'designation_edit', 'uses' =>  'DesignationController@edit']);
		Route::post('/edit/{id}', 	['as' => 'designation_update', 'uses' =>  'DesignationController@update']);
		Route::get('/delete/{id}', 	['as' => 'designation_delete', 'uses' =>  'DesignationController@delete']);
		Route::get('/sync', 	['as' => 'designation_sync', 'uses' =>  'DesignationController@syncDesignation']);
	});

	Route::group(['prefix' => 'grouptypes'], function(){
		Route::get('/', 	['as' => 'grouptype_list', 'uses' =>  'GrouptypeController@index']);
		Route::get('/add', 	['as' => 'grouptype_add', 'uses' =>  'GrouptypeController@add']);
		Route::post('/add', 	['as' => 'grouptype_store', 'uses' =>  'GrouptypeController@store']);
		Route::get('/edit/{id}', 	['as' => 'grouptype_edit', 'uses' =>  'GrouptypeController@edit']);
		Route::post('/edit/{id}', 	['as' => 'grouptype_update', 'uses' =>  'GrouptypeController@update']);
		Route::get('/delete/{id}', 	['as' => 'grouptype_delete', 'uses' =>  'GrouptypeController@delete']);
		Route::get('/sync', 	['as' => 'grouptype_sync', 'uses' =>  'GrouptypeController@syncGroup']);

		
		Route::get('permission/{id}', ['as' => 'user_permission', 'uses' => 'GrouptypeController@permission']);
		Route::post('permission/{id}', ['as' => 'user_permission_submit', 'uses' => 'GrouptypeController@submitPermission']);
	});

	Route::group(['prefix' => 'eventtypes'], function(){
		Route::get('/', 	['as' => 'eventtype_list', 'uses' =>  'EventtypeController@index']);
		Route::get('/add', 	['as' => 'eventtype_add', 'uses' =>  'EventtypeController@add']);
		Route::post('/add', 	['as' => 'eventtype_store', 'uses' =>  'EventtypeController@store']);
		Route::get('/edit/{id}', 	['as' => 'eventtype_edit', 'uses' =>  'EventtypeController@edit']);
		Route::post('/edit/{id}', 	['as' => 'eventtype_update', 'uses' =>  'EventtypeController@update']);
		Route::get('/delete/{id}', 	['as' => 'eventtype_delete', 'uses' =>  'EventtypeController@delete']);
	});

	Route::group(['prefix' => 'events' ], function(){
		Route::get('/', ['as' => 'event_list', 'uses' => 'EventController@index']);
		Route::get('/add', 			['as' => 'event_add', 'uses' =>  'EventController@add']);
		Route::post('/add', 		['as' => 'event_store', 'uses' =>  'EventController@store']);
		Route::get('/edit/{id}', 	['as' => 'event_edit', 'uses' =>  'EventController@edit']);
		Route::post('/edit/{id}', 	['as' => 'event_update', 'uses' =>  'EventController@update']);
		Route::post('/status_change', ['as' => 'status_change', 'uses' =>  'EventController@statusChange']);
		Route::post('/delete/{id}', ['as' => 'event_delete', 'uses' =>  'EventController@delete']);
		Route::get('/delete_eventimage/{id}',['as' => 'delete_eventimage', 'uses' =>  'EventController@delete_eventimage']);
		Route::get('/event-posts/{id}', ['as' => 'event_posts', 'uses' =>  'EventController@view_posts']);
	});

	Route::group(['prefix' => 'groups' ], function(){
		Route::get('/', ['as' => 'group_list', 'uses' => 'GroupController@index']);
		Route::post('/status_change', ['as' => 'status_change', 'uses' =>  'GroupController@statusChange']);
		Route::post('/status_change_approve', ['as' => 'status_change_approve', 'uses' =>  'GroupController@statusChangeApprove']);
		Route::post('/status_change_disapprove', ['as' => 'status_change_disapprove', 'uses' =>  'GroupController@statusChangeDisapprove']);		
		Route::get('/add-group', 			['as' => 'add_group', 'uses' =>  'GroupController@add']);
		Route::post('/add-group', 		['as' => 'group_store', 'uses' =>  'GroupController@store']);
		Route::get('/edit/{id}', 	['as' => 'edit_group', 'uses' =>  'GroupController@edit']);
		Route::post('/edit/{id}', 	['as' => 'group_update', 'uses' =>  'GroupController@update']);
		Route::post('/delete/{id}', ['as' => 'group_delete', 'uses' =>  'GroupController@delete']);
		Route::get('/group-posts/{id}', ['as' => 'group_posts', 'uses' =>  'GroupController@view_posts']);
		Route::get('/delete-posts/{id?}/{gid?}/{var?}', ['as' => 'delete_posts', 'uses' =>  'GroupController@delete_post']);
		Route::get('/delete-comments/{id?}/{gid?}/{var?}', ['as' =>'delete_comments','uses' =>  'GroupController@delete_comment']);
		
	});


	Route::group(['prefix' => 'sitesettings'], function(){
		Route::get('/', 			['as' => 'sitesetting_list', 'uses' =>  'SitesettingController@index']);
		Route::post('/edit', 	['as' => 'sitesetting_update', 'uses' =>  'SitesettingController@update']);
	});

	Route::group(['prefix' => 'roles'], function(){
		Route::get('/', 						['as' => 'role_list', 				'uses' =>  'RoleController@index']);
		Route::get('/add', 						['as' => 'role_add', 				'uses' =>  'RoleController@add']);
		Route::post('/add', 					['as' => 'role_store', 				'uses' =>  'RoleController@store']);
		Route::get('/edit/{id}', 				['as' => 'role_edit', 				'uses' =>  'RoleController@edit']);
		Route::post('/edit/{id}', 				['as' => 'role_update', 			'uses' =>  'RoleController@update']);
		Route::get('role-permission/{id}', 		['as' => 'role_permission', 		'uses' =>  'RoleController@permission']);
		Route::post('role-permission/{id}', 	['as' => 'role_permission_submit', 	'uses' =>  'RoleController@submitPermission']);
		Route::post('/delete/{id}', 			['as' => 'role_delete', 			'uses' =>  'RoleController@delete']);
	});

	Route::group(['prefix' => 'tickets'], function(){
		Route::get('/', 						['as' => 'admin_ticket_list', 				'uses' =>  'TicketController@index']);
		Route::get('/view-ticket/{id}', 		['as' => 'admin_view_ticket', 			    'uses' =>  'TicketController@viewTicket']);
		// Route::get('/add', 						['as' => 'role_add', 				'uses' =>  'RoleController@add']);
		// Route::post('/add', 					['as' => 'role_store', 				'uses' =>  'RoleController@store']);
		// Route::get('/edit/{id}', 				['as' => 'role_edit', 				'uses' =>  'RoleController@edit']);
	});

	Route::group(['prefix' => 'faqs'], function(){
		Route::get('/', 					['as' => 'faq_list', 'uses' => 'FaqController@index']);
		Route::get('/add', 					['as' => 'faq_add', 'uses' =>  'FaqController@add']);
		Route::post('/add', 				['as' => 'faq_store', 'uses' =>  'FaqController@store']);
		Route::get('/edit/{id}', 			['as' => 'faq_edit', 'uses' =>  'FaqController@edit']);
		Route::post('/edit/{id}', 			['as' => 'faq_update', 'uses' =>  'FaqController@update']);
		Route::post('/delete/{id}', 		['as' => 'faq_delete', 'uses' =>  'FaqController@delete']);
	});	

	Route::group(['prefix' => 'helparticles'], function(){
		Route::get('/', 					['as' => 'helparticle_list', 'uses' => 'HelparticleController@index']);
		Route::get('/add', 					['as' => 'helparticle_add', 'uses' =>  'HelparticleController@add']);
		Route::post('/add', 				['as' => 'helparticle_store', 'uses' =>  'HelparticleController@store']);
		Route::get('/edit/{id}', 			['as' => 'helparticle_edit', 'uses' =>  'HelparticleController@edit']);
		Route::post('/edit/{id}', 			['as' => 'helparticle_update', 'uses' =>  'HelparticleController@update']);
		Route::post('/delete/{id}', 		['as' => 'helparticle_delete', 'uses' =>  'HelparticleController@delete']);
	});

	Route::group(['prefix' => 'howtos'], function(){
		Route::get('/', 					['as' => 'howto_list', 'uses' => 'HowtoController@index']);
		Route::get('/add', 					['as' => 'howto_add', 'uses' =>  'HowtoController@add']);
		Route::post('/add', 				['as' => 'howto_store', 'uses' =>  'HowtoController@store']);
		Route::get('/edit/{id}', 			['as' => 'howto_edit', 'uses' =>  'HowtoController@edit']);
		Route::post('/edit/{id}', 			['as' => 'howto_update', 'uses' =>  'HowtoController@update']);
		Route::post('/delete/{id}', 		['as' => 'howto_delete', 'uses' =>  'HowtoController@delete']);
	});	


	Route::group(['prefix' => 'cms'], function(){
		Route::get('/', 	['as' => 'cms_list', 'uses' =>  'CmsController@index']);
		Route::get('/add', 	['as' => 'cms_add', 'uses' =>  'CmsController@add']);
		Route::post('/add', 	['as' => 'cms_store', 'uses' =>  'CmsController@store']);
		Route::get('/edit/{id}', 	['as' => 'cms_edit', 'uses' =>  'CmsController@edit']);
		Route::post('/edit/{id}', 	['as' => 'cms_update', 'uses' =>  'CmsController@update']);
		Route::post('/delete/{id}', 	['as' => 'cms_delete', 'uses' =>  'CmsController@delete']);
	});

	Route::group(['prefix' => 'ebook'], function(){
		Route::get('/', 	['as' => 'ebook_list', 'uses' =>  'EbookController@index']);
		Route::get('/add', 	['as' => 'ebook_add', 'uses' =>  'EbookController@add']);
		Route::post('/add', 	['as' => 'ebook_store', 'uses' =>  'EbookController@store']);
		Route::get('/edit/{id}', 	['as' => 'ebook_edit', 'uses' =>  'EbookController@edit']);
		Route::post('/edit/{id}', 	['as' => 'ebook_update', 'uses' =>  'EbookController@update']);
		Route::post('/delete/{id}', 	['as' => 'ebook_delete', 'uses' =>  'EbookController@delete']);
	});

	Route::group(['prefix' => 'emailtemplates'], function(){
		Route::get('/', 					['as' => 'emailtemplate_list', 'uses' => 'EmailTemplateController@index']);
		Route::get('/add', 					['as' => 'emailtemplate_add', 'uses' =>  'EmailTemplateController@add']);
		Route::post('/add', 				['as' => 'emailtemplate_store', 'uses' =>  'EmailTemplateController@store']);
		Route::get('/edit/{id}', 			['as' => 'emailtemplate_edit', 'uses' =>  'EmailTemplateController@edit']);
		Route::post('/edit/{id}', 			['as' => 'emailtemplate_update', 'uses' =>  'EmailTemplateController@update']);
		Route::post('/delete/{id}', 		['as' => 'emailtemplate_delete', 'uses' =>  'EmailTemplateController@delete']);
	});		


});
