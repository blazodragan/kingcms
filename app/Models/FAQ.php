<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FAQ extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'faqs';

    protected $fillable = ['question', 'answer'];
    public $translatable = ['question', 'answer'];

    public function faqable()
    {
        return $this->morphTo();
    }
}
