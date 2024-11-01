<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\DesignerMaterialController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Model3dController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsIsLikeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PremiumFeatureController;
use App\Http\Controllers\ProductColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFeatureController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);
Route::apiResource('carts', CartController::class);
// Route::apiResource('designers', DesignerController::class);
Route::apiResource('designer-materials', DesignerMaterialController::class);
Route::apiResource('materials', MaterialController::class);
Route::apiResource('news', NewsController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-details', OrderDetailController::class);
Route::apiResource('premium-features', PremiumFeatureController::class);
Route::apiResource('products', ProductController::class);


Route::apiResource('subscriptions', SubscriptionController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('user-features', UserFeatureController::class);

Route::apiResource('images', ProductImageController::class);
Route::apiResource('sizes', ProductSizeController::class);
Route::apiResource('colors', ProductColorController::class);

Route::apiResource('model-3d', Model3dController::class);


Route::apiResource('comment', NewsCommentController::class);
Route::apiResource('islike', NewsIsLikeController::class);

use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('designers/order-from-customer/{id}', [DesignerController::class, 'getOrdersForDesigner']);
Route::put('designers/order-detail/update-status/{id}', [DesignerController::class, 'updateStatusOrderDetail']);


Route::get('/designers', [DesignerController::class, 'index'])->name('designers.index');


Route::post('/designers', [DesignerController::class, 'store'])->name('designers.store');


Route::get('/designers/{designer}', [DesignerController::class, 'show'])->name('designers.show');


Route::put('/designers/{designer}', [DesignerController::class, 'update'])->name('designers.update');


Route::delete('/designers/{designer}', [DesignerController::class, 'destroy'])->name('designers.destroy');