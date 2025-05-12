<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Item;
use App\Models\ReturnedItem;
use App\Models\Report;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOutItems = StockOut::with('item')->get();

        return view('stock_out.index', compact('stockOutItems'));
    }

    public function addToStockOut(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::where('item_id', $id)->first();

        if ($item) {
            if ($validated['quantity'] > $item->in_stock) {
                return redirect()->back()->withErrors(['error' => 'Quantity exceeds available stock.']);
            }

            StockOut::create([
                'item_id' => $item->item_id,
                'quantity' => $validated['quantity'],
            ]);

            // Update the remaining quantity in the Items Table
            $item->in_stock -= $validated['quantity'];

            // Save the updated item
            $item->save();
        } else {
            // If not found in Items Table, try the Returned Items Table
            $returnedItem = ReturnedItem::where('item_id', $id)->first();

            if (!$returnedItem) {
                return redirect()->back()->withErrors(['error' => 'Item not found in either inventory or returned items.']);
            }

            // Handle stock-out for Returned Items Table
            if ($validated['quantity'] > $returnedItem->quantity) {
                return redirect()->back()->withErrors(['error' => 'Quantity exceeds available stock in returned items.']);
            }

            // Add the item to the Stock-Out table
            StockOut::create([
                'item_id' => $returnedItem->item_id,
                'quantity' => $validated['quantity'],
            ]);

            // Update the remaining quantity in the Returned Items Table
            $returnedItem->quantity -= $validated['quantity'];

            // If the quantity becomes 0, delete the returned item
            if ($returnedItem->quantity <= 0) {
                $returnedItem->delete();
            } else {
                $returnedItem->save();
            }
        }

        return redirect()->route('inventory.index')->with('success', 'Item successfully moved to Stock-Out.');
    }

    public function finalize(Request $request)
    {
        $stockOutItems = StockOut::with('item')->get();

        foreach ($stockOutItems as $item) {
            Report::create([
                'activity' => 'Stocked out item: ' . $item->item->name . ' (Quantity: ' . $item->quantity . ')',
                'user_id' => auth()->id(),
            ]);
        }

        StockOut::truncate();

        return redirect()->route('stock_out.index')->with('success', 'All items have been stocked out.');
    }
}