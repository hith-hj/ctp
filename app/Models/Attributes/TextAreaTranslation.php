<?php

namespace App\Models\Attributes;

use Illuminate\Database\Eloquent\Model;

class TextAreaTranslation extends Model
{
    protected $fillable = ['value'];

    public $timestamps = false;
}
