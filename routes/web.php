<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DeparmentController;
use App\Http\Controllers\Admin\DoctorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//------------Frontend Part----------
Route::get('/',[App\Http\Controllers\Frontend\IndexController::class, 'index'])->name('index');
Route::get('/doctor-list',[App\Http\Controllers\Frontend\IndexController::class, 'doctorList'])->name('doctor');
Route::get('/appointment',[App\Http\Controllers\Frontend\IndexController::class, 'appointment'])->name('appointment');
Route::post('/appointment-store',[App\Http\Controllers\Frontend\IndexController::class, 'appointmentStore'])->name('appointment_store');
Route::post('/appointment-submit',[App\Http\Controllers\Frontend\IndexController::class, 'appointmentSubmit'])->name('appointment_submit');
Route::get('/get-doctor-fee/{id}',[App\Http\Controllers\Frontend\IndexController::class, 'getDoctorFee']); //ajax route doctor fee

Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//------------Backend Part----------
Route::group(['prefix'=>'admin','middleware'=>'auth'],function(){
    Route::get('/',[AdminController::class,'admin'])->name('admin');

    //Department
    Route::resource('department', DeparmentController::class);

    //Doctor
    Route::resource('doctor', DoctorController::class);

    //Appointment
    Route::resource('appointment', AppointmentController::class);

});
