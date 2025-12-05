<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    // REGISTER NEW USER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Account created successfully!',
            'user' => $user
        ], 201);
    }

    // LOGIN USER
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid email'], 401);
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Wrong password'], 401);
        }

        // generate token
        $token = bin2hex(random_bytes(20));

        $user->api_token = $token;
        $user->save();

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user->email
        ]);
    }

    // FORGOT PASSWORD
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // generate reset code
        $code = rand(100000, 999999);

        $user->reset_code = $code;
        $user->save();

        return response()->json([
            'message' => 'Reset code generated successfully.',
            'reset_code' => $code
        ]);
    }

    // RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'reset_code' => 'required',
            'new_password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)
                    ->where('reset_code', $request->reset_code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid reset code or email'], 400);
        }

        $user->password = bcrypt($request->new_password);
        $user->reset_code = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }
}
