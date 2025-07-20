<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'category_id',
        'sku',
        'slug',
        'price',
        'capital_price',
        'price_before_discount',
        'featured_image',
        'images',
        'shipping_price',
        'status',
        'sort_order',
        'admin_id',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'double',
        'shipping_price' => 'double',
        'price_before_discount' => 'double',
    ];

    protected $appends = ['full_featured_image', 'is_new'];

    protected $hidden = [
        'translations',
        'category_id',
        'admin_id',
        'created_at',
        'updated_at',
        'sort_order',
        'status',
    ];

    // public function getPriceBeforeDiscountAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    // public function getShippingPriceAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    // public function getPriceAttribute($value): float
    // {
    //     return round($value * getAppCurrency()->selected_rate, 2);
    // }

    public function getFullFeaturedImageAttribute()
    {
        return storageImage($this->featured_image);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes')->withPivot('value');
    }

    public function getIsNewAttribute(): bool
    {
        $diffInDays = Carbon::now()->diffInDays($this->created_at);

        return $diffInDays <= 10;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function isLikedBy(User $user): bool
    {
        return (bool) $user
            ->wishList()
            ->where('products.id', $this->id)
            ->count();
    }

    //    public function reviews(): HasMany
    //    {
    //        return $this->hasMany(Review::class, 'model_id')->where('model_type', 'App\Models\Product');
    //    }

}
