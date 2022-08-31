<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/
use Bigpxl\UserApproval\Http\Controllers\UserApprovalController;

Route::get('/unapproved-athletes', UserApprovalController::class.'@getUnapprovedAthletes');
Route::get('/unapproved-coaches', UserApprovalController::class.'@getUnapprovedCoaches');

Route::post('/approve-coach/{user}', UserApprovalController::class.'@approveCoach');
Route::post('/reject-coach/{user}', UserApprovalController::class.'@rejectCoach');

Route::get('/search-colleges', UserApprovalController::class.'@searchCollege');

Route::post('/approve-athlete/{user}', UserApprovalController::class.'@approveAthlete');