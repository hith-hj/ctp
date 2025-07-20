<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['background_image', 'responsive_image', 'sort_order', 'product_id'];

    public $translatedAttributes = ['title', 'brief'];

    public $mediaAttributes = ['background_image' => 'image', 'responsive_image' => 'image'];

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
