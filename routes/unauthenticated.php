<?php

use Illuminate\Support\Facades\Route;

Route::get('pendingEmail/verify/{token}', '\ProtoneMedia\LaravelVerifyNewEmail\Http\VerifyNewEmailController@verify')->name('pendingEmail.verify');