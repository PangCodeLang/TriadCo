@extends('dashboard')

@section('title', 'Employees - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<h2>EMPLOYEES</h2>
<div class="container py-5">
    <div class="glass-card glass-card-wide mx-auto">
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead class="table-light">
                    <tr>
                        <th colspan="5">
                            <form action="{{ route('employees.index') }}" method="GET" class="d-flex justify-content-end">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search employees..." />
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </form>
                        </th>
                    </tr>
                    <tr>
                        <th>Profile Picture</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . ($employee->profile_picture ?? 'TCEmployeeProfile.png')) }}" alt="Profile Picture" class="profile-picture">
                            </td>
                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_number }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this employee?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection