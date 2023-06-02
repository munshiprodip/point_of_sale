<?php
// organizations routes
Route::get('/organizations', 'OrganizationController@index')->name('organizations'); // Read
Route::post('/organizations/store', 'OrganizationController@store')->name('organizations.store'); // Write
Route::get('/organizations/find/{id}', 'OrganizationController@findById')->name('organizations.find'); // Modify
Route::patch('/organizations/update/{id}', 'OrganizationController@update')->name('organizations.update'); // Modify
Route::get('/organizations/change_status/{id}', 'OrganizationController@changeStatus')->name('organizations.change_status'); // Modify
Route::delete('/organizations/delete/{id}', 'OrganizationController@destroy')->name('organizations.destroy'); // Delete

// departments routes
Route::get('/departments', 'DepartmentController@index')->name('departments'); // Read
Route::post('/departments/store', 'DepartmentController@store')->name('departments.store'); // Write
Route::get('/departments/find/{id}', 'DepartmentController@findById')->name('departments.find'); // Modify
Route::patch('/departments/update/{id}', 'DepartmentController@update')->name('departments.update'); // Modify
Route::get('/departments/change_status/{id}', 'DepartmentController@changeStatus')->name('departments.change_status'); // Modify
Route::delete('/departments/delete/{id}', 'DepartmentController@destroy')->name('departments.destroy'); // Delete

// schedules routes
Route::get('/schedules', 'ScheduleController@index')->name('schedules'); // Read
Route::post('/schedules/store', 'ScheduleController@store')->name('schedules.store'); // Write
Route::get('/schedules/find/{id}', 'ScheduleController@findById')->name('schedules.find'); // Modify
Route::patch('/schedules/update/{id}', 'ScheduleController@update')->name('schedules.update'); // Modify
Route::get('/schedules/change_status/{id}', 'ScheduleController@changeStatus')->name('schedules.change_status'); // Modify
Route::delete('/schedules/delete/{id}', 'ScheduleController@destroy')->name('schedules.destroy'); // Delete

// employees routes
Route::get('/employees', 'EmployeeController@index')->name('employees'); // Read
Route::post('/employees/store', 'EmployeeController@store')->name('employees.store'); // Write
Route::get('/employees/find/{id}', 'EmployeeController@findById')->name('employees.find'); // Modify
Route::patch('/employees/update/{id}', 'EmployeeController@update')->name('employees.update'); // Modify
Route::get('/employees/change_status/{id}', 'EmployeeController@changeStatus')->name('employees.change_status'); // Modify
Route::delete('/employees/delete/{id}', 'EmployeeController@destroy')->name('employees.destroy'); // Delete

// attendances routes 
Route::get('/attendances', 'AttendanceController@index')->name('attendances'); // Read
Route::get('/attendances/logs', 'AttendanceController@attendancelogs')->name('attendances.attendancelogs'); // Read


// reports routes 
Route::get('/reports/index', 'ReportController@index')->name('reports.index');
Route::get('/reports/submit', 'ReportController@generateReport')->name('reports.submit');
Route::get('/reports/daily_attendances', 'ReportController@dailyAttendance')->name('reports.daily_attendances');
