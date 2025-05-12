@extends('dashboard')

@section('title', 'Inventory Dashboard')

@section('head')
    <link href="{{ asset('css/supplier.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="inventory-dashboard">
        <h1 class="dashboard-title">INVENTORY DASHBOARD</h1>
        <p class="dashboard-subtitle">Comprehensive overview of inventory and room management</p>

        <div class="dashboard-grid">
            <div class="dashboard-card summary-card">
                <h3 class="card-title">Recent Stocks In</h3>
                <div class="card-content">
                    <span class="large-number">{{ $totalStockIn }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Recent Stock Outs</h3>
                <div class="card-content">
                    <span class="large-number">{{ $totalStockOut }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Total Items</h3>
                <div class="card-content">
                    <span class="large-number">{{ $totalItems }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Total Rooms</h3>
                <div class="card-content">
                    <span class="large-number">{{ $totalRooms }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Total Empty Rooms</h3>
                <div class="card-content">
                    <span class="large-number">{{ $emptyRooms }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Total No Stock Items</h3>
                <div class="card-content">
                    <span class="large-number">{{ $noStockItems }}</span>
                </div>
            </div>

            <div class="dashboard-card summary-card">
                <h3 class="card-title">Total Occupied Rooms</h3>
                <div class="card-content">
                    <span class="large-number">{{ $occupiedRooms }}</span>
                </div>
            </div>

            <!-- No Stock Items Card -->
            <div class="dashboard-card no-stock-items-card">
                <h3 class="card-title">No Stock Items</h3>
                <div class="no-stock-items">
                    @if($noStockItems > 0)
                        <p>The following items need restocking:</p>
                        <ul class="no-stock-items-list">
                            @foreach($itemsNeedingRestock as $item)
                                <li>{{ $item->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>All items are sufficiently stocked.</p>
                    @endif
                </div>
            </div>
            <div class="dashboard-card chart-card">
                <h3 class="card-title">Room Occupancy</h3>
                <div class="chart-container">
                    <div class="pie-chart">
                        <div class="pie-chart-segment occupied-rooms" style="--percentage: {{ $occupiedPercentage }}%"></div>
                        <div class="pie-chart-segment empty-rooms" style="--percentage: {{ $emptyPercentage }}%"></div>
                        <div class="pie-chart-center">
                            <span class="pie-chart-label">Room Status</span>
                        </div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <span class="legend-color occupied-rooms"></span>
                            <span class="legend-text">Occupied Rooms ({{ number_format($occupiedPercentage, 1) }}%)</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color empty-rooms"></span>
                            <span class="legend-text">Empty Rooms ({{ number_format($emptyPercentage, 1) }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-card summary-reports-card">
            <h3 class="card-title">Summary Reports</h3>
            <div class="summary-reports">
                <h4>Recent Activities</h4>
                <ul class="recent-activities">
                    @foreach($recentActivities as $activity)
                        <li>{{ $activity->activity }} ({{ $activity->created_at->format('Y-m-d H:i:s') }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
        </div>
    </div>
@endsection