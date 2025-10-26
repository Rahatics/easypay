<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // লগিং এর জন্য

class SendOrderCallback implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->order->callback_url)) {
            return;
        }

        // মার্চেন্টকে পাঠানোর জন্য ডেটা প্রস্তুত করুন
        $payload = [
            'order_id' => $this->order->order_id,
            'status' => $this->order->status,
            'amount' => $this->order->amount,
            'transaction_id' => $this->order->transaction_id,
            'timestamp' => now()->toIso8601String(),
        ];

        // Webhook signature for security
        $secretKey = $this->order->user->secret_key; // মার্চেন্টের সিক্রেট কী
        $payloadJson = json_encode($payload);
        $signature = hash_hmac('sha256', $payloadJson, $secretKey);

        try {
            // মার্চেন্টের সাইটে POST রিকোয়েস্ট পাঠান
            $response = Http::withHeaders([
                'X-Easypay-Signature' => $signature
            ])->post($this->order->callback_url, $payload);

            // লগিং
            Log::info('Callback sent for order: ' . $this->order->order_id, [
                'url' => $this->order->callback_url,
                'status_code' => $response->status(),
                'response_body' => $response->body(),
            ]);

        } catch (\Exception $e) {
            Log::error('Callback failed for order: ' . $this->order->order_id, [
                'url' => $this->order->callback_url,
                'error' => $e->getMessage(),
            ]);
            // প্রয়োজনে জবটি আবার চেষ্টা করার জন্য রিলিজ করতে পারেন
            // $this->release(60); // ১ মিনিট পর আবার চেষ্টা করবে
        }
    }
}
