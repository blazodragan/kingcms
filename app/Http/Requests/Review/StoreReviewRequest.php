<?php
namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use app\Settings\GeneralSettings;

class StoreReviewRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.review.create");
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        $settings = app(GeneralSettings::class);
        $defaultLocale = $settings->default_locale;
        return [
            "slug.$defaultLocale" => [
                'required',
                'max:255',
                "unique_locale_slug:reviews",
            ],
            'status' => ['required'],
            'template' => ['required'],
            'rating' => ['required'],
            "title.$defaultLocale" => ['required'],
            'perex' => ['required'],
            'content' => ['required'],
            'text' => ['required'],
            'why' => ['nullable'],
            'active' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'href_lang' => ['nullable'],
            'no_index' => ['required','boolean'],
            'no_follow' => ['required','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'user_id' => ['required','exists:users,id'],
            'rating' => ['nullable'],
            'published_at' => ['nullable'],
            'categories_ids' => ['nullable','array'],
            'faqs.*.question' => ['nullable'],
            'faqs.*.answer' => ['nullable'],
        ];
    }
}
