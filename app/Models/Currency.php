<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['code', 'symbol', 'rate', 'is_active', 'is_default', 'use_api_rate'];

    public $translatedAttributes = ['name'];

    protected $appends = ['selected_rate'];

    protected $hidden = ['translations', 'created_at', 'updated_at', 'is_active'];

    public $visibleAttributes = [
        'code' => 'text',
        'symbol' => 'text',
        'is_active' => 'status',
        'use_api_rate' => 'status',
        'exchange_rate' => 'text',
        'rate' => 'text',
    ];

    public function getSelectedRateAttribute()
    {
        return $this->use_api_rate == 1 ? $this->exchange_rate : $this->rate;
    }
}
