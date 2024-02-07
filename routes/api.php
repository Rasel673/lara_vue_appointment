<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

 // user list----------------------


    Route::get('/users', [AdminController::class,'users']);
    Route::post('/create_user', [AdminController::class,'createUsrs']);
    Route::post('/update_user/{id}', [AdminController::class,'updateUsrs']);
    Route::get('/delete_user/{id}', [AdminController::class,'deleteUsrs']);
    Route::post('/change_role', [AdminController::class,'changeRole']);
    Route::get('/user/search/',[AdminController::class,'search']);
    Route::delete('/delete_bulk_user', [AdminController::class,'bulkDelete']);
    
    
    // appointments list----------------------
    Route::get('/appointments', [AppointmentController::class,'index']);
    
    Route::get('/appointments_status', [AppointmentController::class,'appointmentStatus']);
    
    Route::post('/appointments_add', [AppointmentController::class,'addAppointment']);
    
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    
    Route::put('/appointments/{appointment}/edit', [AppointmentController::class, 'update'])->name('appointments.update');
    
    Route::delete('/appointments/{appointment}/delete', [AppointmentController::class, 'destroy'])->name('appointments.delete');

    Route::get('/appointments_stat/count', [AppointmentController::class,'appointments_stat']);

    
    
    // client list route----------------------
    Route::get('/clients', [ClientController::class,'clientList']); 
    
    
   //update settings-------
   Route::get('/settings',[SettingController::class,'index']);
   Route::post('/settings',[SettingController::class,'update']);


   // profile route----------
   Route::get('/profile',[ProfileController::class,'index']);


   //  task route---------
   Route::apiResource('task',TaskController::class);

    


