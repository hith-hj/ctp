<?php

namespace App\Models\Attributes;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Album extends Model
{
    protected $fillable = ['setting_id', 'value'];

    protected $casts = ['value' => 'array'];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function getAlbumAttribute()
    {
        return $this->value;
    }
}
