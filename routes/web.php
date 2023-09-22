<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\VisitorController;
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
Route::middleware(['guest'])->group(function(){
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login',[LoginController::class,'store'])->name('login.store');
});

Route::middleware(['auth'])->group(function(){
    Route::post('logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/',[HomeController::class,'index'])->name('home');

    Route::prefix('security')->group(function(){
        Route::get('list',[SecurityController::class,'index'])->name('security.index');
        Route::post('create',[SecurityController::class,'store'])->name('security.create');
        Route::get('edit{id}',[SecurityController::class,'edit'])->name('security.edit');
        Route::get('data',[SecurityController::class,'ajaxData'])->name('security.ajax');
        Route::post('delete',[SecurityController::class,'delete'])->name('security.delete');
    });

    Route::prefix('resident')->group(function(){
        Route::get('list',[ResidentController::class,'index'])->name('resident.index');
        Route::post('store',[ResidentController::class,'store'])->name('resident.store');
        Route::get('edit{id}',[ResidentController::class,'edit'])->name('resident.edit');
        Route::get('data',[ResidentController::class,'ajaxData'])->name('resident.ajax');
        Route::post('delete',[ResidentController::class,'delete'])->name('resident.delete');
    });

    Route::prefix('visitor')->group(function(){
        Route::get('list',[VisitorController::class,'index'])->name('visitor.index');
        Route::get('data',[VisitorController::class,'ajaxData'])->name('visitor.ajax');
    });

});
