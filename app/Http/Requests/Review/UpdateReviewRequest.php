<?php
namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use app\Settings\GeneralSettings;

class UpdateReviewRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.review.edit");
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
                'sometimes',
                'max:255',
            ],
            "title.$defaultLocale" => ['required'],
            'status' => ['required'],
            'template' => ['required'],
            'perex' => ['sometimes'],
            'content' => ['sometimes'],
            'text' => ['sometimes'],
            'why' => ['nullable'],
            'active' => ['sometimes','boolean'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'href_lang' => ['nullable'],
            'no_index' => ['sometimes','boolean'],
            'no_follow' => ['sometimes','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'user_id' => ['sometimes','exists:users,id'],
            'rating' => ['nullable'],
            'published_at' => ['nullable'],
            'categories_ids' => ['nullable','array'],
            'faqs.*.question' => ['nullable'],
            'faqs.*.answer' => ['nullable'],
        ];
    }
}
