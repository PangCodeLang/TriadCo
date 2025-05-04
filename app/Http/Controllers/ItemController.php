<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\StockIn;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch items with category and stock-in relationships
        $items = Item::with(['category', 'stockIn'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
            })->get();

        // Fetch all categories for the dropdown
        $categories = ItemCategory::all();

        // Fetch all stock-in records for the dropdown
        $stockIns = StockIn::all();

        // Pass data to the view
        return view('inventory.index', compact('items', 'categories', 'stockIns'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate(Item::$rules);

        Item::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'stockin_id' => $validated['stockin_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();
        $stockIns = StockIn::all();
        return view('inventory.edit', compact('item', 'categories', 'stockIns'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name,' . $id . ',item_id',
            'category_id' => 'required|exists:item_categories,itemctgry_id',
            'stockin_id' => 'required|exists:stock_in,stockin_id',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }
}