<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>

    <!-- استخدام PHP لعرض الأصول -->
  <link rel="stylesheet" href="{{ asset('auth.css') }}">
</head>

<body>

    <div class="card">
        <img src="<?php echo asset('logo.svg'); ?>" class="logo">

        <h2 style="text-align:center;">Reset Your Password</h2>

        <form id="forgotForm">

            <label>Email</label>
            <input type="email" id="forgot_email" required>

            <button type="submit" class="btn">Send Reset Code</button>

            <div class="links">
                <p><a href="<?php echo url('/login'); ?>">Back to Login</a></p>
            </div>

        </form>
    </div>

    <script src="{{ asset('app.js') }}"></script>

</body>
</html>
