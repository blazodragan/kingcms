<?php

namespace App\Models;

use App\Media\InteractsWithMedia;
use App\Media\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class UnassignedMedia extends Model implements HasMedia
{
    use InteractsWithMedia;
    use ProcessMediaTrait;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')->singleFile();
    }
}
