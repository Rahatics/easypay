<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GatewaysController extends Controller
{
    /**
     * Display the gateways page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get gateways data from session (in a real app, this would come from the database)
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'description' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
                'enabled' => true,
                'fees' => '1.8% per transaction',
                'account_number' => '01712345678'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'description' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.',
                'enabled' => false,
                'fees' => '1.5% per transaction',
                'account_number' => ''
            ]
        ]);

        return view('gateways', compact('gateways'));
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
        // Get existing gateways data
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'description' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
                'enabled' => true,
                'fees' => '1.8% per transaction',
                'account_number' => '01712345678'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'description' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.',
                'enabled' => false,
                'fees' => '1.5% per transaction',
                'account_number' => ''
            ]
        ]);

        // Find the gateway to update
        $gatewayIndex = collect($gateways)->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });

        if ($gatewayIndex !== false) {
            // Validate request data
            $request->validate([
                'account_number' => 'required|string|max:15',
                'fees' => 'required|numeric|min:0|max:100'
            ]);

            // Format fees as percentage string
            $formattedFees = $request->fees . '% per transaction';

            // Update the gateway data
            $gateways[$gatewayIndex]['account_number'] = $request->account_number;
            $gateways[$gatewayIndex]['fees'] = $formattedFees;
            // Handle checkbox correctly - if not present or value is 0, it means unchecked
            $gateways[$gatewayIndex]['enabled'] = $request->has('enabled') && $request->enabled == '1' ? true : false;

            // Save updated data to session
            session(['gateways_data' => $gateways]);

            return redirect()->route('gateways')->with('success', $gateways[$gatewayIndex]['name'] . ' gateway updated successfully!');
        }

        return redirect()->route('gateways')->with('error', 'Gateway not found!');
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
        // Get existing gateways data
        $gateways = session('gateways_data', [
            [
                'id' => 1,
                'name' => 'bkash',
                'description' => 'bkash is a mobile financial service in Bangladesh that allows users to make payments, send money, and perform various financial transactions using their mobile phones.',
                'enabled' => true,
                'fees' => '1.8% per transaction',
                'account_number' => '01712345678'
            ],
            [
                'id' => 2,
                'name' => 'Nagad',
                'description' => 'Nagad is a government-backed mobile financial service in Bangladesh that provides digital payment solutions to unbanked and underbanked populations.',
                'enabled' => false,
                'fees' => '1.5% per transaction',
                'account_number' => ''
            ]
        ]);

        // Find the gateway to update
        $gatewayIndex = collect($gateways)->search(function ($item) use ($id) {
            return $item['id'] == $id;
        });

        if ($gatewayIndex !== false) {
            // Toggle the enabled status
            $gateways[$gatewayIndex]['enabled'] = !$gateways[$gatewayIndex]['enabled'];

            // Save updated data to session
            session(['gateways_data' => $gateways]);

            $status = $gateways[$gatewayIndex]['enabled'] ? 'enabled' : 'disabled';
            return response()->json(['success' => true, 'message' => $gateways[$gatewayIndex]['name'] . ' gateway ' . $status . ' successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Gateway not found!']);
    }

    /**
     * Calculate processing fee based on gateway fees and amount
     *
     * @param string $fees
     * @param float $amount
     * @return float
     */
    public static function calculateProcessingFee($fees, $amount)
    {
        // Parse fees string (e.g., "1.8% per transaction" or "15 BDT per transaction")
        if (strpos($fees, '%') !== false) {
            // Percentage-based fee
            preg_match('/([\d.]+)%/', $fees, $matches);
            $percentage = isset($matches[1]) ? floatval($matches[1]) : 0;
            return ($percentage / 100) * $amount;
        } elseif (strpos($fees, 'BDT') !== false) {
            // Fixed amount fee
            preg_match('/([\d.]+) BDT/', $fees, $matches);
            $fixedAmount = isset($matches[1]) ? floatval($matches[1]) : 0;
            return $fixedAmount;
        }

        // Default to 0 if fees format is not recognized
        return 0;
    }
}
