<?php
namespace App\Http\Requests\Block;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Rules\SanitizeHtml;


class UpdateBlockRequest extends FormRequest
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
            'name' => ['sometimes'],
            'type' => ['sometimes'],
            'content' => ['sometimes'],
            'content.*' => ['sometimes', new SanitizeHtml],
        ];
    }

}
