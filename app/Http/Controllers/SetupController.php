<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class SetupController extends Controller
{
    /**
     * Display the setup page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated user's data
        $user = Auth::user();

        // Check if user has API credentials, if not generate them
        if (empty($user->api_key) || empty($user->secret_key) || empty($user->merchant_id)) {
            $user = User::find($user->id);
            $user->api_key = 'ak_' . Str::random(32);
            $user->secret_key = 'sk_' . Str::random(64);
            $user->merchant_id = 'mer_' . uniqid();
            $user->save();
        }

        // Prepare setup data from user's API credentials
        $setupData = [
            'website_name' => $user->name . '\'s Website',
            'website_logo' => '',
            'api_key' => $user->api_key,
            'secret_key' => $user->secret_key,
            'merchant_id' => $user->merchant_id
        ];

        return view('setup', compact('setupData'));
    }

    /**
     * Update the setup configuration
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'website_name' => 'required|string|max:255',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'merchant_id' => 'required|string|max:255'
        ]);

        // Update only the website name (API keys are read-only)
        // Note: In a real application, you might want to store this in a separate user profile table
        // For now, we'll just use a session variable to store the website name
        session(['website_name' => $request->website_name]);

        // Handle file upload for website_logo
        if ($request->hasFile('website_logo')) {
            // Store the file in storage/app/public/logos with a unique name
            $filename = time() . '_' . $request->file('website_logo')->getClientOriginalName();
            $path = $request->file('website_logo')->storeAs('logos', $filename, 'public');
            // Save the path to session
            session(['website_logo' => asset('storage/' . $path)]);
        }

        return redirect()->back()->with('success', 'Setup configuration updated successfully!');
    }

    /**
     * Generate new API credentials
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateCredentials(Request $request)
    {
        // This method is no longer needed as API credentials are tied to the user account
        return response()->json([
            'error' => 'API credentials are tied to your account and cannot be regenerated from this page.'
        ], 400);
    }
}
