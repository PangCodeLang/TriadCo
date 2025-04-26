<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;

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

// Common Routes (accessible by both Admin and Employees)
Route::middleware('auth')->group(function () {
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/stock-in', function () {
        return view('stock_in.index');
    })->name('stock-in.index');

    Route::get('/inventory', function () {
        return view('inventory.index');
    })->name('inventory.index');

    Route::get('/rooms', function () {
        return view('rooms.index');
    })->name('rooms.index');

    Route::get('/profile', [AuthController::class, 'viewProfile'])->name('profile.view');
});

// Role-Based Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('dashboard.main'); // Admin dashboard
        } elseif (auth()->user()->role === 'employee') {
            $employee = \App\Models\Employee::where('user_id', auth()->id())->first();
            return view('dashboard.main', compact('employee')); // Pass $employee to the view
        }
        abort(403, 'Unauthorized');
    })->name('dashboard');

    // Admin-Only Routes
    Route::group([], function () {
        Route::get('/reports', function () {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }
            return view('reports.index');
        })->name('reports.index');

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
            app(EmployeeController::class)->store(request());
        })->name('employees.store');
    });
});