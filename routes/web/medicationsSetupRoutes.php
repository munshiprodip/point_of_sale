<?php

// generics routes
Route::get('/generics', 'GenericController@index')->name('generics'); // Read
Route::post('/generics/store', 'GenericController@store')->name('generics.store'); // Write
Route::get('/generics/find/{id}', 'GenericController@findById')->name('generics.find'); // Modify
Route::patch('/generics/update/{id}', 'GenericController@update')->name('generics.update'); // Modify
Route::get('/generics/change_status/{id}', 'GenericController@changeStatus')->name('generics.change_status'); // Modify
Route::delete('/generics/delete/{id}', 'GenericController@destroy')->name('generics.destroy'); // Delete

// companies routes
Route::get('/companies', 'CompanyController@index')->name('companies'); // Read
Route::post('/companies/store', 'CompanyController@store')->name('companies.store'); // Write
Route::get('/companies/find/{id}', 'CompanyController@findById')->name('companies.find'); // Modify
Route::patch('/companies/update/{id}', 'CompanyController@update')->name('companies.update'); // Modify
Route::get('/companies/change_status/{id}', 'CompanyController@changeStatus')->name('companies.change_status'); // Modify
Route::delete('/companies/delete/{id}', 'CompanyController@destroy')->name('companies.destroy'); // Delete

// brands routes
Route::get('/brands', 'BrandController@index')->name('brands'); // Read
Route::post('/brands/store', 'BrandController@store')->name('brands.store'); // Write
Route::get('/brands/find/{id}', 'BrandController@findById')->name('brands.find'); // Modify
Route::patch('/brands/update/{id}', 'BrandController@update')->name('brands.update'); // Modify
Route::get('/brands/change_status/{id}', 'BrandController@changeStatus')->name('brands.change_status'); // Modify
Route::delete('/brands/delete/{id}', 'BrandController@destroy')->name('brands.destroy'); // Delete

// doses routes
Route::get('/doses', 'DoseController@index')->name('doses'); // Read
Route::post('/doses/store', 'DoseController@store')->name('doses.store'); // Write
Route::get('/doses/find/{id}', 'DoseController@findById')->name('doses.find'); // Modify
Route::patch('/doses/update/{id}', 'DoseController@update')->name('doses.update'); // Modify
Route::get('/doses/change_status/{id}', 'DoseController@changeStatus')->name('doses.change_status'); // Modify
Route::delete('/doses/delete/{id}', 'DoseController@destroy')->name('doses.destroy'); // Delete

// instructions routes
Route::get('/instructions', 'InstructionController@index')->name('instructions'); // Read
Route::post('/instructions/store', 'InstructionController@store')->name('instructions.store'); // Write
Route::get('/instructions/find/{id}', 'InstructionController@findById')->name('instructions.find'); // Modify
Route::patch('/instructions/update/{id}', 'InstructionController@update')->name('instructions.update'); // Modify
Route::get('/instructions/change_status/{id}', 'InstructionController@changeStatus')->name('instructions.change_status'); // Modify
Route::delete('/instructions/delete/{id}', 'InstructionController@destroy')->name('instructions.destroy'); // Delete

// durations routes
Route::get('/durations', 'DurationController@index')->name('durations'); // Read
Route::post('/durations/store', 'DurationController@store')->name('durations.store'); // Write
Route::get('/durations/find/{id}', 'DurationController@findById')->name('durations.find'); // Modify
Route::patch('/durations/update/{id}', 'DurationController@update')->name('durations.update'); // Modify
Route::get('/durations/change_status/{id}', 'DurationController@changeStatus')->name('durations.change_status'); // Modify
Route::delete('/durations/delete/{id}', 'DurationController@destroy')->name('durations.destroy'); // Delete