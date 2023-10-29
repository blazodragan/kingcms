<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('sanctum.settings.edit','sanctum');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'available_locales' => ['array', 'required'],
            'default_locale' => ['string', 'required'],
            'default_route' => ['string', 'required'],
            'default_siteTitle' => ['nullable'],
            'default_siteDescription' => ['nullable'],
            'default_googleAnalytics' => ['nullable'],
            'default_customCss' => ['nullable'],
            

        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        return $validated;
    }
}
