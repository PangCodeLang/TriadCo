<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Item;
use App\Models\Room;
use App\Models\Report;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // Fetch data for the dashboard
        $totalStockIn = StockIn::count();
        $totalStockOut = StockOut::count();
        $totalItems = Item::count();
        $totalRooms = Room::count();
        $emptyRooms = Room::where('status', 'empty')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $noStockItems = Item::where('in_stock', 0)->count();

        $occupiedPercentage = $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0;
        $emptyPercentage = $totalRooms > 0 ? ($emptyRooms / $totalRooms) * 100 : 0;

        $itemsNeedingRestock = Item::where('in_stock', 0)->get();

        $recentActivities = Report::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalStockIn',
            'totalStockOut',
            'totalItems',
            'totalRooms',
            'emptyRooms',
            'occupiedRooms',
            'noStockItems',
            'occupiedPercentage',
            'emptyPercentage',
            'itemsNeedingRestock',
            'recentActivities'
        ));
    }
}