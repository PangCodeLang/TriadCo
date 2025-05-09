@extends('dashboard')

@section('title', 'Inventory - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2>INVENTORY</h2>
    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-add-supplier w-50" onclick="toggleModal('addItemModal', 'open')">
            Add Item
        </button>
        <button onclick="window.location.href='{{ route('inventory.itemctgry') }}'" class="btn btn-page-link w-50 text-center">
            Item Categories
        </button>
    </div>

    <!-- Modal -->
    <div class="supplier-modal hidden" id="addItemModal">
        <div class="modal-content">
            <div class="supplier-modal-header">
                Add Item
            </div>
            <div class="modal-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter item name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Item Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->itemctgry_id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="btn-add">Add Item</button>
                        <button type="button" class="btn-cancel" onclick="toggleModal('addItemModal', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <td colspan="6">
                            <form action="{{ route('inventory.index') }}" method="GET" class="d-flex justify-content-end">
                                <label for="category_filter" class="me-2 fw-bold filter-label">Item Filter:</label>
                                    <select name="category_filter" id="category_filter" class="form-select form-select-sm filter-dropdown me-3" onchange="this.form.submit()">
                                        <option value="" {{ request('category_filter') == '' ? 'selected' : '' }}>All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->itemctgry_id }}" {{ request('category_filter') == $category->itemctgry_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search items..." value="{{ request('search') }}" />
                                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>Item ID</th>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>In Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->item_id }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>
                                @if ($item->in_stock > 0)
                                    {{ $item->in_stock }}
                                @else
                                    <span class="text-danger">No Stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('inventory.edit', $item->item_id) }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('inventory.destroy', $item->item_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/inventory.js') }}"></script>
@endsection