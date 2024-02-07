<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
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

  // profile route----------
Route::get('/profile',[ProfileController::class,'index']);
Route::put('/profile',[ProfileController::class,'update']);
Route::post('/upload_profile_picture',[ProfileController::class,'updateProfilePicture']);


Route::get('/{pathMatch}', function () {
    return view('backend.layouts.app');
})->where('pathMatch',".*")->middleware('auth');





 



Route::middleware('auth')->prefix('api')->group(function(){

    
    });
    

      
 