<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone' => ['required'],
                'password' => ['required']
            ]);

            $credentials = $request->only(['phone', 'password']);
            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Invalid credentials'
                ], 'Invalid credentials', 500);
            }

            $user = User::where('phone', $request->phone)->first();
            if(!Hash::check($request->password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'Invalid credentials'
                ], 'Invalid credentials', 500);
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login successful');
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong'
            ], $e->getMessage(), 500);
        }
    }

    public function profile()
    {
        return Auth::user();
    }
}
