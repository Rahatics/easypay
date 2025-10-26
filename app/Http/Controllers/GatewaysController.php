<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MerchantGateway;

class GatewaysController extends Controller
{
    /**
     * Display the gateways page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Define default gateways
        $defaultGateways = [
            [
                'name' => 'bkash',
                'description' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
                'is_enabled' => true,
                'fees_percentage' => 1.80,
                'account_number' => ''
            ],
            [
                'name' => 'Nagad',
                'description' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.',
                'is_enabled' => false,
                'fees_percentage' => 1.50,
                'account_number' => ''
            ]
        ];

        // Get user's gateways from database
        $userGateways = MerchantGateway::where('user_id', $user->id)->get();

        // If user has no gateways, create default ones
        if ($userGateways->isEmpty()) {
            foreach ($defaultGateways as $gateway) {
                MerchantGateway::create([
                    'user_id' => $user->id,
                    'gateway_name' => $gateway['name'],
                    'account_number' => $gateway['account_number'],
                    'fees_percentage' => $gateway['fees_percentage'],
                    'is_enabled' => $gateway['is_enabled']
                ]);
            }
            // Reload gateways
            $userGateways = MerchantGateway::where('user_id', $user->id)->get();
        }

        // Format gateways for the view
        $gateways = $userGateways->map(function ($gateway, $index) {
            return [
                'id' => $gateway->id,
                'name' => $gateway->gateway_name,
                'description' => $this->getGatewayDescription($gateway->gateway_name),
                'enabled' => $gateway->is_enabled,
                'fees' => $gateway->fees_percentage . '% per transaction',
                'account_number' => $gateway->account_number
            ];
        })->toArray();

        return view('gateways_new', compact('gateways'));
    }

    /**
     * Update gateway configuration
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Find the gateway for this user
        $gateway = MerchantGateway::where('id', $id)->where('user_id', $user->id)->first();

        if (!$gateway) {
            return redirect()->route('gateways')->with('error', 'Gateway not found!');
        }

        // Validate request data
        $request->validate([
            'account_number' => 'required|string|max:15',
            'fees' => 'required|numeric|min:0|max:100'
        ]);

        // Update the gateway data
        $gateway->account_number = $request->account_number;
        $gateway->fees_percentage = $request->fees;
        // Handle checkbox correctly - if not present or value is 0, it means unchecked
        $gateway->is_enabled = $request->has('enabled') && $request->enabled == '1' ? true : false;
        $gateway->save();

        return redirect()->route('gateways')->with('success', $gateway->gateway_name . ' gateway updated successfully!');
    }

    /**
     * Toggle gateway status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Request $request, $id)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Find the gateway for this user
        $gateway = MerchantGateway::where('id', $id)->where('user_id', $user->id)->first();

        if (!$gateway) {
            return response()->json(['success' => false, 'message' => 'Gateway not found!']);
        }

        // Toggle the enabled status
        $gateway->is_enabled = !$gateway->is_enabled;
        $gateway->save();

        $status = $gateway->is_enabled ? 'enabled' : 'disabled';
        return response()->json(['success' => true, 'message' => $gateway->gateway_name . ' gateway ' . $status . ' successfully!']);
    }

    /**
     * Get gateway description by name
     *
     * @param string $name
     * @return string
     */
    private function getGatewayDescription($name)
    {
        $descriptions = [
            'bkash' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
            'Nagad' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.'
        ];

        return $descriptions[$name] ?? '';
    }

    /**
     * Calculate processing fee based on gateway fees and amount
     *
     * @param float $fees_percentage
     * @param float $amount
     * @return float
     */
    public static function calculateProcessingFee($fees_percentage, $amount)
    {
        // Calculate percentage-based fee
        return ($fees_percentage / 100) * $amount;
    }
}
