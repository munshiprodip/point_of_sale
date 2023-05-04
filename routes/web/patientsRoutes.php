<?php


Route::get('/appointments', 'AppointmentController@index')->name('appointments');
Route::get('/appointments/create', 'AppointmentController@create')->name('appointments.create');
Route::post('/appointments/store', 'AppointmentController@store')->name('appointments.store'); // create patient & create appointment 
Route::get('/appointments/{appointment_no}/prescribe', 'AppointmentController@prescribe')->name('appointments.prescribe'); // create patient & create appointment 
Route::patch('/appointments/{id}/update', 'AppointmentController@update')->name('appointments.update'); // create patient & create appointment 

Route::patch('/appointments/patient_info/{id}/update', 'PatientController@update')->name('patients.update'); // create patient & create appointment 


Route::get('/appointments/{patient_id}/peevious-appointments/{appointment_no}', 'AppointmentController@previousAppointments')->name('appointments.previous_appointments');

Route::get('/media_libraries/get-media', 'MediaLibraryController@allMedia')->name('media_libraries.all_media');
Route::post('/media_libraries/store', 'MediaLibraryController@store')->name('media_libraries.store');


Route::post('/medicine_template/store', 'MedicineTemplateController@store')->name('medicine_template.store');
Route::get('/medicine_template/get-all', 'MedicineTemplateController@index')->name('medicine_template.index');
Route::post('/medicine_template/add-to-appointment', 'MedicineTemplateController@addToAppointment')->name('medicine_template.add_to_appointment');

Route::post('/medications/store/{appointment_id}', 'MedicationController@store')->name('medications.store');
Route::post('/medications/favourite/store', 'MedicationController@storeFavouriteMedication')->name('medications.add_to_favourite');
Route::post('/medications/favourite/add_to_appointment', 'MedicationController@addFavouriteToAppointment')->name('favourite_medications.add_to_appointment');
Route::get('/medications/favourite/get', 'MedicationController@getFavouriteMedication')->name('medications.get_favourite');
Route::get('/medications/{appointment_id}/get_medications', 'MedicationController@getMedication')->name('medications.get_medications');
Route::get('/medications/{appointment_id}/get_previous_medications', 'MedicationController@getPreviousMedication')->name('medications.get_previous_medications');

Route::delete('/medications/delete/{id}', 'MedicationController@destroy')->name('medications.destroy'); // Delete 
// patients/appointments   - List only doctor wise
    // patients/appointments/todays   - List only todays patients doctor wise
    // patients/appointments/create
    // patients/appointments/A2023045255/view
    // patients/appointments/registration