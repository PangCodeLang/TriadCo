@extends('dashboard')

@section('title', 'Item Categories - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2>ITEM CATEGORIES</h2>
    <div class="mb-4 d-flex gap-2">
        <!-- Add Category Button -->
        <button class="btn btn-add-supplier w-50" onclick="toggleModal('addCategoryModal', 'open')">
            Add Category
        </button>
        <!-- Back Button -->
        <button onclick="window.location.href='{{ route('inventory.index') }}'" class="btn btn-back w-50 text-center">
            Back
        </button>
    </div>

    <!-- Modal -->
    <div class="supplier-modal hidden" id="addCategoryModal">
        <div class="modal-content">
            <div class="supplier-modal-header">
                Add Item Category
            </div>
            <div class="modal-body">
                <form action="{{ route('inventory.itemctgry.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="btn-add">Add Category</button>
                        <button type="button" class="btn-cancel" onclick="toggleModal('addCategoryModal', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <th colspan="6">
                            <form action="{{ route('inventory.itemctgry') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search category" />
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->itemctgry_id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('inventory.itemctgryedit', $category->itemctgry_id) }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('inventory.itemctgry.destroy', $category->itemctgry_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

