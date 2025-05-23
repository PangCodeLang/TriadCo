<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Item;
use App\Models\ReturnedItem;
use App\Models\Report;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roomTypeFilter = $request->input('roomtype_filter');

        $roomTypes = RoomType::all();
        $inventoryItems = Item::all();

        $query = Room::with('type');

        if ($roomTypeFilter) {
            $query->where('roomtype_id', $roomTypeFilter);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('type', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        }

        $rooms = $query->paginate(10);

        return view('rooms.index', compact('rooms', 'roomTypes', 'inventoryItems'));
    }

    public function assignItems(Request $request, $id)
    {
        $validated = $request->validate([
            'items.*.item_id' => 'required|exists:items,item_id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($id);

        foreach ($validated['items'] as $item) {
            $inventoryItem = Item::find($item['item_id']);

            if ($inventoryItem->in_stock < $item['quantity']) {
                return redirect()->back()->withErrors([
                    'error' => "Not enough stock for item: {$inventoryItem->name}",
                ]);
            }

            $inventoryItem->in_stock -= $item['quantity'];
            $inventoryItem->save();

            $room->items()->syncWithoutDetaching([
                $item['item_id'] => ['quantity' => $item['quantity']],
            ]);
        }

        if ($room->items()->count() > 0) {
            $room->status = 'occupied';
            $room->save();
        }

        Report::create([
            'activity' => 'Assigned items to room ID: ' . $id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('rooms.index')->with('success', 'Items assigned successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'roomtype_id' => 'required|exists:room_types,roomtype_id',
        ]);

        $room = Room::create([
            'name' => $validated['name'],
            'roomtype_id' => $validated['roomtype_id'],
        ]);

        Report::create([
            'activity' => 'Added new room: ' . $room->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully!');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();

        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $id . ',room_id',
            'roomtype_id' => 'required|exists:room_types,roomtype_id',
        ]);

        $room = Room::findOrFail($id);
        $room->update($validated);

        Report::create([
            'activity' => 'Updated room: ' . $room->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        Report::create([
            'activity' => 'Deleted room: ' . $room->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }

    public function returnItem(Request $request, $id)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,item_id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);

        $room = Room::findOrFail($id);
        $item = $room->items()->where('room_item.item_id', $validated['item_id'])->first();

        if (!$item || $item->pivot->quantity < $validated['quantity']) {
            return redirect()->back()->withErrors(['error' => 'Invalid quantity for return.']);
        }

        $newQuantity = $item->pivot->quantity - $validated['quantity'];
        if ($newQuantity > 0) {
            $room->items()->updateExistingPivot($validated['item_id'], [
                'quantity' => $newQuantity,
            ]);
        } else {
            $room->items()->detach($validated['item_id']);
        }

        ReturnedItem::create([
            'item_id' => $validated['item_id'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
        ]);

        Report::create([
            'activity' => 'Returned item: ' . $item->name . ' (Quantity: ' . $validated['quantity'] . ') from room: ' . $room->name . '. Reason: ' . $validated['reason'],
            'user_id' => auth()->id(),
        ]);

        if ($room->items()->sum('room_item.quantity') == 0) {
            $room->status = 'empty';
            $room->save();
        }

        return redirect()->route('rooms.view', $id)->with('success', 'Item returned successfully!');
    }

    public function view($id)
    {
        $room = Room::with('type', 'items')->findOrFail($id);
        $items = Item::all();

        return view('rooms.view', compact('room', 'items'));
    }
}