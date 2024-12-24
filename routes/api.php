<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ModeratorPanelController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');


Route::resource('/admin_panel', AdminPanelController::class)
    ->middleware(['auth:sanctum', 'administrator']);

Route::middleware(['auth:sanctum', 'moderator'])->group(function () {
    Route::get('/moderate_adverts', [ModeratorPanelController::class, 'index']);
    Route::get('/moderate_adverts/user/{user}', [ModeratorPanelController::class, 'getAdvertsByUser']);
    Route::get('/moderate_adverts/inactive', [ModeratorPanelController::class, 'getInactiveAdverts']);
    Route::get('/moderate_adverts/{advert}', [ModeratorPanelController::class, 'show'])
        ->name('moderate_adverts.show');
    Route::put('/moderate_adverts/{advert}', [ModeratorPanelController::class, 'update']);
    Route::delete('/moderate_adverts/{advert}', [ModeratorPanelController::class, 'destroy']);
    //Route::resource('/moderate_adverts', ModeratorPanelController::class);
});


Route::get('/adverts', [AdvertController::class, 'index']);
Route::get('/adverts/{advert}', [AdvertController::class, 'show'])->name('adverts.show');
Route::get('/adverts/category/{category}', [AdvertController::class, 'showByCategory']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/adverts/{advert}', [AdvertController::class, 'show'])->name('adverts.show');
    Route::post('/adverts', [AdvertController::class, 'store']);
    Route::put('/adverts/{advert}', [AdvertController::class, 'update']);
    Route::delete('/adverts/{advert}', [AdvertController::class, 'destroy']);
    Route::get('/adverts/byUser/{user}', [AdvertController::class, 'getByUser']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/messages', [MessageController::class, 'store']);
    Route::get('/messages/{advert}/{user}', [MessageController::class, 'show']);
    Route::get('/messages/{advert}', [MessageController::class, 'showDialogues']);
});
