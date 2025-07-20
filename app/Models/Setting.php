<?php

namespace App\Models;

use App\Models\Attributes\Album;
use App\Models\Attributes\Checkbox;
use App\Models\Attributes\Image;
use App\Models\Attributes\Number;
use App\Models\Attributes\RichTextBox;
use App\Models\Attributes\Select;
use App\Models\Attributes\Text;
use App\Models\Attributes\TextArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Setting extends Model
{
    protected $fillable = ['key', 'type'];

    public function text(): HasOne
    {
        return $this->hasOne(Text::class);
    }

    public function textArea(): HasOne
    {
        return $this->hasOne(TextArea::class);
    }

    public function richTextBox(): HasOne
    {
        return $this->hasOne(RichTextBox::class);
    }

    public function number(): HasOne
    {
        return $this->hasOne(Number::class);
    }

    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }

    public function album(): HasOne
    {
        return $this->hasOne(Album::class);
    }

    public function checkbox(): HasOne
    {
        return $this->hasOne(Checkbox::class);
    }

    public function select(): HasOne
    {
        return $this->hasOne(Select::class);
    }

    public function translate(): bool
    {
        return false;
    }

    public function detachAll()
    {
        //MEANS '$this->text()->delete();' FOR EXAMPLE
        $this->{camel($this->type)}()->delete();
    }
}
