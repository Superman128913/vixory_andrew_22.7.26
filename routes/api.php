<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('info', function() {
    phpinfo();
});

Broadcast::routes(['middleware' => ['auth:sanctum']]);

//Profile page Routes
Route::get('/user/{user}', 'UserController@getOtherUser');
Route::get("theme/{theme}", "ProfileThemesController@getSingle");
Route::get("video/{user}", "VideoController@listUsers");
Route::get("article/user/{user}", "ArticleController@listUsers");
Route::get("sport-field/", "SportFieldController@list");

//Registration routes
Route::get("plan", "PlanController@list");
Route::get("payment-intent", "SubscriptionController@paymentIntent");
Route::post("register", "SubscriptionController@registerUserWithSubscription");

//Misc unrestricted routes
Route::get('/user', 'UserController@getUser');

Route::prefix("college")->group(function() {
    Route::get("/search", "CollegeController@search");
});

Route::prefix("coupon")->group(function(){
    Route::post("/check-validity", "CouponController@checkValidity");
});

Route::prefix("faqs")->group(function() {
    Route::get("/", "FrequentlyAskedQuestionController@list");
});

Route::prefix('blogs')->group(function() {
    Route::get('/', 'BlogController@list');
    Route::get('categories', 'BlogController@categories');
    Route::get('recent', 'BlogController@recent');
    Route::get('featured', 'BlogController@featured');
    Route::get('/{title}', 'BlogController@single');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('connection')->group(function() {
        Route::get("/", "ConnectionController@list");
        Route::post("/", "ConnectionController@create");
        Route::post("/{connection}", "ConnectionController@acceptConnection");
        Route::delete("/{connection}", "ConnectionController@rejectConnection");
    });

    Route::prefix("search")->group(function(){
        Route::post("/", "SearchController@searchUsers");
    });

    Route::prefix("notifications")->group(function(){
        Route::get("/{user}", "NotificationController@getUnread");
        Route::post("/read/{user}", "NotificationController@markAsRead");
    });

    Route::prefix("savedsearch")->group(function(){
        Route::get("/", "SavedSearchController@list");
        Route::get("/{saved_search}", "SavedSearchController@getSingle");
        Route::patch("/{saved_search}", "SavedSearchController@update");
        Route::post("/", "SavedSearchController@create");
        Route::delete("/{saved_search}", "SavedSearchController@delete");
    });

    Route::prefix("theme")->group(function() {
        Route::get("/", "ProfileThemesController@get");
        Route::post("/{user}", "ProfileThemesController@setUserTheme");
    });

    Route::prefix("video")->group(function() {
        Route::get("/sources", "VideoController@getSources");
        Route::get("/{video}", "VideoController@getSingle");
        Route::get("/", "VideoController@list");
        Route::post("/byreference", "VideoController@uploadByReference");
        Route::post("/", "VideoController@upload");
        Route::patch("/{video}", "VideoController@update");
        Route::delete("/{video}", "VideoController@delete");
    });

    Route::prefix('billing')->group(function() {
        Route::get("payments", "SubscriptionController@getPayments");
        Route::get("details", "SubscriptionController@getBillingDetails");
        Route::patch("subscription/{plan}", "SubscriptionController@changeSubscription");
        Route::post("payment-method", "SubscriptionController@createPaymentMethod");
        Route::delete("payment-method/{payment_method}", "SubscriptionController@deletePaymentMethod");
        Route::post("payment-method/primary", "SubscriptionController@makePaymentMethodPrimary");
    });

    Route::prefix('article')->group(function() {
        Route::post("/", 'ArticleController@store');
        Route::post("details", "ArticleController@getDetails");
        Route::get("/", "ArticleController@list");
        Route::get("/{article}", "ArticleController@single");
        Route::patch("/{article}", "ArticleController@update");
        Route::delete("/{article}", "ArticleController@delete");
    });

    Route::prefix('user')->group(function(){
        Route::patch("/partial/{user}", "UserController@updatePartial");
        Route::patch("{user}", "UserController@update");
        Route::post('/reactivate', 'UserController@reactivate');
        Route::post('/deactivate', 'UserController@deactivate');
        Route::get('/steps', 'UserController@listSteps');
        Route::delete('/', 'UserController@deleteUser');
        Route::post('/images/header/{theme_id}', 'UserController@updateHeader');
        Route::post('/images/profile', 'UserController@uploadProfileImage');
        Route::post('/images/reserved', 'UserController@uploadReservedFile');
        Route::post('/images/tmp', 'UserController@uploadTempImage');
    });

    Route::prefix('sport')->group(function() {
        Route::get("/", "SportController@list");
        Route::get("/full", "SportController@listFull");
    });

    Route::prefix('enums')->group(function () {
        Route::get("countries", "EnumController@getCountries");
        Route::get("school-year", "EnumController@getSchoolYears");
        Route::get("states", "EnumController@getStates");
        Route::get("playing-levels", "EnumController@getPlayingLevels");
    });
});
