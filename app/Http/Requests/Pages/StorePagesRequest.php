<?php
namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use app\Settings\GeneralSettings;

class StorePagesRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.page.create");
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
                "unique_locale_slug:pages",
            ],
            "title.$defaultLocale" => ['required'],
            'template' => ['required'],
            'status' => ['required'],
            'user_id' => ['required','exists:users,id'],
            'perex' => ['required'],
            'content' => ['required'],
            'text' => ['nullable'],
            'why' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'is_index' => ['required','boolean'],
            'is_parent' => ['required','boolean'],
            'no_index' => ['required','boolean'],
            'no_follow' => ['required','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'parent_id' => ['nullable'],
            'published_at' => ['nullable'],
            'faqs.*.question' => ['nullable'],
            'faqs.*.answer' => ['nullable'],
            'tips.*.title' => ['nullable'],
            'tips.*.body' => ['nullable'],
            'tips.*.icon' => ['nullable'],
            'tips.*.type' => ['nullable'],
        ];
    }
}
