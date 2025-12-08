<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('auth.css') }}">
</head>
<body>

    <div class="card">
        <img src="{{ asset('logo.svg') }}" class="logo">

        <h2 style="text-align:center;">Enter Your New Password</h2>

        <form id="resetForm">

            <label>Email</label>
            <input type="email" id="reset_email" required>

            <label>Reset Code</label>
            <input type="text" id="reset_code" required>

            <label>New Password</label>
            <input type="password" id="reset_new_password" required>

            <button type="submit" class="btn">Reset Password</button>

            <div class="links">
                <p><a href="{{ url('/login') }}">Back to Login</a></p>
            </div>
        </form>
    </div>

    {{-- JS --}}
    <script src="{{ asset('app.js') }}"></script>
</body>
</html>
