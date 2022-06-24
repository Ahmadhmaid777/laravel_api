<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user/create',[UserController::class,'store']);
Route::post('/user/login',[LoginController::class,'userLogin']);
Route::post('/admin/login',[LoginController::class,'adminLogin']);
Route::get('/countries',[\App\Http\Controllers\CountryController::class,'index']);
Route::get('/leagues',[\App\Http\Controllers\LeagueController::class,'index']);
Route::get('/clubs',[\App\Http\Controllers\ClubController::class,'index']);
Route::get('/matches',[\App\Http\Controllers\MatchController::class,'index']);
Route::get('/matches/filter',[\App\Http\Controllers\MatchController::class,'filterMatches']);
Route::get('/league/filter',[\App\Http\Controllers\LeagueController::class,'filterLeagues']);

Route::middleware(['auth:admin','scopes:admin'])->group(function (){
    Route::get('/users',[UserController::class,'index']);
    Route::post('/country/create',[\App\Http\Controllers\CountryController::class,'store']);
    Route::post('/country/update/{id}',[\App\Http\Controllers\CountryController::class,'update']);
    Route::post('/country/delete/{id}',[\App\Http\Controllers\CountryController::class,'destroy']);
    Route::post('/league/create',[\App\Http\Controllers\LeagueController::class,'store']);
    Route::post('/league/update/{id}',[\App\Http\Controllers\LeagueController::class,'update']);
    Route::post('/league/delete/{id}',[\App\Http\Controllers\LeagueController::class,'destroy']);
    Route::post('/club/create',[\App\Http\Controllers\ClubController::class,'store']);
    Route::post('/club/update/{id}',[\App\Http\Controllers\ClubController::class,'update']);
    Route::post('/club/delete/{id}',[\App\Http\Controllers\ClubController::class,'destroy']);
    Route::post('/match/create',[\App\Http\Controllers\MatchController::class,'store']);
    Route::post('/match/update/{id}',[\App\Http\Controllers\MatchController::class,'update']);
    Route::post('/match/delete/{id}',[\App\Http\Controllers\MatchController::class,'destroy']);


    Route::post('/admin/create',[AdminController::class,'store']);

});
