<?php

namespace App\Models\Attributes;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Number extends Model
{
    protected $fillable = ['value'];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function getNumberAttribute()
    {
        return $this->value;
    }
}
