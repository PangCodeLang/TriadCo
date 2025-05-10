<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Fetch the filter value from the request
        $filter = $request->input('filter');

        // Base query for reports
        $query = Report::with('user')->orderBy('created_at', 'desc');

        // Apply filter based on the selected option
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
        }

        // Paginate the filtered results
        $reports = $query->paginate(10);

        // Calculate statistics
        $totalStockInThisMonth = StockIn::whereMonth('stockin_date', now()->month)
            ->whereYear('stockin_date', now()->year)
            ->count();

        $totalSuppliers = Supplier::count();
        $totalItems = Item::count();

        return view('reports.index', compact('reports', 'totalStockInThisMonth', 'totalSuppliers', 'totalItems'));
    }
}