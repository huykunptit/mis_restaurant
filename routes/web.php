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
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StaffOrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerManagementController;
use App\Http\Controllers\StaffManagementController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\AttendanceController;
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

        // Cart
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::put('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Checkout
        Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

        // Order History
        Route::get('orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
        Route::get('orders/{id}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');

    });


// |--------------------------------------------------------------------------
// | Admin
// |--------------------------------------------------------------------------

    Route::prefix('admin')->middleware(['admin'])->group(function() {

        Route::get('home', [OrderController::class, 'dashboard'])->name('home.admin');
        Route::get('orders', [OrderController::class, 'index'])->name('orders.admin');

        // Customer Management
        Route::prefix('customers')->group(function() {
            Route::get('/', [CustomerManagementController::class, 'index'])->name('admin.customers.index');
            Route::get('create', [CustomerManagementController::class, 'create'])->name('admin.customers.create');
            Route::post('store', [CustomerManagementController::class, 'store'])->name('admin.customers.store');
            Route::get('edit/{id}', [CustomerManagementController::class, 'edit'])->name('admin.customers.edit');
            Route::put('update/{id}', [CustomerManagementController::class, 'update'])->name('admin.customers.update');
            Route::delete('delete/{id}', [CustomerManagementController::class, 'destroy'])->name('admin.customers.destroy');
        });

        // Staff Management
        Route::prefix('staffs')->group(function() {
            Route::get('/', [StaffManagementController::class, 'index'])->name('admin.staffs.index');
            Route::get('create', [StaffManagementController::class, 'create'])->name('admin.staffs.create');
            Route::post('store', [StaffManagementController::class, 'store'])->name('admin.staffs.store');
            Route::get('edit/{id}', [StaffManagementController::class, 'edit'])->name('admin.staffs.edit');
            Route::put('update/{id}', [StaffManagementController::class, 'update'])->name('admin.staffs.update');
            Route::delete('delete/{id}', [StaffManagementController::class, 'destroy'])->name('admin.staffs.destroy');
        });

        // Shift Management
        Route::prefix('shifts')->group(function() {
            Route::get('/', [ShiftController::class, 'index'])->name('admin.shifts.index');
            Route::get('create', [ShiftController::class, 'create'])->name('admin.shifts.create');
            Route::post('store', [ShiftController::class, 'store'])->name('admin.shifts.store');
            Route::get('edit/{id}', [ShiftController::class, 'edit'])->name('admin.shifts.edit');
            Route::put('update/{id}', [ShiftController::class, 'update'])->name('admin.shifts.update');
            Route::delete('delete/{id}', [ShiftController::class, 'destroy'])->name('admin.shifts.destroy');
        });

        // Attendance Management
        Route::prefix('attendances')->group(function() {
            Route::get('/', [AttendanceController::class, 'index'])->name('admin.attendances.index');
            Route::get('report', [AttendanceController::class, 'report'])->name('admin.attendances.report');
        });

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

        // Staff Orders - Đặt món tại bàn
        Route::get('orders/select-table', [StaffOrderController::class, 'selectTable'])->name('staff.orders.select-table');
        Route::get('orders/create', [StaffOrderController::class, 'create'])->name('staff.orders.create');
        Route::post('orders', [StaffOrderController::class, 'store'])->name('staff.orders.store');
        Route::get('orders/table/{tableId}', [StaffOrderController::class, 'table'])->name('staff.orders.table');

        // Staff Payment
        Route::get('payment/table/{tableId}', [PaymentController::class, 'table'])->name('staff.payment.table');
        Route::post('payment/create-qr', [PaymentController::class, 'createQrCode'])->name('staff.payment.create-qr');
        Route::post('payment/confirm/{paymentId}', [PaymentController::class, 'confirm'])->name('staff.payment.confirm');

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
        // Profile & Settings
        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        
        // Notifications
        Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
        Route::get('notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::post('notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        
        Route::resource('reservations', ReservationController::class);
        Route::resource('tables', TableController::class)->middleware('auth')->except('show');
        Route::get('/tables/list', [TableController::class, 'list'])->name('tables.list');
        Route::get('tables/{table}', [TableController::class, 'show'])->name('tables.show');
        Route::post('/tables/merge', [TableController::class, 'merge'])->name('tables.merge');
        Route::post('/tables/{id}/revert', [TableController::class, 'revertMerge'])->name('tables.revert');

    });