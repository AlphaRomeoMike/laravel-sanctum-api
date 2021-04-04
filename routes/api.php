<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Models\Product;
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
/*
|--------------------------------------------------------------------------
| We can also create a resource group if we only have a simple Create,
| Read, Update and Delete from the model!
|--------------------------------------------------------------------------
|
| Example: Route::resource('products', ProductController::class)
|
*/

// Public Routes
Route::post('/register',[AuthController::class, 'register']);
Route::get('/products',[ProductController::class, 'index']);
Route::get('/Product/{id}', [ProductController::class, 'show']);
Route::get('products/search/{name}', [ProductController::class, 'search']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout',[AuthController::class, 'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
