<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['sort_order', 'slug', 'image', 'icon', 'is_active', 'icon', 'parent_category'];

    public $translatedAttributes = ['name'];

    protected $hidden = ['translations', 'created_at', 'updated_at', 'parent_category', 'is_active'];

    protected $appends = ['product_count'];

    public function parentCategory(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category');
    }

    public function subcategories(): HasMany
    {
        return $this->parentCategory()->active();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeSorted(Builder $query)
    {
        return $query->orderBy('sort_order');
    }

    public function getTitleAttribute()
    {
        return $this->name;
    }

    public function getParent()
    {
        if (! $this->getAttribute('parent_category')) {
            return null;
        }

        return $this->getAttribute('parent_category');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeParent(Builder $query): Builder
    {
        return $query->whereNull('parent_category');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeSub(Builder $query): Builder
    {
        return $query->whereNotNull('parent_category');
    }

    public function getProductCountAttribute($value)
    {
        if ($this->parent_category != null) {
            return count($this->products);
        } else {
            return 0;
        }
    }
}
