<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/reg', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:sanctum');

// Create a new appointment
Route::post('/appointment/book', [AppointmentController::class, 'make_appointment'])->middleware('auth:sanctum');

// List appointments for the authenticated user
Route::get('/appointments', [AppointmentController::class, 'index'])->middleware('auth:sanctum');

// List appointments for the authenticated doctor
Route::get('/doctor/appointments', [DoctorController::class, 'index'])->middleware('auth:sanctum');

// Mark an appointment as "seen" or "completed"
Route::put('/doctor/appointments/{appointment}', [DoctorController::class, 'update_appointment'])->middleware('auth:sanctum');

// Create a referral to a specialist
Route::post('/doctor/referrals', [DoctorController::class, 'storeReferral'])->middleware('auth:sanctum');
Route::post('/specialist/handover', [SpecialistController::class, 'handoverToPharmacy'])->middleware('auth:sanctum');
Route::post('/pharmacy/handover', [PharmacyController::class, 'handoverToBilling'])->middleware('auth:sanctum');

// List referrals created by the doctor
// Route::get('/doctor/referrals', 'DoctorController@indexReferrals')->middleware('auth:sanctum');
