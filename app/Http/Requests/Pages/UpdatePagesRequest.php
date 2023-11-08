<?php
namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use app\Settings\GeneralSettings;

class UpdatePagesRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.page.edit");
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
            'template' => ['required'],
            'status' => ['required'],
            'perex' => ['sometimes'],
            'content' => ['sometimes'],
            'text' => ['nullable'],
            'why' => ['nullable'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'is_index' => ['sometimes','boolean'],
            'is_parent' => ['sometimes','boolean'],
            'no_index' => ['sometimes','boolean'],
            'no_follow' => ['sometimes','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'user_id' => ['required','exists:users,id'],
            'parent_id' => ['nullable'],
            'published_at' => ['nullable'],
        ];
    }
}
