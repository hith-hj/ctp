<?php

namespace App\Models\Attributes;

use App\Models\Setting;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TextArea extends Model implements TranslatableContract
{
    use Translatable;

    protected $fillable = ['setting_id'];

    public $translatedAttributes = ['value'];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function getTextAreaAttribute()
    {
        return $this->translate()->value;
    }
}
