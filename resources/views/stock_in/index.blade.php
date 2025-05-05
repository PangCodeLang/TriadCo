@extends('dashboard')

@section('title', 'Stock-In - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5 text-primary">STOCK-IN</h2>
    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-add-supplier w-100 text-center" onclick="toggleModal('addStockInModal', 'open')">
            Add Stock-In
        </button>
    </div>

    <!-- Modal -->
    <div class="supplier-modal hidden" id="addStockInModal">
        <div class="modal-content">
            <div class="supplier-modal-header">
                Add Stock-In
            </div>
            <div class="modal-body">
                <form action="{{ route('stock_in.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="item_id" class="form-label">Item</label>
                        <select class="form-control" id="item_id" name="item_id" required>
                            <option value="" disabled selected>Select an item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->item_id }}" data-price="{{ $item->price }}">
                                    {{ $item->name }} ({{ $item->category->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Price will appear here" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="total_price" class="form-label">Total Price</label>
                        <input type="text" class="form-control" id="total_price" name="total_price" placeholder="Total price will appear here" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stockin_date" class="form-label">Stock-In Date</label>
                        <input type="date" class="form-control" id="stockin_date" name="stockin_date" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="btn-add">Add Stock-In</button>
                        <button type="button" class="btn-cancel" onclick="toggleModal('addStockInModal', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stock-In Table -->
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <th colspan="6">
                            <form action="{{ route('stock_in.index') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search stock-in records..." />
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th>Stock-In ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Stock-In Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stockIns as $stockIn)
                        <tr>
                            <td>{{ $stockIn->stockin_id }}</td>
                            <td>{{ $stockIn->item->name }}</td>
                            <td>{{ $stockIn->quantity }}</td>
                            <td>{{ number_format($stockIn->price, 2) }}</td>
                            <td>{{ number_format($stockIn->total_price, 2) }}</td>
                            <td>{{ $stockIn->stockin_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No stock-in records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/calculate_total.js') }}"></script>
@endsection