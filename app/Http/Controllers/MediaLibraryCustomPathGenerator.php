<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaLibraryCustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        if (!is_null($media->collection_name))
            return $media->collection_name . '/' . $media->id . '/';
        return $media->id . '/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}
