<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = ['type', 'use_as_filter'];

    public $visibleAttributes = [
        'type' => 'text',
        'use_as_filter' => 'status',
    ];

    protected $appends = ['values'];

    protected $hidden = ['translations', 'created_at', 'updated_at', 'values'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attributes');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_attributes');
    }

    public function getValuesAttribute()
    {
        switch ($this->type) {
            case 'select':
            case 'size':
            case 'color':
            case 'text':
                return $this->hasMany(ProductAttribute::class, 'attribute_id')->groupBy('value')->pluck('value');
            case 'number':
                return ['min' => ProductAttribute::min('value'), 'max' => ProductAttribute::max('value')];
            case 'checkbox':
                return ['true' => 1, 'false' => 0];
        }
    }

    public function scopeIsFilter()
    {
        return $this->where('use_as_filter', 1);
    }
}
