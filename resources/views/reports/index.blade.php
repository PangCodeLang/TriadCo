@extends('dashboard')

@section('title', 'Reports - Recent Activities')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5 text-primary">REPORTS</h2>

    <div class="glass-card glass-card-wide mx-auto">
        <!-- Reports Table -->
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle supplier-table">
                <thead>
                    <tr>
                        <td colspan="3" class="text-center">
                            <form action="{{ route('reports.index') }}" method="GET" class="d-flex justify-content-center align-items-center">
                                <label for="filter" class="me-2 fw-bold filter-label">Filter Reports:</label>
                                <select name="filter" id="filter" class="form-select form-select-sm filter-dropdown" onchange="this.form.submit()">
                                    <option value="" {{ request('filter') == '' ? 'selected' : '' }}>All Reports</option>
                                    <option value="items" {{ request('filter') == 'items' ? 'selected' : '' }}>Items Reports</option>
                                    <option value="suppliers" {{ request('filter') == 'suppliers' ? 'selected' : '' }}>Supplier Reports</option>
                                    <option value="stock_in" {{ request('filter') == 'stock_in' ? 'selected' : '' }}>Stock-In Reports</option>
                                    <option value="stock_out" {{ request('filter') == 'stock_out' ? 'selected' : '' }}>Stock-Out Reports</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                </thead>
                <thead class="table-light">
                    <tr>
                        <th>Activity</th>
                        <th>User</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->activity }}</td>
                            <td>{{ $report->user ? $report->user->name : 'Unknown User' }}</td>
                            <td>{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No recent activities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="stats-container d-flex">
        <!-- Left Column -->
        <div class="stats-left">
            <!-- Small Cards -->
            <div class="card small-card">
                <h3 class="stats-header">{{ $totalRooms }}</h3>
                <p>Total Rooms</p>
            </div>
            <div class="card small-card">
                <h3 class="stats-header">{{ $occupiedRooms }}</h3>
                <p>Occupied Rooms</p>
            </div>
            <div class="card small-card">
                <h3 class="stats-header">{{ $emptyRooms }}</h3>
                <p>Empty Rooms</p>
            </div>
            <div class="card small-card">
                <h3 class="stats-header">{{ $totalCategories }}</h3>
                <p>Total Categories</p>
            </div>

            <!-- Medium Cards -->
            <div class="card medium-card">
                <h3 class="stats-header">{{ $topStockedOutItem->name ?? 'N/A' }}</h3>
                <p>Top Stocked-Out Item</p>
            </div>
            <div class="card medium-card">
                <h3 class="stats-header">{{ $topStockedInItem->name ?? 'N/A' }}</h3>
                <p>Top Stocked-In Item</p>
            </div>
            <div class="card medium-card">
                <h3 class="stats-header">{{ $mostActiveUser->name ?? 'N/A' }}</h3>
                <p>Most Active User</p>
            </div>
            <div class="card medium-card">
                <h3 class="stats-header">{{ $totalReturnedItems }}</h3>
                <p>Total Returned Items</p>
            </div>
        </div>

        <!-- Right Column -->
        <div class="stats-right">
            <!-- Long Cards -->
            <div class="card long-card">
                <h3 class="stats-header">Monthly Activity Summary</h3>
                <ul>
                    <li>Stock-Ins: {{ $totalStockInThisMonth }}</li>
                    <li>Stock-Outs: {{ $totalStockOutThisMonth }}</li>
                    <li>Items Added: {{ $totalItems }}</li>
                </ul>
            </div>
            <div class="card long-card">
                <h3 class="stats-header">Recent Activities</h3>
                <ul>
                    @foreach($recentActivities as $activity)
                        <li>{{ $activity->activity }} ({{ $activity->created_at->format('Y-m-d H:i:s') }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection