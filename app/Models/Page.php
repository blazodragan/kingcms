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

class Page extends Model  implements HasMedia {

    use SoftDeletes;

    use HasTranslations;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use InteractsWithMedia;
    use HasMediaPreviewsTrait;

    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'perex', 'content', 'status' , 'template','is_index', 'meta_title', 'meta_description', 'meta_url_canolical', 'href_lang', 'no_index', 'no_follow', 'og_title', 'og_description', 'og_type', 'og_url', 'user_id', 'published_at'];

    public $translatable = ['title', 'slug', 'perex', 'content', 'meta_title', 'meta_description', 'meta_url_canolical', 'href_lang', 'og_title', 'og_description', 'og_type', 'og_url'];

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
    }
}
