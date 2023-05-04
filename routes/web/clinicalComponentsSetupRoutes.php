<?php

// clinical_components routes
Route::get('/clinical_components/{component_type}', 'ClinicalComponentController@index')->name('clinical_components'); // Read
Route::post('/clinical_components/store', 'ClinicalComponentController@store')->name('clinical_components.store'); // Write
Route::get('/clinical_components/find/{id}', 'ClinicalComponentController@findById')->name('clinical_components.find'); // Modify
Route::patch('/clinical_components/update/{id}', 'ClinicalComponentController@update')->name('clinical_components.update'); // Modify
Route::get('/clinical_components/change_status/{id}', 'ClinicalComponentController@changeStatus')->name('clinical_components.change_status'); // Modify
Route::delete('/clinical_components/delete/{id}', 'ClinicalComponentController@destroy')->name('clinical_components.destroy'); // Delete


Route::get('/clinical_components/{component_type}/get_favourites', 'ClinicalComponentController@getFavouriteComponents')->name('clinical_components.get_favourites'); // Read
Route::post('/clinical_components/add_to_favourite', 'ClinicalComponentController@addComponentToFavourite')->name('clinical_components.add_to_favourite'); // Write
Route::post('/clinical_components/remove_from_favourite', 'ClinicalComponentController@removeComponentFromFavourite')->name('clinical_components.remove_from_favourite'); // Write

Route::get('/clinical_components/{component_type}/select_option_search', 'ClinicalComponentController@selectOptionsSearch')->name('clinical_components.select_option_search'); // Write
