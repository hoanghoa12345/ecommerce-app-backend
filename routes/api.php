<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionDetailController;
use App\Http\Controllers\UserController;
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
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/top',[ProductController::class, 'getTop']);
    Route::get('/product/{slug}',[ProductController::class, 'findBySlug']);
    Route::get('/products/{product}',[ProductController::class,'show']);
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/{slug}',[CategoryController::class,'getBySlug']);
    Route::get('/category/{categorySlug}',[CategoryController::class,'getListProduct']);
    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show']);
    //Auth route
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);

    // Protected route
    Route::group(['middleware'=>['auth:sanctum']],function(){
        Route::post('/logout',[AuthController::class,'logout']);
        Route::post('/categories',[CategoryController::class,'store']);
        Route::put('/products/{product}',[ProductController::class,'update']);
        Route::delete('/products/{product}',[ProductController::class,'destroy']);
        Route::post('/products',[ProductController::class,'store']);
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);
        Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy']);
        Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update']);
        Route::post('/subscription-details', [SubscriptionDetailController::class, 'store']);
        Route::post('/subscription-details/bulk',[SubscriptionDetailController::class, 'bulkInsert']);
        Route::put('/subscription-details/{subscriptionDetail}', [SubscriptionDetailController::class, 'update']);
        Route::delete('/subscription-details', [SubscriptionDetailController::class, 'destroy']);
        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
        Route::get('/users/{id}',[UserController::class,'show']);
        Route::put('/users/{id}',[UserController::class,'update']);
        Route::delete('/users/{id}',[UserController::class,'destroy']);
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
