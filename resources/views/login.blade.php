<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - StoreMaster</title>

    <!-- تحميل ملف CSS -->
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
</head>

<body>

    <div class="card">
        <img src="{{ asset('logo.svg') }}" class="logo">

        <h2 style="text-align:center;">Welcome Back 👋</h2>

        <form id="loginForm">

            <label>Email</label>
            <input id="login_email" type="email" required>

            <label>Password</label>
            <input id="login_password" type="password" required>

            <button type="submit" class="btn">Login</button>

            <div class="links">
                <p>Don’t have an account? 
                    <a href="{{ url('/register') }}">Create one</a>
                </p>

                <p>
                    <a href="{{ url('/forgot') }}">Forgot password?</a>
                </p>
            </div>

        </form>
    </div>

    <!-- تحميل ملف الجافاسكربت -->
    <script src="{{ asset('app.js') }}"></script>

</body>
</html>
