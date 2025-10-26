<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // User মডেল import করুন

class AuthenticateApiRequest
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY'); // হেডার থেকে API Key নিন
        $secretKey = $request->header('X-SECRET-KEY'); // হেডার থেকে Secret Key নিন

        if (!$apiKey || !$secretKey) {
            return response()->json(['error' => 'API keys are missing.'], 401);
        }

        // কী ব্যবহার করে মার্চেন্টকে খুঁজুন
        $merchant = User::where('api_key', $apiKey)->first();

        // Check if merchant exists and verify secret key using Hash::check
        if (!$merchant || !Hash::check($secretKey, $merchant->secret_key)) {
            return response()->json(['error' => 'Invalid API credentials.'], 401);
        }

        if (!$merchant) {
            return response()->json(['error' => 'Invalid API credentials.'], 401);
        }

        // রিকোয়েস্টে মার্চেন্টের তথ্য যোগ করুন যাতে কন্ট্রোলারে ব্যবহার করা যায়
        $request->merge(['merchant' => $merchant]);

        return $next($request);
    }
}
