<?php
namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdatePagesRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Gate::allows("sanctum.news.edit");
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'title' => ['sometimes'],
            'slug' => ['sometimes'],
            'perex' => ['sometimes'],
            'content' => ['sometimes'],
            'meta_title' => ['nullable'],
            'meta_description' => ['nullable'],
            'meta_url_canolical' => ['nullable'],
            'template' => ['nullable'],
            'is_index' => ['sometimes','boolean'],
            'no_index' => ['sometimes','boolean'],
            'no_follow' => ['sometimes','boolean'],
            'og_title' => ['nullable'],
            'og_description' => ['nullable'],
            'og_type' => ['nullable'],
            'og_url' => ['nullable'],
            'user_id' => ['sometimes','exists:users,id'],
            'published_at' => ['nullable'],
            'status' => ['nullable'],
        ];
    }
}
