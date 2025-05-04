@extends('dashboard')

@section('title', 'Edit Employee - TriadCo')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5 employee-edit">
    <div class="glass-card glass-card-wide mx-auto">
        <div class="supplier-modal-header">
            EDIT EMPLOYEE
        </div>
        
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Employee Account Section -->
            <h4 class="fw-bold text-primary text-center mb-4">Employee Account</h4>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $employee->user->name) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $employee->user->email) }}" required>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
            <h4 class="fw-bold text-primary text-center mb-4">Employee Information</h4>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name) }}" required>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $employee->address) }}" required>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="contact_number" class="form-label">Contact Number:</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ old('contact_number', $employee->contact_number) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="sss_number" class="form-label">SSS Number:</label>
                        <input type="text" id="sss_number" name="sss_number" class="form-control" value="{{ old('sss_number', $employee->sss_number) }}" required>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="profile_picture" class="form-label">Upload Profile Picture:</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="button-row mt-4">
                <button type="submit" class="btn-update">Update Employee</button>
                <a href="{{ route('employees.index') }}" class="btn-canceledit">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection