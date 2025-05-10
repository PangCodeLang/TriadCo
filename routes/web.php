<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ReportsController;

//-----------------------------------------------------------------------------------------------

// Default Route
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login'); 
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//-----------------------------------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    
    // Supplier 
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');  
    
    // Inventory
    Route::get('/inventory', [ItemController::class, 'index'])->name('inventory.index'); 
    Route::post('/inventory', [ItemController::class, 'store'])->name('inventory.store'); // Removed stockin_id
    Route::get('/inventory/{id}/edit', [ItemController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [ItemController::class, 'update'])->name('inventory.update'); 
    Route::delete('/inventory/{id}', [ItemController::class, 'destroy'])->name('inventory.destroy'); 
    Route::get('/inventory/item-categories', [ItemCategoryController::class, 'index'])->name('inventory.itemctgry');
    Route::post('/inventory/item-categories', [ItemCategoryController::class, 'store'])->name('inventory.itemctgry.store');    
    Route::get('/inventory/item-categories/{id}/edit', [ItemCategoryController::class, 'edit'])->name('inventory.itemctgryedit');
    Route::put('/inventory/item-categories/{id}', [ItemCategoryController::class, 'update'])->name('inventory.itemctgry.update');
    Route::delete('/inventory/item-categories/{id}', [ItemCategoryController::class, 'destroy'])->name('inventory.itemctgry.destroy');
    
    // Stock In 
    Route::get('/stock_in', [StockInController::class, 'index'])->name('stock_in.index');
    Route::get('/stock_in/create', [StockInController::class, 'create'])->name('stock_in.create');
    Route::post('/stock_in', [StockInController::class, 'store'])->name('stock_in.store');
    Route::get('/stock_in/{id}/edit', [StockInController::class, 'edit'])->name('stock_in.edit');
    Route::put('/stock_in/{id}', [StockInController::class, 'update'])->name('stock_in.update');
    Route::delete('/stock_in/{id}', [StockInController::class, 'destroy'])->name('stock_in.destroy');

    // Rooms
    Route::get('/rooms', function () {
        return view('rooms.index');
    })->name('rooms.index');
    
    // Profile
    Route::get('/profile', [AuthController::class, 'viewProfile'])->name('profile.view');
});

//-----------------------------------------------------------------------------------------------

// Admin-Only Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('dashboard.index'); 
        } elseif (auth()->user()->role === 'employee') {
            $employee = \App\Models\Employee::where('user_id', auth()->id())->first();
            return view('dashboard.index', compact('employee')); 
        }
        abort(403, 'Unauthorized');
    })->name('dashboard');

    // Reports
    Route::get('/reports', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\ReportsController::class)->index(request());
    })->name('reports.index');

    // Employees
    Route::get('/employees', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\EmployeeController::class)->index();
    })->name('employees.index');

    Route::get('/employees/create', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return view('employees.create');
    })->name('employees.create');

    Route::post('/employees', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\EmployeeController::class)->store(request());
    })->name('employees.store');

    Route::get('/employees/{employee}/edit', function ($employee) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\EmployeeController::class)->edit(app(\App\Models\Employee::class)->findOrFail($employee));
    })->name('employees.edit');

    Route::put('/employees/{employee}', function ($employee) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\EmployeeController::class)->update(request(), app(\App\Models\Employee::class)->findOrFail($employee));
    })->name('employees.update');

    Route::delete('/employees/{employee}', function ($employee) {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
        return app(\App\Http\Controllers\EmployeeController::class)->destroy(app(\App\Models\Employee::class)->findOrFail($employee));
    })->name('employees.destroy');
});