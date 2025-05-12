<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\Room;
use App\Models\ReturnedItem;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        // Query for filtering reports
        $query = Report::with('user')->orderBy('created_at', 'desc');

        if ($filter == 'items') {
            $query->where('activity', 'like', 'Added new item:%')
                ->orWhere('activity', 'like', 'Updated item:%')
                ->orWhere('activity', 'like', 'Deleted item:%');
        } elseif ($filter == 'suppliers') {
            $query->where('activity', 'like', 'Added new supplier:%')
                ->orWhere('activity', 'like', 'Updated supplier:%')
                ->orWhere('activity', 'like', 'Deleted supplier:%');
        } elseif ($filter == 'stock_in') {
            $query->where('activity', 'like', 'Added Stock-In record%')
                ->orWhere('activity', 'like', 'Updated Stock-In record%')
                ->orWhere('activity', 'like', 'Deleted Stock-In record%');
        } elseif ($filter == 'stock_out') {
            $query->where('activity', 'like', 'Stocked out item:%');
        }

        $reports = $query->paginate(10);

        // Statistics for the cards
        $totalStockInThisMonth = StockIn::whereMonth('stockin_date', now()->month)
            ->whereYear('stockin_date', now()->year)
            ->count();

        $totalStockOutThisMonth = Report::where('activity', 'like', 'Stocked out item:%')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalSuppliers = Supplier::count();
        $totalItems = Item::count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $emptyRooms = Room::where('status', 'empty')->count();
        $totalCategories = Item::distinct('category_id')->count();

        // Advanced statistics
        $topStockedOutItem = StockOut::select('item_id', \DB::raw('SUM(quantity) as total'))
            ->groupBy('item_id')
            ->orderByDesc('total')
            ->with('item')
            ->first();

        $topStockedInItem = StockIn::select('item_id', \DB::raw('SUM(quantity) as total'))
            ->groupBy('item_id')
            ->orderByDesc('total')
            ->with('item')
            ->first();

        $mostActiveUser = Report::select('user_id', \DB::raw('COUNT(*) as total'))
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user')
            ->first();

        $totalReturnedItems = ReturnedItem::sum('quantity');

        $recentActivities = Report::latest()->take(5)->get();

        return view('reports.index', compact(
            'reports',
            'totalStockInThisMonth',
            'totalStockOutThisMonth',
            'totalSuppliers',
            'totalItems',
            'totalRooms',
            'occupiedRooms',
            'emptyRooms',
            'totalCategories',
            'topStockedOutItem',
            'topStockedInItem',
            'mostActiveUser',
            'totalReturnedItems',
            'recentActivities'
        ));
    }
}