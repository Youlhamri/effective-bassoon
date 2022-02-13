<?php

use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[DataController::class,'index'])->name('admin')->middleware('auth');
Route::get('show/{id}',[DataController::class,'show'])->name('show');


Route::get('display',[DataController::class,'displayData'])->name('display');
//create new
Route::get('create',[DataController::class,'create'])->name('create');
Route::post('store',[DataController::class,'store'])->name('store');

//edit
Route::get('edit/{id}',[DataController::class,'edit'])->name('edit')->middleware('auth');
Route::put('update/{id}',[DataController::class,'update'])->name('update')->middleware('auth');

//Change Status
Route::put('status/{id}',[DataController::class,'changestatus'])->name('status')->middleware('auth');

//Change Status
Route::delete('delete/{id}',[DataController::class,'destroy'])->name('destroy')->middleware('auth');

//Download file from public folser
Route::post('upload/{id}',[DataController::class,'upload'])->name('upload');
Auth::routes();

