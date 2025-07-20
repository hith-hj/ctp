<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipping_details_id',
        'shipping_fees',
        'code',
        'amount_discount',
    ];

    protected $with = ['orders'];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function shippingDetails(): BelongsTo
    {
        return $this->belongsTo(ShippingDetails::class);
    }
}
