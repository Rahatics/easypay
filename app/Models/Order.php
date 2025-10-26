<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'processing_fee',
        'total_amount',
        'currency',
        'description',
        'customer_info',
        'status',
        'gateway',
        'transaction_id',
        'callback_url',
        'cancel_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'processing_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'customer_info' => 'array'
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
