<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockInController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin sees all stock-ins, employees see only their own
        $stockIns = $user->role === 'admin'
            ? StockIn::with(['supplier', 'items'])->get() // Ensure items are loaded
            : StockIn::with(['supplier', 'items'])->where('id', $user->id)->get();

        return view('stock_in.index', compact('stockIns'));
    }

    public function create()
    {
        $suppliers = Supplier::all(); // Get all suppliers for the dropdown
        return view('stock_in.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'stock_in_date' => 'required|date',
            'items' => 'nullable|array', 
            'items.*.name' => 'nullable|string|max:255', 
            'items.*.price' => 'nullable|numeric|min:0', 
            'items.*.quantity' => 'nullable|integer|min:1', 
        ]);

        // Generate Stock-In ID
        $lastStockIn = StockIn::latest('stockin_id')->first();
        $customId = $lastStockIn ? 'SI' . str_pad((int) substr($lastStockIn->stockin_id, 2) + 1, 3, '0', STR_PAD_LEFT) : 'SI001';

        // Create the Stock-In record
        $stockIn = StockIn::create([
            'stockin_id' => $customId,
            'supplier_id' => $validated['supplier_id'],
            'id' => Auth::id(),
            'stock_in_date' => $validated['stock_in_date'],
        ]);

        // Create the associated items (only if valid items are provided)
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $item) {
                if (!empty($item['name']) && !empty($item['price']) && !empty($item['quantity'])) {
                    Item::create([
                        'item_id' => 'IT' . str_pad(Item::count() + 1, 3, '0', STR_PAD_LEFT),
                        'stockin_id' => $stockIn->stockin_id,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
        }

        return redirect()->route('stock_in.index')->with('success', 'Stock-In added successfully!');
    }
}