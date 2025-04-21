<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TriadCo. Hotel Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-left">
                <img src="{{ asset('images/TriadEmb.png') }}" alt="Hotel" />
            </div>
            <div class="login-right">
                <h2>TriadCo.<br>Hotel Set-Up</h2>

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf 

                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" placeholder="Enter username" value="{{ old('name') }}" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>

                    <button type="submit">Log In</button>
                </form>

                @if ($errors->any())
                    <div style="color: #ffb3b3; font-size: 13px; margin-top: 10px;">
                        <ul style="padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="bottom-logo">
            <img src="{{ asset('images/TriadCoLogo.png') }}" alt="TriadCo Logo">
        </div>
    </div>
</body>
</html>