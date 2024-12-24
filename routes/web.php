<?php

use App\Http\Controllers\AdvertController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('/adverts', AdvertController::class);

//Route::get('/', function () {
//    return 'Main screen';
//    //return view('welcome');
//});
//
//route::group([
//    'as' => 'adverts',
//    'prefix' => 'adverts',
//    ], function () {
//   Route::get('/', [AdvertController::class, 'index'])->name('index');
//   Route::get('/create', [AdvertController::class, 'create'])->name('create');
//   Route::post('/store', [AdvertController::class, 'store'])->name('store');
//   Route::get('/{id}/edit', [AdvertController::class, 'edit'])->name('edit');
//   Route::put('/{id}/update', [AdvertController::class, 'update'])->name('update');
//   Route::delete('/{id}', [AdvertController::class, 'destroy'])->name('destroy');
//});
