<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionDetailController;
use App\Http\Controllers\SubscriptionsUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriptionController;
use App\Models\UserSubscription;
use App\Http\Controllers\ProfileController;
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
Route::prefix('v1')->group(function () {
    Route::get('/about', function () {
        return response([
            "API Name" => "Shop API",
            "version" => "v1.0.0"
        ],200);
    });
    // Public route
    Route::get('/home/categories',[DashboardController::class,'getCategoryHome']);
    Route::get('/home/sliders/banners',[DashboardController::class,'getSliderBanner']);
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/top',[ProductController::class, 'getTop']);
    Route::get('/products/search',[ProductController::class, 'search']);
    Route::get('/product/{slug}',[ProductController::class, 'findBySlug']);
    Route::get('/products/{product}',[ProductController::class,'show']);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/{slug}',[CategoryController::class,'getBySlug']);
    Route::get('/category/{categorySlug}',[CategoryController::class,'getListProduct']);
    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show']);
    Route::get('/subscriptions-by-admin', [SubscriptionController::class, 'getSubByAdmin']);
    //Auth route
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login'])->name('login');

    // Protected route
    Route::group(['middleware'=>['auth:sanctum']],function(){
        Route::post('/logout',[AuthController::class,'logout']);
        Route::post('/categories',[CategoryController::class,'store']);

        //Products
        Route::put('/products/{product}',[ProductController::class,'update']);
        Route::delete('/products/{product}',[ProductController::class,'destroy']);
        Route::post('/products',[ProductController::class,'store']);

        //Subscription
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);
        Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy']);
        Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update']);
        Route::post('/subscription-details', [SubscriptionDetailController::class, 'store']);
        Route::post('/subscription-details/bulk',[SubscriptionDetailController::class, 'bulkInsert']);
        Route::put('/subscription-details/{subscriptionDetail}', [SubscriptionDetailController::class, 'update']);
        Route::delete('/subscription-details', [SubscriptionDetailController::class, 'destroy']);

        //Profile user
        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
        Route::get('/users/{id}',[UserController::class,'show']);
        Route::put('/users/{id}',[UserController::class,'update']);
        Route::delete('/users/{id}',[UserController::class,'destroy']);
        Route::get('/usersprofile',[UserController::class,'getUsersProfile']);
        Route::get('/profiles',[ProfileController::class,'index']);
        Route::get('/profiles/{user_id}',[ProfileController::class,'show']);
        Route::put('/profiles/{user_id}',[ProfileController::class,'update']);

        //Register subscription
        Route::apiResource('/user-subscription', UserSubscriptionController::class);

        //Subscription create by user
        Route::post('/subscription-users', [SubscriptionsUserController::class,'store']);
        Route::get('/subscription-users/{user}', [SubscriptionsUserController::class, 'byUser']);
        Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
