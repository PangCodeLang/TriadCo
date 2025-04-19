<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="{{ asset('css/system.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="sidebar" id="sidebar">
        <h2>TriadCo Dashboard</h2>
        <center>
            <ul>
                <li><a href="#!">Dashboard</a></li>
                <li><a href="#!">Stock-In</a></li>
                <li><a href="#!">Inventory</a></li>
                <li><a href="#!">Rooms</a></li>
                <li><a href="#!">Suppliers</a></li>
                <li><a href="#!">Reports</a></li>
            </ul>
        </center>
    </div>

    <div class="header">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <h1>Triad Corporations Hotel Set-Up</h1>
        <div class="logout">
            <a href="{{ route('logout') }}">
                <img src="{{ asset('images/logout-icon.png') }}" alt="Log Out">
            </a>
        </div>
    </div>

    <div class="main-content">
        <h2>Welcome to the Dashboard</h2>
        <p>Use the sidebar to navigate through the system.</p>

        <div class="card">
            <h3>Card Title</h3>
            <p>This is a sample card. You can use this space to display important information or widgets.</p>
        </div>

        <div class="card">
            <h3>Another Card</h3>
            <p>Here is another card for additional content or features.</p>
        </div>
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