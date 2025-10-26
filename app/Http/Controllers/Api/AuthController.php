<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // ভ্যালিডেশন পরিবর্তন করে 'login_field' করা হলো
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required',
        ]);

        $loginField = $request->input('login_field');
        $password = $request->input('password');

        // ইনপুটটি ইমেইল নাকি 'name' (ইউজারনেম) তা চেক করুন
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // নতুন ক্রেডেনশিয়াল দিয়ে লগইন করার চেষ্টা করুন
        $credentials = [
            $fieldType => $loginField,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
