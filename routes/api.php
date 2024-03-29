<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
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
        ], 200);
    });
    // Public route
    Route::get('/home/categories', [DashboardController::class, 'getCategoryHome']);
    Route::get('/home/sliders/banners', [DashboardController::class, 'getSliderBanner']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/top', [ProductController::class, 'getTop']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/product/{slug}', [ProductController::class, 'findBySlug']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'getBySlug']);
    Route::get('/category/{categorySlug}', [CategoryController::class, 'getListProduct']);
    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show']);
    Route::get('/subscriptions-by-user/{userId}', [SubscriptionController::class, 'getSubsByUserId']);
    Route::get('/subscriptions-by-admin', [SubscriptionController::class, 'getSubByAdmin']);
    //Auth route
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/zalopay/payment', [UserSubscriptionController::class, 'zalopayPayment']);
    Route::get('/zalopay/bank-list', [UserSubscriptionController::class, 'zalopayBankList']);
    Route::get('/zalopay/status', [UserSubscriptionController::class, 'zalopayStatusPayment']);
    Route::put('/payment-status', [UserSubscriptionController::class, 'updatePaymentStatus']);

    // Protected route
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
        //Products
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::post('/products', [ProductController::class, 'store']);

        //Subscription
        Route::post('/subscriptions', [SubscriptionController::class, 'store']);
        Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy']);
        Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update']);
        Route::post('/subscription-details', [SubscriptionDetailController::class, 'store']);
        Route::post('/subscription-details/bulk', [SubscriptionDetailController::class, 'bulkInsert']);
        Route::put('/subscription-details/{subscriptionDetail}', [SubscriptionDetailController::class, 'update']);
        Route::delete('/subscription-details/{id}', [SubscriptionDetailController::class, 'destroy']);
        Route::post('/subscription-details/update/{subscriptionId}', [SubscriptionDetailController::class, 'updateList']);
        Route::post('/subscriptions/copy-new-subscription', [SubscriptionController::class, 'copySubscription']);

        //Profile user
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
        Route::get('/usersprofile', [UserController::class, 'getUsersProfile']);
        Route::get('/profiles', [ProfileController::class, 'index']);
        Route::get('/profiles/{user_id}', [ProfileController::class, 'show']);
        Route::put('/profiles/{user_id}', [ProfileController::class, 'update']);

        //Register subscription
        Route::apiResource('/user-subscription', UserSubscriptionController::class);

        //Subscription create by user
        Route::get('/user-subscriptions', [UserSubscriptionController::class, 'index']);
        Route::post('/subscription-users', [SubscriptionsUserController::class, 'store']);
        Route::get('/subscriptions-user/{userId}', [UserSubscriptionController::class, 'getUserSubsByUserId']);

        Route::get('/admin/dashboard', [DashboardController::class, 'index']);

        //Order
        Route::post('/order', [OrderController::class, 'save']);
        Route::get('/orders', [OrderController::class, 'list']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);

        //Favorites
        Route::get('/favorites/{userId}', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'save']);
        Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
    });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
