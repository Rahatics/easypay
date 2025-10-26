<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetupController extends Controller
{
    /**
     * Display the setup page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if setup data already exists in database
        $setupData = $this->getSetupData();

        return view('setup', compact('setupData'));
    }

    /**
     * Get setup data from database or create initial data
     *
     * @return array
     */
    private function getSetupData()
    {
        // Check if setup data exists in database
        $setupRecord = \App\Models\SetupData::first();

        // If not, create initial setup data
        if (!$setupRecord) {
            $setupRecord = \App\Models\SetupData::create([
                'website_name' => 'My Website',
                'website_logo' => '',
                'api_key' => 'sk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'secret_key' => 'ssk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'merchant_id' => 'MID' . rand(100000, 999999)
            ]);
        }

        // Convert to array for compatibility
        return $setupRecord->toArray();
    }

    /**
     * Save setup data to database
     *
     * @param array $setupData
     * @return void
     */
    private function saveSetupData($setupData)
    {
        // Get the first (and only) setup record
        $setupRecord = \App\Models\SetupData::first();

        // If it doesn't exist, create it
        if (!$setupRecord) {
            \App\Models\SetupData::create($setupData);
        } else {
            // Update existing record
            $setupRecord->update($setupData);
        }
    }

    /**
     * Update the setup configuration
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'website_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'api_key' => 'required|string|max:255',
            'secret_key' => 'required|string|max:255',
            'merchant_id' => 'required|string|max:255'
        ]);

        // Get existing setup data
        $setupRecord = \App\Models\SetupData::first();

        // If not found, create initial setup data
        if (!$setupRecord) {
            $setupRecord = \App\Models\SetupData::create([
                'website_name' => 'My Website',
                'website_logo' => '',
                'api_key' => 'sk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'secret_key' => 'ssk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'merchant_id' => 'MID' . rand(100000, 999999)
            ]);
        }

        // Update only the user-editable fields
        $setupRecord->website_name = $request->website_name;
        $setupRecord->api_key = $request->api_key;
        $setupRecord->secret_key = $request->secret_key;
        $setupRecord->merchant_id = $request->merchant_id;

        // Handle file upload for website_logo
        if ($request->hasFile('website_logo')) {
            // Store the file in storage/app/public/logos with a unique name
            $filename = time() . '_' . $request->file('website_logo')->getClientOriginalName();
            $path = $request->file('website_logo')->storeAs('logos', $filename, 'public');
            // Save the path to be used in views
            $setupRecord->website_logo = asset('storage/' . $path);
        }

        // Save updated data
        $setupRecord->save();

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
        $type = $request->type;

        // Get existing setup data
        $setupRecord = \App\Models\SetupData::first();

        // If not found, create initial setup data
        if (!$setupRecord) {
            $setupRecord = \App\Models\SetupData::create([
                'website_name' => 'My Website',
                'website_logo' => '',
                'api_key' => 'sk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'secret_key' => 'ssk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32),
                'merchant_id' => 'MID' . rand(100000, 999999)
            ]);
        }

        // Generate new credentials based on type
        if ($type === 'secret_key') {
            $setupRecord->secret_key = 'ssk_' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 32);
        }

        // Save updated data
        $setupRecord->save();

        return response()->json([
            'secret_key' => $setupRecord->secret_key
        ]);
    }
}
