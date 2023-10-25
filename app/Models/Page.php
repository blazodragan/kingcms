<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use App\Media\AutoProcessMediaTrait;
use App\Media\HasMediaPreviewsTrait;
use App\Media\InteractsWithMedia;
use App\Media\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\User;
use App\Models\FAQ;
use App\Models\Tip;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Page extends Model  implements HasMedia {

    use SoftDeletes;

    use HasTranslations;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use InteractsWithMedia;
    use HasMediaPreviewsTrait;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'perex',
        'content',
        'text',
        'why',
        'status',
        'template',
        'is_index',
        'is_parent',
        'meta_title',
        'meta_description',
        'meta_url_canolical',
        'no_index',
        'no_follow',
        'og_title',
        'og_description',
        'og_type',
        'og_url',
        'user_id',
        'parent_id',
        'published_at'];

    public $searchable = ['title'];

    public $translatable = [
        'title',
        'slug',
        'perex',
        'content',
        'text',
        'why',
        'meta_title',
        'meta_description',
        'meta_url_canolical',
        'href_lang',
        'og_title',
        'og_description',
        'og_type',
        'og_url'];

    protected $appends = [
        'cover_url',
        'cover_big',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover');
        $this->addMediaCollection('og_cover');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterPreviews();
        $this->autoRegisterBigThumbs();
    }

    

    public function faqs()
    {
        return $this->morphMany(FAQ::class, 'faqable');
    }

    public function tips()
    {
        return $this->morphMany(Tip::class, 'tipable');
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
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

    protected function coverBig(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->getFirstMediaUrl('cover', 'bigThumb'));
    }


    
}
