<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserDocumentController;
use App\Http\Controllers\Api\UserCartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserPurchaseController;
use App\Http\Controllers\Api\UserStoreController;

// Route::get('/test', function () {
//     return response()->json(['message' => 'API route works!']);
// });


// Route::get('/test2', function () {
//     return response()->json(['message' => 'API route works!']);
// });

//users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'getUser']);
Route::post('/login', [UserController::class, 'login']);


//user document
Route::post('/user-document', [UserDocumentController::class, 'store']);
Route::get('/user-document/{userId}', [UserDocumentController::class, 'show']);

//user cart
Route::post('/user-cart', [UserCartController::class, 'store']);
Route::get('/user-cart/{userId}', [UserCartController::class, 'show']);
Route::delete('/user-cart/{userId}/{productId}', [UserCartController::class, 'deleteProductFromCart']);


//products
Route::post('/products', [ProductController::class, 'store']);
Route::delete('/products/{userId}', [ProductController::class, 'deleteProductsBySeller']);
Route::get('/products', [ProductController::class, 'show']);
Route::get('/products/{userId}', [ProductController::class, 'productsByUser']);

//user purchase
Route::post('/user-purchase', [UserPurchaseController::class, 'store']);
Route::get('/user-purchase/{userId}', [UserPurchaseController::class, 'show']);
Route::get('/user-purchase/user/{userId}', [UserPurchaseController::class, 'getUserOrders']);
Route::get('/user-purchases/admin', [UserPurchaseController::class, 'showAdmin']);

//user store
Route::post('/user-store', [UserStoreController::class, 'store']);
Route::get('/user-store/{userId}', [UserStoreController::class, 'show']);