<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'cart_id', 'admin_id', 'price', 'price_before_discount', 'qty'];

    protected $with = ['product'];

    protected $appends = ['name'];

    protected $hidden = ['id', 'updated_at', 'cart_id', 'admin_id'];

    protected $casts = ['price' => 'double', 'price_before_discount' => 'double'];

    // public function getPriceAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    // public function getPriceBeforeDiscountAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function getNameAttribute()
    {
        return $this->product->name;
    }
}
