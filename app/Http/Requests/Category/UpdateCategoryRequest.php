<?php
namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Settings\GeneralSettings;

class UpdateCategoryRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.category.edit");
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
                'sometimes',
                'max:255',
            ],
            "title.$defaultLocale" => ['required'],
            'description' => ['nullable'],
            'type' => ['required'],
        ];
    }
}
