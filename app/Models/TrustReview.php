<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TrustReview extends Model {

    use HasTranslations;

    protected $table = 'trust_reviews';
    protected $fillable = ['title', 'description', 'rating'];
    protected $searchable = ['title'];
    public $translatable = ['title', 'description'];

}
