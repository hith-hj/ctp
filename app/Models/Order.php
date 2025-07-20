<?php

namespace App\Models;

use App\Http\Traits\FcmNotifiable;
use App\Http\Traits\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use FcmNotifiable;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'admin_id',
        'order_detail_id',
        'payment_method_id',
        'payment_method_type',
        'payment_method_status',
        'total_price',
        'total_price_before_discount',
        'currency_id',
        'coupon_id',
        'discount_on_coupon',
        'mile_commission',
        'delivery_date',
        'code',
        'status',
    ];

    protected $appends = ['vendor_name', 'client_name', 'status_name', 'create_date'];

    protected $hidden = ['vendor', 'client'];

    protected $with = ['items'];

    protected $casts = ['total_price' => 'double', 'total_price_before_discount' => 'double'];

    const STATUS_PENDING = 1;

    const STATUS_ONGOING = 2;

    const STATUS_CANCELLED = 3;

    const STATUS_DELIVERED = 4;

    /** ORDER RELATIONS **/
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'order_id');
    }

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function orderDetail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /** ORDER APPENDS **/
    public function getClientNameAttribute()
    {
        return $this->client->name;
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getCreateDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // public function getTotalPriceAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    public function getVendorNameAttribute()
    {
        return $this->vendor->name;
    }

    public function getStatusNameAttribute()
    {
        switch ($this->status) {
            case self::STATUS_ONGOING:
                return __('order.ongoing');
            case self::STATUS_CANCELLED:
                return __('order.cancelled');
            case self::STATUS_DELIVERED:
                return __('order.delivered');
            default:
                return __('order.pending');
        }
    }

    /** ORDER METHODS **/
    public function calculatePrices($shippingPrice = 0)
    {
        $cart = $this->cart;
        if ($this->coupon_id) {
            $coupon = $this->coupon->coupon_value;
            $couponDiscount = $cart->total_price * ($coupon / 100);
            $this->discount_on_coupon = $couponDiscount;
            $this->total_price_before_discount = $cart->total_price_before_discount + $shippingPrice;
            $this->total_price = round($cart->total_price_before_discount - $couponDiscount, 2);
        } else {
            $this->discount_on_coupon = 0;
            $this->total_price = $cart->total_price;
            $this->total_price_before_discount = $cart->total_price_before_discount;

        }
        $this->save();
    }

    public function getIsPayableAttribute()
    {
        return $this->payment_method_type == null &&
            $this->payment_method_id == null &&
            $this->payment_method_status == null;
    }
}
