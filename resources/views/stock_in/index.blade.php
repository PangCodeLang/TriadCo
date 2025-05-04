@extends('dashboard')

@section('title', 'Stock-In - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5 text-primary">STOCK-IN</h2>
    <a href="{{ route('stock_in.create') }}" class="btn-add mb-4">Add Stock-In</a>
    @forelse($stockIns as $stockIn)
        <div class="stock-in-card mb-4 p-4 bg-white shadow-sm rounded">
            <h4 class="fw-bold text-primary">Stock-In: {{ $stockIn->stockin_id }}</h4>
            <p><strong>Supplier:</strong> {{ $stockIn->supplier->name }}</p>
            <p><strong>Items:</strong></p>
            <ul>
                @foreach($stockIn->items as $item)
                    <li>{{ $item->name }} - Price: {{ $item->price }} - Quantity: {{ $item->quantity }}</li>
                @endforeach
            </ul>
            <p><strong>Total Price:</strong> {{ $stockIn->items->sum(function($item) {
                return $item->price * $item->quantity;
            }) }}</p>
            <p><strong>Stock-In Date:</strong> {{ $stockIn->stock_in_date }}</p>
            <div class="action-buttons mt-3">
                <a href="#!" class="btn-edit">Edit</a>
                <form action="#!" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center">No stock-ins found.</p>
    @endforelse
</div>
@endsection