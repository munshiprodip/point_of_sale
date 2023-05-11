<?php

// profile settings routes
Route::get('/account', 'ProfileController@account')->name('profiles.account');
Route::post('/account/update', 'ProfileController@updateAccount')->name('profiles.account.update'); 
Route::get('/security', 'ProfileController@security')->name('profiles.security');
Route::post('/security/update', 'ProfileController@updateSecurity')->name('profiles.security.update'); 

Route::get('/organization', 'PersonalSettingController@organizationSetting')->name('settings.organization');
Route::post('/organization/update', 'PersonalSettingController@organizationSettingUpdate')->name('settings.organization.update'); 
Route::get('/emr_options', 'PersonalSettingController@emrSetting')->name('settings.emr');
Route::post('/emr_options/update', 'PersonalSettingController@emrSettingUpdate')->name('settings.emr.update'); 
Route::get('/print_options', 'PersonalSettingController@printSetting')->name('settings.print');
Route::post('/print_options/update', 'PersonalSettingController@printSettingUpdate')->name('settings.print.update'); 
