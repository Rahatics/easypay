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
            'website_name' => $user->website_name ?? ($user->name . '\'s Website'),
            'website_logo' => $user->website_logo ?? '',
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

        // Update the user's website name
        $user->website_name = $request->website_name;

        // Get a fresh instance of the user model for saving
        $userModel = User::find($user->id);

        // Handle file upload for website_logo
        if ($request->hasFile('website_logo')) {
            // Store the file in storage/app/public/logos with a unique name
            $filename = time() . '_' . $request->file('website_logo')->getClientOriginalName();
            $path = $request->file('website_logo')->storeAs('logos', $filename, 'public');
            // Save the path to the user's record
            $userModel->website_logo = 'storage/' . $path;
        }

        // Update website name
        $userModel->website_name = $request->website_name;
        $userModel->save();

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

    /**
     * Download the integration guide PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadIntegrationGuide()
    {
        // Get the authenticated user's data
        $user = Auth::user();

        // Get user's API credentials
        $apiKey = $user->api_key ?? 'your_api_key_here';
        $secretKey = $user->secret_key ?? 'your_secret_key_here';
        $merchantId = $user->merchant_id ?? 'your_merchant_id_here';

        // Create a detailed step-by-step integration guide with user's credentials
        $content = "Easypay Integration Guide - Detailed Step by Step Instructions\n" .
                  "=============================================================\n\n" .

                  "VERSION: 1.0\n" .
                  "LAST UPDATED: " . date('Y-m-d') . "\n" .
                  "PREPARED FOR: " . ($user->website_name ?? $user->name) . "\n\n" .

                  "TABLE OF CONTENTS\n" .
                  "-----------------\n" .
                  "1. Prerequisites\n" .
                  "2. Your API Credentials\n" .
                  "3. Server-to-Server Integration\n" .
                  "4. Environment Configuration\n" .
                  "5. Creating Routes\n" .
                  "6. Controller Implementation\n" .
                  "7. Frontend Integration\n" .
                  "8. Callback Handling\n" .
                  "9. Testing\n" .
                  "10. Going Live\n\n" .

                  "1. PREREQUISITES\n" .
                  "----------------\n" .
                  "- A working Laravel application (version 8.0 or higher)\n" .
                  "- PHP 7.4 or higher\n" .
                  "- Composer installed\n" .
                  "- HTTPS enabled on your server (recommended)\n\n" .

                  "2. YOUR API CREDENTIALS\n" .
                  "----------------------\n" .
                  "IMPORTANT: Keep your Secret Key secure and never expose it in client-side code!\n\n" .
                  "API Key: " . $apiKey . "\n" .
                  "Secret Key: " . $secretKey . "\n" .
                  "Merchant ID: " . $merchantId . "\n\n" .
                  "These credentials are already pre-filled in the guide below.\n\n" .

                  "3. SERVER-TO-SERVER INTEGRATION\n" .
                  "-------------------------------\n" .
                  "Easypay uses a secure server-to-server communication model to protect your credentials:\n" .
                  "- All API calls are made from your server to Easypay's servers\n" .
                  "- Customer's browser never sees your Secret Key\n" .
                  "- All communication is encrypted via HTTPS\n\n" .

                  "4. ENVIRONMENT CONFIGURATION\n" .
                  "----------------------------\n" .
                  "1. Open your .env file in your Laravel project root\n" .
                  "2. Add the following lines (leave EASYPAY_BASE_URL empty for automatic detection):\n\n" .
                  "EASYPAY_BASE_URL=\n" .
                  "EASYPAY_KEY=" . $apiKey . "\n" .
                  "EASYPAY_SECRET=" . $secretKey . "\n" .
                  "EASYPAY_MERCHANT_ID=" . $merchantId . "\n\n" .
                  "Note: If EASYPAY_BASE_URL is left empty, the system will automatically detect the current domain.\n" .
                  "If you want to specify a custom domain, set it like: EASYPAY_BASE_URL=https://your-domain.com\n\n" .
                  "3. Open config/services.php and add:\n\n" .
                  "'easypay' => [\n" .
                  "    'base_url' => env('EASYPAY_BASE_URL', url('/')),\n" .
                  "    'key' => env('EASYPAY_KEY'),\n" .
                  "    'secret' => env('EASYPAY_SECRET'),\n" .
                  "    'merchant_id' => env('EASYPAY_MERCHANT_ID'),\n" .
                  "],\n\n" .

                  "5. CREATING ROUTES\n" .
                  "------------------\n" .
                  "Add these routes to your routes/web.php file:\n\n" .
                  "Route::post('/easypay/initiate', [EasypayController::class, 'initiatePayment']);\n" .
                  "Route::post('/easypay/callback', [EasypayController::class, 'handleCallback']);\n\n" .

                  "6. CONTROLLER IMPLEMENTATION\n" .
                  "----------------------------\n" .
                  "Create or update your controller with the following methods:\n\n" .
                  "<?php\n\n" .
                  "namespace App\Http\Controllers;\n\n" .
                  "use Illuminate\Http\Request;\n" .
                  "use Illuminate\Support\Facades\Http;\n" .
                  "use Illuminate\Support\Facades\Log;\n\n" .
                  "class EasypayController extends Controller\n" .
                  "{\n" .
                  "    public function initiatePayment(Request \$request)\n" .
                  "    {\n" .
                  "        // Validate request data\n" .
                  "        \$validated = \$request->validate([\n" .
                  "            'amount' => 'required|numeric|min:10',\n" .
                  "            'customer_name' => 'required|string|max:255',\n" .
                  "            'customer_email' => 'required|email',\n" .
                  "            'product_name' => 'required|string',\n" .
                  "        ]);\n\n" .
                  "        // Get credentials and base URL from config\n" .
                  "        \$baseUrl = config('services.easypay.base_url');\n" .
                  "        \$apiKey = config('services.easypay.key');\n" .
                  "        \$secretKey = config('services.easypay.secret');\n" .
                  "        \$merchantId = config('services.easypay.merchant_id');\n\n" .
                  "        // Prepare payment data\n" .
                  "        \$paymentData = [\n" .
                  "            'merchant_id' => \$merchantId,\n" .
                  "            'amount' => \$validated['amount'],\n" .
                  "            'customer_name' => \$validated['customer_name'],\n" .
                  "            'customer_email' => \$validated['customer_email'],\n" .
                  "            'description' => \$validated['product_name'],\n" .
                  "            'callback_url' => route('easypay.callback'),\n" .
                  "            'redirect_url' => url('/payment-success'),\n" .
                  "        ];\n\n" .
                  "        // Make API request to Easypay\n" .
                  "        \$response = Http::withHeaders([\n" .
                  "            'X-API-KEY' => \$apiKey,\n" .
                  "            'X-SECRET-KEY' => \$secretKey,\n" .
                  "            'Accept' => 'application/json',\n" .
                  "            'Content-Type' => 'application/json',\n" .
                  "        ])->post(\"{\$baseUrl}/api/payment/process\", \$paymentData);\n\n" .
                  "        // Handle response\n" .
                  "        if (\$response->successful()) {\n" .
                  "            \$responseData = \$response->json();\n" .
                  "            if (isset(\$responseData['checkout_url'])) {\n" .
                  "                return redirect(\$responseData['checkout_url']);\n" .
                  "            }\n" .
                  "        }\n\n" .
                  "        // Log error for debugging\n" .
                  "        Log::error('Easypay payment initiation failed', [\n" .
                  "            'response' => \$response->body(),\n" .
                  "            'data' => \$paymentData\n" .
                  "        ]);\n\n" .
                  "        return back()->with('error', 'Payment initiation failed. Please try again.');\n" .
                  "    }\n\n" .
                  "    public function handleCallback(Request \$request)\n" .
                  "    {\n" .
                  "        // Verify the callback is from Easypay\n" .
                  "        \$apiKey = config('services.easypay.key');\n" .
                  "        \$secretKey = config('services.easypay.secret');\n" .
                  "        \$providedSignature = \$request->header('X-Easypay-Signature');\n\n" .
                  "        // Verify signature (implement your verification logic)\n" .
                  "        // \$expectedSignature = hash_hmac('sha256', \$request->getContent(), \$secretKey);\n" .
                  "        // if (!hash_equals(\$expectedSignature, \$providedSignature)) {\n" .
                  "        //     return response()->json(['error' => 'Invalid signature'], 400);\n" .
                  "        // }\n\n" .
                  "        // Process payment status\n" .
                  "        \$orderId = \$request->input('order_id');\n" .
                  "        \$status = \$request->input('status');\n" .
                  "        \$transactionId = \$request->input('transaction_id');\n\n" .
                  "        // Update your database with payment status\n" .
                  "        // Example:\n" .
                  "        // \$order = Order::where('easypay_order_id', \$orderId)->first();\n" .
                  "        // if (\$order) {\n" .
                  "        //     \$order->status = \$status;\n" .
                  "        //     \$order->transaction_id = \$transactionId;\n" .
                  "        //     \$order->save();\n" .
                  "        // }\n\n" .
                  "        // Return success response\n" .
                  "        return response()->json(['status' => 'success']);\n" .
                  "    }\n" .
                  "}\n\n" .

                  "7. FRONTEND INTEGRATION\n" .
                  "-----------------------\n" .
                  "Add a payment button to your product pages:\n\n" .
                  "<form action=\"{{ route('easypay.initiate') }}\" method=\"POST\">\n" .
                  "    @csrf\n" .
                  "    <input type=\"hidden\" name=\"amount\" value=\"{{ \$product->price }}\">\n" .
                  "    <input type=\"hidden\" name=\"product_name\" value=\"{{ \$product->name }}\">\n" .
                  "    <input type=\"hidden\" name=\"customer_name\" value=\"{{ auth()->user()->name }}\">\n" .
                  "    <input type=\"hidden\" name=\"customer_email\" value=\"{{ auth()->user()->email }}\">\n" .
                  "    \n" .
                  "    <button type=\"submit\" class=\"btn btn-primary btn-lg\">\n" .
                  "        Pay ৳{{ number_format(\$product->price) }} with Easypay\n" .
                  "    </button>\n" .
                  "</form>\n\n" .

                  "8. CALLBACK HANDLING\n" .
                  "--------------------\n" .
                  "Easypay will send payment status updates to your callback URL:\n" .
                  "- Successful payments\n" .
                  "- Failed payments\n" .
                  "- Cancelled payments\n\n" .
                  "Ensure your callback handler:\n" .
                  "1. Verifies the request is from Easypay\n" .
                  "2. Updates your order records\n" .
                  "3. Sends confirmation emails (optional)\n" .
                  "4. Returns a success response\n\n" .

                  "9. TESTING\n" .
                  "----------\n" .
                  "1. Test with small amounts first\n" .
                  "2. Verify callback handling\n" .
                  "3. Test error scenarios\n" .
                  "4. Check database updates\n" .
                  "5. Verify redirect URLs work correctly\n\n" .

                  "10. GOING LIVE\n" .
                  "--------------\n" .
                  "1. Update API endpoint URLs to production\n" .
                  "2. Ensure HTTPS is enabled\n" .
                  "3. Verify callback URLs are publicly accessible\n" .
                  "4. Test with real transactions\n" .
                  "5. Monitor transactions in your dashboard\n\n" .

                  "SUPPORT\n" .
                  "-------\n" .
                  "For assistance with integration:\n" .
                  "- Email: support@easypay.com\n" .
                  "- Phone: +880 XXX XXX XXX\n" .
                  "- Documentation: https://easypay.com/docs\n\n" .
                  "SECURITY BEST PRACTICES\n" .
                  "-----------------------\n" .
                  "- Never expose your Secret Key in client-side code\n" .
                  "- Always use HTTPS for all communication\n" .
                  "- Validate all incoming data\n" .
                  "- Implement proper error handling\n" .
                  "- Log errors for debugging (but never log credentials)\n" .
                  "- Verify callback signatures\n\n" .
                  "ERROR CODES\n" .
                  "-----------\n" .
                  "- 400: Bad Request - Check your request data\n" .
                  "- 401: Unauthorized - Check your API credentials\n" .
                  "- 403: Forbidden - Check your permissions\n" .
                  "- 422: Unprocessable Entity - Validation failed\n" .
                  "- 500: Internal Server Error - Contact support\n\n" .

                  "This guide was generated on " . date('Y-m-d H:i:s') . " for " . ($user->website_name ?? $user->name) . "\n" .
                  "For the latest version, visit your Easypay merchant dashboard.";

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="easypay-integration-guide-' . date('Y-m-d') . '.txt"',
        ];

        return response()->make($content, 200, $headers);
    }

    /**
     * Download the code samples package
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadCodeSamples()
    {
        // Get the authenticated user's data
        $user = Auth::user();

        // Get user's API credentials
        $apiKey = $user->api_key ?? 'your_api_key_here';
        $secretKey = $user->secret_key ?? 'your_secret_key_here';
        $merchantId = $user->merchant_id ?? 'your_merchant_id_here';

        // Create comprehensive code samples package with user's credentials
        $content = "Easypay Code Samples Package\n" .
                  "==========================\n\n" .

                  "This package contains ready-to-use code samples for integrating Easypay with your Laravel application.\n" .
                  "Prepared for: " . ($user->website_name ?? $user->name) . "\n" .
                  "Generated on: " . date('Y-m-d H:i:s') . "\n\n" .

                  "YOUR API CREDENTIALS:\n" .
                  "API Key: " . $apiKey . "\n" .
                  "Secret Key: " . $secretKey . "\n" .
                  "Merchant ID: " . $merchantId . "\n\n" .
                  "IMPORTANT: Keep your Secret Key secure and never expose it in client-side code!\n\n" .

                  "CONTENTS:\n" .
                  "1. Routes Configuration\n" .
                  "2. Controller Implementation\n" .
                  "3. Model Examples\n" .
                  "4. Frontend Integration\n" .
                  "5. Configuration Files\n" .
                  "6. Environment Setup\n\n" .

                  "1. ROUTES CONFIGURATION\n" .
                  "-----------------------\n" .
                  "Add these routes to your routes/web.php file:\n\n" .
                  "<?php\n\n" .
                  "use App\Http\Controllers\EasypayController;\n\n" .
                  "// Easypay payment routes\n" .
                  "Route::post('/easypay/initiate', [EasypayController::class, 'initiatePayment'])->name('easypay.initiate');\n" .
                  "Route::post('/easypay/callback', [EasypayController::class, 'handleCallback'])->name('easypay.callback');\n" .
                  "Route::get('/easypay/success', function () { return view('payment.success'); })->name('easypay.success');\n" .
                  "Route::get('/easypay/cancel', function () { return view('payment.cancel'); })->name('easypay.cancel');\n\n" .

                  "2. CONTROLLER IMPLEMENTATION\n" .
                  "----------------------------\n" .
                  "Create app/Http/Controllers/EasypayController.php with the following content:\n\n" .
                  "<?php\n\n" .
                  "namespace App\Http\Controllers;\n\n" .
                  "use Illuminate\Http\Request;\n" .
                  "use Illuminate\Support\Facades\Http;\n" .
                  "use Illuminate\Support\Facades\Log;\n" .
                  "use Illuminate\Support\Facades\Auth;\n" .
                  "use App\Models\Order;\n\n" .
                  "class EasypayController extends Controller\n" .
                  "{\n" .
                  "    /**\n" .
                  "     * Initiate a payment with Easypay\n" .
                  "     */\n" .
                  "    public function initiatePayment(Request \$request)\n" .
                  "    {\n" .
                  "        // Validate request data\n" .
                  "        \$validated = \$request->validate([\n" .
                  "            'amount' => 'required|numeric|min:10',\n" .
                  "            'product_name' => 'required|string|max:255',\n" .
                  "            'customer_name' => 'required|string|max:255',\n" .
                  "            'customer_email' => 'required|email',\n" .
                  "        ]);\n\n" .
                  "        // Get API credentials from config\n" .
                  "        \$apiKey = config('services.easypay.key');\n" .
                  "        \$secretKey = config('services.easypay.secret');\n" .
                  "        \$merchantId = config('services.easypay.merchant_id');\n\n" .
                  "        // Create order in your database\n" .
                  "        \$order = Order::create([\n" .
                  "            'user_id' => Auth::id(),\n" .
                  "            'amount' => \$validated['amount'],\n" .
                  "            'product_name' => \$validated['product_name'],\n" .
                  "            'customer_name' => \$validated['customer_name'],\n" .
                  "            'customer_email' => \$validated['customer_email'],\n" .
                  "            'status' => 'pending',\n" .
                  "        ]);\n\n" .
                  "        // Prepare payment data for Easypay API\n" .
                  "        \$paymentData = [\n" .
                  "            'merchant_id' => \$merchantId,\n" .
                  "            'order_id' => \$order->id,\n" .
                  "            'amount' => \$validated['amount'],\n" .
                  "            'customer_name' => \$validated['customer_name'],\n" .
                  "            'customer_email' => \$validated['customer_email'],\n" .
                  "            'description' => \$validated['product_name'],\n" .
                  "            'callback_url' => route('easypay.callback'),\n" .
                  "            'redirect_url' => route('easypay.success'),\n" .
                  "            'cancel_url' => route('easypay.cancel'),\n" .
                  "        ];\n\n" .
                  "        try {\n" .
                  "            // Get Base URL from config\n" .
                  "            \$baseUrl = config('services.easypay.base_url');\n\n" .
                  "            // Make API request to Easypay\n" .
                  "            \$response = Http::withHeaders([\n" .
                  "                'X-API-KEY' => \$apiKey,\n" .
                  "                'X-SECRET-KEY' => \$secretKey,\n" .
                  "                'Accept' => 'application/json',\n" .
                  "                'Content-Type' => 'application/json',\n" .
                  "            ])->timeout(30)->post(\"{\$baseUrl}/api/payment/process\", \$paymentData);\n\n" .
                  "            // Handle response\n" .
                  "            if (\$response->successful()) {\n" .
                  "                \$responseData = \$response->json();\n" .
                  "                \n" .
                  "                if (isset(\$responseData['checkout_url'])) {\n" .
                  "                    // Update order with Easypay order ID\n" .
                  "                    \$order->easypay_order_id = \$responseData['order_id'] ?? null;\n" .
                  "                    \$order->save();\n" .
                  "                    \n" .
                  "                    // Redirect to Easypay checkout\n" .
                  "                    return redirect()->away(\$responseData['checkout_url']);\n" .
                  "                }\n" .
                  "                \n" .
                  "                Log::error('Easypay checkout URL missing', ['response' => \$responseData]);\n" .
                  "            } else {\n" .
                  "                Log::error('Easypay API error', [\n" .
                  "                    'status' => \$response->status(),\n" .
                  "                    'body' => \$response->body()\n" .
                  "                ]);\n" .
                  "            }\n" .
                  "        } catch (Exception \$e) {\n" .
                  "            Log::error('Easypay payment initiation exception', [\n" .
                  "                'message' => \$e->getMessage(),\n" .
                  "                'trace' => \$e->getTraceAsString()\n" .
                  "            ]);\n" .
                  "        }\n\n" .
                  "        // If we get here, something went wrong\n" .
                  "        return back()->with('error', 'Unable to initiate payment. Please try again.');\n" .
                  "    }\n\n" .
                  "    /**\n" .
                  "     * Handle callback from Easypay\n" .
                  "     */\n" .
                  "    public function handleCallback(Request \$request)\n" .
                  "    {\n" .
                  "        // Get credentials\n" .
                  "        \$apiKey = config('services.easypay.key');\n" .
                  "        \$secretKey = config('services.easypay.secret');\n\n" .
                  "        // Verify callback signature (optional but recommended)\n" .
                  "        \$providedSignature = \$request->header('X-Easypay-Signature');\n" .
                  "        if (\$providedSignature) {\n" .
                  "            \$expectedSignature = hash_hmac('sha256', \$request->getContent(), \$secretKey);\n" .
                  "            if (!hash_equals(\$expectedSignature, \$providedSignature)) {\n" .
                  "                Log::warning('Invalid Easypay callback signature', [\n" .
                  "                    'provided' => \$providedSignature,\n" .
                  "                    'expected' => \$expectedSignature\n" .
                  "                ]);\n" .
                  "                return response()->json(['error' => 'Invalid signature'], 400);\n" .
                  "            }\n" .
                  "        }\n\n" .
                  "        // Process payment data\n" .
                  "        \$orderId = \$request->input('order_id');\n" .
                  "        \$status = \$request->input('status');\n" .
                  "        \$transactionId = \$request->input('transaction_id');\n" .
                  "        \$amount = \$request->input('amount');\n\n" .
                  "        // Update order in database\n" .
                  "        \$order = Order::where('id', \$orderId)->first();\n" .
                  "        \n" .
                  "        if (\$order) {\n" .
                  "            \$order->status = \$status;\n" .
                  "            \$order->transaction_id = \$transactionId;\n" .
                  "            \$order->save();\n\n" .
                  "            // Send confirmation email, update inventory, etc.\n" .
                  "            // Add your business logic here\n\n" .
                  "            Log::info('Order updated', [\n" .
                  "                'order_id' => \$orderId,\n" .
                  "                'status' => \$status,\n" .
                  "                'transaction_id' => \$transactionId\n" .
                  "            ]);\n\n" .
                  "            return response()->json(['status' => 'success']);\n" .
                  "        }\n\n" .
                  "        Log::warning('Order not found for callback', ['order_id' => \$orderId]);\n" .
                  "        return response()->json(['error' => 'Order not found'], 404);\n" .
                  "    }\n" .
                  "}\n\n" .

                  "3. MODEL EXAMPLE\n" .
                  "----------------\n" .
                  "Create or update your Order model (app/Models/Order.php):\n\n" .
                  "<?php\n\n" .
                  "namespace App\Models;\n\n" .
                  "use Illuminate\Database\Eloquent\Factories\HasFactory;\n" .
                  "use Illuminate\Database\Eloquent\Model;\n\n" .
                  "class Order extends Model\n" .
                  "{\n" .
                  "    use HasFactory;\n\n" .
                  "    protected \$fillable = [\n" .
                  "        'user_id',\n" .
                  "        'amount',\n" .
                  "        'product_name',\n" .
                  "        'customer_name',\n" .
                  "        'customer_email',\n" .
                  "        'status',\n" .
                  "        'transaction_id',\n" .
                  "        'easypay_order_id',\n" .
                  "    ];\n\n" .
                  "    // Define relationships\n" .
                  "    public function user()\n" .
                  "    {\n" .
                  "        return \$this->belongsTo(User::class);\n" .
                  "    }\n" .
                  "}\n\n" .

                  "4. FRONTEND INTEGRATION\n" .
                  "-----------------------\n" .
                  "Product page form example:\n\n" .
                  "<!-- resources/views/product.blade.php -->\n" .
                  "<div class=\"payment-section\">\n" .
                  "    <h3>Pay with Easypay</h3>\n" .
                  "    \n" .
                  "    <form action=\"{{ route('easypay.initiate') }}\" method=\"POST\">\n" .
                  "        @csrf\n" .
                  "        <input type=\"hidden\" name=\"amount\" value=\"{{ \$product->price }}\">\n" .
                  "        <input type=\"hidden\" name=\"product_name\" value=\"{{ \$product->name }}\">\n" .
                  "        <input type=\"hidden\" name=\"customer_name\" value=\"{{ auth()->user()->name }}\">\n" .
                  "        <input type=\"hidden\" name=\"customer_email\" value=\"{{ auth()->user()->email }}\">\n" .
                  "        \n" .
                  "        <div class=\"payment-summary\">\n" .
                  "            <p>Product: {{ \$product->name }}</p>\n" .
                  "            <p>Price: ৳{{ number_format(\$product->price) }}</p>\n" .
                  "        </div>\n" .
                  "        \n" .
                  "        <button type=\"submit\" class=\"btn btn-primary btn-lg\">\n" .
                  "            <i class=\"fas fa-lock\"></i> Pay ৳{{ number_format(\$product->price) }} Securely\n" .
                  "        </button>\n" .
                  "    </form>\n" .
                  "</div>\n\n" .

                  "Success page example:\n\n" .
                  "<!-- resources/views/payment/success.blade.php -->\n" .
                  "@extends('layouts.app')\n\n" .
                  "@section('title', 'Payment Successful')\n\n" .
                  "@section('content')\n" .
                  "<div class=\"container py-5\">\n" .
                  "    <div class=\"row justify-content-center\">\n" .
                  "        <div class=\"col-md-8\">\n" .
                  "            <div class=\"card\">\n" .
                  "                <div class=\"card-header bg-success text-white\">\n" .
                  "                    <h4 class=\"mb-0\"><i class=\"fas fa-check-circle\"></i> Payment Successful</h4>\n" .
                  "                </div>\n" .
                  "                <div class=\"card-body text-center\">\n" .
                  "                    <div class=\"mb-4\">\n" .
                  "                        <i class=\"fas fa-check-circle text-success\" style=\"font-size: 4rem;\"></i>\n" .
                  "                    </div>\n" .
                  "                    <h5>Thank you for your payment!</h5>\n" .
                  "                    <p>Your transaction has been processed successfully.</p>\n" .
                  "                    <a href=\"{{ route('dashboard') }}\" class=\"btn btn-primary\">Back to Dashboard</a>\n" .
                  "                </div>\n" .
                  "            </div>\n" .
                  "        </div>\n" .
                  "    </div>\n" .
                  "</div>\n" .
                  "@endsection\n\n" .

                  "5. CONFIGURATION FILES\n" .
                  "----------------------\n" .
                  "Update config/services.php:\n\n" .
                  "<?php\n\n" .
                  "return [\n" .
                  "    // ... other services ...\n\n" .
                  "    'easypay' => [\n" .
                  "        'key' => env('EASYPAY_KEY'),\n" .
                  "        'secret' => env('EASYPAY_SECRET'),\n" .
                  "        'merchant_id' => env('EASYPAY_MERCHANT_ID'),\n" .
                  "    ],\n\n" .
                  "];\n\n" .

                  "6. ENVIRONMENT SETUP\n" .
                  "--------------------\n" .
                  "Add to your .env file:\n\n" .
                  "# Easypay API Credentials\n" .
                  "EASYPAY_KEY=" . $apiKey . "\n" .
                  "EASYPAY_SECRET=" . $secretKey . "\n" .
                  "EASYPAY_MERCHANT_ID=" . $merchantId . "\n\n" .

                  "DATABASE MIGRATION\n" .
                  "------------------\n" .
                  "Create a migration for the orders table:\n\n" .
                  "php artisan make:migration create_orders_table\n\n" .
                  "<?php\n\n" .
                  "use Illuminate\Database\Migrations\Migration;\n" .
                  "use Illuminate\Database\Schema\Blueprint;\n" .
                  "use Illuminate\Support\Facades\Schema;\n\n" .
                  "class CreateOrdersTable extends Migration\n" .
                  "{\n" .
                  "    public function up()\n" .
                  "    {\n" .
                  "        Schema::create('orders', function (Blueprint \$table) {\n" .
                  "            \$table->id();\n" .
                  "            \$table->foreignId('user_id')->constrained()->onDelete('cascade');\n" .
                  "            \$table->decimal('amount', 10, 2);\n" .
                  "            \$table->string('product_name');\n" .
                  "            \$table->string('customer_name');\n" .
                  "            \$table->string('customer_email');\n" .
                  "            \$table->string('status')->default('pending');\n" .
                  "            \$table->string('transaction_id')->nullable();\n" .
                  "            \$table->string('easypay_order_id')->nullable();\n" .
                  "            \$table->timestamps();\n" .
                  "        });\n" .
                  "    }\n\n" .
                  "    public function down()\n" .
                  "    {\n" .
                  "        Schema::dropIfExists('orders');\n" .
                  "    }\n" .
                  "}\n\n" .

                  "This package was generated on " . date('Y-m-d H:i:s') . " for " . ($user->website_name ?? $user->name) . "\n" .
                  "For the latest samples and documentation, visit https://easypay.com/docs";

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="easypay-code-samples-' . date('Y-m-d') . '.txt"',
        ];

        return response()->make($content, 200, $headers);
    }
}
