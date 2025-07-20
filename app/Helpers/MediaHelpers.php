<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

function uploadMedia($file, $folderName)
{
    $size = getimagesize($file);
    if ($size[0] > 1500) { // or 800 * 1200
        $extension = $file->extension();
        $featuredImage = Image::make($file)->resize(1000, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode($extension);
        $hash = md5($featuredImage->__toString());

        $filePath = $folderName.'/'.$hash.'.'.$extension;
        Storage::disk('public')->put($filePath, $featuredImage->__toString());
        $storagePath = $filePath;
        ImageOptimizer::optimize('storage/'.$filePath);
    } else {
        $storagePath = Storage::disk('public')->put($folderName, $file);
        ImageOptimizer::optimize('storage/'.$storagePath);
    }

    return $storagePath;
}
