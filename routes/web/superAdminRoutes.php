<?php

// users routes
Route::get('/users', 'UserController@index')->name('users'); // Read
Route::post('/users/store', 'UserController@store')->name('users.store'); // Write
Route::get('/users/find/{id}', 'UserController@findById')->name('users.find'); // Modify
Route::patch('/users/update/{id}', 'UserController@update')->name('users.update'); // Modify
Route::get('/users/change_status/{id}', 'UserController@changeStatus')->name('users.change_status'); // Modify
Route::delete('/users/delete/{id}', 'UserController@destroy')->name('users.destroy'); // Delete

// permissions routes
Route::get('/permissions', 'PermissionController@index')->name('permissions'); 
Route::post('/permissions/store', 'PermissionController@store')->name('permissions.store'); 
Route::get('/permissions/find/{id}', 'PermissionController@findById')->name('permissions.find'); 
Route::patch('/permissions/update/{id}', 'PermissionController@update')->name('permissions.update'); 
Route::get('/permissions/change_status/{id}', 'PermissionController@changeStatus')->name('permissions.change_status'); 
Route::delete('/permissions/delete/{id}', 'PermissionController@destroy')->name('permissions.destroy'); 

// roles routes
Route::get('/roles', 'RoleController@index')->name('roles'); 
Route::post('/roles/store', 'RoleController@store')->name('roles.store'); 
Route::get('/roles/find/{id}', 'RoleController@findById')->name('roles.find'); 
Route::patch('/roles/update/{id}', 'RoleController@update')->name('roles.update'); 
Route::get('/roles/change_status/{id}', 'RoleController@changeStatus')->name('roles.change_status'); 
Route::delete('/roles/delete/{id}', 'RoleController@destroy')->name('roles.destroy'); 