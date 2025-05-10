@extends('dashboard')

@section('title', 'Room Types - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2>ROOM TYPES</h2>
    <div class="mb-4 d-flex gap-2">
        <button class="btn btn-add-supplier w-50" onclick="toggleModal('addRoomTypeModal', 'open')">
            Add Room Type
        </button>
        <button onclick="window.location.href='{{ route('rooms.index') }}'" class="btn btn-back w-50 text-center">
            Back
        </button>
    </div>

    <!-- Modal -->
    <div class="supplier-modal hidden" id="addRoomTypeModal">
        <div class="modal-content">
            <div class="supplier-modal-header">
                Add Room Type
            </div>
            <div class="modal-body">
                <form action="{{ route('rooms.type.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Room Type Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter room type name" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="btn-add">Add Room Type</button>
                        <button type="button" class="btn-cancel" onclick="toggleModal('addRoomTypeModal', 'close')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Room Types Table -->
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <td colspan="6">
                            <form action="{{ route('rooms.type') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search room type" />
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>Room Type ID</th>
                        <th>Room Type Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roomTypes as $type)
                        <tr>
                            <td>{{ $type->roomtype_id }}</td>
                            <td>{{ $type->name }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('rooms.type.edit', $type->roomtype_id) }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('rooms.type.destroy', $type->roomtype_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this room type?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No room types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection