<?php
namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

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
        return [
            'alias' => ['sometimes','string'],
            'slug' => ['sometimes'],
            'title' => ['sometimes'],
            'description' => ['sometimes'],
        ];
    }
}
