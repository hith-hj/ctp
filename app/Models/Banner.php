<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Banner extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'model_type',
        'model_id',
        'image',
        'sort_order',
        'applies_to',
    ];

    public $translatedAttributes = ['title', 'brief'];

    public $mediaAttributes = ['image' => 'image'];

    protected $appends = [
        'model_type_name',
        'price',
        'is_new',
    ];

    protected $hidden = ['model_type', 'model_id', 'sort_order', 'applies_to', 'created_at', 'updated_at', 'translations', 'applicable'];

    protected $with = ['applicable'];

    public function getIsNewAttribute(): bool
    {
        return $this->applicable->is_new ?? false;
    }

    public function getPriceAttribute()
    {
        return $this->applicable->price ?? 0;
    }

    public function applicable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }

    // Request Status ATTRIBUTE
    public function getModelTypeNameAttribute(): string
    {
        switch ($this->model_type) {
            case 'App\\Models\\Product':
                return __('admin.product');
            case 'App\\Models\\Category':
                return __('admin.category');
            default:
                return __('request.model');
        }
    }

    public function scopeSorted(Builder $query)
    {
        return $query->orderBy('sort_order');
    }
}
