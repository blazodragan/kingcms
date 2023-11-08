<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use App\Media\AutoProcessMediaTrait;
use App\Media\HasMediaPreviewsTrait;
use App\Media\InteractsWithMedia;
use App\Media\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Category;
use App\Models\User;
use App\Models\FAQ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model  implements HasMedia {

    use SoftDeletes;
    use HasFactory;
    use HasTranslations;
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use InteractsWithMedia;
    use HasMediaPreviewsTrait;


    protected $table = 'posts';
    protected $fillable = [
        'title',
        'slug',
        'perex',
        'content',
        'status' ,
        'meta_title',
        'meta_description',
        'meta_url_canolical',
        'href_lang',
        'no_index',
        'no_follow',
        'og_title',
        'og_description',
        'og_type',
        'og_url',
        'user_id',
        'published_at',
        'template'
    ];
    public $searchable = ['title'];

    public $translatable = [
        'title',
        'slug',
        'perex',
        'content',
        'meta_title',
        'meta_description',
        'meta_url_canolical',
        'href_lang',
        'og_title',
        'og_description',
        'og_type',
        'og_url'
    ];
    protected $appends = [
        'cover_big',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }

    public function faqs()
    {
        return $this->morphMany(FAQ::class, 'faqable');
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

    protected function coverBig(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->getFirstMediaUrl('cover', 'bigThumb'));
    }
}
