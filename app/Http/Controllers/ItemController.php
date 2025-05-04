<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch items with category relationships
        $items = Item::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhereHas('category', function ($query) use ($search) {
                                 $query->where('name', 'like', "%{$search}%");
                             });
            })->get();

        // Fetch all categories for the dropdown
        $categories = ItemCategory::all();

        // Pass data to the view
        return view('inventory.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name',
            'category_id' => 'required|exists:item_categories,itemctgry_id',
            'price' => 'required|numeric|min:0',
        ]);

        // Create the item
        Item::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        // Fetch the item and related data
        $item = Item::findOrFail($id);
        $categories = ItemCategory::all();

        return view('inventory.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name,' . $id . ',item_id',
            'category_id' => 'required|exists:item_categories,itemctgry_id',
            'price' => 'required|numeric|min:0',
        ]);

        // Update the item
        $item = Item::findOrFail($id);
        $item->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        // Delete the item
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully!');
    }
}