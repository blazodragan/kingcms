<?php
namespace App\Http\Requests\TrustReview;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreTrustReviewRequest extends FormRequest
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
        return [

            'title' => ['required'],
            'description' => ['required'],
            'rating' => 'required|numeric|between:0,5'
        ];
    }
}
