<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantGateway extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'gateway_name',
        'account_number',
        'fees_percentage',
        'is_enabled'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'fees_percentage' => 'decimal:2'
    ];

    /**
     * Get the user that owns the gateway.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
