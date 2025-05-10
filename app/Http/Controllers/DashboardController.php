<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function loadSection($section)
    {
        $views = [
            'dashboard' => 'dashboard.index',
            'suppliers' => 'suppliers.index',
            'stock-in' => 'stock_in.index',
            'inventory' => 'inventory.index',
            'rooms' => 'rooms.index',
            'reports' => 'reports.index',
        ];

        if (auth()->user()->role === 'employee') {
            $allowedSections = ['suppliers', 'stock-in', 'inventory', 'rooms'];
            if (!in_array($section, $allowedSections)) {
                abort(403, 'Unauthorized');
            }
        }

        if (array_key_exists($section, $views)) {
            return view($views[$section]);
        }

        return response()->json(['error' => 'Section not found'], 404);
    }
    public function index()
    {
                $employee = Employee::where('user_id', Auth::id())->first();
        return view('dashboard', compact('employee'));
    }
}