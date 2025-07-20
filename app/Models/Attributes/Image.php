<?php

namespace App\Models\Attributes;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = ['setting_id', 'value'];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function getImageAttribute()
    {
        return $this->value;
    }
}
