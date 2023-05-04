<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

//=============================================================================================

// Super Admin routes 
Route::group(
    [
        'middleware' => ['auth'],
        'namespace' => 'App\Http\Controllers',
        'prefix'=>'admin'
    ], 
    __DIR__.'/web/superAdminRoutes.php'
);

// Medications setup routes 
Route::group(
    [
        'middleware' => ['auth'],
        'namespace' => 'App\Http\Controllers',
        'prefix'=>'settings/medications'
    ], 
    __DIR__.'/web/medicationsSetupRoutes.php'
);

// Medications setup routes 
Route::group(
    [
        'middleware' => ['auth'],
        'namespace' => 'App\Http\Controllers',
        'prefix'=>'settings/clinical'
    ], 
    __DIR__.'/web/clinicalComponentsSetupRoutes.php'
);


// Profile setup routes 
Route::group(
    [
        'middleware' => ['auth'],
        'namespace' => 'App\Http\Controllers',
        'prefix'=>'settings/profiles'
    ], 
    __DIR__.'/web/profileSetupRoutes.php'
);


// Patients routes 
Route::group(
    [
        'middleware' => ['auth'],
        'namespace' => 'App\Http\Controllers',
        'prefix'=>'patients'
    ], 
    __DIR__.'/web/patientsRoutes.php'
);
