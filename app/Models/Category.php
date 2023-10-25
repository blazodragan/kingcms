<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Media\AutoProcessMediaTrait;
use App\Media\HasMediaPreviewsTrait;
use App\Media\InteractsWithMedia;
use App\Media\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model  implements HasMedia {

    use HasTranslations;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use InteractsWithMedia;
    use HasMediaPreviewsTrait;

    protected $table = 'categories';
    protected $fillable = ['alias', 'slug', 'title', 'description', 'type'];
    public $searchable = ['alias']; 
    public $translatable = ['slug', 'title', 'description'];


    protected $appends = [
        'cover_url',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('cover')
            ->singleFile();
        ;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterPreviews();
    }

    /**
     * Get the user's avatar URL.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->getFirstMediaUrl('cover', 'preview'));
    }

}
