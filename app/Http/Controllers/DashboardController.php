<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function loadSection($section)
    {
        $views = [
            'dashboard' => 'dashboard.main',
            'suppliers' => 'suppliers.index',
            'stock-in' => 'stock_in.index',
            'inventory' => 'inventory.index',
            'rooms' => 'rooms.index',
            'reports' => 'reports.index',
        ];

        if (array_key_exists($section, $views)) {
            return view($views[$section]);
        }

        return response()->json(['error' => 'Section not found'], 404);
    }
}