<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account - StoreMaster</title>

    {{-- Load CSS --}}
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
</head>
<body>

    <div class="card">
        <img src="{{ asset('logo.svg') }}" class="logo">

        <h2 style="text-align:center;">Create Account</h2>

        <form id="registerForm">

            <label>Name</label>
            <input type="text" id="reg_name" required>

            <label>Email</label>
            <input type="email" id="reg_email" required>

            <label>Password</label>
            <input type="password" id="reg_password" required>

            <button type="submit" class="btn">Create Account</button>

            <div class="links">
                <p>Already have an account? 
                    <a href="{{ url('/login') }}">Login</a>
                </p>
            </div>
        </form>
    </div>

    {{-- Load JS --}}
    <script src="{{ asset('app.js') }}"></script>
</body>
</html>
