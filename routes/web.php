<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;
// |--------------------------------------------------------------------------
// | Guest
// |--------------------------------------------------------------------------

    Route::middleware(['guest'])->group(function() {

        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/', [LoginController::class, 'login'])->name('login');

    });


// |--------------------------------------------------------------------------
// | Customer
// |--------------------------------------------------------------------------

    Route::prefix('customer')->middleware(['customer'])->group(function() {

        Route::get('home', [CustomerController::class, 'index'])->name('home.customer');
        Route::get('menu', [MenuController::class, 'customer'])->name('menu.customer');
        Route::get('help', [CustomerController::class, 'help'])->name('help.customer');

    });


// |--------------------------------------------------------------------------
// | Admin
// |--------------------------------------------------------------------------

    Route::prefix('admin')->middleware(['admin'])->group(function() {

        Route::get('home', [OrderController::class, 'dashboard'])->name('home.admin');
        Route::get('orders', [OrderController::class, 'index'])->name('orders.admin');

        // User
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Category
        Route::get('category', [CategoryController::class, 'index'])->name('category.index');
        Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    });


// |--------------------------------------------------------------------------
// | Staff
// |--------------------------------------------------------------------------

    Route::prefix('staff')->middleware(['staff'])->group(function() {

        Route::get('home', [OrderController::class, 'index'])->name('home.staff');

    });


// |--------------------------------------------------------------------------
// | Staff and Admin
// |--------------------------------------------------------------------------

    Route::prefix('authorized')->middleware(['staffOrAdmin'])->group(function() {

        // Order
        Route::put('order/complete/{id}', [OrderController::class, 'complete'])->name('order.complete');
        Route::put('order/paid/{id}', [OrderController::class, 'paid'])->name('order.paid');
        Route::get('order/show/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::put('order/show/complete/{id}', [OrderController::class, 'completeSingleOrder'])->name('order.show.complete');
        Route::delete('order/show/cancel/{id}', [OrderController::class, 'cancelSingleOrder'])->name('order.show.cancel');

        // Menu
        Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
        Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('menu/store', [MenuController::class, 'store'])->name('menu.store');
        Route::get('menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::put('menu/disable/{id}', [MenuController::class, 'disable'])->name('menu.disable');
        Route::put('menu/enable/{id}', [MenuController::class, 'enable'])->name('menu.enable');
        Route::delete('menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    
    });

// Order table

// |--------------------------------------------------------------------------
// | All
// |--------------------------------------------------------------------------

    Route::post('logout', [LogoutController::class, 'index'])->name('logout');
    
    Route::middleware('auth')->group(function () {
        Route::resource('reservations', ReservationController::class);
        Route::resource('tables', TableController::class)->middleware('auth')->except('show');
        Route::get('/tables/list', [TableController::class, 'list'])->name('tables.list');
        Route::get('tables/{table}', [TableController::class, 'show'])->name('tables.show');
        Route::post('/tables/merge', [TableController::class, 'merge'])->name('tables.merge');
        Route::post('/tables/{id}/revert', [TableController::class, 'revertMerge'])->name('tables.revert');

    });