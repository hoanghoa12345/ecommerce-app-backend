<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

    //Auth route
    Route::post('/categories',[CategoryController::class,'store']);
    Route::put('/products/{product}',[ProductController::class,'update']);
    Route::delete('/products/{product}',[ProductController::class,'destroy']);
    Route::post('/products',[ProductController::class,'store']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
