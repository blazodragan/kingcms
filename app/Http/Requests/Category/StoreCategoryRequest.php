<?php
namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use app\Settings\GeneralSettings;

class StoreCategoryRequest extends FormRequest
{

    
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.category.create");
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
            'alias' => ['required','string'],
            "slug.$defaultLocale" => [
                'required',
                'max:255',
                "unique_locale_slug:categories",
            ],
            "title.$defaultLocale" => ['required'],
            'description' => ['nullable'],
            'type' => ['required'],
        ];
    }
}
