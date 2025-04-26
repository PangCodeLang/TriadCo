<!-- filepath: c:\Users\jarma\Documents\TriadCo\TriadCo\resources\views\suppliers\index.blade.php -->
@extends('dashboard')

@section('title', 'Suppliers - TriadCo')

@section('content')

    <h2 class="mb-4">SUPPLIERS</h2>

    <div class="mb-4">
        <a href="#!" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">Add Supplier</a>
    </div>

    <div class="table-responsive">
        @if($suppliers->isEmpty())
            <div class="text-center">
                <p class="text-muted">Table Empty</p>
                <img src="{{ asset('images/TCLogo3.png') }}" alt="TriadCo Logo" class="empty-table-logo">
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th> <!-- Added custom ID column -->
                        <th>Name</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Contact Person</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->custom_id }}</td> <!-- Display custom ID -->
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->number }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>
                                <a href="#!" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSupplierModal{{ $supplier->id }}">Edit</a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Supplier Modal -->
                        <div class="modal fade" id="editSupplierModal{{ $supplier->id }}" tabindex="-1" aria-labelledby="editSupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editSupplierModalLabel{{ $supplier->id }}">Edit Supplier</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ $supplier->address }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="number" class="form-label">Contact Number</label>
                                                <input type="text" class="form-control" id="number" name="number" value="{{ $supplier->number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="contact_person" class="form-label">Contact Person</label>
                                                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ $supplier->contact_person }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="number" name="number" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection