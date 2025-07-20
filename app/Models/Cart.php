<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'total_price_before_discount', 'currency_id', 'user_id', 'order_id', 'status'];

    protected $with = ['items'];

    protected $hidden = ['user_id', 'order_id', 'total_price', 'total_price_before_discount', 'created_at', 'updated_at'];

    protected $casts = ['total_price' => 'double', 'total_price_before_discount' => 'double'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }

    public function scopeNotActive(Builder $query)
    {
        return $query->where('status', 0);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        $totalPriceBeforeDiscount = 0;

        foreach ($this->items as $item) {
            $totalPrice = $totalPrice + $item->getRawOriginal('price');
            $totalPriceBeforeDiscount += $item->getRawOriginal('price_before_discount');
        }
        $this->total_price = round($totalPrice, 2);
        $this->total_price_before_discount = round($totalPriceBeforeDiscount, 2);
        $this->save();
    }

    public function emptyTotalPrice()
    {
        $this->total_price = 0;
        $this->total_price_before_discount = 0;
    }

    public function calculateShippingPrice(): float
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->product->shipping_price;
        }

        return round($price, 2);
    }

    public function calculateSutotalPrice(): float
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->price;
        }

        return round($price, 2);
    }
}
