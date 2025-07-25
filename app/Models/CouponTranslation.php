<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponTranslation extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;
}
