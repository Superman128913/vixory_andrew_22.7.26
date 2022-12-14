<?php

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
Auth::routes(['verify' => true]);
Route::get('{any}', function () { 
    return view('vue_app'); 
})->where('any', '.*'); 
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/sitemap.xml', '\App\Http\Controllers\SitemapController@index');