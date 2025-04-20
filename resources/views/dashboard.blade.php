<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - TriadCo')</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="{{ asset('css/system.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="{{ session('first_login') ? 'fade-in' : '' }}">
    @php
        session()->forget('first_login');
    @endphp>
    
    <div class="sidebar" id="sidebar">
        <h2>TriadCo Dashboard</h2>
        <center>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                <li><a href="#!" class="nav-link">Stock-In</a></li>
                <li><a href="#!" class="nav-link">Inventory</a></li>
                <li><a href="#!" class="nav-link">Rooms</a></li>
                <li><a href="{{ route('suppliers.index') }}" class="nav-link">Suppliers</a></li>
                <li><a href="#!" class="nav-link">Reports</a></li>
            </ul>
        </center>
        <div class="sidebar-logo">
            <img src="{{ asset('images/TCLogo2.png') }}" alt="TriadCo Logo 2">
        </div>
    </div>

    <div class="header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1>Triad Corporations Hotel Set-Up</h1>
        <div class="logout">
            <form action="{{ route('logout') }}" method="GET" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="bi bi-box-arrow-left"></i> Log-Out
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content') 
    </div>

    <div class="footer">
        <p>&copy; 2025 TriadCo. All rights reserved.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>

</html>