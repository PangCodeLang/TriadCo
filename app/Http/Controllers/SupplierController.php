<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:15',
            'contact_person' => 'required|string|max:255',
        ]);

        $lastSupplier = Supplier::latest('id')->first();
        $customId = $lastSupplier ? 'S' . str_pad($lastSupplier->id + 1, 3, '0', STR_PAD_LEFT) : 'S001';

        Supplier::create([
            'custom_id' => $customId,
            'name' => $request->name,
            'address' => $request->address,
            'number' => $request->number,
            'contact_person' => $request->contact_person,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }
}