<?php

/*** LOGIN ***/
Route::get('login', 											'AuthController@login');
Route::post('login/doLogin', 									'AuthController@doLogin');

/*** CADASTRA-SE ***/
Route::get('signup', 											'SignupController@index');
Route::post('signup/save', 										'SignupController@save');

/*** VALIDA USUÁRIO ***/
Route::get('validateUser', 										'validateUserController@validateHash');
Route::post('validateUser/resendEmail', 						'validateUserController@resendEmail');

/*** ADMIN/MEMBRO ***/
Route::middleware('auth')->group(function(){
	/*** LOGOUT ***/
	Route::get('logout', 										'AuthController@getLogout');
	
	/*** PÁGINA INICIAL ***/
	Route::get('/', 											'DashboardController@index');
	Route::get('dashboard', 									'DashboardController@index');
	
	/*** USUÁRIOS ***/
	Route::get('user', 											'UsersController@index');
	Route::post('user/new', 									'UsersController@new');
	Route::get('user/see/{id?}', 								'UsersController@see');
	Route::match(['get','post'],'user/edit/{id?}', 				'UsersController@edit');
	Route::match(['get','post'],'user/config/{id?}', 			'UsersController@config');
	Route::post('user/delete', 									'UsersController@delete');
	Route::get('user/search', 									'UsersController@search');
	
	/*** CONTATOS ***/
	Route::get('userContact', 									'UsersContactsController@index');
	Route::post('userContact/new', 								'UsersContactsController@new');
	Route::get('userContact/see/{id?}', 						'UsersContactsController@see');
	Route::match(['get','post'],'userContact/edit/{id?}', 		'UsersContactsController@edit');
	Route::post('userContact/delete', 							'UsersContactsController@delete');
	Route::get('userContact/search', 							'UsersContactsController@search');
});