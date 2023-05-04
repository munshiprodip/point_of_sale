<?php

// profile settings routes
Route::get('/account', 'ProfileController@account')->name('profiles.account');
Route::post('/account/update', 'ProfileController@updateAccount')->name('profiles.account.update'); 
Route::get('/security', 'ProfileController@security')->name('profiles.security');
Route::post('/security/update', 'ProfileController@updateSecurity')->name('profiles.security.update'); 
