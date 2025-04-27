@extends('dashboard')

@section('title', 'Suppliers - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2>SUPPLIERS</h2>
    <div class="mb-4">
        <button class="btn btn-add-supplier w-100" onclick="toggleModal('addSupplierModal', 'open')">
            Add Supplier
        </button>
    </div>

    <!-- Modal -->
    <div class="supplier-modal hidden" id="addSupplierModal">
        <div class="modal-content">
            <div class="supplier-modal-header">
                Supplier Information
            </div>
            <div class="modal-body">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter supplier name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Supplier Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="Enter phone number" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_person" class="form-label">Contact Person</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter contact person" required>
                    </div>

                    <div class="button-row">
                        <button type="submit" class="btn-add">Add Supplier</button>
                        <button type="button" class="btn-cancel" onclick="toggleModal('addSupplierModal', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Supplier Table -->
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <th colspan="6">
                            <form action="{{ route('suppliers.index') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search suppliers..." />
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Contact Person</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->supplier_id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->number }}</td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('suppliers.edit', $supplier->supplier_id) }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->supplier_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this supplier?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No suppliers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection